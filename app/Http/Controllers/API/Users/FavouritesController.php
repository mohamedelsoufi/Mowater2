<?php

namespace App\Http\Controllers\API\Users;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use function PHPUnit\Framework\isEmpty;

class FavouritesController extends Controller
{
    public function add_to_favourites(Request $request)
    {
        $rules = [
            'model_type' => 'required|in:Agency,CarShowroom,Garage,RentalOffice,SpecialNumberOrganization
            ,Wench,Vehicle,AccessoriesStore,Accessory,Ad,Branch,Broker,BrokerPackage,CarWash,FuelStation
            ,CarWashService,DeliveryMan,DrivingTrainer,InsuranceCompany,InsuranceCompanyPackage,MiningCenter
            ,MiningCenterService,Product,RentalOfficeCar,Scrap,Service,SparePart,SpecialNumber,TechnicalInspectionCenter
            ,TechnicalInspectionCenterService,TireExchangeCenter,TireExchangeCenterService,TrafficClearingOffice
            ,TrafficClearingService',
            'model_id' => 'required'
        ];

        $validator = validator()->make($request->all(), $rules);

        if ($validator->fails()) {
            return responseJson(0, $validator->errors()->first(), $validator->errors());
        }


        $class = 'App\\Models\\' . $request->model_type; // 'App\\Models\Product'
        $model = new $class;               // $model = Product
        $record = $model->find($request->model_id); // $record = Product::find(1);

        if (!$record) {
            return responseJson(0, 'error');
        }

        $record->attachFavourite();
        return responseJson(1, 'success');
    }

    public function remove_from_favourites(Request $request)
    {
        $client = auth('api')->user();

        $rules = [
            'model_type' => 'required|in:Agency,CarShowroom,Garage,RentalOffice,SpecialNumberOrganization,Wench',
            'model_id' => 'required'
        ];

        $validator = validator()->make($request->all(), $rules);

        if ($validator->fails()) {
            return responseJson(0, $validator->errors()->first(), $validator->errors());
        }


        $class = 'App\\Models\\' . $request->model_type; // 'App\\Models\Product'
        $model = new $class;               // $model = Product
        $record = $model->find($request->model_id); // $record = Product::find(1);

        if (!$record) {
            return responseJson(0, 'error');
        }

        $record->detachFavourite();
        return responseJson(1, 'success');
    }

    public function get_favourites()
    {
        $user = auth('api')->id();
        $favourites = DB::table('favourables')->where('user_id', $user)->select('favourable_type','favourable_id')
            ->get();


        $favourites->map(function ($org) {
            $model_type= $org->favourable_type;
            $model_id= $org->favourable_id;
            $class = new $model_type;
            $favorite_item = $class->find($model_id);
            if ($model_type === 'App\\Models\\Vehicle'){
                $org->name = $favorite_item->main_vehicle->brand->name . '<->'.$favorite_item->main_vehicle->car_model->name . '<->'. $favorite_item->main_vehicle->car_class->name;
            }else{
                $org->name = $favorite_item->name;
            }

            $org->favourable_type = str_replace('App\\Models\\', '', $org->favourable_type);
            return $org;
        });

        $grouping = $favourites->groupBy('favourable_type')->toArray();

        $groupingArray = [];
        foreach ($grouping as $key => $value) {
            $groupingArray[] = (object) [
                'type' => $key,
                'data' => $value,
            ];
        }

        if ($grouping == null) {
            return responseJson(0, __('message.no_favourites_exists'));
        } else {
            return responseJson(1, 'success', $groupingArray);
        }
//        $favourites = DB::table('favourables')->where('user_id', $user)->select('favourable_type','favourable_id')->get()->map(function ($org) {
//            $org->favourable_type = str_replace('App\\Models\\', '', $org->favourable_type);
//            return $org;
//        });
//        if ($grouping->isEmpty())
//            return responseJson(0, __('message.no_favourites_exists'));
//        return responseJson(1,'success', $favourites);
    }

}
