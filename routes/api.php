<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/


// unauthenticated routes
Route::group(['namespace' => 'API', 'middleware' => 'APILocalization'], function () {
    Route::group(['namespace' => 'General'], function () {
        // section routes
        Route::get('sections', 'SectionController@index');
        Route::get('show-section', 'SectionController@show');

        // slider routes
        Route::get('sliders', 'SliderController@home_sliders');

        // brand routes
        Route::get('brands', 'BrandController@index');

        // car model routes
        Route::get('car-models', 'CarModelController@index');
        Route::get('get-manufacturing-years', 'CarModelController@getManufacturingYears');

        // car class routes
        Route::get('car-classes', 'CarClassController@index');
        Route::get('get-engine-sizes', 'CarClassController@getEngineSize');

        // country routes
        Route::get('countries', 'CountryController@index');
        Route::get('show-country', 'CountryController@show');

        // city routes
        Route::get('cities', 'CityController@index');
        Route::get('show-city', 'CityController@show');

        // area routes
        Route::get('areas', 'AreaController@index');
        Route::get('show-area', 'AreaController@show');

        //color routes
        Route::get('colors', 'ColorController@index');
        Route::get('show-color', 'ColorController@show');

        //color routes
        Route::get('currencies', 'CurrencyController@index');
        Route::get('show-currency', 'CurrencyController@show');

        //ads routes
        Route::get('ads', 'AdsController@index');
        Route::get('show-ad', 'AdsController@show_ad')->name('ads.show');
        //auctions routes
        Route::get('all-auctions', 'AuctionsController@index');
        Route::get('show-auction', 'AuctionsController@show_auction');
        Route::get('auction-bids', 'AuctionsController@auctionBids');

        //products categories
        Route::get('get-products-categories', 'ProductController@get_products_categories');

        //payment methods
        Route::get('get-payment-methods', 'PaymentMethodController@index');
        Route::get('show-payment-method', 'PaymentMethodController@show');

    });


    Route::group(['namespace' => 'Organizations'], function () {
        // Agency routes


        Route::get('agencies', 'AgencyController@index');
        Route::get('show-agency', 'AgencyController@show');
        Route::get('agency_products', 'AgencyController@products');
        Route::get('agency_services', 'AgencyController@services');
        Route::get('agency_categories', 'AgencyController@categories');
        Route::get('agency-mawater-card-offers', 'AgencyController@getDiscountCardOffers');

        //Branches
        Route::get('branches', 'BranchController@index');
        Route::get('show-branch', 'BranchController@show');
        Route::get('branch-available-times', 'BranchController@available_times');
        Route::get('branch-products', 'BranchController@products');
        Route::get('branch-services', 'BranchController@services');
        Route::get('branch-vehicles', 'BranchController@vehicles');
        Route::get('branches-lookup', 'BranchController@getLookingUpBranches');
        Route::get('service-available-time', 'BranchController@serviceAvailableTime');


        // CarShowroom routes
        Route::get('car-show-room', 'CarShowroomController@index');
        Route::get('show-car-show-room', 'CarShowroomController@show');
        Route::get('car-showroom-mawater-card-offers', 'CarShowroomController@getDiscountCardOffers');


        // RentalOffice routes
        Route::get('rental-office', 'RentalOfficeController@index');
        Route::get('show-rental-office', 'RentalOfficeController@show');
        Route::get('show-rental-office-car', 'RentalOfficeController@show_rental_office_car');
        Route::get('get-rental-office-cars', 'RentalOfficeController@getRentalOfficeCars');
        Route::get('rental-office-mawater-card-offers', 'RentalOfficeController@getDiscountCardOffers');

        // Garage routes
        Route::get('garages', 'GarageController@index');
        Route::get('show-garage', 'GarageController@show');
        Route::get('garages-categories', 'GarageCategoriesController@index');
//        Route::get('garage-available-times', 'GarageController@available_times');
        Route::get('garage-products', 'GarageController@get_products');
        Route::get('garage-services', 'GarageController@get_services');
        Route::get('garage-mawater-card-offers', 'GarageController@getDiscountCardOffers');

        // Wench routes
        Route::get('wenches', 'WenchController@index');
        Route::get('show-wench', 'WenchController@show');
//        Route::get('wench-available-times', 'WenchController@available_times');
        Route::get('wench-services', 'WenchController@get_services');
        Route::get('nearest-wench', 'WenchController@nearest_location');
        Route::get('wench-mawater-card-offers', 'WenchController@getDiscountCardOffers');

        // Special numbers routes
        Route::get('special_numbers-categories', 'SpecialNumberController@getCategories');
        Route::get('special_numbers', 'SpecialNumberController@index');
        Route::get('show-special_number', 'SpecialNumberController@show');
        Route::get('special-number-offers', 'SpecialNumberController@getOffers');
        Route::get('get-special-number-organizations', 'SpecialNumberController@getOrganizations');
        Route::get('show-special-number-organization', 'SpecialNumberController@showOrganization')->name('special-org.show');

        // Vehicles routes
        Route::get('main_vehicles', 'VehicleController@main_vehicles');
        Route::get('vehicles', 'VehicleController@vehicles');
        Route::get('show-vehicle', 'VehicleController@get_vehicle');
        Route::get('used-vehicles-for-sale', 'MawaterController@index');


        //scraps routes
        Route::get('scraps', 'ScrapController@index');
        Route::get('show-scrap', 'ScrapController@show_scrap');
        Route::get('show-products-scrap', 'ScrapController@show_products');
        Route::get('show-product-scrap', 'ScrapController@show_product');
        Route::get('scrap-available-times', 'ScrapController@scrap_available_times');
        Route::post('reserve-product-from-scrap', 'ScrapController@reserve_product');

        //spareparts routes
        Route::get('spare-parts', 'SparePartsController@index');
        Route::get('show-spare-part', 'SparePartsController@show_spare_part');
        Route::get('show-products-spare-part', 'SparePartsController@show_products');
        Route::get('show-product-spare-part', 'SparePartsController@show_product');
        Route::get('sparepart-available-times', 'SparePartsController@spare_part_available_times');
        Route::post('reserve-product-from-spare-part', 'SparePartsController@reserve_product');


        //insurance companies
        Route::get('insurance-companies', 'IsuranceCompanyController@index');
        Route::get('show-insurance-company', 'IsuranceCompanyController@show_insurance_company')->name('insurance.show');
        Route::get('insurance-mawater-card-offers', 'IsuranceCompanyController@getDiscountCardOffers');
        Route::get('show-insurance-package', 'IsuranceCompanyController@ShowPackage');

        //Brokers routes
        Route::get('brokers', 'BrokerController@index');
        Route::get('show-broker', 'BrokerController@show')->name('brokers.show');
        Route::get('broker-mawater-card-offers', 'BrokerController@getDiscountCardOffers');
        Route::get('show-broker-package', 'BrokerController@ShowPackage');


        //Driving Training
        Route::get('show-trainers', 'DrivingTrainerController@index')->name('trainers.all');
        Route::get('show-trainer', 'DrivingTrainerController@show_trainer')->name('trainers.show');
        Route::get('show-trainers-available-times', 'DrivingTrainerController@trainer_available_times');
        Route::get('/training-types', 'DrivingTrainerController@training_types');
        Route::get('get-mawater-cards-offers', 'DrivingTrainerController@getDiscountCardOffers');


        //delivery
        Route::get('delivery-men', 'DeliveryManController@index')->name('deliveries.all');
        Route::get('show-delivery', 'DeliveryManController@show_delivery_man')->name('deliveries.show');
        Route::get('show-delivery-available-times', 'DeliveryManController@delivery_man_available_times');
        Route::get('/delivery-types', 'DeliveryManController@delivery_types');
        Route::get('delivery-mawater-cards-offers', 'DeliveryManController@getDiscountCardOffers');


        // Wench routes
        Route::get('fuel-stations', 'FuelStationController@index');
        Route::get('show-fuel-station', 'FuelStationController@show');
        Route::get('nearest-fuel-station', 'FuelStationController@nearest_location');

        //Traffic Clearing Office routes
        Route::get('get-traffic-clearing-offices', 'TrafficClearingOfficeController@index');
        Route::get('show-traffic-clearing-office', 'TrafficClearingOfficeController@show');
        Route::get('show-traffic-clearing-office-service', 'TrafficClearingOfficeController@showService');
        Route::get('traffic-clearing-office-services', 'TrafficClearingOfficeController@getServices');
        Route::get('traffic-mawater-card-offers', 'TrafficClearingOfficeController@getDiscountCardOffers');

        //Technical Inspection Center routes
        Route::get('get-technical-inspection-centers', 'TechnicalInspectionCenterController@index')->name('inspection-centers.all');
        Route::get('show-technical-inspection-center', 'TechnicalInspectionCenterController@show')->name('inspection-centers.show');
        Route::get('get-inspection-center-services', 'TechnicalInspectionCenterController@getAllServices');
        Route::get('show-inspection-center-service', 'TechnicalInspectionCenterController@ShowService')->name('inspection-centers.show-service');
        Route::get('get-center-mawater-offers', 'TechnicalInspectionCenterController@getMawaterOffers');
        Route::get('get-center-service-available-times', 'TechnicalInspectionCenterController@getServiceAvailableTimes');

        //Tire Exchange Center routes
        Route::get('get-tire-exchange-centers', 'TireExchangeCenterController@index');
        Route::get('show-tire-exchange-center', 'TireExchangeCenterController@show')->name('tire-centers.show');
        Route::get('get-tire-exchange-services', 'TireExchangeCenterController@getAllServices');
        Route::get('show-tire-exchange-service', 'TireExchangeCenterController@ShowService')->name('tire-centers.show-service');
        Route::get('get-tire-exchange-mawater-offers', 'TireExchangeCenterController@getMawaterOffers');

        //CarWash routes
        Route::get('get-car-washes', 'CarWashController@index')->name('car-washes.all');
        Route::get('show-car-wash', 'CarWashController@show')->name('car-washes.show');
        Route::get('get-car-washes-services', 'CarWashController@getAllServices');
        Route::get('show-car-wash-service', 'CarWashController@ShowService')->name('car-washes.show-service');
        Route::get('get-car-wash-mawater-offers', 'CarWashController@getMawaterOffers');
        Route::get('get-car-wash-service-available-times', 'CarWashController@getServiceAvailableTimes');

        //Mining Center routes
        Route::get('get-mining-centers', 'MiningCenterController@index');
        Route::get('show-mining-center', 'MiningCenterController@show')->name('mining-centers.show');
        Route::get('get-mining-center-services', 'MiningCenterController@getAllServices');
        Route::get('show-mining-center-service', 'MiningCenterController@ShowService')->name('mining-centers.show-service');
        Route::get('get-mining-center-mawater-offers', 'MiningCenterController@getMawaterOffers');

        //Accessories Store routes
        Route::get('get-accessories-stores', 'AccessoriesStoreController@index');
        Route::get('show-accessories-store', 'AccessoriesStoreController@show')->name('accessories-store.show');
        Route::get('get-accessories', 'AccessoriesStoreController@getAllAccessories');
        Route::get('show-accessory', 'AccessoriesStoreController@ShowAccessory')->name('accessories.show');
        Route::get('get-accessories-store-mawater-offers', 'AccessoriesStoreController@getMawaterOffers');

    });

    Route::group(['namespace' => 'Auth'], function () {
        Route::post('register', 'AuthController@register');
        Route::get('user/verify/{verification_code}', 'AuthController@verifyUser')->name('user.verify');
        Route::post('login', 'AuthController@login');
        Route::post('forgot-password', 'AuthController@forgetPassword');
        Route::post('reset-forgot-password', 'AuthController@resetForgottenPassword');
        Route::post('update-token', 'AuthController@updateToken');
    });

    Route::group(['namespace' => 'Users'], function () {
        //discount cards
        Route::get('/discount-cards', 'DiscountCardController@index');
        Route::get('/show-discount-card', 'DiscountCardController@showDiscountCard');
        Route::get('/check-before-apply-discount-card', 'DiscountCardController@check_before_apply_discount_card');
    });

    Route::group(['namespace' => 'General'], function () {
        Route::get('show-product', 'ProductController@show');
        Route::get('services', 'ServiceController@index');
        Route::get('show-service', 'ServiceController@show');

        //coverage_type routes
        Route::get('coverage-types','CoverageTypeController@index');
        Route::get('show-coverage-type','CoverageTypeController@show');
    });
});

