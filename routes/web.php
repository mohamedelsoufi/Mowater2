<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

Route::get('/sms', function () {
    return sms();
});
Route::group(['prefix' => LaravelLocalization::setLocale(),
    'middleware' => ['localeSessionRedirect', 'localizationRedirect', 'localeViewPath']], function () {
    Route::namespace('Organization')->name('organization.')->group(function () {
        //organization login
        //->middleware('guest:web')
        Route::get('login', 'Auth\AuthController@login')->name('login');
        Route::post('authenticate', 'Auth\AuthController@authenticate')->name('authenticate');

        Route::middleware(['auth:web'])->group(function () {
            Route::get('/', 'HomeController@index')->name('home');
            Route::get('logout', 'Auth\AuthController@logout')->name('logout');

            // organization route
            Route::resource('organizations', 'OrgDataController');

            //users
            Route::resource('users', 'OrgUsersController');

            //brokers requirements
//            Route::get('/show-requirements', 'OrgDataController@show_requirements')->name('brokers.requirements');

            //update_branch_data
            Route::put('update_branch_data', 'OrgDataController@update_branch_data')->name('update_branch_data');

            // vehicle routes
            Route::resource('vehicles', 'OrgVehicleController');
            // work time routes
            Route::get('work_time', 'OrgWorkTimeController@edit')->name('work_time.edit');
            Route::put('work_time', 'OrgWorkTimeController@update')->name('work_time.update');
            //contact
            Route::get('contact', 'OrgContactController@edit')->name('contact.edit');
            Route::put('contact', 'OrgContactController@update')->name('contact.update');
            //day offs
            Route::resource('day_off', 'OrgDayOffController');
            //reserve
            Route::resource('reserve_vehicle', 'OrgVehicleReservationController');
            //test drive
            Route::resource('test', 'OrgVehicleTestController');
            //review
            Route::resource('review', 'OrgReviewController');
            //available vehicles
            Route::resource('available_vehicle', 'OrgAvailableVehicleController');
            //available products
            Route::resource('available_product', 'OrgAvailableProductController');
            //available services
            Route::resource('available_service', 'OrgAvailableServiceController');


            // products routes
            Route::resource('products', 'OrgProductController');
            Route::get('sub-category/{id}', 'OrgProductController@sub_category')->name('products.sub_category');

            //services
            Route::resource('services', 'OrgServiceController');
            //branches
            Route::resource('branch', 'OrgBranchController');
            //phones

            Route::resource('phone', 'OrgPhoneController');

            Route::resource('phone', 'OrgPhoneController');
            Route::resource('phone', 'OrgPhoneController');
            //rental office cars
            Route::resource('rental_office_car', 'OrgRentalOfficeCarController');
            //rental laws
            Route::resource('rental_law', 'OrgRentalLawController');
            //Available Payment Methods
            Route::resource('available_payment_method', 'OrgAvailablePaymentMethodController');
            //Rental Reservations
            Route::resource('rental_reservation', 'OrgRentalReservationController');
            //Coverage Types
            Route::resource('coverage_type', 'OrgCoverageTypeController');
            //laws
            Route::resource('law', 'OrgInsuranceCompanyLawController');

            //ads
            Route::resource('ads', 'OrgAdController');

            //reservations
            Route::get('/reservations', 'OrgReservationsController@index')->name('reservations.index');
            Route::get('/reservations-edit/{id}', 'OrgReservationsController@edit')->name('reservations.edit');
            Route::get('/reservations-show/{id}', 'OrgReservationsController@show')->name('reservations.show');
            Route::post('/update/{id}', 'OrgReservationsController@update')->name('reservations.update');
            Route::post('/reservations_delivery/{id}', 'OrgReservationsController@delivery_details')->name('reservations.delivery_details');
            //trainer reservations
            Route::get('/trainer_reservations', 'TrainerReservationController@index')->name('trainer_reservations.index');
            Route::get('/trainer_reservations-edit/{id}', 'TrainerReservationController@edit')->name('trainer_reservations.edit');
            Route::get('/trainer_reservations-show/{id}', 'TrainerReservationController@show')->name('trainer_reservations.show');
            Route::post('/trainer_update/{id}', 'TrainerReservationController@update')->name('trainer_reservations.update');

            //trainer reservations
            Route::get('/delivery_reservations', 'DeliveryReservations@index')->name('delivery_reservations.index');
            Route::get('/delivery_reservations-edit/{id}', 'DeliveryReservations@edit')->name('delivery_reservations.edit');
            Route::get('/delivery_reservations-show/{id}', 'DeliveryReservations@show')->name('delivery_reservations.show');
            Route::post('/delivery_update/{id}', 'DeliveryReservations@update')->name('delivery_reservations.update');
            //requests products
            Route::get('/requests_products', 'OrgProductsRequestsController@index')->name('products_requests.index');
            Route::get('/show/{id}', 'OrgProductsRequestsController@show')->name('products_requests.show');
            Route::get('/reply/{id}', 'OrgProductsRequestsController@reply')->name('products_requests.reply');
            Route::post('/send_reply', 'OrgProductsRequestsController@send_reply')->name('products_requests.send_reply');

            //insurance requests
            Route::get('/insurance_requests', 'OrgInsuranceRequestController@index')->name('insurance_requests.index');
            Route::get('/show-insurance/{id}', 'OrgInsuranceRequestController@show')->name('insurance_requests.show');
            Route::get('/edit-insurance/{id}', 'OrgInsuranceRequestController@update')->name('insurance_requests.update');
            Route::post('/update-insurance', 'OrgInsuranceRequestController@update_insurance')->name('insurance_requests.update_insurance');
            // Special numbers of Organization
            Route::resource('special-numbers', 'OrgSpecialNumberController');
            Route::get('special-number-reservations', 'OrgSpecialNumberController@reservation')->name('special-number-reservations');
            Route::get('special-number-reservations/{id}', 'OrgSpecialNumberController@show_reservation')->name('show-special-number-reservations');
            Route::post('update-special-number-reservations/{id}', 'OrgSpecialNumberController@update_reservation_status')->name('update-special-number-reservations');

            // Verifications
            Route::resource('verifications', 'OrgVerificationController');

            // Discount Cards
            Route::get('discount-cards', 'OrgDiscountCardController@index')->name('discount-cards.index');
            Route::get('discount-cards/offers/{id}', 'OrgDiscountCardController@offers')->name('discount-cards.offers');
            Route::post('discount-cards/offers', 'OrgDiscountCardController@create_offers')->name('discount-cards.create_offers');
            Route::post('discount-cards/offers/update/{id}', 'OrgDiscountCardController@update_offers')->name('discount-cards.update_offers');
            Route::get('discount-cards/show/{id}', 'OrgDiscountCardController@show')->name('discount-cards.show');
            Route::post('discount-cards/subscribe/{id}', 'OrgDiscountCardController@subscribe')->name('discount-cards.subscribe');
            Route::get('discount-cards/show-offers/{id}', 'OrgDiscountCardController@show_offer')->name('discount-cards.show_offer');
        });

    });

    Route::namespace('Dashboard')->group(function () {
        Route::get('cities-of-country/{id}', 'Location\CityController@get_cities_of_country')->name('cities-of-country');
        Route::get('areas-of-city/{id}', 'Location\AreaController@get_areas_of_city')->name('areas-of-city');
        Route::get('car-models-of-brand/{id}', 'VehicleDetails\CarModelController@get_models_of_brand')->name('car-models-of-brand');

    });
});


