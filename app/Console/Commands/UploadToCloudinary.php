<?php

namespace App\Console\Commands;

use App\Models\File;
use Cloudinary\Cloudinary;
use Cloudinary\Configuration\Configuration;
use Illuminate\Console\Command;

class UploadToCloudinary extends Command
{
    protected $signature = 'files:cloudinary-upload';
    protected $description = 'Upload all local files to Cloudinary';

    public function handle()
    {
        Configuration::instance([
            'cloud' => [
                'cloud_name' => env('CLOUDINARY_CLOUD_NAME'),
                'api_key'    => env('CLOUDINARY_API_KEY'),
                'api_secret' => env('CLOUDINARY_API_SECRET'),
            ],
            'url' => [
                'secure' => true,
            ],
        ]);

        $cloudinary = new Cloudinary();

        $files = File::whereNull('cloudinary_url')->get();
        $this->info("Found {$files->count()} files to upload...");

        foreach ($files as $file) {
            $localPath = storage_path('app/public/' . $file->path);

            if (!file_exists($localPath)) {
                $this->warn("SKIP - not found: {$localPath}");
                continue;
            }

            try {
                $publicId = 'powerful-posts/' . pathinfo($file->original_name, PATHINFO_FILENAME);

                $result = $cloudinary->uploadApi()->upload($localPath, [
                    'folder'    => 'powerful-posts',
                    'public_id' => pathinfo($file->original_name, PATHINFO_FILENAME),
                    'overwrite' => true,
                ]);

                $file->update([
                    'cloudinary_url'       => $result['secure_url'],
                    'cloudinary_public_id' => $result['public_id'],
                ]);

                $this->info("✅ {$file->name} => {$result['secure_url']}");

            } catch (\Exception $e) {
                $this->error("❌ {$file->name}: {$e->getMessage()}");
            }
        }

        $uploaded = File::whereNotNull('cloudinary_url')->count();
        $total    = File::count();
        $this->info("Done! Uploaded: {$uploaded}/{$total}");
    }
}