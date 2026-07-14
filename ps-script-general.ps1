# fix-403-manual.ps1
Write-Host "========================================" -ForegroundColor Cyan
Write-Host "Fixing 403 Forbidden - Manual Fix" -ForegroundColor Cyan
Write-Host "========================================" -ForegroundColor Yellow

# Create Middleware folder
Write-Host ""
Write-Host "[1/5] Creating Middleware folder..."
New-Item -ItemType Directory -Path "app/Http/Middleware" -Force | Out-Null
Write-Host "Done" -ForegroundColor Green

# Create TrustProxies.php
Write-Host ""
Write-Host "[2/5] Creating TrustProxies.php..."
@'
<?php

namespace App\Http\Middleware;

use Illuminate\Http\Middleware\TrustProxies as Middleware;
use Illuminate\Http\Request;

class TrustProxies extends Middleware
{
    protected $proxies = '*';

    protected $headers =
        Request::HEADER_X_FORWARDED_FOR |
        Request::HEADER_X_FORWARDED_HOST |
        Request::HEADER_X_FORWARDED_PORT |
        Request::HEADER_X_FORWARDED_PROTO |
        Request::HEADER_X_FORWARDED_AWS_ELB;
}
'@ | Out-File -FilePath "app/Http/Middleware/TrustProxies.php" -Encoding utf8
Write-Host "Done" -ForegroundColor Green

# Update AppServiceProvider
Write-Host ""
Write-Host "[3/5] Updating AppServiceProvider.php..."
@'
<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        if (env('FORCE_HTTPS', false)) {
            \URL::forceScheme('https');
        }
    }
}
'@ | Out-File -FilePath "app/Providers/AppServiceProvider.php" -Encoding utf8
Write-Host "Done" -ForegroundColor Green

# Clear sessions
Write-Host ""
Write-Host "[4/5] Clearing sessions..."
$env:PGPASSWORD="Pr45p03kwYiWkbOYbr4wPntqxREnV8Q1"
$psql = "C:\Program Files\PostgreSQL\18\bin\psql.exe"
& $psql -h "dpg-d8sub3v7f7vs73bi7t9g-a.singapore-postgres.render.com" -U "the_powerful_posts_user" -d "the_powerful_posts" -c "DELETE FROM sessions;" 2>$null
Write-Host "Done" -ForegroundColor Green

# Commit and push
Write-Host ""
Write-Host "[5/5] Committing and pushing..."
git add app/Http/Middleware/TrustProxies.php app/Providers/AppServiceProvider.php
git commit -m "Fix: Add TrustProxies and force HTTPS"
git push origin main
Write-Host "Done" -ForegroundColor Green

Write-Host ""
Write-Host "========================================" -ForegroundColor Green
Write-Host "Fix Complete!" -ForegroundColor Green
Write-Host "========================================" -ForegroundColor Cyan
Write-Host ""
Write-Host "Next steps:" -ForegroundColor Yellow
Write-Host "   1. In Render dashboard, add environment variables:" -ForegroundColor White
Write-Host "      SESSION_SECURE_COOKIE=true" -ForegroundColor Cyan
Write-Host "      SESSION_DOMAIN=.onrender.com" -ForegroundColor Cyan
Write-Host "      FORCE_HTTPS=true" -ForegroundColor Cyan
Write-Host "   2. Manual Deploy" -ForegroundColor White
Write-Host "   3. Clear browser cookies" -ForegroundColor White
Write-Host "   4. Login with admin@example.com / password123" -ForegroundColor White

Read-Host "Press Enter to exit"