<?php

namespace App\Http\Controllers\API\Organizations;

use App\Http\Controllers\Controller;
use App\Http\Requests\API\ReserveVehicleRequest;
use App\Http\Requests\API\Show3DFileRequest;
use App\Http\Requests\API\ShowTestDriveRequest;
use App\Http\Requests\API\ShowVehicleRequest;
use App\Http\Requests\API\TestDriveRequest;
use App\Http\Requests\API\VehiclesRequest;
use App\Http\Resources\Vehicles\AllVehiclesResource;
use App\Http\Resources\Vehicles\GetReservedVehiclesResource;
use App\Http\Resources\Vehicles\ShowTestDriveResource;
use App\Http\Resources\Vehicles\ShowVehicleResource;
use App\Http\Resources\Vehicles\TestDriveResource;
use App\Models\Branch;
use App\Models\DiscoutnCardUserUse;
use App\Models\Offer;
use App\Models\Vehicle;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;


class VehicleController extends Controller
{

    // get organization vehicles
    public function vehicles(VehiclesRequest $request)
    {
        try {
            $class = 'App\\Models\\' . $request->model_type;
            $model = new $class;               // $model = Product
            $record = $model->find($request->model_id); // $record = Product::find(1);
            if (!$record) {
                return responseJson(0, 'error');
            }
            $organization_vehicles = $record->vehicles()->with('brand', 'car_model', 'car_class')->active()->overView()->search()->latest('id')->paginate(PAGINATION_COUNT);
            if (empty($organization_vehicles))
                return responseJson(0, __('message.no_result'));
            return responseJson(1, 'success', AllVehiclesResource::collection($organization_vehicles)->response()->getData(true));
        } catch (\Exception $e) {
            return responseJson(0, 'error', $e->getMessage());
        }
    }

    // show vehicles
    public function get_vehicle(ShowVehicleRequest $request)
    {
        try {
            $vehicle = Vehicle::find($request->id);
            if (empty($vehicle)){
                return responseJson(0,'error',__('message.no_result'));
            }
            //update number of views start
            updateNumberOfViews($vehicle);
            //update number of views end

            $vehicle->makeHidden('one_image');

            return responseJson(1, 'success', new ShowVehicleResource($vehicle));
        } catch (\Exception $e) {
            return responseJson(0, 'error', $e->getTrace());
        }
    }

    // reserve vehicle
    public function reserve_vehicle(ReserveVehicleRequest $request)
    {
        try {
            // auth user
            $user = getAuthAPIUser();

            // store vehicle
            $validator = $request->except(['personal_ID', 'driving_license']);
            $vehicle = Vehicle::find($request->vehicle_id);

            if ($vehicle->active == false)
                return responseJson(0, __('message.reservation_not_active'));

            if ($vehicle->availability == false)
                return responseJson(0, __('message.reservation_not_available'));

            $user_vehicle_reservations =  $user->reserve_vehicles()->first();
            if ($user_vehicle_reservations)
                return responseJson(0, __('message.vehicle_reserved_before'));

            // use mawater card start
            if ($request->is_mawater_card == true) {
                try {
                    \DB::beginTransaction();
                    $branch = Branch::find($request->branch_id);
                    $organization = $branch->branchable;
                    $vehicle_offers = $organization->vehicles()->wherehas('offers')->pluck('id')->toArray();
                    if (in_array($request->vehicle_id, $vehicle_offers)) {
                        $vehicle_offer = Offer::where('offerable_id', $vehicle->id)
                            ->where('offerable_type', 'App\\Models\\Vehicle')->first();

                        $consumption = DiscoutnCardUserUse::where('barcode', $request->barcode)
                            ->where('offer_id', $vehicle_offer->id)->first();
                        if (!$consumption) {
                            DiscoutnCardUserUse::create([
                                'user_id' => $user->id,
                                'barcode' => $request->barcode,
                                'offer_id' => $vehicle_offer->id,
                                'original_number_of_uses' => $vehicle_offer->specific_number,
                                'consumption_number' => 1
                            ]);
                        } else {
                            if ($consumption->consumption_number == $consumption->original_number_of_uses) {
                                return responseJson(0, 'error', 'you have reach max number of consumption for vehicle id: ' . $vehicle->id);
                            }
                            $consumption->update([
                                'consumption_number' => $consumption->consumption_number + 1
                            ]);
                        }
                    } else {
                        return responseJson(0, 'error', __('message.vehicle_id') . $request->vehicle_id . __('message.service_not_fount_in_offer'));
                    }


                    \DB::commit();
                } catch (\Exception $e) {
                    \DB::rollBack();
                    return responseJson(0, 'error', $e->getMessage());
                }

            }
            // use mawater card end

            $store_vehicle_reservation = $user->reserve_vehicles()->create($validator);

            // add related files images for (driving license [front,back] , personal ID [front,back])
            $vehicle = $store_vehicle_reservation->refresh();

            $vehicle->upload_reserve_vehicle_images();

            return responseJson(1, 'success',__('message.vehicle_successfully_reserved'));
        } catch (\Exception $e) {
            return responseJson(0, 'error', $e->getMessage());
        }
    }

