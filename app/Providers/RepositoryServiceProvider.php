<?php

namespace App\Providers;

use App\Repositories\AccessoriesStore\AccessoriesStoreInterface;
use App\Repositories\AccessoriesStore\AccessoriesStoreRepository;
use App\Repositories\CarWash\CarWashInterface;
use App\Repositories\CarWash\CarWashRepository;
use App\Repositories\MiningCenter\MiningCenterInterface;
use App\Repositories\MiningCenter\MiningCenterRepository;
use App\Repositories\PaymentMethod\PaymentMethodInterface;
use App\Repositories\PaymentMethod\PaymentMethodRepository;
use App\Repositories\TechnicalInspectionCenter\TechnicalInspectionCenterInterface;
use App\Repositories\TechnicalInspectionCenter\TechnicalInspectionCenterRepository;
use App\Repositories\TireExchangeCenter\TireExchangeCenterInterface;
use App\Repositories\TireExchangeCenter\TireExchangeCenterRepository;
use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        $this->app->bind(TechnicalInspectionCenterInterface::class, TechnicalInspectionCenterRepository::class);
        $this->app->bind(PaymentMethodInterface::class, PaymentMethodRepository::class);
        $this->app->bind(TireExchangeCenterInterface::class, TireExchangeCenterRepository::class);
        $this->app->bind(CarWashInterface::class, CarWashRepository::class);
        $this->app->bind(MiningCenterInterface::class, MiningCenterRepository::class);
        $this->app->bind(AccessoriesStoreInterface::class, AccessoriesStoreRepository::class);
    }
}
