<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\URL;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // 本番環境（Railway）なら、URL生成をすべてHTTPSに強制する
        if (config('app.env') === 'production') {
            URL::forceScheme('https');
        }
    }
}
