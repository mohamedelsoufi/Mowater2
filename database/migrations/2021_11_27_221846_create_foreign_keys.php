<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateForeignKeys extends Migration {

	public function up()
	{
        Schema::table('sections', function (Blueprint $table) {
            $table->foreign('section_id')->references('id')->on('sections')
                ->onDelete('set null')
                ->onUpdate('set null');
        });
        Schema::table('categories', function (Blueprint $table) {
            $table->foreign('section_id')->references('id')->on('sections')
                ->onDelete('cascade')
                ->onUpdate('cascade');
        });
        Schema::table('categorizables', function (Blueprint $table) {
            $table->foreign('category_id')->references('id')->on('categories')
                ->onDelete('cascade')
                ->onUpdate('cascade');
        });
        Schema::table('sliders', function (Blueprint $table) {
            $table->foreign('section_id')->references('id')->on('sections')
                ->onDelete('cascade')
                ->onUpdate('cascade');
        });
        Schema::table('brands', function (Blueprint $table) {
            $table->foreign('manufacture_country_id')->references('id')->on('manufacture_countries')
                ->onDelete('cascade')
                ->onUpdate('cascade');
        });
        Schema::table('car_models', function (Blueprint $table) {
            $table->foreign('brand_id')->references('id')->on('brands')
                ->onDelete('cascade')
                ->onUpdate('cascade');
        });
        Schema::table('cities', function (Blueprint $table) {
            $table->foreign('country_id')->references('id')->on('countries')
                ->onDelete('cascade')
                ->onUpdate('cascade');
        });
        Schema::table('areas', function (Blueprint $table) {
            $table->foreign('city_id')->references('id')->on('cities')
                ->onDelete('cascade')
                ->onUpdate('cascade');
        });

        Schema::table('car_model_products', function (Blueprint $table) {
            $table->foreign('car_model_id')->references('id')->on('car_models')
                ->onDelete('cascade')
                ->onUpdate('cascade');
        });
        Schema::table('car_model_products', function (Blueprint $table) {
            $table->foreign('product_id')->references('id')->on('products')
                ->onDelete('cascade')
                ->onUpdate('cascade');
        });
        Schema::table('reviews', function (Blueprint $table) {
            $table->foreign('user_id')->references('id')->on('users')
                ->onDelete('set null')
                ->onUpdate('set null');
        });
        Schema::table('favourables', function (Blueprint $table) {
            $table->foreign('user_id')->references('id')->on('users')
                ->onDelete('cascade')
                ->onUpdate('cascade');
        });
        Schema::table('branches', function (Blueprint $table) {
            $table->foreign('area_id')->references('id')->on('areas')
                ->onDelete('set null')
                ->onUpdate('set null');
        });
        Schema::table('branches', function (Blueprint $table) {
            $table->foreign('category_id')->references('id')->on('categories')
                ->onDelete('set null')
                ->onUpdate('set null');
        });
        Schema::table('available_payment_methods', function (Blueprint $table) {
            $table->foreign('payment_method_id')->references('id')->on('payment_methods')
                ->onDelete('cascade')
                ->onUpdate('cascade');
        });
        Schema::table('verifications', function (Blueprint $table) {
            $table->foreign('user_id')->references('id')->on('users')
                ->onDelete('cascade')
                ->onUpdate('cascade');
        });
        Schema::table('agencies', function (Blueprint $table) {
            $table->foreign('brand_id')->references('id')->on('brands')
                ->onDelete('set null')
                ->onUpdate('set null');
        });
        Schema::table('agencies', function (Blueprint $table) {
            $table->foreign('country_id')->references('id')->on('countries')
                ->onDelete('set null')
                ->onUpdate('set null');
        });
        Schema::table('agencies', function (Blueprint $table) {
            $table->foreign('city_id')->references('id')->on('cities')
                ->onDelete('set null')
                ->onUpdate('set null');
        });
        Schema::table('agencies', function (Blueprint $table) {
            $table->foreign('area_id')->references('id')->on('areas')
                ->onDelete('set null')
                ->onUpdate('set null');
        });
        Schema::table('rental_office_cars', function (Blueprint $table) {
            $table->foreign('rental_office_id')->references('id')->on('rental_offices')
                ->onDelete('cascade')
                ->onUpdate('cascade');
        });
        Schema::table('rental_office_cars', function (Blueprint $table) {
            $table->foreign('car_model_id')->references('id')->on('car_models')
                ->onDelete('set null')
                ->onUpdate('set null');
        });
        Schema::table('rental_office_cars', function (Blueprint $table) {
            $table->foreign('car_class_id')->references('id')->on('car_classes')
                ->onDelete('set null')
                ->onUpdate('set null');
        });
        Schema::table('rental_laws', function (Blueprint $table) {
            $table->foreign('rental_office_id')->references('id')->on('rental_offices')
                ->onDelete('cascade')
                ->onUpdate('cascade');
        });
        Schema::table('rental_reservations', function (Blueprint $table) {
            $table->foreign('rental_office_car_id')->references('id')->on('rental_office_cars')
                ->onDelete('set null')
                ->onUpdate('set null');
        });
        Schema::table('rental_reservations', function (Blueprint $table) {
            $table->foreign('user_id')->references('id')->on('users')
                ->onDelete('set null')
                ->onUpdate('set null');
        });

//        Schema::table('special_numbers', function (Blueprint $table) {
//            $table->foreign('special_number_category_id')->references('id')->on('special_number_categories')
//                ->onDelete('set null')
//                ->onUpdate('set null');
//        });
        Schema::table('special_numbers', function (Blueprint $table) {
            $table->foreign('user_id')->references('id')->on('users')
                ->onDelete('cascade')
                ->onUpdate('cascade');
        });
		Schema::table('special_numbers', function(Blueprint $table) {
			$table->foreign('special_number_organization_id')->references('id')->on('special_number_organizations')
						->onDelete('cascade')
						->onUpdate('cascade');
		});
		Schema::table('special_number_reservations', function(Blueprint $table) {
			$table->foreign('special_number_id')->references('id')->on('special_numbers')
						->onDelete('cascade')
						->onUpdate('cascade');
		});
		Schema::table('special_number_reservations', function(Blueprint $table) {
			$table->foreign('user_id')->references('id')->on('users')
						->onDelete('cascade')
						->onUpdate('cascade');
		});
		Schema::table('reservations', function(Blueprint $table) {
			$table->foreign('user_id')->references('id')->on('users')
						->onDelete('cascade')
						->onUpdate('cascade');
		});
	}

	public function down()
	{
		Schema::table('sections', function(Blueprint $table) {
			$table->dropForeign('sections_section_id_foreign');
		});
		Schema::table('categories', function(Blueprint $table) {
			$table->dropForeign('categories_section_id_foreign');
        });
        Schema::table('categorizables', function (Blueprint $table) {
            $table->dropForeign('categorizables_category_id_foreign');
        });
        Schema::table('sliders', function (Blueprint $table) {
            $table->dropForeign('sliders_sections_id_foreign');
        });
        Schema::table('brands', function (Blueprint $table) {
            $table->dropForeign('brands_manufacture_country_id_foreign');
        });
        Schema::table('car_models', function (Blueprint $table) {
            $table->dropForeign('car_models_brand_id_foreign');
        });
        Schema::table('cities', function (Blueprint $table) {
            $table->dropForeign('cities_country_id_foreign');
        });
        Schema::table('areas', function (Blueprint $table) {
            $table->dropForeign('areas_city_id_foreign');
        });
        Schema::table('Contacts', function (Blueprint $table) {
            $table->dropForeign('contacts_contactable_id_foreign');
        });
        Schema::table('model_product', function (Blueprint $table) {
            $table->dropForeign('model_product_model_id_foreign');
        });
        Schema::table('model_product', function (Blueprint $table) {
            $table->dropForeign('model_product_product_id_foreign');
        });
        Schema::table('reviews', function (Blueprint $table) {
            $table->dropForeign('reviews_user_id_foreign');
		});
		Schema::table('favourables', function(Blueprint $table) {
			$table->dropForeign('favourables_user_id_foreign');
		});
		Schema::table('branches', function(Blueprint $table) {
			$table->dropForeign('branches_area_id_foreign');
		});
		Schema::table('branches', function(Blueprint $table) {
			$table->dropForeign('branches_category_id_foreign');
		});
		Schema::table('available_payment_methods', function(Blueprint $table) {
			$table->dropForeign('available_payment_methods_payment_method_id_foreign');
		});
		Schema::table('verifications', function(Blueprint $table) {
			$table->dropForeign('verifications_user_id_foreign');
		});
		Schema::table('agencies', function(Blueprint $table) {
			$table->dropForeign('agencies_brand_id_foreign');
		});
		Schema::table('agencies', function(Blueprint $table) {
			$table->dropForeign('agencies_country_id_foreign');
		});
		Schema::table('agencies', function(Blueprint $table) {
			$table->dropForeign('agencies_city_id_foreign');
		});
		Schema::table('agencies', function(Blueprint $table) {
			$table->dropForeign('agencies_area_id_foreign');
		});
		Schema::table('rental_office_cars', function(Blueprint $table) {
			$table->dropForeign('rental_office_cars_rental_office_id_foreign');
		});
		Schema::table('rental_office_cars', function(Blueprint $table) {
			$table->dropForeign('rental_office_cars_model_id_foreign');
		});
		Schema::table('rental_office_cars', function(Blueprint $table) {
			$table->dropForeign('rental_office_cars_car_class_id_foreign');
		});
		Schema::table('rental_laws', function(Blueprint $table) {
			$table->dropForeign('rental_laws_rental_office_id_foreign');
		});
		Schema::table('rental_reservations', function(Blueprint $table) {
			$table->dropForeign('rental_reservations_rental_office_car_id_foreign');
		});
		Schema::table('rental_reservations', function(Blueprint $table) {
			$table->dropForeign('rental_reservations_user_id_foreign');
		});
		Schema::table('rental_reservations', function(Blueprint $table) {
			$table->dropForeign('rental_reservations_payment_method_id_foreign');
		});
		Schema::table('special_numbers', function(Blueprint $table) {
			$table->dropForeign('special_numbers_special_number_category_id_foreign');
		});
		Schema::table('special_numbers', function(Blueprint $table) {
			$table->dropForeign('special_numbers_user_id_foreign');
		});
		Schema::table('special_numbers', function(Blueprint $table) {
			$table->dropForeign('special_numbers_special_number_organization_id_foreign');
		});
		Schema::table('special_number_reservations', function(Blueprint $table) {
			$table->dropForeign('special_number_reservations_special_number_id_foreign');
		});
		Schema::table('special_number_reservations', function(Blueprint $table) {
			$table->dropForeign('special_number_reservations_user_id_foreign');
		});
		Schema::table('reservations', function(Blueprint $table) {
			$table->dropForeign('reservations_user_id_foreign');
		});
	}
}