// authenticated routes
Route::group(['middleware' => ['jwt.verify:api', 'APILocalization', 'IsVerified'], 'namespace' => 'API'], function () {
//Route::group(['middleware' => ['jwt.verify:api', 'APILocalization'], 'namespace' => 'API'], function () {

    Route::group(['namespace' => 'General'], function () {
        //request product
        Route::post('request-product', 'ProductController@request_product');
        Route::get('get-requests', 'ProductController@get_requests');
        Route::get('get-requests-replies', 'ProductController@get_requests_replies');

        //request insurance
        Route::post('quotation-request', 'RequestInsuranceController@quotationRequest');

        //subscribe auction

        Route::post('subscribe-auction ', 'AuctionsController@subscribe');
        Route::get('user-auctions-subscriptions', 'AuctionsController@user_subscriptions');

        //add bid to auction
        Route::post('/add-bid', 'AuctionsController@add_bid');
        Route::get('/user-auction-bids', 'AuctionsController@UserAuctionBids');

    });
    // user route
    Route::group(['namespace' => 'Auth'], function () {
        Route::post('logout', 'AuthController@logout');
        // user routes
        Route::get('profile', 'AuthController@profile')->withoutMiddleware('IsVerified');
//        Route::get('profile', 'AuthController@profile');
        Route::post('update', 'AuthController@update');
        Route::post('change-password', 'AuthController@changePassword');

        // firebase notifications
        Route::post('store-token', 'FirebaseController@storeToken');
        Route::post('delete-token', 'FirebaseController@deleteToken');
    });

    Route::group(['namespace' => 'Organizations'], function () {
        // rental office reservation routes
        Route::post('rental-office-reservation', 'RentalOfficeController@reservation');
        Route::get('user-rental-office-reservations', 'RentalOfficeController@get_user_reservations');
        Route::get('show-rental-office-reservation', 'RentalOfficeController@show_reservation');

        // garage routes
        Route::post('create-garage-reservation', 'GarageController@reservations');
        Route::get('garage-user-reservations', 'GarageController@getUserReservations');
        Route::get('garage-user-reservation', 'GarageController@ShowUserReservation');

        // branch routes
        Route::post('branch-reservation', 'BranchController@reservations');
        Route::get('user-reservations', 'BranchController@getUserReservations');
        Route::get('user-reservation', 'BranchController@ShowUserReservation');

        //wench routes
        Route::post('create-wench-reservation', 'WenchController@reservations');
        Route::get('user-wench-reservations', 'WenchController@getUserReservations');
        Route::get('user-wench-reservation', 'WenchController@ShowUserReservation');

        // special number
        Route::post('create-special-number-reservation', 'SpecialNumberController@special_number_reservation');
        Route::get('special-number-reservations', 'SpecialNumberController@getReservations');
        Route::post('special-number-verification', 'VerificationController@verifications');

        // vehicles routes
        Route::post('reserve-vehicle', 'VehicleController@reserve_vehicle');
        Route::get('my-reserve-vehicle', 'VehicleController@get_reservation_vehicles');
        Route::post('test-drive', 'VehicleController@add_test_drive');
        Route::get('test-drives', 'VehicleController@test_drives');
        Route::get('show-test-drive', 'VehicleController@show_test_drive');
        Route::get('get-3d-file', 'VehicleController@get3dFile');


        // used vehicles for sale routes
        Route::post('create-used-vehicles-for-sale', 'MawaterController@store');
        Route::post('update-used-vehicles-for-sale', 'MawaterController@update');
        Route::post('delete-used-vehicles-for-sale', 'MawaterController@delete');
        Route::get('user-vehicles-for-sale', 'MawaterController@sell_cars');


        // profile vehicles routes
        Route::post('store-profile-vehicle', 'MawaterController@store_profile_vehicle');
        Route::get('profile-vehicles', 'MawaterController@get_vehicles');


        //reserve insurance company routes
        Route::post('reserve-insurance-service', 'IsuranceCompanyController@reserveInsuranceService')->name('insurance.reservation');
        Route::get('get-user-reservations', 'IsuranceCompanyController@getUserReservations');
        Route::get('show-user-reservation', 'IsuranceCompanyController@ShowUserReservation');

        //reserve broker
        Route::post('reserve-broker', 'BrokerController@reserveBrokerService')->name('brokers.reservations');
        Route::get('user-broker-reservations', 'BrokerController@getUserReservations');
        Route::get('show-user-broker-reservation', 'BrokerController@ShowUserReservation');

        //reserve trainer
        Route::post('reserve-training', 'DrivingTrainerController@reserve_training');
        Route::get('user-training-reservations', 'DrivingTrainerController@getUserReservations')->name('training-reservations.all');
        Route::get('show-training-reservation', 'DrivingTrainerController@showUserReservation')->name('training-reservations.show');

        //reserve delivery
        Route::post('reserve-delivery', 'DeliveryManController@reserve_delivery');
        Route::get('user-delivery-reservations', 'DeliveryManController@getUserReservations')->name('delivery-reservations.all');
        Route::get('show-delivery-reservation', 'DeliveryManController@showUserReservation')->name('delivery-reservations.show');


        //Traffic Clearing Office routes
        Route::post('request-traffic-clearing-office', 'TrafficClearingOfficeController@storeTrafficClearingOfficeRequests');
        Route::get('get-user-request-traffic', 'TrafficClearingOfficeController@getUserTrafficClearingOfficeRequests');

        //Technical Inspection Center routes
        Route::post('request-technical-inspection', 'TechnicalInspectionCenterController@requestTechnicalInspection');
        Route::get('get-user-inspection-requests', 'TechnicalInspectionCenterController@getUserRequests');
        Route::get('show-user-inspection-request', 'TechnicalInspectionCenterController@showUserRequest')->name('inspection.show-request');

        //Car Wash routes
        Route::post('request-car-wash', 'CarWashController@requestCarWash');
        Route::get('get-user-car-wash-requests', 'CarWashController@getUserRequests');
        Route::get('show-user-car-wash-request', 'CarWashController@showUserRequest')->name('car-washes.show-request');

        //Accessories Store routes
        Route::post('purchase-accessories', 'AccessoriesStoreController@purchase');
        Route::get('get-purchases', 'AccessoriesStoreController@getUserPurchases');
        Route::get('show-purchase', 'AccessoriesStoreController@showUserPurchase')->name('accessories-purchase.show');

    });

    Route::group(['namespace' => 'Users'], function () {
        //favourites
        Route::post('/add-to-favorites', 'FavouritesController@add_to_favourites');
        Route::post('/remove-from-favorites', 'FavouritesController@remove_from_favourites');
        Route::get('/favourites', 'FavouritesController@get_favourites');

        //discount cards
        Route::post('/subscribe', 'DiscountCardController@subscribe');
        Route::post('/add-vehicles', 'DiscountCardController@add_vehicles');
        Route::get('/user-discount-cards', 'DiscountCardController@getUserDiscountCards');
        Route::get('show/user-discount-card', 'DiscountCardController@getUserDiscountCard');
//        Route::get('discount-card/offers', 'DiscountCardController@getOffers');

        //reviews
        Route::post('add-review', 'ReviewController@add_review');

        //wallet
        Route::post('charge-wallet', 'WalletController@chargeWallet');
        Route::get('show-wallet', 'WalletController@show');
    });


});
