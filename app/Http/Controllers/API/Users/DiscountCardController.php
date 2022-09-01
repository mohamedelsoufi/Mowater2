<?php

namespace App\Http\Controllers\API\Users;

use App\Http\Controllers\Controller;
use App\Http\Requests\API\ShowDiscountCardRequest;
use App\Http\Resources\DiscountCards\GetDiscountCardsResource;
use App\Http\Resources\DiscountCards\ShowDiscountCardResource;
use App\Http\Resources\DiscountCards\ShowUserDiscountCardResource;
use App\Models\Agency;
use App\Models\DiscountCard;
use App\Models\DiscountCardOrganization;
use App\Models\DiscountCardUser;
use App\Models\DiscoutnCardUserUse;
use App\Models\Offer;
use App\Models\Product;
use App\Models\Service;
use App\Models\Vehicle;
use Illuminate\Support\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use function PHPUnit\Framework\isEmpty;


class DiscountCardController extends Controller
{
    public function index()
    {
        $discount_cards = DiscountCard::where('status', 'started')->active()->latest('id')->paginate(PAGINATION_COUNT);

        return responseJson(1, 'success', GetDiscountCardsResource::collection($discount_cards)->response()->getData(true));
    }

    public function showDiscountCard(ShowDiscountCardRequest $request)
    {
        $discount_card = DiscountCard::find($request->id);
        //update number of views start
        updateNumberOfViews($discount_card);
        //update number of views end

        return responseJson(1, 'success', new ShowDiscountCardResource($discount_card));
    }

