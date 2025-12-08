<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\URL;
use Illuminate\Database\Eloquent\Model;
use Filament\Support\Facades\FilamentView;
use Illuminate\Support\Facades\Blade;

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
            URL::forceScheme('https');
            $this->app['request']->server->set('HTTPS', true);
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
