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
            //update_branch_data
            Route::get('get-branches', 'OrgDataController@getBranches')->name('org.branches.index');
            Route::get('show-branch/{id}', 'OrgDataController@showBranch')->name('org.branches.show');
            Route::get('create-branch', 'OrgDataController@createBranch')->name('org.branches.create');
            Route::post('store-branch', 'OrgDataController@storeBranch')->name('org.branches.store');
            Route::get('edit-branch/{id}', 'OrgDataController@editBranch')->name('org.branches.edit');
            Route::put('update-branch/{id}', 'OrgDataController@updateBranch')->name('org.branches.update');
            Route::delete('delete-branch/{id}', 'OrgDataController@deleteBranch')->name('org.branches.delete');
            Route::get('branch-user-org/{org_id}/id/{user_id}', 'OrgDataController@getUser')->name('org.branches.user');
            Route::get('branch-users-org/{org_id}', 'OrgDataController@getUsers')->name('org.branches.users');

            //users
            Route::resource('users', 'OrgUsersController');
            Route::get('organization-branches-users', 'OrgUsersController@getBranchUsers')->name('org-branches-users.index');
            Route::get('organization-branch-user/{id}/show', 'OrgUsersController@showBranchUser')->name('org-branches-users.show');
            Route::get('organization-branch-user/{id}/edit', 'OrgUsersController@editBranchUser')->name('org-branches-users.edit');
            Route::put('organization-branch-user/{id}/update', 'OrgUsersController@updateBranchUser')->name('org-branches-users.update');
            Route::delete('organization-branch-user/{id}/delete', 'OrgUsersController@deleteBranchUser')->name('org-branches-users.delete');

            //Roles
            Route::resource('org-roles', 'OrgRolesController');

            //brokers requirements
//            Route::get('/show-requirements', 'OrgDataController@show_requirements')->name('brokers.requirements');

            // vehicle routes
            Route::resource('vehicles', 'OrgVehicleController');

            // work time routes
            Route::get('work-times', 'OrgWorkTimeController@index')->name('work-times.index');
            Route::get('edit-work-time', 'OrgWorkTimeController@edit')->name('work-times.edit');
            Route::put('update-work-time', 'OrgWorkTimeController@update')->name('work-times.update');

            //contact
            Route::get('contacts', 'OrgContactController@index')->name('contacts.index');
            Route::get('edit-contacts', 'OrgContactController@edit')->name('contacts.edit');
            Route::post('update-contacts', 'OrgContactController@update')->name('contacts.update');

            //day offs
            Route::resource('days-off', 'OrgDayOffController');

            //reserve
            Route::get('vehicle-reservations', 'OrgVehicleReservationController@index')->name('vehicle-reservations.index');
            Route::get('vehicle-reservations/{id}/show', 'OrgVehicleReservationController@show')->name('vehicle-reservations.show');
            Route::put('vehicle-reservations/{id}/update', 'OrgVehicleReservationController@update')->name('vehicle-reservations.update');

            //test drive
            Route::get('tests', 'OrgVehicleTestController@index')->name('tests.index');
            Route::get('tests/{id}/show', 'OrgVehicleTestController@show')->name('tests.show');
            Route::put('tests/{id}/update', 'OrgVehicleTestController@update')->name('tests.update');

            //review
            Route::resource('reviews', 'OrgReviewController');

            //available vehicles
            Route::get('available-vehicles', 'OrgAvailableVehicleController@index')->name('available-vehicles.index');
            Route::get('available-vehicles/{id}/show', 'OrgAvailableVehicleController@show')->name('available-vehicles.show');
            Route::get('available-vehicles/edit', 'OrgAvailableVehicleController@edit')->name('available-vehicles.edit');
            Route::post('available-vehicles/update', 'OrgAvailableVehicleController@update')->name('available-vehicles.update');

            //available products
            Route::get('available-products', 'OrgAvailableProductController@index')->name('available-products.index');
            Route::get('available-products/{id}/show', 'OrgAvailableProductController@show')->name('available-products.show');
            Route::get('available-products/edit', 'OrgAvailableProductController@edit')->name('available-products.edit');
            Route::post('available-products/update', 'OrgAvailableProductController@update')->name('available-products.update');

            //available services
            Route::get('available-services', 'OrgAvailableServiceController@index')->name('available-services.index');
            Route::get('available-services/{id}/show', 'OrgAvailableServiceController@show')->name('available-services.show');
            Route::get('available-services/edit', 'OrgAvailableServiceController@edit')->name('available-services.edit');
            Route::post('available-services/update', 'OrgAvailableServiceController@update')->name('available-services.update');


            // products routes
            Route::resource('products', 'OrgProductController');
            Route::get('sub-category/{id}', 'OrgProductController@sub_category')->name('products.sub_category');

            //services
            Route::resource('services', 'OrgServiceController');

            //branches
            Route::resource('branch', 'OrgBranchController');

            //phones
            Route::resource('phones', 'OrgPhoneController');

            //rental office cars
            Route::resource('rental-office-cars', 'OrgRentalOfficeCarController');
            Route::get('cars/properties', 'OrgRentalOfficeCarController@getProperties')->name('rental-cars-properties.index');
            Route::get('cars/properties/{id}/show', 'OrgRentalOfficeCarController@showProperty')->name('rental-cars-properties.show');
            Route::get('cars/properties/create', 'OrgRentalOfficeCarController@createProperty')->name('rental-cars-properties.create');
            Route::post('cars/properties/store', 'OrgRentalOfficeCarController@storeProperty')->name('rental-cars-properties.store');
            Route::get('cars/properties/{id}/edit', 'OrgRentalOfficeCarController@editProperty')->name('rental-cars-properties.edit');
            Route::put('cars/properties/{id}/update', 'OrgRentalOfficeCarController@updateProperty')->name('rental-cars-properties.update');
            Route::delete('cars/properties/{id}/delete', 'OrgRentalOfficeCarController@destroyProperty')->name('rental-cars-properties.destroy');

            //rental laws
            Route::resource('rental-laws', 'OrgRentalLawController');

            //Available Payment Methods
            Route::get('available-payment-methods', 'OrgAvailablePaymentMethodController@index')->name('available-payment-methods.index');
            Route::get('available-payment-methods/show/{id}', 'OrgAvailablePaymentMethodController@show')->name('available-payment-methods.show');
            Route::post('available-payment-methods/update', 'OrgAvailablePaymentMethodController@update')->name('available-payment-methods.update');
            Route::get('edit-available-payment-methods', 'OrgAvailablePaymentMethodController@edit')->name('available-payment-methods.edit');

            //Rental Reservations
            Route::resource('rental_reservation', 'OrgRentalReservationController');

            //Coverage Types
            Route::resource('coverage_type', 'OrgCoverageTypeController');

            //laws
            Route::resource('law', 'OrgInsuranceCompanyLawController');

            //ads
            Route::resource('ads', 'OrgAdController');
            Route::get('get-module/{relation}', 'OrgAdController@getModule')->name('ads.get-module');

            //reservations
            Route::get('/reservations', 'OrgReservationsController@index')->name('reservations.index');
            Route::get('/reservations/show/{id}', 'OrgReservationsController@show')->name('reservations.show');
            Route::put('/reservations/update/{id}', 'OrgReservationsController@update')->name('reservations.update');

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
        Route::get('get-ads-orgs/{orgName}', 'General\AdminAdController@getOrgs')->name('ads.orgs');

    });
});


