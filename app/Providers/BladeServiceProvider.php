<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Blade;

class BladeServiceProvider extends ServiceProvider
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
        Blade::directive('numberFormat', function ($value) {
            return "<?php echo app('App\Utils\Helpers')->numberFormat($value); ?>";
        });

        Blade::directive('moneyFormat', function ($value) {
            return "<?php echo app('App\Utils\Helpers')->moneyFormat($value); ?>";
        });

        Blade::directive('dateFormat', function ($value) {
            return "<?php echo date('d/m/Y', strtotime($value));?>";
        });

        Blade::directive('dateFormat2', function ($value) {
            return "<?php echo date('d-m-Y', strtotime($value));?>";
        });

        Blade::directive('timeFormat', function ($value) {
            return "<?php echo date('H\hi\\m\\i\\n', strtotime($value));?>";
        });
    }
}
