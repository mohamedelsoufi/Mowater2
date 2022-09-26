<?php

namespace Database\Seeders;

use App\Models\AccessoriesStore;
use App\Models\Accessory;
use App\Models\AdType;
use App\Models\Agency;
use App\Models\Broker;
use App\Models\BrokerPackage;
use App\Models\CarShowroom;
use App\Models\CarWash;
use App\Models\CarWashService;
use App\Models\DeliveryMan;
use App\Models\DrivingTrainer;
use App\Models\FuelStation;
use App\Models\Garage;
use App\Models\InsuranceCompany;
use App\Models\InsuranceCompanyPackage;
use App\Models\MiningCenter;
use App\Models\MiningCenterService;
use App\Models\Product;
use App\Models\RentalOffice;
use App\Models\RentalOfficeCar;
use App\Models\Service;
use App\Models\SpecialNumber;
use App\Models\SpecialNumberOrganization;
use App\Models\TechnicalInspectionCenter;
use App\Models\TechnicalInspectionCenterService;
use App\Models\TireExchangeCenter;
use App\Models\TireExchangeCenterService;
use App\Models\TrafficClearingOffice;
use App\Models\TrafficClearingService;
use App\Models\TrafficClearingServiceUse;
use App\Models\Vehicle;
use App\Models\Wench;
use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;

