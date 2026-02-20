<?php

namespace App\Providers;

use App\Models\Guardian;
use App\Models\InventoryCategory;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        Route::bind('parent', fn (string $value) => Guardian::findOrFail($value));
        Route::bind('inventory', fn (string $value) => InventoryCategory::findOrFail($value));

        View::composer('layouts.app', function ($view) {
            $years = range((int) date('Y') + 1, (int) date('Y') - 10);
            $view->with('filterYears', $years);
            $view->with('filterYear', request('year'));
        });
    }
}
