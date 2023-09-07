<?php

namespace App\Providers;

use Filament\Facades\Filament;
use Illuminate\Foundation\Vite;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\ServiceProvider;
use Filament\Navigation\NavigationGroup;

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
        // $url->forceScheme(config('app.scheme'));

        if(env('FORCE_HTTPS',false)) { // Default value should be false for local server
            URL::forceScheme('https');
        }
        Filament::serving(function () {
            // Using Vite
            Filament::registerTheme(
                app(Vite::class)('resources/css/filament.css'),
            );
            Filament::registerNavigationGroups([
                NavigationGroup::make('Checklist')
                    ->label('Checklist'),
                NavigationGroup::make('Reports')
                    ->label('Reports'),
                // NavigationGroup::make('Roles & Permissions')
                //     ->label('Roles & Permissions'),
                NavigationGroup::make('User Management')
                    ->label('User Management'),
                // NavigationGroup::make('Blogs')
                //      ->label('Blogs'),
                NavigationGroup::make('Filament Shield')
                    ->label('Filament Shield'),
                
                // NavigationGroup::make('Service Center Repair Jobs')
                //     ->label('Service Center Repair Jobs'),
            ]);

        });
    }
}
