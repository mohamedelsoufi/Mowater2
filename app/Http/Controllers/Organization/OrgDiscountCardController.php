<?php

namespace App\Http\Controllers\Organization;

use App\Http\Controllers\Controller;
use App\Http\Requests\OffersRequest;
use App\Models\DiscountCard;
use App\Models\Offer;
use App\Models\Vehicle;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class OrgDiscountCardController extends Controller
{

    public function index()
    {
        $user = auth()->guard('web')->user();
        $model_type = $user->organizable_type;
        $model_id = $user->organizable_id;
        $model = new $model_type;
        $record = $model->find($model_id);

        $discount_cards = DiscountCard::active()->get();
        return view('organization.discount_cards.index', compact('discount_cards', 'record'));
    }

    public function show($id)
    {
        $show_discount_card = DiscountCard::find($id);
        $show_discount_card->makeVisible('title_en', 'title_ar');
        $data = compact('show_discount_card');
        return response()->json(['status' => true, 'data' => $data]);
    }

    public function subscribe($id)
    {
        $discount_card = DiscountCard::find($id);
        if ($discount_card) {
            $user = auth()->guard('web')->user();
            $model_type = $user->organizable_type;
            $model_id = $user->organizable_id;
            $model = new $model_type;
            $record = $model->find($model_id);
            $record->discount_cards()->attach($id);
            return redirect()->route('organization.discount-cards.offers', $id);
        }
        return redirect()->back()->with(['error' => __('message.something_wrong')]);
    }

    public function create_offers(Request $request)
    {
//        return $request;
        $discount_card_id = $request->discount_card_id;
        $user = auth()->guard('web')->user();
        $model_type = $user->organizable_type;
        $model_id = $user->organizable_id;
        $model = new $model_type;
        $record = $model->find($model_id);

        if ($request->has('vehicle_id')) {
            $vehicle_ids = $request->vehicle_id;
            foreach ($vehicle_ids as $key => $vehicle_id) {
                $messages = [
                    'vehicle_discount_value.*.required_with' => 'قيمة خصم المركبة مطلوب',
                ];
                $validator = Validator::make($request->all(),[
                    'vehicle_discount_value.'.$key => 'required_with:vehicle_id.'.$key,
                    'vehicle_specific_number.'.$key => 'nullable|numeric',
                ],$messages);

                if ($validator->fails())
                    return redirect()->back()->withErrors($validator);
                $vehicles = $record->vehicles()->find($vehicle_id);
                $vehicles->offers()->create([
                    'discount_card_id' => $discount_card_id,
                    'discount_type' => $request->vehicle_discount_type[$key],
                    'discount_value' => $request->vehicle_discount_value[$key],
                    'number_of_uses_times' => $request->vehicle_specific_number[$key] == null ? 'endless' : 'specific_number',
                    'specific_number' => $request->vehicle_specific_number[$key],
                ]);
            }
        }

        if ($request->has('product_id')) {
            $product_ids = $request->product_id;
            foreach ($product_ids as $key => $product_id) {
                $messages = [
                    'product_discount_value.*.required_with' => 'قيمة خصم قطع الغيار مطلوب',
                ];

                $validator = Validator::make($request->all(),[
                    'product_discount_value.'.$key => 'required_with:product_id.'.$key,
                    'product_specific_number.'.$key => 'nullable|numeric',
                ],$messages);
                if ($validator->fails())
                    return redirect()->back()->withErrors($validator);
                $products = $record->products()->find($product_id);
                $products->offers()->create([
                    'discount_card_id' => $discount_card_id,
                    'discount_type' => $request->product_discount_type[$key],
                    'discount_value' => $request->product_discount_value[$key],
                    'number_of_uses_times' => $request->product_specific_number[$key] == null ? 'endless' : 'specific_number',
                    'specific_number' => $request->product_specific_number[$key],
                ]);
            }
        }

        if ($request->has('service_id')) {
            $service_ids = $request->service_id;
            foreach ($service_ids as $key => $service_id) {
                $messages = [
                    'service_discount_value.*.required_with' => 'قيمة خصم الخدمة مطلوب',
                ];

                $validator = Validator::make($request->all(),[
                    'service_discount_value.'.$key => 'required_with:service_id.'.$key,
                    'service_specific_number.'.$key => 'nullable|numeric',
                ],$messages);
                if ($validator->fails())
                    return redirect()->back()->withErrors($validator);
                $services = $record->services()->find($service_id);
                $services->offers()->create([
                    'discount_card_id' => $discount_card_id,
                    'discount_type' => $request->service_discount_type[$key],
                    'discount_value' => $request->service_discount_value[$key],
                    'number_of_uses_times' => $request->service_specific_number[$key] == null ? 'endless' : 'specific_number',
                    'specific_number' => $request->service_specific_number[$key],
                ]);
            }
        }

        return redirect()->route('organization.discount-cards.index')->with('success', __('message.created_successfully'));

    }

    public function offers($id)
    {
        $user = auth()->guard('web')->user();

        $model_type = $user->organizable_type;
        $model_id = $user->organizable_id;
        $model = new $model_type;
        $record = $model->find($model_id);
        $discount_cad = DiscountCard::find($id);
        $vehicles = null;
        $products = null;
        $services = null;
        if ($record->vehicles)
            $vehicles = $record->vehicles()->latest('id')->get();
        if ($record->products)
            $products = $record->products()->latest('id')->get();
        if ($record->services)
            $services = $record->services()->latest('id')->get();
        return view('organization.discount_cards.offers', compact('discount_cad', 'vehicles', 'products', 'services'));
    }

    public function show_offer($id)
    {
        $discount_cad = DiscountCard::find($id);
        $user = auth()->guard('web')->user();

        $model_type = $user->organizable_type;
        $model_id = $user->organizable_id;
        $model = new $model_type;
        $record = $model->find($model_id);
        $discount_cad = DiscountCard::find($id);
        $vehicles = null;
        $products = null;
        $services = null;
        if ($record->vehicles)
            $vehicles = $record->vehicles()->with(['offers' => function ($q) use ($id) {
                return $q->where('discount_card_id', $id);
            }])->latest('id')->get();

        if ($record->products)
            $products = $record->products()->with(['offers' => function ($q) use ($id) {
                return $q->where('discount_card_id', $id);
            }])->latest('id')->get();

        if ($record->services)
            $services = $record->services()->with(['offers' => function ($q) use ($id) {
                return $q->where('discount_card_id', $id);
            }])->latest('id')->get();

        return view('organization.discount_cards.show_offers', compact('vehicles', 'discount_cad', 'services', 'products'));
    }

    public function update_offers(Request $request, $id)
    {
//        return $request;
        $discount_card = DiscountCard::find($id);
        $user = auth()->guard('web')->user();
        $model_type = $user->organizable_type;
        $model_id = $user->organizable_id;
        $model = new $model_type;
        $record = $model->find($model_id);

        if ($record->vehicles) {
            $stored_vehicles = $record->vehicles()->pluck('id');
            if ($stored_vehicles)
                Offer::whereIn('offerable_id', $stored_vehicles)->delete();
        }

        if ($record->products) {
            $stored_products = $record->products()->pluck('id');
            if ($stored_products)
                Offer::whereIn('offerable_id', $stored_products)->delete();
        }

        if ($record->services) {
            $stored_services = $record->services()->pluck('id');
            if ($stored_services)
                Offer::whereIn('offerable_id', $stored_services)->delete();
        }

        if ($request->has('vehicle_id')) {
            $vehicle_ids = $request->vehicle_id;

            foreach ($vehicle_ids as $key => $vehicle_id) {
                $messages = [
                    'vehicle_discount_value.*.required_with' => 'قيمة خصم المركبة مطلوب',
                ];

                $validator = Validator::make($request->all(),[
                    'vehicle_id'=>'array',
                    'vehicle_discount_value.'.$key => 'required_with:vehicle_id.'.$key,
                    'vehicle_specific_number.'.$key => 'nullable|numeric',
                ],$messages);

                if ($validator->fails())
                    return redirect()->back()->withErrors($validator)->withInputs($request->all());
                $vehicles = $record->vehicles()->find($vehicle_id);
                $vehicles->offers()->create([
                    'discount_card_id' => $discount_card->id,
                    'discount_type' => $request->vehicle_discount_type[$key],
                    'discount_value' => $request->vehicle_discount_value[$key],
                    'number_of_uses_times' => $request->vehicle_specific_number[$key] == null ? 'endless' : 'specific_number',
                    'specific_number' => $request->vehicle_specific_number[$key],
                ]);
            }
        }

        if ($request->has('product_id')) {
            $product_ids = $request->product_id;
            foreach ($product_ids as $key => $product_id) {
                $messages = [
                    'product_discount_value.*.required_with' => 'قيمة خصم قطع الغيار مطلوب',
                ];

                $validator = Validator::make($request->all(),[
                    'product_discount_value.'.$key => 'required_with:product_id.'.$key,
                    'product_specific_number.'.$key => 'nullable|numeric',
                ],$messages);
                if ($validator->fails())
                    return redirect()->back()->withErrors($validator);

                $products = $record->products()->find($product_id);

                $products->offers()->create([
                    'discount_card_id' => $discount_card->id,
                    'discount_type' => $request->product_discount_type[$key],
                    'discount_value' => $request->product_discount_value[$key],
                    'number_of_uses_times' => $request->product_specific_number[$key] == null ? 'endless' : 'specific_number',
                    'specific_number' => $request->product_specific_number[$key],
                ]);
            }
        }

        if ($request->has('service_id')) {
            $service_ids = $request->service_id;
            foreach ($service_ids as $key => $service_id) {
                $messages = [
                    'service_discount_value.*.required_with' => 'قيمة خصم الخدمة مطلوب',
                ];

                $validator = Validator::make($request->all(),[
                    'service_discount_value.'.$key => 'required_with:service_id.'.$key,
                    'service_specific_number.'.$key => 'nullable|numeric',
                ],$messages);
                if ($validator->fails())
                    return redirect()->back()->withErrors($validator);
                $services = $record->services()->find($service_id);

                $services->offers()->create([
                    'discount_card_id' => $discount_card->id,
                    'discount_type' => $request->service_discount_type[$key],
                    'discount_value' => $request->service_discount_value[$key],
                    'number_of_uses_times' => $request->service_specific_number[$key] == null ? 'endless' : 'specific_number',
                    'specific_number' => $request->service_specific_number[$key],
                ]);
            }
        }

        return redirect()->route('organization.discount-cards.index')->with('success', __('message.updated_successfully'));

    }
}
