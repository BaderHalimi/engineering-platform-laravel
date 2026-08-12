<?php

namespace App\Providers\Filament;

use Filament\Http\Middleware\Authenticate;
use Filament\Http\Middleware\AuthenticateSession;
use Filament\Http\Middleware\DisableBladeIconComponents;
use Filament\Http\Middleware\DispatchServingFilamentEvent;
use Filament\Pages\Dashboard;
use Filament\Panel;
use Filament\PanelProvider;
use Filament\Support\Colors\Color;
use Filament\Widgets\AccountWidget;
use Filament\Widgets\FilamentInfoWidget;
use Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse;
use Illuminate\Cookie\Middleware\EncryptCookies;
use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken;
use Illuminate\Routing\Middleware\SubstituteBindings;
use Illuminate\Session\Middleware\StartSession;
use Illuminate\View\Middleware\ShareErrorsFromSession;
use Filament\Navigation\MenuItem;
use Filament\Support\Assets\Css;
use Closure;
class AdminPanelProvider extends PanelProvider
{

    public function panel(Panel $panel): Panel
    {
        return $panel
            ->default()
            ->id('admin')
            ->path('admin')
            ->login()

            ->brandName('Engineering Platform')
            ->colors([
                'primary' => [
                    50 => '#fff8eb',
                    100 => '#feefc7',
                    200 => '#fce08a',
                    300 => '#f8cb54',
                    400 => '#f5ad2a',
                    500 => '#f5ad2a',
                    600 => '#dc9415',
                    700 => '#b87812',
                    800 => '#945d16',
                    900 => '#794d16',
                    950 => '#4d2a07',
                ],
            ])
            ->userMenuItems([

                MenuItem::make()
                    ->label('العربية')
                    ->url(url('/lang/ar')),

                MenuItem::make()
                    ->label('English')
                    ->url(url('/lang/en')),

            ])

            ->viteTheme('resources/css/filament/admin/theme.css')

->discoverResources(in: app_path('Filament/Resources'), for: 'App\Filament\Resources')
            ->discoverResources(in: app_path('Filament/User/Resources'), for: 'App\Filament\User\Resources')

            ->discoverPages(in: app_path('Filament/Pages'), for: 'App\Filament\Pages')
            ->discoverPages(in: app_path('Filament/User/Pages'), for: 'App\Filament\User\Pages')
            ->pages([
                Dashboard::class,
            ])

            ->discoverWidgets(in: app_path('Filament/Widgets'), for: 'App\Filament\Widgets')
            ->discoverWidgets(in: app_path('Filament/User/Widgets'), for: 'App\Filament\User\Widgets')
            ->widgets([
                AccountWidget::class,
                FilamentInfoWidget::class,
            ])
            ->middleware([
                EncryptCookies::class,
                AddQueuedCookiesToResponse::class,
                StartSession::class,
                AuthenticateSession::class,
                ShareErrorsFromSession::class,
                VerifyCsrfToken::class,
                SubstituteBindings::class,
                DisableBladeIconComponents::class,
                DispatchServingFilamentEvent::class,

                \App\Http\Middleware\SetLocale::class,

            ])

            ->authMiddleware([
                Authenticate::class,
            ]);
    }

}
