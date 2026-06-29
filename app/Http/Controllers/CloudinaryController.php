<?php

namespace App\Http\Controllers;

use Cloudinary\Cloudinary;

class CloudinaryController extends Controller
{
    public function uploadImage()
    {
        try {
            $cloudinary = new Cloudinary([
                'cloud' => [
                    'cloud_name' => 'dgk1pwiet',
                    'api_key' => '628453573112432',
                    'api_secret' => 'uYQQzPYIwWlFlhsA9dPbWvCltkc',
                ],
            ]);

            $result = $cloudinary->uploadApi()->upload(
                'https://res.cloudinary.com/demo/image/upload/sample.jpg'
            );
            
            echo "<pre>";
            echo "✅ Upload successful!\n";
            echo "Public ID: " . $result['public_id'] . "\n";
            echo "Secure URL: " . $result['secure_url'] . "\n";
            echo "</pre>";
            
        } catch (\Exception $e) {
            echo "❌ Error: " . $e->getMessage();
        }
    }
}