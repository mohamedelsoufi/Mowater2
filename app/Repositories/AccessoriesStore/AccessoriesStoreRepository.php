<?php


namespace App\Repositories\AccessoriesStore;


use App\Http\Resources\AccessoriesStore\GetPurchasesResource;
use App\Http\Resources\TechnicalInspectionCenter\RequestInspectionCenterResource;
use App\Models\AccessoriesStore;
use App\Models\Accessory;
use App\Models\DiscoutnCardUserUse;
use App\Models\Offer;
use Illuminate\Support\Facades\DB;

class AccessoriesStoreRepository implements AccessoriesStoreInterface
{
    private $model;
    private $accessory;

    public function __construct(AccessoriesStore $model, Accessory $accessory)
    {
        $this->model = $model;
        $this->accessory = $accessory;
    }

    public function getAll()
    {
        try {
            $stores = $this->model->search()->latest('id');
            return $stores;
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }

    public function getStoreById($request)
    {
        try {
            $store = $this->model->where('id', $request);
            return $store;

        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }

    public function mawaterOffers($request)
    {
        try {
            $store = $this->model->find($request);

            $discount_cards = $store->discount_cards()->where('status', 'started')->get();

            if ($discount_cards->isEmpty()) {
                return responseJson(0, 'error', __('message.something_wrong'));
            }
            $accessories = $store->accessories()->whereHas('offers')->get();
            GeneralMowaterCard($accessories);

            return $accessories;
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }

    public function getAccessories()
    {
        try {
            $accessories = $this->accessory->search()->latest('id');
            return $accessories;
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }

    public function showAccessory($request)
    {
        try {
            $accessory = $this->accessory->where('id', $request);
            return $accessory;
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }

    public function purchase($request)
    {
        try {
            $user = getAuthAPIUser();
            $request['user_id'] = $user->id;
            $store = $this->getStoreById($request->accessories_store_id)->first();


            if ($store->reservation_active == 0)
                return responseJson(0, 'error', __('message.reservation_not_active'));

            if ($store->reservation_availability == true) {
                // use mawater card start
                if ($request->is_mawater_card == true) {
                    $accessory_offers = $store->accessories()->whereHas('offers')->pluck('id')->toArray();

                    $user_mawater_card_vehicles = $user->discount_cards()->wherePivot('barcode', $request->barcode)->first();

                    $user_dc_vehicles = $user_mawater_card_vehicles->pivot->vehicles;
                    $user_dc_vehicles_array = explode(',', $user_dc_vehicles);
                    foreach ($request->owen_vehicles as $vehicle) {
                        if (!in_array($vehicle['id'], $user_dc_vehicles_array)) {
                            return responseJson(0, 'error', __('message.user_vehicle_not_found'));
                        }
                    }
                    try {
                        DB::beginTransaction();
                        foreach ($request->accessories as $accessory) {
                            if (in_array($accessory, $accessory_offers)) {
                                $accessory_offer = Offer::where('offerable_id', $accessory)
                                    ->where('offerable_type', 'App\\Models\\TechnicalInspectionCenterService')->first();

                                $service_consumption = DiscoutnCardUserUse::where('barcode', $request->barcode)
                                    ->where('offer_id', $accessory_offer->id)->first();
                                if (!$service_consumption) {
                                    DiscoutnCardUserUse::create([
                                        'user_id' => $user->id,
                                        'barcode' => $request->barcode,
                                        'offer_id' => $accessory_offer->id,
                                        'original_number_of_uses' => $accessory_offer->specific_number,
                                        'consumption_number' => 1
                                    ]);
                                } else {
                                    if ($service_consumption->consumption_number == $service_consumption->original_number_of_uses) {
                                        return responseJson(0, 'error', 'you have reach max number of consumption for service id: ' . $accessory);
                                    }
                                    $service_consumption->update([
                                        'consumption_number' => $service_consumption->consumption_number + 1
                                    ]);
                                }
                            } else {
                                return responseJson(0, 'error', __('message.accessory_id') . $accessory . __('message.not_exist_in_offer'));
                            }
                        }

                        DB::commit();
                    } catch (\Exception $e) {
                        DB::rollBack();
                        return responseJson(0, 'error', $e->getMessage());
                    }

                }
                // use mawater card end

                DB::beginTransaction();
                $request_purchase = $store->purchases()->create($request->except('accessories'));

                foreach ($request->accessories as $accessory) {
                    $accessory_model = $this->accessory->find($accessory);
                    if ($accessory_model->available == 0 || $accessory_model->active == 0) {
                        DB::rollBack();
                        return responseJson(0, __('message.Service_id') . $accessory_model->id . __('message.not_available_or_not_active'));
                    }

                    $request_purchase->accessories()->attach($accessory);
                }

                DB::commit();
                return responseJson(1, 'success', new GetPurchasesResource($request_purchase));

            } else {
                return responseJson(0, $request->id . __('message.not_available_for_reservation'));
            }


        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }

    public function getUserPurchases()
    {
        try {
            $user = getAuthAPIUser();
            $user_requests = $user->accessoryStorePurchases;
            return $user_requests;
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }

    public function ShowUserPurchase($request)
    {
        try {
            $user = getAuthAPIUser();
            $user_request = $user->accessoryStorePurchases()->find($request->id);
            return $user_request;
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }

    public function offers($request)
    {
        try {
            $store = $this->model->find($request);

            $accessories = $store->accessories()->where('discount_type', '!=', '')->latest('id')->get();
            if (isset($accessories))
                $accessories->each(function ($item) {
                    $item->is_mowater_card = false;
                });

            $mowater_accessories = $store->accessories()->whereHas('offers')->get();
            if (isset($mowater_accessories)) {
                GeneralOffers($mowater_accessories);
            }
            return collect($accessories)->merge($mowater_accessories)->paginate(PAGINATION_COUNT);
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }
}
