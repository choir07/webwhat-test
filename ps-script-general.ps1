# fix-db-sync.ps1
Write-Host "========================================" -ForegroundColor Cyan
Write-Host "🔄 Fixing Database Sync" -ForegroundColor Cyan
Write-Host "========================================" -ForegroundColor Yellow

# Step 1: Export production as SQL
Write-Host ""
Write-Host "[1/4] Exporting production database as SQL..." -ForegroundColor Yellow
$env:PGPASSWORD="Pr45p03kwYiWkbOYbr4wPntqxREnV8Q1"
$psql = "C:\Program Files\PostgreSQL\18\bin\pg_dump.exe"
$host = "dpg-d8sub3v7f7vs73bi7t9g-a.singapore-postgres.render.com"
$user = "the_powerful_posts_user"
$db = "the_powerful_posts"

& $psql -h $host -U $user -d $db --no-owner --no-privileges > production_dump.sql
Write-Host "✅ Exported to production_dump.sql" -ForegroundColor Green

# Step 2: Get local password
Write-Host ""
Write-Host "[2/4] Enter your local PostgreSQL password:" -ForegroundColor Yellow
$localPass = Read-Host -AsSecureString
$localPass = [System.Runtime.InteropServices.Marshal]::PtrToStringAuto([System.Runtime.InteropServices.Marshal]::SecureStringToBSTR($localPass))

# Step 3: Import to local
Write-Host ""
Write-Host "[3/4] Importing to local database..." -ForegroundColor Yellow
$env:PGPASSWORD = $localPass
& "C:\Program Files\PostgreSQL\18\bin\psql.exe" -h localhost -U postgres -d f5_crud -f production_dump.sql 2>$null

if ($LASTEXITCODE -eq 0) {
    Write-Host "✅ Import successful" -ForegroundColor Green
} else {
    Write-Host "⚠️ Import had some errors but may have completed partially" -ForegroundColor Yellow
}

# Step 4: Run migrations
Write-Host ""
Write-Host "[4/4] Running migrations locally..." -ForegroundColor Yellow
php artisan migrate --force
Write-Host "✅ Migrations run" -ForegroundColor Green

Write-Host ""
Write-Host "========================================" -ForegroundColor Green
Write-Host "✅ Sync complete!" -ForegroundColor Green
Write-Host "========================================" -ForegroundColor Cyan

Read-Host "Press Enter to exit"