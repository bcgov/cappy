<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\URL;
use Illuminate\Database\Eloquent\Model;
use Filament\Support\Facades\FilamentView;
use Illuminate\Support\Facades\Blade;
use App\Http\Middleware\TrustProxies;
use Illuminate\Contracts\Http\Kernel;

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
        if (app()->isProduction()) {
            URL::forceRootUrl(config('app.url'));
            URL::forceScheme('https');
        } else {
            Model::preventLazyLoading(false);
        }

        FilamentView::registerRenderHook(
            'panels::scripts.after',
            fn(): string => Blade::render('
        <script>
            if(localStorage.getItem(\'theme\') === null) {
                localStorage.setItem(\'theme\', \'dark\')
            }
        </script>'),
        );
    }
}
