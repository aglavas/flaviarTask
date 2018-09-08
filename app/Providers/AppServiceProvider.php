<?php

namespace App\Providers;

use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\ServiceProvider;
use App\Contracts\ProductRepositoryInterface;
use App\Contracts\VendorRepositoryInterface;
use App\Repositories\ProductRepository;
use App\Repositories\VendorRepository;


class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Schema::defaultStringLength(191);
        Validator::extend('excel', 'App\Validators\CustomValidator@extensionExcel');
        Validator::replacer('excel', 'App\Validators\CustomValidator@extensionExcelReplacer');
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(
            ProductRepositoryInterface::class,
            ProductRepository::class
        );

        $this->app->bind(
            VendorRepositoryInterface::class,
            VendorRepository::class
        );
    }
}
