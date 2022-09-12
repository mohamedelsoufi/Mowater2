<?php

use Illuminate\Support\Facades\Route;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

Route::get('car-models-of-brand/{id}', 'VehicleDetails\CarModelController@get_models_of_brand')->name('car-models-of-brand');

Route::group(['prefix' => LaravelLocalization::setLocale(),
    'middleware' => ['localeSessionRedirect', 'localizationRedirect', 'localeViewPath']], function () {
    Route::prefix('admin')->group(function () {
        //admin login
        Route::get('login', 'Auth\AuthController@login')->name('dashboard.login')->middleware('guest:admin');
        Route::post('authenticate', 'Auth\AuthController@authenticate')->name('authenticate');

        Route::get('cities-of-country/{id}', 'Location\CityController@get_cities_of_country')->name('cities-of-country');
        Route::get('areas-of-city/{id}', 'Location\AreaController@get_areas_of_city')->name('areas-of-city');


        Route::middleware(['auth:admin'])->group(function () {
            Route::get('/', 'Auth\AuthController@home')->name('admin.home');
            Route::get('logout', 'Auth\AuthController@logout')->name('admin.logout');

            //AdminRoles routes
            Route::resource('admin-roles', 'General\AdminRolesController');

            //user routes
            Route::resource('admin-users', 'General\AdminUserController');

            //brand routes
            Route::resource('brands', 'VehicleDetails\BrandsController');

            //manufacture country routes
            Route::resource('manufacture-countries', 'VehicleDetails\ManufacturingCountriesController');

            //car model routes
            Route::resource('car-models', 'VehicleDetails\CarModelController');


            //car class routes
            Route::resource('car-classes', 'VehicleDetails\CarClassController');

            //country routes
            Route::resource('countries', 'Location\CountryController');

            //city routes
            Route::resource('cities', 'Location\CityController');

            //area routes
            Route::resource('areas', 'Location\AreaController');

            //section routes
            Route::resource('sections', 'General\SectionController');
            Route::get('sections/sub-section/{id}', 'General\SectionController@subSection')->name('sections.subSection');

            //slider routes
            Route::resource('app-sliders', 'General\AppSliderController');
            Route::resource('organization-sliders', 'General\SliderController');

            //payment method routes
            Route::resource('payment-methods', 'General\PaymentMethodController');

            //Discount card
            Route::resource('discount-cards', 'General\DiscountCardController');

            //color routes
            Route::resource('colors', 'General\ColorController');

            //currency routes
            Route::resource('currencies', 'General\CurrencyController');

            //category routes
            Route::resource('categories', 'General\CategoryController');

            //sub category routes
            Route::resource('sub-categories', 'General\SubCategoryController');

            //auctions
            Route::resource('auctions', 'General\AuctionController');
            Route::get('org_product/{object}', 'General\AuctionController@org_products')->name('auctions.org_products');
            Route::get('org_vehicles/{object}', 'General\AuctionController@org_vehicles')->name('auctions.org_vehicles');

            //special numbers routes
            Route::resource('special-number-organizations', 'Organizations\SpecialNumberOrganizationController');
            Route::resource('special-number-categories', 'Organizations\SpecialNumberCategoryController');
            Route::resource('special-numbers', 'Organizations\SpecialNumberController');
            Route::get('get-categories/{id}', 'Organizations\SpecialNumberController@getCategories')->name('get-categories');
            Route::get('get-sub-categories/{id}', 'Organizations\SpecialNumberController@getSubCategories')->name('get-sub-categories');

            //agency routes
            Route::resource('agencies', 'Organizations\AgencyController');

            //Insurance Company routes
            Route::resource('insurance_companies', 'Organizations\InsuranceCompanyController');

            //car-showroom routes
            Route::resource('car-showrooms', 'Organizations\CarShowroomController');

            //rental-office routes
            Route::resource('rental-offices', 'Organizations\RentalOfficeController');

            //wench routes
            Route::resource('wenches', 'Organizations\WenchController');

            //garage routes
            Route::resource('garages', 'Organizations\GarageController');

            //Technical Inspection Center routes
            Route::resource('inspection-centers', 'Organizations\TechnicalInspectionCenterController');

            //Tire Exchange Center routes
            Route::resource('tire-exchange-centers', 'Organizations\TireExchangeCenterController');

            //Accessories Store routes
            Route::resource('accessories-stores', 'Organizations\AccessoriesStoreController');

            //Car Wash routes
            Route::resource('car-washes', 'Organizations\CarWashController');

            //Mining Center routes
            Route::resource('mining-centers', 'Organizations\MiningCenterController');

            //scraps
            Route::resource('scraps', 'Organizations\ScrapController');

            //spareparts
            Route::resource('spareparts', 'Organizations\SparePartController');

            //brokers
            Route::resource('brokers', 'Organizations\BrokerController');

            //trainers
            Route::resource('trainers', 'Organizations\DrivingTrainersController');

            //delivery
            Route::resource('delivery', 'Organizations\DeliveryController');

            //fuel station routes
            Route::resource('fuel-stations', 'Organizations\FuelStationController');

            //fuel station routes
            Route::resource('traffic-clearing-offices', 'Organizations\TrafficClearingOfficeController');

            //user
            Route::get('agency-user-org/{org_id}/id/{user_id}', 'Organizations\AgencyController@getUser')->name('agency.user');
            Route::get('agency-users-org/{org_id}', 'Organizations\AgencyController@getUsers')->name('agency.users');
            Route::get('broker-user-org/{org_id}/id/{user_id}', 'Organizations\BrokerController@getUser')->name('broker.user');
            Route::get('broker-users-org/{org_id}', 'Organizations\BrokerController@getUsers')->name('broker.users');
            Route::get('car-showroom-user-org/{org_id}/id/{user_id}', 'Organizations\CarShowroomController@getUser')->name('car-showroom.user');
            Route::get('car-showroom-users-org/{org_id}', 'Organizations\CarShowroomController@getUsers')->name('car-showroom.users');
            Route::get('delivery-user-org/{org_id}/id/{user_id}', 'Organizations\DeliveryController@getUser')->name('delivery-user.user');
            Route::get('delivery-users-org/{org_id}', 'Organizations\DeliveryController@getUsers')->name('delivery-user.users');
            Route::get('trainer-user-org/{org_id}/id/{user_id}', 'Organizations\DrivingTrainersController@getUser')->name('trainer.user');
            Route::get('trainer-users-org/{org_id}', 'Organizations\DrivingTrainersController@getUsers')->name('trainer.users');
            Route::get('garage-user-org/{org_id}/id/{user_id}', 'Organizations\GarageController@getUser')->name('garage.user');
            Route::get('garage-users-org/{org_id}', 'Organizations\GarageController@getUsers')->name('garage.users');
            Route::get('insurance-user-org/{org_id}/id/{user_id}', 'Organizations\InsuranceCompanyController@getUser')->name('insurance.user');
            Route::get('insurance-users-org/{org_id}', 'Organizations\InsuranceCompanyController@getUsers')->name('insurance.users');
            Route::get('rental-user-org/{org_id}/id/{user_id}', 'Organizations\RentalOfficeController@getUser')->name('rental.user');
            Route::get('rental-users-org/{org_id}', 'Organizations\RentalOfficeController@getUsers')->name('rental.users');
            Route::get('scrap-user-org/{org_id}/id/{user_id}', 'Organizations\ScrapController@getUser')->name('scrap.user');
            Route::get('sparepart-user-org/{org_id}/id/{user_id}', 'Organizations\SparePartController@getUser')->name('sparepart.user');
            Route::get('special-org-user/{org_id}/id/{user_id}', 'Organizations\SpecialNumberOrganizationController@getUser')->name('special-org.user');
            Route::get('special-org-users/{org_id}', 'Organizations\SpecialNumberOrganizationController@getUsers')->name('special-org.users');
            Route::get('wench-user-org/{org_id}/id/{user_id}', 'Organizations\WenchController@getUser')->name('wench.user');
            Route::get('wench-users-org/{org_id}', 'Organizations\WenchController@getUsers')->name('wench.users');
            Route::get('fuel-station-user-org/{org_id}/id/{user_id}', 'Organizations\FuelStationController@getUser')->name('fuel-station.user');
            Route::get('fuel-station-users-org/{org_id}', 'Organizations\FuelStationController@getUsers')->name('fuel-station.users');
            Route::get('traffic-clearing-user-org/{org_id}/id/{user_id}', 'Organizations\TrafficClearingOfficeController@getUser')->name('traffic.user');
            Route::get('traffic-clearing-users-org/{org_id}', 'Organizations\TrafficClearingOfficeController@getUsers')->name('traffic.users');
            Route::get('inspection-center-user-org/{org_id}/id/{user_id}', 'Organizations\TechnicalInspectionCenterController@getUser')->name('inspection.user');
            Route::get('inspection-center-users-org/{org_id}', 'Organizations\TechnicalInspectionCenterController@getUsers')->name('inspection.users');
            Route::get('tire-exchange-center-user-org/{org_id}/id/{user_id}', 'Organizations\TireExchangeCenterController@getUser')->name('tire-exchange.user');
            Route::get('tire-exchange-center-users-org/{org_id}', 'Organizations\TireExchangeCenterController@getUsers')->name('tire-exchange.users');
            Route::get('accessories-store-user-org/{org_id}/id/{user_id}', 'Organizations\AccessoriesStoreController@getUser')->name('accessories.user');
            Route::get('accessories-store-users-org/{org_id}', 'Organizations\AccessoriesStoreController@getUsers')->name('accessories.users');
            Route::get('car-wash-user-org/{org_id}/id/{user_id}', 'Organizations\CarWashController@getUser')->name('car-wash.user');
            Route::get('car-wash-users-org/{org_id}', 'Organizations\CarWashController@getUsers')->name('car-wash.users');
            Route::get('mining-center-user-org/{org_id}/id/{user_id}', 'Organizations\MiningCenterController@getUser')->name('mining-center.user');
            Route::get('mining-center-users-org/{org_id}', 'Organizations\MiningCenterController@getUsers')->name('mining-center.users');

        });

        Route::get('categories-of-main-category/{main_category}', 'Organizations\SpecialNumberCategoryController@get_categories_of_main_category')->name('main-category');

    });
});
