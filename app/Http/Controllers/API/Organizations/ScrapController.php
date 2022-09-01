<?php

namespace App\Http\Controllers\API\Organizations;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use App\Models\Scrap;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ScrapController extends Controller
{
    public function index()
    {
        $scraps = Scrap::selection()->active()->available()
            ->search()->latest('id')->paginate(PAGINATION_COUNT);
        return responseJson(1, 'success', $scraps);
    }

    public function show_scrap(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id' => 'required|exists:scraps,id',
        ]);
        if ($validator->fails())
            return responseJson(0, $validator->errors());
        $scrap = Scrap::with(['country', 'city', 'area', 'work_time', 'contact', 'reviews'])->active()->search()->find($request->id);

        if ($scrap) {
            //update number of views start
            updateNumberOfViews($scrap);
            //update number of views end

            $categories = $scrap->products->pluck('category_id');
            $categoriesdata = Category::whereIn('id', $categories)->get();
            $scrap->categories = $categoriesdata;
            return responseJson(1, 'success', $scrap);
        } else {
            return responseJson(0, 'error');
        }
    }

    public function show_products(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'scrap_id' => 'required|exists:scraps,id',
//            'category_id' => 'required|exists:categories,id',
        ]);
        if ($validator->fails())
            return responseJson(0, $validator->errors());
        /* $products = Scrap::with([
            'products' => function ($query) {
                $query->active()->search()->paginate(PAGINATION_COUNT);
            }
        ])->find($request->scrap_id);
        */
        $products = Scrap::find($request->scrap_id)->products()->search()->active()->search()->with('category','sub_category')->latest('id')->paginate(PAGINATION_COUNT);
        return responseJson(1, 'success', $products);

    }

    public function show_product(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id' => 'required|exists:products,id'
        ]);
        if ($validator->fails())
            return responseJson(0, $validator->errors());
        $product = Product::with('car_model', 'category', 'files')->find($request->id);
        return responseJson(1, 'success', $product);

    }

    public function scrap_available_times(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'id' => 'required|exists:scraps,id',
                'date' => 'required|date'
            ]);
            if ($validator->fails())
                return responseJson(0, $validator->errors());

            $day = date("D", strtotime($request->date));

            $scrap = Scrap::with(['work_time', 'day_offs'])->find($request->id);


            $day_offs = $scrap->day_offs()->where('date', $request->date)->get();
            foreach ($day_offs as $day_off) {
                if ($day_off)
                    return responseJson(0, __('message.requested_date') . $request->date . __('message.is_day_off'));
            }
            if (!$scrap->work_time) {
                return responseJson(0, __('message.no_work_times_for_this_garage'));
            }
            $find_day = array_search($day, $scrap->work_time->days);


            if ($find_day !== false) {

                $module = $scrap->work_time;

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
            'id' => 'required|exists:scraps,id',
            'name' => 'required',
            'country_code' => 'required',
            'phone' => 'required|integer',
            'address' => 'required|max:255',
//            'from' => 'required',
            'to' => 'required',
            'date' => 'required',
//            'time' => 'required',
            'products' => 'required|array',
            'products.*.id' => 'exists:products,id',
            'products.*.quantity' => 'required|numeric'
        ]);
        if ($validator->fails())
            return responseJson(0, $validator->errors());
        $scrap = Scrap::find($request->id);
        $user_id = auth('api')->user()->id;
        $reservation = $request->all();
        $reservation['user_id'] = $user_id;
        if ($request->has('products')) {
            if ($scrap->reservation_active == 0)
                return responseJson(0, 'error', __('message.reservation_not_active'));
            if ($scrap->reservation_availability == 1) {
                \DB::beginTransaction();
//                if ($request->delivery == 1) {
//                    if ($scrap->delivery_availability == 1) {
//                        $reserve = $scrap->reservations()->create($reservation);
//
//                    } else {
//                        return responseJson(0, __('message.delivery_not_available'));
//                    }
//                } else {
//                    $reserve = $scrap->reservations()->create($reservation);
//                }
                $reserve = $scrap->reservations()->create($reservation);
                $products = $request->products;
                foreach ($products as $product) {
                    $product = Product::find($product['id']);
                    if ($product->productable_type = 'App\\Models\\Scrap' && $product->productable_id == $request->id) {
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