class AdSeeder extends Seeder
{
    public function run()
    {
        $class = "App\\Models\\";
        $is_negotiable = [0, 1];
        $price = [1598753, 3578951, 258963, 147852, 1476325];


        //Agency start
        $agency = Agency::inRandomOrder()->first();
        $vehicles = Vehicle::where('vehicable_type', $class . 'Agency')->inRandomOrder()->take(11)->get();
        foreach ($vehicles as $vehicle) {
            $vehicle->adsOn()->create([
                'organizationable_type' => $vehicle->vehicable_type,
                'organizationable_id' => $vehicle->vehicable_id,
                'title_ar' => 'إعلان وكالة ' . $vehicle->brand->name_ar,
                'title_en' => $vehicle->brand->name_en . ' Agency Ad',
                'description_ar' => 'تفاصيل الإعلان ' . $vehicle->brand->name_ar,
                'description_en' => 'Agency desc ' . $vehicle->brand->name_en,
                'price' => $price[array_rand($price)],
                'negotiable' => $is_negotiable[array_rand($is_negotiable)],
                'ad_type_id' =>   AdType::where('id','!=',4)->inRandomOrder()->first()->id,
                'country_id' => 1,
                'city_id' => 2,
                'area_id' => 3,
                'start_date' => Carbon::now(),
                'end_date' => '2022-12-31',
                'image' => $vehicle->files()->first()->getRawOriginal('path')
            ]);
        }
        $agency->ads()->create([
            'title_ar' => 'أعلان برابط خارجي',
            'title_en' => 'Ad in External Link',
            'description_ar' => 'تفاصيل اعلان الرابط الخارجي',
            'description_en' => 'Description of external link Ad',
            'price' => $price[array_rand($price)],
            'negotiable' => $is_negotiable[array_rand($is_negotiable)],
            'ad_type_id' => 4,
            'country_id' => 1,
            'city_id' => 2,
            'area_id' => 3,
            'start_date' => Carbon::now(),
            'end_date' => '2022-12-31',
            'image' => 'seeder/externalAd.jpg',
            'link' => 'https://www.google.com',
        ]);
        //Agency end

        //CarShowroom start
        $car_showroom = CarShowroom::inRandomOrder()->first();
        $vehicles = Vehicle::where('vehicable_type', $class . 'CarShowroom')->inRandomOrder()->take(11)->get();
        foreach ($vehicles as $vehicle) {
            $vehicle->adsOn()->create([
                'organizationable_type' => $vehicle->vehicable_type,
                'organizationable_id' => $vehicle->vehicable_id,
                'title_ar' => 'إعلان  ' . $vehicle->brand->name_ar,
                'title_en' => $vehicle->brand->name_en . ' Car Showroom Ad',
                'description_ar' => 'تفاصيل الإعلان ' . $vehicle->brand->name_ar,
                'description_en' => 'Car Showroom desc ' . $vehicle->brand->name_en,
                'price' => $price[array_rand($price)],
                'negotiable' => $is_negotiable[array_rand($is_negotiable)],
                'ad_type_id' =>   AdType::where('id','!=',4)->inRandomOrder()->first()->id,
                'country_id' => 1,
                'city_id' => 2,
                'area_id' => 3,
                'start_date' => Carbon::now(),
                'end_date' => '2022-12-31',
                'image' => $vehicle->files()->first()->getRawOriginal('path')
            ]);

        }
        $car_showroom->ads()->create([
            'title_ar' => 'أعلان برابط خارجي',
            'title_en' => 'Ad in External Link',
            'description_ar' => 'تفاصيل اعلان الرابط الخارجي',
            'description_en' => 'Description of external link Ad',
            'price' => $price[array_rand($price)],
            'negotiable' => $is_negotiable[array_rand($is_negotiable)],
            'ad_type_id' => 4,
            'country_id' => 1,
            'city_id' => 2,
            'area_id' => 3,
            'start_date' => Carbon::now(),
            'end_date' => '2022-12-31',
            'image' => 'seeder/externalAd.jpg',
            'link' => 'https://www.google.com',
        ]);
        //CarShowroom end

        //AccessoriesStore start
        $store = AccessoriesStore::inRandomOrder()->first();
        $accessories = Accessory::inRandomOrder()->take(11)->get();
        foreach ($accessories as $accessory) {
            $accessory->adsOn()->create([
                'organizationable_type' => 'App\\Models\\AccessoriesStore',
                'organizationable_id' => $accessory->accessories_store_id,
                'title_ar' => 'إعلان ' . $accessory->name_ar,
                'title_en' => $accessory->name_en . ' Accessory Ad',
                'description_ar' => 'تفاصيل الإعلان ' . $accessory->name_ar,
                'description_en' => 'Accessory desc ' . $accessory->name_en,
                'price' => $price[array_rand($price)],
                'negotiable' => $is_negotiable[array_rand($is_negotiable)],
                'ad_type_id' =>   AdType::where('id','!=',4)->inRandomOrder()->first()->id,
                'country_id' => 1,
                'city_id' => 2,
                'area_id' => 3,
                'start_date' => Carbon::now(),
                'end_date' => '2022-12-31',
                'image' => $accessory->files()->first()->getRawOriginal('path')
            ]);

        }
        $store->ads()->create([
            'title_ar' => 'أعلان برابط خارجي',
            'title_en' => 'Ad in External Link',
            'description_ar' => 'تفاصيل اعلان الرابط الخارجي',
            'description_en' => 'Description of external link Ad',
            'price' => $price[array_rand($price)],
            'negotiable' => $is_negotiable[array_rand($is_negotiable)],
            'ad_type_id' => 4,
            'country_id' => 1,
            'city_id' => 2,
            'area_id' => 3,
            'start_date' => Carbon::now(),
            'end_date' => '2022-12-31',
            'image' => 'seeder/externalAd.jpg',
            'link' => 'https://www.google.com',
        ]);
        //AccessoriesStore end

        //Broker start
        $broker = Broker::inRandomOrder()->first();
        $broker_packages = BrokerPackage::inRandomOrder()->take(11)->get();
        foreach ($broker_packages as $package) {
            $package->adsOn()->create([
                'organizationable_type' => 'App\\Models\\Broker',
                'organizationable_id' => $package->broker_id,
                'title_ar' => 'إعلان ' . $package->name_ar,
                'title_en' => $package->name_en . ' Broker Ad',
                'description_ar' => 'تفاصيل الإعلان ' . $package->name_ar,
                'description_en' => 'Broker desc ' . $package->name_en,
                'price' => $price[array_rand($price)],
                'negotiable' => $is_negotiable[array_rand($is_negotiable)],
                'ad_type_id' =>   AdType::where('id','!=',4)->inRandomOrder()->first()->id,
                'country_id' => 1,
                'city_id' => 2,
                'area_id' => 3,
                'start_date' => Carbon::now(),
                'end_date' => '2022-12-31',
                'image' => 'seeder/externalAd.jpg'
            ]);

        }
        $broker->ads()->create([
            'title_ar' => 'أعلان برابط خارجي',
            'title_en' => 'Ad in External Link',
            'description_ar' => 'تفاصيل اعلان الرابط الخارجي',
            'description_en' => 'Description of external link Ad',
            'price' => $price[array_rand($price)],
            'negotiable' => $is_negotiable[array_rand($is_negotiable)],
            'ad_type_id' => 4,
            'country_id' => 1,
            'city_id' => 2,
            'area_id' => 3,
            'start_date' => Carbon::now(),
            'end_date' => '2022-12-31',
            'image' => 'seeder/externalAd.jpg',
            'link' => 'https://www.google.com',
        ]);
        //Broker end

        //Insurance start
        $company = InsuranceCompany::inRandomOrder()->first();
        $company_packages = InsuranceCompanyPackage::inRandomOrder()->take(11)->get();
        foreach ($company_packages as $package) {
            $package->adsOn()->create([
                'organizationable_type' => 'App\\Models\\InsuranceCompany',
                'organizationable_id' => $package->insurance_company_id,
                'title_ar' => 'إعلان ' . $package->name_ar,
                'title_en' => $package->name_en . ' Insurance Ad',
                'description_ar' => 'تفاصيل الإعلان ' . $package->name_ar,
                'description_en' => 'Insurance desc ' . $package->name_en,
                'price' => $price[array_rand($price)],
                'negotiable' => $is_negotiable[array_rand($is_negotiable)],
                'ad_type_id' =>   AdType::where('id','!=',4)->inRandomOrder()->first()->id,
                'country_id' => 1,
                'city_id' => 2,
                'area_id' => 3,
                'start_date' => Carbon::now(),
                'end_date' => '2022-12-31',
                'image' => 'seeder/externalAd.jpg'
            ]);

        }
        $company->ads()->create([
            'title_ar' => 'أعلان برابط خارجي',
            'title_en' => 'Ad in External Link',
            'description_ar' => 'تفاصيل اعلان الرابط الخارجي',
            'description_en' => 'Description of external link Ad',
            'price' => $price[array_rand($price)],
            'negotiable' => $is_negotiable[array_rand($is_negotiable)],
            'ad_type_id' => 4,
            'country_id' => 1,
            'city_id' => 2,
            'area_id' => 3,
            'start_date' => Carbon::now(),
            'end_date' => '2022-12-31',
            'image' => 'seeder/externalAd.jpg',
            'link' => 'https://www.google.com',
        ]);
        //Insurance end

        //CarWash start
        $car_wash = CarWash::inRandomOrder()->first();
        $carWashServices = CarWashService::inRandomOrder()->take(11)->get();
        foreach ($carWashServices as $carWashService) {
            $carWashService->adsOn()->create([
                'organizationable_type' => 'App\\Models\\CarWash',
                'organizationable_id' => $carWashService->car_wash_id,
                'title_ar' => 'إعلان ' . $carWashService->name_ar,
                'title_en' => $carWashService->name_en . ' CarWash Ad',
                'description_ar' => 'تفاصيل الإعلان ' . $carWashService->name_ar,
                'description_en' => 'CarWash desc ' . $carWashService->name_en,
                'price' => $price[array_rand($price)],
                'negotiable' => $is_negotiable[array_rand($is_negotiable)],
                'ad_type_id' =>   AdType::where('id','!=',4)->inRandomOrder()->first()->id,
                'country_id' => 1,
                'city_id' => 2,
                'area_id' => 3,
                'start_date' => Carbon::now(),
                'end_date' => '2022-12-31',
                'image' => $carWashService->files()->first()->getRawOriginal('path')
            ]);
        }
        $car_wash->ads()->create([
            'title_ar' => 'أعلان برابط خارجي',
            'title_en' => 'Ad in External Link',
            'description_ar' => 'تفاصيل اعلان الرابط الخارجي',
            'description_en' => 'Description of external link Ad',
            'price' => $price[array_rand($price)],
            'negotiable' => $is_negotiable[array_rand($is_negotiable)],
            'ad_type_id' => 4,
            'country_id' => 1,
            'city_id' => 2,
            'area_id' => 3,
            'start_date' => Carbon::now(),
            'end_date' => '2022-12-31',
            'image' => 'seeder/externalAd.jpg',
            'link' => 'https://www.google.com',
        ]);
        //CarWash end

        //DeliveryMan start
        $delivery_man = DeliveryMan::inRandomOrder()->first();
        $delivery_man->ads()->create([
            'title_ar' => 'أعلان برابط خارجي',
            'title_en' => 'Ad in External Link',
            'description_ar' => 'تفاصيل اعلان الرابط الخارجي',
            'description_en' => 'Description of external link Ad',
            'price' => $price[array_rand($price)],
            'negotiable' => $is_negotiable[array_rand($is_negotiable)],
            'ad_type_id' => 4,
            'country_id' => 1,
            'city_id' => 2,
            'area_id' => 3,
            'start_date' => Carbon::now(),
            'end_date' => '2022-12-31',
            'image' => 'seeder/externalAd.jpg',
            'link' => 'https://www.google.com',
        ]);
        //DeliveryMan end

        //DrivingTrainer start
        $driving_trainer = DrivingTrainer::inRandomOrder()->first();
        $driving_trainer->ads()->create([
            'title_ar' => 'أعلان برابط خارجي',
            'title_en' => 'Ad in External Link',
            'description_ar' => 'تفاصيل اعلان الرابط الخارجي',
            'description_en' => 'Description of external link Ad',
            'price' => $price[array_rand($price)],
            'negotiable' => $is_negotiable[array_rand($is_negotiable)],
            'ad_type_id' => 4,
            'country_id' => 1,
            'city_id' => 2,
            'area_id' => 3,
            'start_date' => Carbon::now(),
            'end_date' => '2022-12-31',
            'image' => 'seeder/externalAd.jpg',
            'link' => 'https://www.google.com',
        ]);
        //DrivingTrainer end

        //FuelStation start
        $station = FuelStation::inRandomOrder()->first();
        $services = Service::where('servable_type', $class . 'FuelStation')->inRandomOrder()->take(11)->get();
        foreach ($services as $service) {
            $service->adsOn()->create([
                'organizationable_type' => $service->servable_type,
                'organizationable_id' => $service->servable_id,
                'title_ar' => 'إعلان  ' . $service->name_ar,
                'title_en' => $service->name_en . ' Fuel Station Ad',
                'description_ar' => 'تفاصيل الإعلان ' . $service->name_ar,
                'description_en' => 'Fuel Station desc ' . $service->name_en,
                'price' => $price[array_rand($price)],
                'negotiable' => $is_negotiable[array_rand($is_negotiable)],
                'ad_type_id' =>   AdType::where('id','!=',4)->inRandomOrder()->first()->id,
                'country_id' => 1,
                'city_id' => 2,
                'area_id' => 3,
                'start_date' => Carbon::now(),
                'end_date' => '2022-12-31',
                'image' => 'seeder/externalAd.jpg'
            ]);

        }
        $station->ads()->create([
            'title_ar' => 'أعلان برابط خارجي',
            'title_en' => 'Ad in External Link',
            'description_ar' => 'تفاصيل اعلان الرابط الخارجي',
            'description_en' => 'Description of external link Ad',
            'price' => $price[array_rand($price)],
            'negotiable' => $is_negotiable[array_rand($is_negotiable)],
            'ad_type_id' => 4,
            'country_id' => 1,
            'city_id' => 2,
            'area_id' => 3,
            'start_date' => Carbon::now(),
            'end_date' => '2022-12-31',
            'image' => 'seeder/externalAd.jpg',
            'link' => 'https://www.google.com',
        ]);
        //FuelStation end

        //Garage start
        $garage = Garage::inRandomOrder()->first();
        $services = Service::where('servable_type', $class . 'Garage')->inRandomOrder()->take(6)->get();
        foreach ($services as $service) {
            $service->adsOn()->create([
                'organizationable_type' => $service->servable_type,
                'organizationable_id' => $service->servable_id,
                'title_ar' => 'إعلان  ' . $service->name_ar,
                'title_en' => $service->name_en . ' Garage Ad',
                'description_ar' => 'تفاصيل الإعلان ' . $service->name_ar,
                'description_en' => 'Garage desc ' . $service->name_en,
                'price' => $price[array_rand($price)],
                'negotiable' => $is_negotiable[array_rand($is_negotiable)],
                'ad_type_id' =>   AdType::where('id','!=',4)->inRandomOrder()->first()->id,
                'country_id' => 1,
                'city_id' => 2,
                'area_id' => 3,
                'start_date' => Carbon::now(),
                'end_date' => '2022-12-31',
                'image' => $service->files != null ? $service->files()->first()->getRawOriginal('path') : 'seeder/externalAd.jpg'
            ]);

        }
        $products = Product::where('productable_type', $class . 'Garage')->inRandomOrder()->take(5)->get();
        foreach ($products as $product) {
            $product->adsOn()->create([
                'organizationable_type' => $product->productable_type,
                'organizationable_id' => $product->productable_id,
                'title_ar' => 'إعلان  ' . $product->name_ar,
                'title_en' => $product->name_en . ' Garage Ad',
                'description_ar' => 'تفاصيل الإعلان ' . $product->name_ar,
                'description_en' => 'Garage desc ' . $product->name_en,
                'price' => $price[array_rand($price)],
                'negotiable' => $is_negotiable[array_rand($is_negotiable)],
                'ad_type_id' =>   AdType::where('id','!=',4)->inRandomOrder()->first()->id,
                'country_id' => 1,
                'city_id' => 2,
                'area_id' => 3,
                'start_date' => Carbon::now(),
                'end_date' => '2022-12-31',
                'image' => $product->files != null ? $product->files()->first()->getRawOriginal('path') : 'seeder/externalAd.jpg'
            ]);

        }
        $garage->ads()->create([
            'title_ar' => 'أعلان برابط خارجي',
            'title_en' => 'Ad in External Link',
            'description_ar' => 'تفاصيل اعلان الرابط الخارجي',
            'description_en' => 'Description of external link Ad',
            'price' => $price[array_rand($price)],
            'negotiable' => $is_negotiable[array_rand($is_negotiable)],
            'ad_type_id' => 4,
            'country_id' => 1,
            'city_id' => 2,
            'area_id' => 3,
            'start_date' => Carbon::now(),
            'end_date' => '2022-12-31',
            'image' => 'seeder/externalAd.jpg',
            'link' => 'https://www.google.com',
        ]);
        //Garage end

        //MiningCenter start
        $mining_center = MiningCenter::inRandomOrder()->first();
        $mining_services = MiningCenterService::inRandomOrder()->take(11)->get();
        foreach ($mining_services as $mining_service) {
            $mining_service->adsOn()->create([
                'organizationable_type' => 'App\\Models\\MiningCenter',
                'organizationable_id' => $mining_service->mining_center_id,
                'title_ar' => 'إعلان ' . $mining_service->name_ar,
                'title_en' => $mining_service->name_en . ' MiningCenter Ad',
                'description_ar' => 'تفاصيل الإعلان ' . $mining_service->name_ar,
                'description_en' => 'MiningCenter desc ' . $mining_service->name_en,
                'price' => $price[array_rand($price)],
                'negotiable' => $is_negotiable[array_rand($is_negotiable)],
                'ad_type_id' =>   AdType::where('id','!=',4)->inRandomOrder()->first()->id,
                'country_id' => 1,
                'city_id' => 2,
                'area_id' => 3,
                'start_date' => Carbon::now(),
                'end_date' => '2022-12-31',
                'image' => $mining_service->files()->first()->getRawOriginal('path')
            ]);
        }
        $mining_center->ads()->create([
            'title_ar' => 'أعلان برابط خارجي',
            'title_en' => 'Ad in External Link',
            'description_ar' => 'تفاصيل اعلان الرابط الخارجي',
            'description_en' => 'Description of external link Ad',
            'price' => $price[array_rand($price)],
            'negotiable' => $is_negotiable[array_rand($is_negotiable)],
            'ad_type_id' => 4,
            'country_id' => 1,
            'city_id' => 2,
            'area_id' => 3,
            'start_date' => Carbon::now(),
            'end_date' => '2022-12-31',
            'image' => 'seeder/externalAd.jpg',
            'link' => 'https://www.google.com',
        ]);
        //MiningCenter end

        //RentalOffice start
        $rental = RentalOffice::inRandomOrder()->first();
        $rental_cars = RentalOfficeCar::inRandomOrder()->take(11)->get();
        foreach ($rental_cars as $rental_car) {
            $rental_car->adsOn()->create([
                'organizationable_type' => 'App\\Models\\RentalOffice',
                'organizationable_id' => $rental_car->rental_office_id,
                'title_ar' => 'إعلان ' . $rental_car->brand->name_ar,
                'title_en' => $rental_car->brand->name_en . ' RentalOffice Ad',
                'description_ar' => 'تفاصيل الإعلان ' . $rental_car->brand->name_ar,
                'description_en' => 'RentalOffice desc ' . $rental_car->brand->name_en,
                'price' => $price[array_rand($price)],
                'negotiable' => $is_negotiable[array_rand($is_negotiable)],
                'ad_type_id' =>   AdType::where('id','!=',4)->inRandomOrder()->first()->id,
                'country_id' => 1,
                'city_id' => 2,
                'area_id' => 3,
                'start_date' => Carbon::now(),
                'end_date' => '2022-12-31',
                'image' => $rental_car->files()->first()->getRawOriginal('path')
            ]);
        }
        $rental->ads()->create([
            'title_ar' => 'أعلان برابط خارجي',
            'title_en' => 'Ad in External Link',
            'description_ar' => 'تفاصيل اعلان الرابط الخارجي',
            'description_en' => 'Description of external link Ad',
            'price' => $price[array_rand($price)],
            'negotiable' => $is_negotiable[array_rand($is_negotiable)],
            'ad_type_id' => 4,
            'country_id' => 1,
            'city_id' => 2,
            'area_id' => 3,
            'start_date' => Carbon::now(),
            'end_date' => '2022-12-31',
            'image' => 'seeder/externalAd.jpg',
            'link' => 'https://www.google.com',
        ]);
        //RentalOffice end

        //SpecialNumber start
        $special_number_org = SpecialNumberOrganization::inRandomOrder()->first();
        $numbers = SpecialNumber::inRandomOrder()->take(11)->get();
        foreach ($numbers as $number) {
            $number->adsOn()->create([
                'organizationable_type' => 'App\\Models\\SpecialNumberOrganization',
                'organizationable_id' => $number->special_number_organization_id,
                'title_ar' => 'إعلان ' . $number->number,
                'title_en' => $number->number . ' SpecialNumber Ad',
                'description_ar' => 'تفاصيل الإعلان ' . $number->number,
                'description_en' => 'SpecialNumber desc ' . $number->number,
                'price' => $price[array_rand($price)],
                'negotiable' => $is_negotiable[array_rand($is_negotiable)],
                'ad_type_id' =>   AdType::where('id','!=',4)->inRandomOrder()->first()->id,
                'country_id' => 1,
                'city_id' => 2,
                'area_id' => 3,
                'start_date' => Carbon::now(),
                'end_date' => '2022-12-31',
                'image' => 'seeder/externalAd.jpg'
            ]);
        }
        $special_number_org->ads()->create([
            'title_ar' => 'أعلان برابط خارجي',
            'title_en' => 'Ad in External Link',
            'description_ar' => 'تفاصيل اعلان الرابط الخارجي',
            'description_en' => 'Description of external link Ad',
            'price' => $price[array_rand($price)],
            'negotiable' => $is_negotiable[array_rand($is_negotiable)],
            'ad_type_id' => 4,
            'country_id' => 1,
            'city_id' => 2,
            'area_id' => 3,
            'start_date' => Carbon::now(),
            'end_date' => '2022-12-31',
            'image' => 'seeder/externalAd.jpg',
            'link' => 'https://www.google.com',
        ]);
        //SpecialNumber end

        //TechnicalInspectionCenter start
        $inspection_center = TechnicalInspectionCenter::inRandomOrder()->first();
        $inspection_services = TechnicalInspectionCenterService::inRandomOrder()->take(11)->get();
        foreach ($inspection_services as $inspection_service) {
            $inspection_service->adsOn()->create([
                'organizationable_type' => 'App\\Models\\TechnicalInspectionCenter',
                'organizationable_id' => $inspection_service->technical_inspection_center_id,
                'title_ar' => 'إعلان ' . $inspection_service->name_ar,
                'title_en' => $inspection_service->name_en . ' MiningCenter Ad',
                'description_ar' => 'تفاصيل الإعلان ' . $inspection_service->name_ar,
                'description_en' => 'MiningCenter desc ' . $inspection_service->name_en,
                'price' => $price[array_rand($price)],
                'negotiable' => $is_negotiable[array_rand($is_negotiable)],
                'ad_type_id' =>   AdType::where('id','!=',4)->inRandomOrder()->first()->id,
                'country_id' => 1,
                'city_id' => 2,
                'area_id' => 3,
                'start_date' => Carbon::now(),
                'end_date' => '2022-12-31',
                'image' => $inspection_service->files()->first()->getRawOriginal('path')
            ]);
        }
        $inspection_center->ads()->create([
            'title_ar' => 'أعلان برابط خارجي',
            'title_en' => 'Ad in External Link',
            'description_ar' => 'تفاصيل اعلان الرابط الخارجي',
            'description_en' => 'Description of external link Ad',
            'price' => $price[array_rand($price)],
            'negotiable' => $is_negotiable[array_rand($is_negotiable)],
            'ad_type_id' => 4,
            'country_id' => 1,
            'city_id' => 2,
            'area_id' => 3,
            'start_date' => Carbon::now(),
            'end_date' => '2022-12-31',
            'image' => 'seeder/externalAd.jpg',
            'link' => 'https://www.google.com',
        ]);
        //TechnicalInspectionCenter end

        //TireExchangeCenter start
        $tire_center = TireExchangeCenter::inRandomOrder()->first();
        $tire_services = TireExchangeCenterService::inRandomOrder()->take(11)->get();
        foreach ($tire_services as $tire_service) {
            $tire_service->adsOn()->create([
                'organizationable_type' => 'App\\Models\\TireExchangeCenter',
                'organizationable_id' => $tire_service->tire_exchange_center_id,
                'title_ar' => 'إعلان ' . $tire_service->name_ar,
                'title_en' => $tire_service->name_en . ' MiningCenter Ad',
                'description_ar' => 'تفاصيل الإعلان ' . $tire_service->name_ar,
                'description_en' => 'MiningCenter desc ' . $tire_service->name_en,
                'price' => $price[array_rand($price)],
                'negotiable' => $is_negotiable[array_rand($is_negotiable)],
                'ad_type_id' =>   AdType::where('id','!=',4)->inRandomOrder()->first()->id,
                'country_id' => 1,
                'city_id' => 2,
                'area_id' => 3,
                'start_date' => Carbon::now(),
                'end_date' => '2022-12-31',
                'image' => $tire_service->files()->first()->getRawOriginal('path')
            ]);
        }
        $tire_center->ads()->create([
            'title_ar' => 'أعلان برابط خارجي',
            'title_en' => 'Ad in External Link',
            'description_ar' => 'تفاصيل اعلان الرابط الخارجي',
            'description_en' => 'Description of external link Ad',
            'price' => $price[array_rand($price)],
            'negotiable' => $is_negotiable[array_rand($is_negotiable)],
            'ad_type_id' => 4,
            'country_id' => 1,
            'city_id' => 2,
            'area_id' => 3,
            'start_date' => Carbon::now(),
            'end_date' => '2022-12-31',
            'image' => 'seeder/externalAd.jpg',
            'link' => 'https://www.google.com',
        ]);
        //TireExchangeCenter end

        //TrafficClearingOffice start
        $traffic = TrafficClearingOffice::inRandomOrder()->first();
        $traffic_services = TrafficClearingServiceUse::inRandomOrder()->take(11)->get();
        foreach ($traffic_services as $traffic_service) {
            $traffic_service->adsOn()->create([
                'organizationable_type' => 'App\\Models\\TrafficClearingOffice',
                'organizationable_id' => $traffic_service->traffic_clearing_office_id,
                'title_ar' => 'إعلان ' . $traffic_service->traffic_service->name_ar,
                'title_en' => $traffic_service->traffic_servicename_en . ' MiningCenter Ad',
                'description_ar' => 'تفاصيل الإعلان ' . $traffic_service->traffic_servicename_ar,
                'description_en' => 'MiningCenter desc ' . $traffic_service->traffic_servicename_en,
                'price' => $price[array_rand($price)],
                'negotiable' => $is_negotiable[array_rand($is_negotiable)],
                'ad_type_id' =>   AdType::where('id','!=',4)->inRandomOrder()->first()->id,
                'country_id' => 1,
                'city_id' => 2,
                'area_id' => 3,
                'start_date' => Carbon::now(),
                'end_date' => '2022-12-31',
                'image' => 'seeder/externalAd.jpg'
            ]);
        }
        $traffic->ads()->create([
            'title_ar' => 'أعلان برابط خارجي',
            'title_en' => 'Ad in External Link',
            'description_ar' => 'تفاصيل اعلان الرابط الخارجي',
            'description_en' => 'Description of external link Ad',
            'price' => $price[array_rand($price)],
            'negotiable' => $is_negotiable[array_rand($is_negotiable)],
            'ad_type_id' => 4,
            'country_id' => 1,
            'city_id' => 2,
            'area_id' => 3,
            'start_date' => Carbon::now(),
            'end_date' => '2022-12-31',
            'image' => 'seeder/externalAd.jpg',
            'link' => 'https://www.google.com',
        ]);
        //TrafficClearingOffice end

        //Wench start
        $wench = Wench::inRandomOrder()->first();
        $services = Service::where('servable_type', $class . 'Wench')->inRandomOrder()->take(11)->get();
        foreach ($services as $service) {
            $service->adsOn()->create([
                'organizationable_type' => $service->servable_type,
                'organizationable_id' => $service->servable_id,
                'title_ar' => 'إعلان  ' . $service->name_ar,
                'title_en' => $service->name_en . ' Wench Ad',
                'description_ar' => 'تفاصيل الإعلان ' . $service->name_ar,
                'description_en' => 'Wench desc ' . $service->name_en,
                'price' => $price[array_rand($price)],
                'negotiable' => $is_negotiable[array_rand($is_negotiable)],
                'ad_type_id' =>   AdType::where('id','!=',4)->inRandomOrder()->first()->id,
                'country_id' => 1,
                'city_id' => 2,
                'area_id' => 3,
                'start_date' => Carbon::now(),
                'end_date' => '2022-12-31',
                'image' => 'seeder/externalAd.jpg'
            ]);

        }
        $wench->ads()->create([
            'title_ar' => 'أعلان برابط خارجي',
            'title_en' => 'Ad in External Link',
            'description_ar' => 'تفاصيل اعلان الرابط الخارجي',
            'description_en' => 'Description of external link Ad',
            'price' => $price[array_rand($price)],
            'negotiable' => $is_negotiable[array_rand($is_negotiable)],
            'ad_type_id' => 4,
            'country_id' => 1,
            'city_id' => 2,
            'area_id' => 3,
            'start_date' => Carbon::now(),
            'end_date' => '2022-12-31',
            'image' => 'seeder/externalAd.jpg',
            'link' => 'https://www.google.com',
        ]);
        //Wench end
    }
}
