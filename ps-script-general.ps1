# Save as upload_to_cloudinary.ps1 in project root
$cloudName = "dgk1pwiet"
$apiKey = "628453573112432"
$apiSecret = "uYQQzPYIwWlFlhsA9dPbWvCltkc"

# Get all files from database via artisan
$files = php artisan tinker --execute="echo json_encode(\App\Models\File::whereNull('cloudinary_url')->get(['id','path','name'])->toArray());"

$fileList = $files | ConvertFrom-Json

Write-Host "Found $($fileList.Count) files to upload..."

foreach ($file in $fileList) {
    $localPath = "storage\app\public\$($file.path)"
    
    if (-not (Test-Path $localPath)) {
        Write-Host "SKIP - File not found: $localPath" -ForegroundColor Yellow
        continue
    }

    # Upload to Cloudinary using API
    $timestamp = [int][double]::Parse((Get-Date -UFormat %s))
    $publicId = "powerful-posts/$($file.name -replace '[^a-zA-Z0-9-_]', '-')"
    
    $sigString = "public_id=$publicId&timestamp=$timestamp$apiSecret"
    $sha1 = [System.Security.Cryptography.SHA1]::Create()
    $sigBytes = $sha1.ComputeHash([System.Text.Encoding]::UTF8.GetBytes($sigString))
    $signature = [BitConverter]::ToString($sigBytes).Replace("-","").ToLower()

    $form = @{
        file      = Get-Item $localPath
        api_key   = $apiKey
        timestamp = $timestamp
        public_id = $publicId
        signature = $signature
    }

    try {
        $response = Invoke-RestMethod `
            -Uri "https://api.cloudinary.com/v1_1/$cloudName/image/upload" `
            -Method Post `
            -Form $form

        $cloudUrl = $response.secure_url
        $cloudPublicId = $response.public_id

        # Update database
        php artisan tinker --execute="\App\Models\File::where('id', $($file.id))->update(['cloudinary_url' => '$cloudUrl', 'cloudinary_public_id' => '$cloudPublicId']);"

        Write-Host "OK - $($file.name) => $cloudUrl" -ForegroundColor Green

    } catch {
        Write-Host "FAIL - $($file.name): $_" -ForegroundColor Red
    }
}

Write-Host "`nDone! Verifying..." -ForegroundColor Cyan
php artisan tinker --execute="echo 'Uploaded: ' . \App\Models\File::whereNotNull('cloudinary_url')->count() . '/' . \App\Models\File::count();"