    public function subscribe(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'discount_card_id' => 'required|exists:discount_cards,id',
        ]);
        if ($validator->fails())
            return responseJson(0, $validator->errors());

        $discount_card = DiscountCard::find($request->discount_card_id);
        if ($discount_card->status == "started") {
            $created_month = $discount_card->created_at->format('m');

            $discount_card_price = $discount_card->price;

            $price_per_month = $discount_card_price / 12;

            $months = 12 - (int)$created_month;

            $final_price = $price_per_month * $months;

            $user = auth()->guard('api')->user();

            $user->discount_cards()->attach($request->discount_card_id, [
                'price' => $final_price,
                'barcode' => $this->generateBarcodeNumber(),
            ]);

            foreach ($user->discount_cards()->get() as $dc) {
                $discount_card = $user->discount_cards()->wherePivot('id', $dc->pivot->id)->first();
            }

            return responseJson(1, 'success', $discount_card);
        } else {
            return responseJson(0, ['error' => __('message.discount_not_lunched')]);
        }


    }

    public function generateBarcodeNumber()
    {
        $number = mt_rand(1000000000000, 9999999999999); // better than rand()

        // call the same function if the barcode exists already
        if ($this->barcodeNumberExists($number)) {
            return $this->generateBarcodeNumber();
        }

        // otherwise, it's valid and can be used
        return $number;
    }

    private function barcodeNumberExists($number)
    {
        return DiscountCardUser::whereBarcode($number)->exists();
    }

    public function add_vehicles(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'discount_card_id' => 'required|exists:discount_cards,id',
            'vehicles' => 'required',
            'barcode' => 'required|exists:discount_card_users,barcode',
        ]);
        if ($validator->fails())
            return responseJson(0, $validator->errors());

        $user = auth()->guard('api')->user();

        $find_discount_card = $user->discount_cards()->where('user_id', $user->id)
            ->where('discount_card_id', $request->discount_card_id)->first();

        if ($find_discount_card->status == "started") {

            $vehicle_ids = $request->vehicles;

            $vehicle_ids_to_array = array_map('intval', explode(',', $vehicle_ids));

            $stored_vehicles = $user->discount_cards()->wherePivot('barcode', $request->barcode)->select('vehicles')->pluck('vehicles');
//            return gettype($stored_vehicles->toArray());

            $conversion = substr($stored_vehicles, 1, -1);
            $conversions = substr($conversion, 1, -1);
            $vehicles_to_array = array_map('intval', explode(',', $conversions));

            $vehicles_counter = count($vehicles_to_array) + count($vehicle_ids_to_array);

//            if (count($vehicles_to_array) >= 4)
//                return responseJson(0, 'error', __('message.max_vehicles'));

            if ($vehicles_counter > 4) {
                return responseJson(0, 'error', __('message.entities_vehicles_counter'));
            } else {

                $user_vehicles = $user->vehicles()->pluck('id')->toArray(); //moshtrak

                foreach ($vehicle_ids_to_array as $id) {
                    $search_vehicles = array_search($id, $user_vehicles);

                    if ($search_vehicles !== false) {
                        if (in_array($id, $vehicles_to_array))
                            return responseJson(0, ['error' => __('message.vehicle_exist_in_discount')]);
                    } else {
                        return responseJson(0, ['error' => __('message.something_wrong')]);
                    }
                }

                if (in_array(null, $stored_vehicles->toArray()))
                    $data = $vehicle_ids;
                else
                    $data = $conversions . ',' . $vehicle_ids;

                $user->discount_cards()->wherePivot('barcode', $request->barcode)->sync([$request->discount_card_id => [
                    'vehicles' => $data,
                ]]);
                return responseJson(1, ['success' => __('message.created_successfully')]);
            }
        } else {
            return responseJson(0, ['error' => __('message.discount_not_lunched')]);
        }
    }

    public function getUserDiscountCards()
    {
        $user = auth()->guard('api')->user();
        $discount_cards = $user->discount_cards()->paginate(PAGINATION_COUNT);

        return responseJson(1, 'success', $discount_cards);
    }

    public function getUserDiscountCard(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'barcode' => 'required|exists:discount_card_users,barcode',
        ]);
        if ($validator->fails())
            return responseJson(0, $validator->errors());

        $user = auth()->guard('api')->user();
        $discount_card = $user->discount_cards()->wherePivot('barcode', $request->barcode)->first();
        return responseJson(1, 'success', new ShowUserDiscountCardResource($discount_card));
    }

    public function getOffers(Request $request)
    {
        $products = Product::wherehas('offers')->get();

        $services = Service::wherehas('offers')->get();

        $vehicles = Vehicle::with(['brand', 'car_model', 'car_class', 'files' => function ($query) {
            $query->with('color');
        }])->overView()->wherehas('offers')->get();

        foreach ($products as $product) {
            foreach ($product->offers as $offer) {
                $discount_type = $offer->discount_type;
                $percentage_value = $offer->discount_value / 100;
                if ($discount_type == 'percentage') {
                    $price_after_discount = $product->price - $percentage_value;
                    $product->discount_type = $offer->discount_value . '%';
                    $product->price_after_discount = $price_after_discount . ' BHD';
                } else {
                    $price_after_discount = $product->price - $offer->discount_value;
                    $product->discount_type = $offer->discount_value . ' BHD';
                    $product->price_after_discount = $price_after_discount . ' BHD';
                }
                $product->makeHidden('offers');
            }
        }

        foreach ($services as $service) {
            foreach ($service->offers as $offer) {
                $discount_type = $offer->discount_type;
                $percentage_value = $offer->discount_value / 100;
                if ($discount_type == 'percentage') {
                    $price_after_discount = $service->price - $percentage_value;
                    $service->discount_type = $offer->discount_value . '%';
                    $service->price_after_discount = $price_after_discount . ' BHD';
                } else {
                    $price_after_discount = $service->price - $offer->discount_value;
                    $service->discount_type = $offer->discount_value . ' BHD';
                    $service->price_after_discount = $price_after_discount . ' BHD';
                }
                $service->makeHidden('offers');
            }
        }

        foreach ($vehicles as $vehicle) {
            foreach ($vehicle->offers as $offer) {
                $discount_type = $offer->discount_type;
                $percentage_value = $offer->discount_value / 100;
                if ($discount_type == 'percentage') {
                    $price_after_discount = $vehicle->price - $percentage_value;
                    $vehicle->discount_type = $offer->discount_value . '%';
                    $vehicle->price_after_discount = $price_after_discount . ' BHD';
                } else {
                    $price_after_discount = $vehicle->price - $offer->discount_value;
                    $vehicle->discount_type = $offer->discount_value . ' BHD';
                    $vehicle->price_after_discount = $price_after_discount . ' BHD';
                }
                $vehicle->features = $vehicle->vehicleProperties();
                $vehicle->makeHidden('offers');
            }
        }

        return responseJson(1, 'success', ['vehicles' => $vehicles, 'products' => $products, 'services' => $services]);

    }

    public function check_before_apply_discount_card(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'model_type' => 'required|in:Agency,CarShowroom,Garage,RentalOffice,SpecialNumberOrganization,Wench',
            'model_id' => 'required',
            'barcode' => 'required|exists:discount_card_users,barcode',
            'vehicles' => 'nullable|array',
            'vehicles.*.id' => 'exists:vehicles,id',
            'products' => 'nullable|array',
            'products.*.id' => 'exists:products,id',
            'services' => 'nullable|array',
            'services.*.id' => 'exists:services,id',
        ]);
        if ($validator->fails())
            return responseJson(0, $validator->errors());

        // get authenticated user
        // auth user
        $user = getAuthAPIUser();

        //format model
        $class = 'App\\Models\\' . $request->model_type;
        $model = new $class;

        $in_mawater_card = [];
        $out_of_mawater_card = [];

        // get requested vehicles
        if ($request->has('vehicles')) {
            $record = $model->find($request->model_id);
            $record_vehicles = $record->vehicles()->wherehas('offers')->pluck('id')->toArray();

            foreach ($request->vehicles as $requested) {
                $find_vehicle_in_offers = array_search($requested['id'], $record_vehicles);
                if ($find_vehicle_in_offers !== false) {
                    $in_mawater_card['vehicles'] = $this->ask_for_offers_items($request->vehicles, $user->id, $request->barcode, 'App\\Models\\Vehicle');
                }
            }
            $out_of_mawater_card['vehicles'] = $this->out_of_mawater_card_offer($request->vehicles, $record_vehicles, 'App\\Models\\Vehicle');
        }

        // get requested products
        if ($request->has('products')) {
            $record = $model->find($request->model_id);
            $record_products = $record->products()->wherehas('offers')->pluck('id')->toArray();

            foreach ($request->products as $requested) {
                $find_product_in_offers = array_search($requested['id'], $record_products);
                if ($find_product_in_offers !== false) {
                    $in_mawater_card['products'] = $this->ask_for_offers_items($request->products, $user->id, $request->barcode, 'App\\Models\\Product');
                }
            }
            $out_of_mawater_card['products'] = $this->out_of_mawater_card_offer($request->products, $record_products, 'App\\Models\\Product');
        }

        // get requested services
        if ($request->has('services')) {
            $record = $model->find($request->model_id);
            $record_services = $record->services()->wherehas('offers')->pluck('id')->toArray();

            foreach ($request->services as $requested) {
                $find_service_in_offers = array_search($requested['id'], $record_services);
                if ($find_service_in_offers !== false) {
                    $in_mawater_card['services'] = $this->ask_for_offers_items($request->services, $user->id, $request->barcode, 'App\\Models\\Service');
                }
            }
            $out_of_mawater_card['services'] = $this->out_of_mawater_card_offer($request->services, $record_services, 'App\\Models\\Service');
        }

        return responseJson(1, 'success', ['in_mawater_card' => $in_mawater_card, 'out_of_mawater_card' => $out_of_mawater_card]);

    }

    private function ask_for_offers_items($request, $user_id, $barcode, $type)
    {
        $number_of_consumption = 0;
        $consumptions = DiscoutnCardUserUse::where('user_id', $user_id)->where('barcode', $barcode)->get();
        $offers = Offer::whereIn('offerable_id', $request)->where('offerable_type', $type)->get();
        foreach ($request as $id) {
            $model_type = new $type;
            $model = $model_type->find($id['id']);

            foreach ($offers as $offer) {

                foreach ($consumptions as $consumption) {
                    $number_of_consumption = (int)$offer->specific_number - (int)$consumption->consumption_number;

                }

                $offer->remaining = $number_of_consumption == null ? $offer->specific_number : $number_of_consumption;

                $offer->original_price = $model->price . ' BHD';

                $discount_type = $offer->discount_type;
                $percentage_value = ((100 - $offer->discount_value) / 100);

                if ($discount_type == 'percentage') {
                    $price_after_discount = $model->price * $percentage_value;
                    $offer->card_price_after_discount = $price_after_discount . ' BHD';
                } else {
                    $price_after_discount = $model->price - $offer->discount_value;
                    $offer->card_price_after_discount = $price_after_discount . ' BHD';
                }

            }
        }
        return $offers;
    }

    private function out_of_mawater_card_offer($request, $offer_records, $type)
    {
        $out = [];

        foreach ($request as $item) {
            if (in_array($item['id'], $offer_records) == false) {
                $class = new $type;
                $model = $class->where('id', $item)->first();
                array_push($out, ['id' => $model->id, 'name' => $model->name]);
            }
        }
        return $out;
    }


}
