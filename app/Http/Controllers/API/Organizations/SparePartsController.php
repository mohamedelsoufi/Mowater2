<?php

namespace App\Http\Controllers\API\Organizations;

use App\Http\Controllers\Controller;

use App\Models\Category;
use App\Models\Product;
use App\Models\SparePart;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class SparePartsController extends Controller
{
    public function index()
    {
        $spareparts = SparePart::selection()->active()->available()
            ->search()->latest('id')->paginate(PAGINATION_COUNT);
        return responseJson(1, 'success', $spareparts);
    }

    public function show_spare_part(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id' => 'required|exists:spare_parts,id',
        ]);
        if ($validator->fails())
            return responseJson(0, $validator->errors());
        $sparepart = SparePart::with(['country', 'city', 'area', 'work_time', 'contact', 'reviews'])->active()->search()->find($request->id);

        //update number of views start
        updateNumberOfViews($sparepart);
        //update number of views end

        if ($sparepart) {
            $categories = $sparepart->products->pluck('category_id');
            $categoriesdata = Category::whereIn('id', $categories)->get();
            $sparepart->categories = $categoriesdata;
            return responseJson(1, 'success', $sparepart);
        } else {
            return responseJson(0, 'error');
        }
    }

    public function show_products(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'sparepart_id' => 'required|exists:spare_parts,id',
//            'category_id' => 'required|exists:categories,id',
        ]);
        if ($validator->fails())
            return responseJson(0, $validator->errors());
        $products = SparePart::find($request->sparepart_id)->products()->search()->active()->search()->with('category','sub_category')->latest('id')->paginate(PAGINATION_COUNT);
        return responseJson(1, 'success', $products);

    }

    public function show_product(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id' => 'required|exists:products,id'
        ]);
        if ($validator->fails())
            return responseJson(0, $validator->errors());
        $product = Product::find($request->id);
        return responseJson(1, 'success', $product);

    }

    public function spare_part_available_times(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'id' => 'required|exists:spare_parts,id',
                'date' => 'required|date'
            ]);
            if ($validator->fails())
                return responseJson(0, $validator->errors());

            $day = date("D", strtotime($request->date));

            $sparepart = SparePart::with(['work_time', 'day_offs'])->find($request->id);


            $day_offs = $sparepart->day_offs()->where('date', $request->date)->get();
            foreach ($day_offs as $day_off) {
                if ($day_off)
                    return responseJson(0, __('message.requested_date' . $request->date) . __('message.is_day_off'));
            }
            if (!$sparepart->work_time) {
                return responseJson(0, __('message.no_work_times'));
            }
            $find_day = array_search($day, $sparepart->work_time->days);


            if ($find_day !== false) {

                $module = $sparepart->work_time;

                $available_times = [];

                $from = date("H:i", strtotime($module->from));
                $to = date("H:i", strtotime($module->to));


                if (!in_array(date("h:i a", strtotime($from)), $available_times)) {
                    array_push($available_times, date("h:i a", strtotime($from)));
                }

                $time_from = strtotime($from);

                $new_time = date("H:i", strtotime($module->duration . ' minutes', $time_from));
                if (!in_array(date("h:i a", strtotime($new_time)), $available_times)) {
                    array_push($available_times, date("h:i a", strtotime($new_time)));
                }

                while ($new_time < $to) {
                    $time = strtotime($new_time);
                    $new_time = date("H:i", strtotime($module->duration . ' minutes', $time));
                    if ($new_time . ':00' >= $to) {
                        break;
                    }

                    if (!in_array(date("h:i a", strtotime($new_time)), $available_times)) {
                        array_push($available_times, date("h:i a", strtotime($new_time)));
                    }

                }

                return responseJson(1, 'success', array_values($available_times));
            } else {
                return responseJson(0, __('message.no_work_times_for_this_garage'));

            }
        } catch (\Exception $e) {
            return responseJson(0, 'error');
        }
    }

    public function reserve_product(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id' => 'required|exists:spare_parts,id',
            'name' => 'required',
            'country_code' => 'required',
            'phone' => 'required|integer',
            'address' => 'required|max:255',
            'from' => 'required',
            'to' => 'required',
            'date' => 'required',
            'time' => 'required',
            'products' => 'required|array',
            'products.*.id' => 'exists:products,id',
            'products.*.quantity' => 'required|numeric'
        ]);
        if ($validator->fails())
            return responseJson(0, $validator->errors());
        $sparepart = SparePart::find($request->id);
        // auth user
        $user = getAuthAPIUser();
        $user_id = $user->id;
        $reservation = $request->all();
        $reservation['user_id'] = $user_id;
//        return $sparepart;
        if ($request->has('products')) {
            if ($sparepart->reservation_active == 0)
                return responseJson(0, 'error', __('message.reservation_not_active'));

            if ($sparepart->reservation_availability == 1) {
                \DB::beginTransaction();

//                if ($request->delivery == 1) {
//                    if ($sparepart->delivery_availability == 1) {
//                        $reserve = $sparepart->reservations()->create($reservation);
//                    } else {
//                        return responseJson(0, __('message.delivery_not_available'));
//                    }
//                } else {
//                    $reserve = $sparepart->reservations()->create($reservation);
//                }

                $reserve = $sparepart->reservations()->create($reservation);

                $products = $request->products;
                foreach ($products as $product) {
                    $product = Product::find($product['id']);
                    if ($product->productable_type = 'App\\Models\\SparePart' && $product->productable_id == $request->id) {
                        if ($product->available == 1 && $product->active == 1) {
                            $reserve->products()->attach($product->id, [
                                'quantity' => $product->quantity
                            ]);
                        } else {
                            return responseJson(0, __('message.product_id' . $product->id . __('message.not_available_or_not_active')));
                        }
                    } else {
                        \DB::rollback();
                        return responseJson(0, __('message.product_id' . $product->id . __('message.not_available_or_not_active')));

                    }
                }
                \DB::commit();
                return responseJson(1, 'success');
            } else {
                return responseJson(0, 'The reservation is not available in this organization');
            }
        }
    }
}
