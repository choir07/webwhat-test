# ps-script-general.ps1
Write-Host "========================================" -ForegroundColor Cyan
Write-Host "🔧 Fixing Shop Styles" -ForegroundColor Cyan
Write-Host "========================================" -ForegroundColor Yellow

# Step 1: Create shop.css
Write-Host ""
Write-Host "[1/3] Creating public/css/shop.css..." -ForegroundColor Yellow
New-Item -ItemType Directory -Path "public/css" -Force | Out-Null

$css = @'
.shop-container { max-width: 1280px; margin: 0 auto; padding: 0 1rem; }
.shop-title { font-size: 1.5rem; font-weight: 700; color: #1f2937; margin-bottom: 1.5rem; }
.shop-grid { display: grid; grid-template-columns: repeat(1, 1fr); gap: 1rem; }
@media (min-width: 640px) { .shop-grid { grid-template-columns: repeat(2, 1fr); } }
@media (min-width: 768px) { .shop-grid { grid-template-columns: repeat(3, 1fr); } }
@media (min-width: 1024px) { .shop-grid { grid-template-columns: repeat(4, 1fr); } }
.product-card { background: white; border-radius: 0.5rem; overflow: hidden; box-shadow: 0 1px 3px rgba(0,0,0,0.1); transition: box-shadow 0.3s; }
.product-card:hover { box-shadow: 0 4px 12px rgba(0,0,0,0.15); }
.product-image { width: 100%; height: 192px; object-fit: cover; }
.product-body { padding: 1rem; }
.product-name { font-size: 1.125rem; font-weight: 600; color: #1f2937; }
.product-name:hover { color: #2563eb; }
.product-category { font-size: 0.875rem; color: #6b7280; }
.product-price { font-size: 1.125rem; font-weight: 700; color: #1f2937; }
.product-price.sale { color: #dc2626; }
.btn-add-cart { background: #2563eb; color: white; padding: 0.25rem 0.75rem; border-radius: 0.25rem; font-size: 0.875rem; border: none; cursor: pointer; }
.btn-add-cart:hover { background: #1d4ed8; }
.category-pill { padding: 0.5rem 1rem; border-radius: 9999px; font-size: 0.875rem; text-decoration: none; display: inline-block; }
.category-pill.active { background: #1f2937; color: white; }
.category-pill.inactive { background: #e5e7eb; color: #374151; }
.category-pill.inactive:hover { background: #d1d5db; }
.search-input { border: 1px solid #d1d5db; padding: 0.5rem 1rem; border-radius: 0.375rem 0 0 0.375rem; font-size: 0.875rem; }
.search-btn { background: #1f2937; color: white; padding: 0.5rem 1rem; border-radius: 0 0.375rem 0.375rem 0; font-size: 0.875rem; border: none; cursor: pointer; }
.search-btn:hover { background: #374151; }
.pagination { margin-top: 2rem; }
.no-products { text-align: center; padding: 3rem 0; color: #6b7280; }
'@

$css | Out-File -FilePath "public/css/shop.css" -Encoding utf8
Write-Host "✅ Created shop.css" -ForegroundColor Green

# Step 2: Commit and push
Write-Host ""
Write-Host "[2/3] Committing and pushing..." -ForegroundColor Yellow
git add public/css/shop.css
git commit -m "Fix: Add fallback CSS for shop"
git push origin main

Write-Host ""
Write-Host "[3/3] Done!" -ForegroundColor Green
Write-Host ""
Write-Host "========================================" -ForegroundColor Green
Write-Host "✅ Fix applied! Redeploy on Railway." -ForegroundColor Green
Write-Host "========================================" -ForegroundColor Cyan

Read-Host "Press Enter to exit"