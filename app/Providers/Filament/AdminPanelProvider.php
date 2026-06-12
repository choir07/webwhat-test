<?php
namespace App\Providers\Filament;
use App\Filament\Pages\Dashboard;
use App\Filament\Pages\UserProfile;
use App\Filament\Resources\ActivityLogResource;
use App\Filament\Resources\Categories\CategoryResource;
use App\Filament\Resources\FileResource;
use App\Filament\Resources\Posts\PostResource;
use App\Filament\Resources\Products\ProductResource;
use App\Filament\Resources\RoleResource;
use App\Filament\Resources\SettingResource;
use App\Filament\Resources\UserResource;
use App\Filament\Widgets\DashboardStats;
use App\Filament\Widgets\ProductsByCategoryChart;
use App\Filament\Widgets\ProductsChart;
use App\Filament\Widgets\RecentActivity;
use App\Filament\Widgets\RecentProductsTable;
use App\Filament\Widgets\PostAnalytics;
use App\Filament\Widgets\RecentPosts;
use App\Filament\Widgets\RecentPostImages;
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
use App\Filament\Widgets\RecentMedia;
use App\Filament\Resources\TagResource;
class AdminPanelProvider extends PanelProvider
{
    public function panel(Panel $panel): Panel
    {
        return $panel
            ->default()
            ->id('admin')
            ->path('admin')
            ->font('Poppins')
            ->login()
            ->colors([
                'primary' => Color::Amber,
            ])
            ->pages([
                Dashboard::class,
                UserProfile::class,
            ])
            ->resources([
                CategoryResource::class,
                PostResource::class,
                TagResource::class,
                ProductResource::class,
                SettingResource::class,
                UserResource::class,
                RoleResource::class,
                ActivityLogResource::class,
                FileResource::class,
            ])
            ->widgets([
                DashboardStats::class,
                ProductsChart::class,
                ProductsByCategoryChart::class,
                \App\Filament\Resources\Posts\Widgets\PostAnalytics::class,
                RecentProductsTable::class,
                RecentActivity::class,
                RecentMedia::class,
                RecentPosts::class,
                RecentPosts::class,
                RecentPostImages::class,
                
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
            ])
            ->authMiddleware([
                Authenticate::class,
            ]);
    }
}