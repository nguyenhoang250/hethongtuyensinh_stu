<?php

namespace Modules\HeThong\Providers;

use Illuminate\Support\ServiceProvider;
use Modules\HeThong\Services\NguoiDungService;
use Modules\HeThong\Services\NhatKyService;
use Modules\HeThong\Services\PhanQuyenService;

class HeThongServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->singleton(NguoiDungService::class);
        $this->app->singleton(NhatKyService::class);
        $this->app->singleton(PhanQuyenService::class);
    }

    public function boot(): void
    {
        $this->loadMigrationsFrom(module_path('HeThong', 'database/migrations'));
        $this->loadViewsFrom(module_path('HeThong', 'resources/views'), 'hethong');
        $this->loadTranslationsFrom(module_path('HeThong', 'lang'), 'hethong');
    }
}