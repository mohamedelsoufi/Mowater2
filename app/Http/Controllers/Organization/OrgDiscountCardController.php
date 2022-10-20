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
    private $discountCard;

    public function __construct(DiscountCard $discountCard)

    {
        $this->middleware(['HasOrgDiscountCard:read'])->only(['index', 'show']);
        $this->middleware(['HasOrgDiscountCard:read-offers'])->only(['offers', 'show_offer']);
        $this->middleware(['HasOrgDiscountCard:create-offers'])->only('create_offers');
        $this->middleware(['HasOrgDiscountCard:update-offers'])->only('update_offers');
        $this->middleware(['HasOrgDiscountCard:subscribe'])->only('subscribe');
        $this->discountCard = $discountCard;

    }

    public function index()
    {
        try {
            $record = getModelData();
            $discountCards = $this->discountCard->active()->get();
            return view('organization.discountCards.index', compact('discountCards', 'record'));
        } catch (\Exception $e) {
            return redirect()->back()->with(['error' => __('message.something_wrong')]);
        }
    }

    public function show($id)
    {
        try {
            $record = getModelData();
            $discount_card = $this->discountCard->active()->find($id);
            return view('organization.discountCards.show', compact('discount_card', 'record'));
        } catch (\Exception $e) {
            return redirect()->back()->with(['error' => __('message.something_wrong')]);
        }
    }

    public function subscribe($id)
    {
        try {
            $discount_card = $this->discountCard->find($id);
            $record = getModelData();
            $find_dc = $record->discount_cards()->find($id);
            if (!$find_dc) {
                $record->discount_cards()->attach($id);
                return $this->offers($id);
            } else {
                return redirect()->back()->with(['error' => __('message.scribed_discount_card')]);
            }
        } catch (\Exception $e) {
            return redirect()->back()->with(['error' => $e->getMessage()]);
        }
    }

    public function create_offers(Request $request)
    {
        try {
            $discount_card_id = $request->discount_card_id;
            $record = getModelData();

            if ($request->has('vehicle_id')) {
                $vehicle_ids = $request->vehicle_id;
                foreach ($vehicle_ids as $key => $vehicle_id) {
                    $messages = [
                        'vehicle_discount_value.*.required_with' => 'قيمة خصم المركبة مطلوب',
                        'vehicle_discount_type.*.in' => 'نوع خصم المركبة مطلوب',
                    ];
                    $validator = Validator::make($request->all(), [
                        'vehicle_discount_value.' . $key => 'required_with:vehicle_id.' . $key,
                        'vehicle_discount_type.' . $key => 'required|in:percentage,amount',
                        'vehicle_specific_number.' . $key => 'nullable|numeric',
                    ], $messages);

                    if ($validator->fails())
                        return redirect()->back()->withErrors($validator);
                    $vehicles = $record->vehicles()->find($vehicle_id);
                    $vehicles->offers()->create([
                        'discount_card_id' => $discount_card_id,
                        'discount_type' => $request->vehicle_discount_type[$key],
                        'discount_value' => $request->vehicle_discount_value[$key],
                        'number_of_uses_times' => $request->vehicle_specific_number[$key] == null ? 'endless' : 'specific_number',
                        'specific_number' => $request->vehicle_specific_number[$key],
                        'notes' => $request->vehicle_notes[$key],
                    ]);
                }
            }

            if ($request->has('product_id')) {
                $product_ids = $request->product_id;
                foreach ($product_ids as $key => $product_id) {
                    $messages = [
                        'product_discount_value.*.required_with' => 'قيمة خصم قطعة الغيار مطلوب',
                        'product_discount_type.*.in' => 'نوع خصم قطعة الغيار مطلوب',
                    ];

                    $validator = Validator::make($request->all(), [
                        'product_discount_value.' . $key => 'required_with:product_id.' . $key,
                        'product_discount_type.' . $key => 'required|in:percentage,amount',
                        'product_specific_number.' . $key => 'nullable|numeric',
                    ], $messages);
                    if ($validator->fails())
                        return redirect()->back()->withErrors($validator);
                    $products = $record->products()->find($product_id);
                    $products->offers()->create([
                        'discount_card_id' => $discount_card_id,
                        'discount_type' => $request->product_discount_type[$key],
                        'discount_value' => $request->product_discount_value[$key],
                        'number_of_uses_times' => $request->product_specific_number[$key] == null ? 'endless' : 'specific_number',
                        'specific_number' => $request->product_specific_number[$key],
                        'notes' => $request->product_notes[$key],
                    ]);
                }
            }

            if ($request->has('service_id')) {
                $service_ids = $request->service_id;
                foreach ($service_ids as $key => $service_id) {
                    $messages = [
                        'service_discount_value.*.required_with' => 'قيمة خصم الخدمة مطلوب',
                        'service_discount_type.*.in' => 'نوع خصم الخدمة مطلوب',
                    ];

                    $validator = Validator::make($request->all(), [
                        'service_discount_value.' . $key => 'required_with:service_id.' . $key,
                        'service_discount_type.' . $key => 'required|in:percentage,amount',
                        'service_specific_number.' . $key => 'nullable|numeric',
                    ], $messages);
                    if ($validator->fails())
                        return redirect()->back()->withErrors($validator);
                    $services = $record->services()->find($service_id);
                    $services->offers()->create([
                        'discount_card_id' => $discount_card_id,
                        'discount_type' => $request->service_discount_type[$key],
                        'discount_value' => $request->service_discount_value[$key],
                        'number_of_uses_times' => $request->service_specific_number[$key] == null ? 'endless' : 'specific_number',
                        'specific_number' => $request->service_specific_number[$key],
                        'notes' => $request->service_notes[$key],
                    ]);
                }
            }

            return redirect()->route('organization.discount-cards.index')->with('success', __('message.created_successfully'));
        } catch (\Exception $e) {
            return redirect()->back()->with(['error' => __('message.something_wrong')]);
        }
    }

    public function offers($id)
    {
        try {
            $record = getModelData();
            $discount_card = $this->discountCard->find($id);
            $vehicles = null;
            $products = null;
            $services = null;
            if ($record->vehicles)
                $vehicles = $record->vehicles()->latest('id')->get();
            if ($record->products)
                $products = $record->products()->latest('id')->get();
            if ($record->services)
                $services = $record->services()->latest('id')->get();
            return view('organization.discountCards.offers', compact('discount_card', 'vehicles', 'products', 'services', 'record'));
        } catch (\Exception $e) {
            return redirect()->back()->with(['error' => __('message.something_wrong')]);
        }
    }

    public function show_offer($id)
    {
        try {
            $record = getModelData();
            $discount_card = $this->discountCard->find($id);
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

            return view('organization.discountCards.showOffers', compact('vehicles', 'discount_card', 'services', 'products', 'record'));
        } catch (\Exception $e) {
            return redirect()->back()->with(['error' => __('message.something_wrong')]);
        }
    }

    public function update_offers(Request $request, $id)
    {
        try {
            $discount_card = $this->discountCard->find($id);
            $record = getModelData();

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
                        'vehicle_discount_type.*.in' => 'نوع خصم المركبة مطلوب',
                    ];

                    $validator = Validator::make($request->all(), [
                        'vehicle_id' => 'array',
                        'vehicle_discount_value.' . $key => 'required_with:vehicle_id.' . $key,
                        'vehicle_discount_type.' . $key => 'in:percentage,amount',
                        'vehicle_specific_number.' . $key => 'nullable|numeric',
                    ], $messages);

                    if ($validator->fails())
                        return redirect()->back()->withErrors($validator)->withInputs($request->all());
                    $vehicles = $record->vehicles()->find($vehicle_id);
                    $vehicles->offers()->create([
                        'discount_card_id' => $discount_card->id,
                        'discount_type' => $request->vehicle_discount_type[$key],
                        'discount_value' => $request->vehicle_discount_value[$key],
                        'number_of_uses_times' => $request->vehicle_specific_number[$key] == null ? 'endless' : 'specific_number',
                        'specific_number' => $request->vehicle_specific_number[$key],
                        'notes' => $request->vehicle_notes[$key],
                    ]);
                }
            }

            if ($request->has('product_id')) {
                $product_ids = $request->product_id;
                foreach ($product_ids as $key => $product_id) {
                    $messages = [
                        'product_discount_value.*.required_with' => 'قيمة خصم قطعة الغيار مطلوب',
                        'product_discount_type.*.in' => 'نوع خصم قطعة الغيار مطلوب',
                    ];

                    $validator = Validator::make($request->all(), [
                        'product_discount_value.' . $key => 'required_with:product_id.' . $key,
                        'product_discount_type.' . $key => 'required|in:percentage,amount',
                        'product_specific_number.' . $key => 'nullable|numeric',
                    ], $messages);
                    if ($validator->fails())
                        return redirect()->back()->withErrors($validator);

                    $products = $record->products()->find($product_id);

                    $products->offers()->create([
                        'discount_card_id' => $discount_card->id,
                        'discount_type' => $request->product_discount_type[$key],
                        'discount_value' => $request->product_discount_value[$key],
                        'number_of_uses_times' => $request->product_specific_number[$key] == null ? 'endless' : 'specific_number',
                        'specific_number' => $request->product_specific_number[$key],
                        'notes' => $request->product_notes[$key],
                    ]);
                }
            }

            if ($request->has('service_id')) {
                $service_ids = $request->service_id;
                foreach ($service_ids as $key => $service_id) {
                    $messages = [
                        'service_discount_value.*.required_with' => 'قيمة خصم الخدمة مطلوب',
                        'service_discount_type.*.in' => 'نوع خصم الخدمة مطلوب',
                    ];

                    $validator = Validator::make($request->all(), [
                        'service_discount_value.' . $key => 'required_with:service_id.' . $key,
                        'service_discount_type.' . $key => 'required|in:percentage,amount',
                        'service_specific_number.' . $key => 'nullable|numeric',
                    ], $messages);
                    if ($validator->fails())
                        return redirect()->back()->withErrors($validator);
                    $services = $record->services()->find($service_id);

                    $services->offers()->create([
                        'discount_card_id' => $discount_card->id,
                        'discount_type' => $request->service_discount_type[$key],
                        'discount_value' => $request->service_discount_value[$key],
                        'number_of_uses_times' => $request->service_specific_number[$key] == null ? 'endless' : 'specific_number',
                        'specific_number' => $request->service_specific_number[$key],
                        'notes' => $request->service_notes[$key],
                    ]);
                }
            }

            return redirect()->route('organization.discount-cards.index')->with('success', __('message.updated_successfully'));
        } catch (\Exception $e) {
            return redirect()->back()->with(['error' => __('message.something_wrong')]);
        }
    }
}
