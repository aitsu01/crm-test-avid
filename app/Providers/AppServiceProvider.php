<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Ingenia\Avid\Facades\Avid;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        Avid::prefix('')
            ->path('')
            ->notifications()
            ->deleteAccount()
            ->resetPassword()
            ->updateProfile()
            ->updatePassword();
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void {}
}
