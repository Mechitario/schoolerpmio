<?php

namespace App\Providers;

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
        View::composer('layouts.app', function ($view) {
            $years = range((int) date('Y') + 1, (int) date('Y') - 10);
            $view->with('filterYears', $years);
            $view->with('filterYear', request('year'));
        });
    }
}
