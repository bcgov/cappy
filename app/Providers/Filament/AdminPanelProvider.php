<?php

namespace App\Providers\Filament;

use Filament\Http\Middleware\Authenticate;
use Filament\Http\Middleware\AuthenticateSession;
use Filament\Http\Middleware\DisableBladeIconComponents;
use Filament\Http\Middleware\DispatchServingFilamentEvent;
use Filament\Panel;
use Filament\PanelProvider;
use Filament\Support\Colors\Color;
use Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse;
use Illuminate\Cookie\Middleware\EncryptCookies;
use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken;
use Illuminate\Routing\Middleware\SubstituteBindings;
use Illuminate\Session\Middleware\StartSession;
use Illuminate\View\Middleware\ShareErrorsFromSession;
use App\Filament\Pages\Auth\Register;
use App\Filament\Pages\Auth\EditProfile;
use Rupadana\ApiService\ApiServicePlugin;

class AdminPanelProvider extends PanelProvider
{
            public function panel(Panel $panel): Panel
            {
                return $panel
                    ->default()
                    ->id('admin')
                    ->path('admin')
                    ->registration(Register::class)
                    ->profile(EditProfile::class)
                    ->passwordReset()
                    ->login()
                    ->brandLogo(fn () => view('filament.admin.logo'))
                    ->brandName('Cappy')
                    ->colors([
                        'primary' => Color::Teal,
                    ])
                    ->discoverResources(in: app_path('Filament/Resources'), for: 'App\Filament\Resources')
                    ->discoverPages(in: app_path('Filament/Pages'), for: 'App\Filament\Pages')
                    ->pages([
                        //
                    ])            ->discoverWidgets(in: app_path('Filament/Widgets'), for: 'App\Filament\Widgets')
            ->widgets([
                //
            ])
            ->middleware([
                EncryptCookies::class,
                AddQueuedCookiesToResponse::class,
                StartSession::class,
                // AuthenticateSession::class, // Temporarily disabled for debugging
                ShareErrorsFromSession::class,
                VerifyCsrfToken::class,
                SubstituteBindings::class,
                DisableBladeIconComponents::class,
                DispatchServingFilamentEvent::class,
            ])
            ->authMiddleware([
                Authenticate::class,
            ])
            ->plugins([
                ApiServicePlugin::make()
            ]);
    }
}
