Write-Host "========================================" -ForegroundColor Cyan
Write-Host "📊 Checking Database Import Status" -ForegroundColor Cyan
Write-Host "========================================" -ForegroundColor Yellow

$env:PGPASSWORD="Pr45p03kwYiWkbOYbr4wPntqxREnV8Q1"

Write-Host "`n[1/4] Checking tables..." -ForegroundColor Yellow
& "C:\Program Files\PostgreSQL\18\bin\psql.exe" -h dpg-d8sub3v7f7vs73bi7t9g-a.singapore-postgres.render.com -U the_powerful_posts_user -d the_powerful_posts -c "\dt"

Write-Host "`n[2/4] Checking posts..." -ForegroundColor Yellow
& "C:\Program Files\PostgreSQL\18\bin\psql.exe" -h dpg-d8sub3v7f7vs73bi7t9g-a.singapore-postgres.render.com -U the_powerful_posts_user -d the_powerful_posts -c "SELECT COUNT(*) FROM posts;"

Write-Host "`n[3/4] Checking users..." -ForegroundColor Yellow
& "C:\Program Files\PostgreSQL\18\bin\psql.exe" -h dpg-d8sub3v7f7vs73bi7t9g-a.singapore-postgres.render.com -U the_powerful_posts_user -d the_powerful_posts -c "SELECT COUNT(*) FROM users;"

Write-Host "`n[4/4] Checking recent posts..." -ForegroundColor Yellow
& "C:\Program Files\PostgreSQL\18\bin\psql.exe" -h dpg-d8sub3v7f7vs73bi7t9g-a.singapore-postgres.render.com -U the_powerful_posts_user -d the_powerful_posts -c "SELECT id, title, status FROM posts ORDER BY id DESC LIMIT 5;"

Write-Host "`n========================================" -ForegroundColor Green
Write-Host "✅ Status check complete!" -ForegroundColor Green
Write-Host "========================================" -ForegroundColor Cyan