    // get profile vehicle reservation
    public function get_reservation_vehicles()
    {
        try {
            // auth user
            $user = getAuthAPIUser();

            $reserved_vehicles = $user->reserve_vehicles()->latest('id')->paginate(PAGINATION_COUNT);
            if (!$reserved_vehicles->isEmpty()) {
                return responseJson(1, 'success', GetReservedVehiclesResource::collection($reserved_vehicles)->response()->getData(true));
            }
            return responseJson(0, __('message.no_vehicle_reservation_for_this_account'));
        } catch (\Exception $e) {
            return responseJson(0, 'error', $e->getMessage());
        }
    }

    // add test drive
    public function add_test_drive(TestDriveRequest $request)
    {
        try {
            $class = Vehicle::find($request->vehicle_id);
            $class->makeHidden('one_image');
            $model_type = $class->vehicable_type;
            $model = new $model_type;
            $record = $model->find($class->vehicable_id);

            if (!$record) {
                return responseJson(0, 'error');
            }

            $organization = $record->branches()->find($request->branch_id);

            if ($organization) {
                $id = $request->branch_id;
                $date = $request->date;
                $vehicle_id = $request->vehicle_id;
                $available_times =  branchAvailableTimeForTestDrive($date,$id, $vehicle_id);
                if (!$available_times) {
                    return responseJson(0, __('message.this_time_is_not_available'));
                } else {
                    if (in_array(date("h:i a", strtotime($request->time)), $available_times)) {
                        if ($organization->reservation_active == 0)
                            return responseJson(0, 'error', __('message.reservation_not_active'));

                        if ($organization->reservation_availability == true) {

                            // auth user
                            $user = getAuthAPIUser();

                            if ($class->availability == 0)
                                return responseJson(0, 'error', __('message.reservation_not_available'));
                            if ($class->active == 0)
                                return responseJson(0, 'error', __('message.reservation_not_active'));

                            // store vehicle
                            $validator = $request->except(['driving_license_for_test']);
                            $validator['user_id'] = $user->id;
                            $store_test_drive = $record->tests()->create($validator);

                            // add related files images for (driving license [front,back] , personal ID [front,back])
                            $vehicle = $store_test_drive->refresh();

                            $vehicle->upload_reserve_vehicle_images();

                            return responseJson(1, __('message.test_drive_added_successfully'));


                        } else {
                            return responseJson(0, $request->vehicle_id . __('message.not_available_for_reservation'));
                        }
                    }
                    return responseJson(0, __('message.this_time_is_reserved'));
                }

            }
            return responseJson(0, 'error');
        } catch (\Exception $e) {
            return responseJson(0, 'error', $e->getMessage());
        }
    }

    // get all test_drive
    public function test_drives()
    {
        try {
            // auth user
            $user = getAuthAPIUser();

            $test_drives = $user->test_drives()->with('vehicle')->latest('id')->paginate(PAGINATION_COUNT);
            if ($test_drives->isEmpty())
                return responseJson(0, __('message.no_result'));
            return responseJson(1, 'success', TestDriveResource::collection($test_drives)->response()->getData(true));
        } catch (\Exception $e) {
            return responseJson(0, 'error', $e->getMessage());
        }
    }

    // show test_drive
    public function show_test_drive(ShowTestDriveRequest $request)
    {
        try {
            // auth user
            $user = getAuthAPIUser();
            $test_drives = $user->test_drives()->with('vehicle', 'files')->find($request->id);
            if (empty($test_drives))
                return responseJson(0, __('message.no_result'));
            return responseJson(1, 'success', new ShowTestDriveResource($test_drives));
        } catch (\Exception $e) {
            return responseJson(0, 'error', $e->getMessage());
        }
    }

    // get 3d file
    public function get3dFile(Show3DFileRequest $request)
    {
        try {
            $vehicle = Vehicle::find($request->vehicle_id);
            $object = $vehicle->files()->where('color_id', $request->color_id)->where('type', 'vehicle_3D')->get();
            if (empty($object))
                return responseJson(0, __('message.no_result'));
            return responseJson(1, 'success', $object);
        }catch (\Exception $e){
            return responseJson(0,'error',$e->getMessage());
        }
    }

}
