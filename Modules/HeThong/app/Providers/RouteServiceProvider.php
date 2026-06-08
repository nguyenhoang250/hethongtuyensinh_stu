<?php

namespace Modules\HeThong\Providers;

use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;

class RouteServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        $this->routes(function () {
            // Web routes
            Route::middleware('web')
                ->group(module_path('HeThong', 'routes/web.php'));

            // API routes
            Route::middleware('api')
                ->prefix('api')
                ->group(module_path('HeThong', 'routes/api.php'));
        });
    }
}