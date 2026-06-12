<?php

require __DIR__ . '/vendor/autoload.php';

$app = require_once __DIR__ . '/bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

use App\Models\File;

echo "========================================\n";
echo "IMAGE DIAGNOSTIC\n";
echo "========================================\n\n";

$files = File::latest()->take(5)->get();

if ($files->isEmpty()) {
    echo "No files found in database!\n";
} else {
    foreach ($files as $file) {
        echo "ID: {$file->id}\n";
        echo "Name: {$file->name}\n";
        echo "Path in DB: {$file->path}\n";
        echo "Collection: {$file->collection}\n";
        
        // Check different possible paths
        $pathsToCheck = [
            storage_path('app/public/' . $file->path),
            storage_path('app/public/files/' . basename($file->path)),
            storage_path('app/public/' . basename($file->path)),
            public_path('storage/' . $file->path),
            public_path('storage/files/' . basename($file->path)),
        ];
        
        $found = false;
        foreach ($pathsToCheck as $path) {
            if (file_exists($path)) {
                echo "✓ File found at: {$path}\n";
                echo "  Size: " . round(filesize($path) / 1024, 2) . " KB\n";
                $found = true;
                break;
            }
        }
        
        if (!$found) {
            echo "✗ File NOT found anywhere!\n";
            echo "  Checked paths:\n";
            foreach ($pathsToCheck as $path) {
                echo "    - {$path}\n";
            }
        }
        
        echo "\n---\n\n";
    }
}

echo "========================================\n";
echo "STORAGE INFO\n";
echo "========================================\n\n";

$storagePath = storage_path('app/public');
echo "Storage path: {$storagePath}\n";
echo "Files directory exists: " . (is_dir($storagePath . '/files') ? 'Yes' : 'No') . "\n";

if (is_dir($storagePath . '/files')) {
    $filesInDir = glob($storagePath . '/files/*');
    echo "Files in directory: " . count($filesInDir) . "\n";
    foreach (array_slice($filesInDir, 0, 5) as $f) {
        echo "  - " . basename($f) . " (" . round(filesize($f) / 1024, 2) . " KB)\n";
    }
}

echo "\n========================================\n";
echo "STORAGE LINK\n";
echo "========================================\n\n";

$publicStorage = public_path('storage');
echo "Public storage link: {$publicStorage}\n";
echo "Link exists: " . (file_exists($publicStorage) ? 'Yes' : 'No') . "\n";

if (file_exists($publicStorage)) {
    echo "Link target: " . readlink($publicStorage) . "\n";
}

echo "\n";