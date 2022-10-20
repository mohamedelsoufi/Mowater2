<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(LaratrustSeeder::class);
        $this->call(AdsTypesSeeder::class);
        $this->call(ManufacturingCountryAndBrands::class); //brands - models - car classes
        $this->call(Localization::class);
        $this->call(AdminSeeder::class);
        $this->call(SectionSeeder::class);
        $this->call(ColorSeeder::class);

        $this->call(PaymentMethodSeeder::class);
        $this->call(DiscountCardSeeder::class);
        $this->call(RentalPropertySeeder::class);
        $this->call(RentalOfficeSeeder::class);

        $this->call(CategorySeeder::class);

        $this->call(GarageSeeder::class);
        $this->call(SliderSeeder::class);


        $this->call(ProductCategorySeeder::class);
        $this->call(ServiceCategorySeeder::class);
        User::factory(5)->create();

        $this->call(CoverageTypeSeeder::class);
        $this->call(FeatureSeeder::class);
        $this->call(InsuranceCompaniesSeeder::class);
        $this->call(TrainingTypesSeeder::class);

        $this->call(AgencySeeder::class);
        $this->call(CarShowRoomSeeder::class);
        $this->call(DeliverySeeder::class);
        $this->call(DrivingTrainersSeeder::class);
        $this->call(BrokerSeeder::class);
        $this->call(SubCategorySeeder::class);
        $this->call(ScrapSeeder::class);
        $this->call(SparePartsSeeder::class);
        $this->call(FuelStationSeeder::class);
        $this->call(WenchSeeder::class);
        $this->call(MawaterVehicleSeeder::class);
        $this->call(AuctionSeeder::class);
        $this->call(SpecialNumberSeeder::class);
        $this->call(TrafficClearingServiceSeeder::class);
        $this->call(TrafficClearingOfficeSeeder::class);
        $this->call(TechnicalInspectionCenterSeeder::class);
        $this->call(TireExchangeCenterSeeder::class);
        $this->call(CarWashSeeder::class);
        $this->call(MiningCenterSeeder::class);
        $this->call(AccessoriesStoreSeeder::class);
        $this->call(AdSeeder::class);

    }
}
