<?php

namespace App\Providers;

use App\Models\Setting;
use App\Models\Text;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Schema::defaultStringLength(191);

        $settings = Setting::first();
        $footerTexts = Text::get(['about', 'details']);
        $footerTexts = !empty($footerTexts) ? $footerTexts[0] : [];

        View::share([
            'settings' => $settings,
            'footerTexts' => $footerTexts,
        ]);
    }
}
