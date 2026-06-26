// database/migrations/2026_06_26_154612_create_admin_user.php
<?php

use App\Models\User;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Hash;

return new class extends Migration
{
    public function up()
    {
        $email = env('ADMIN_EMAIL', 'admin@example.com');
        
        // ✅ CHECK IF USER EXISTS FIRST
        if (!User::where('email', $email)->exists()) {
            User::create([
                'name' => env('ADMIN_NAME', 'Admin User'),
                'email' => $email,
                'password' => Hash::make(env('ADMIN_PASSWORD', 'password123')),
                'email_verified_at' => now(),
            ]);
            echo "✅ Admin user created!\n";
        } else {
            echo "✅ Admin user already exists. Skipping...\n";
        }
    }

    public function down()
    {
        // Optional: remove admin user
        User::where('email', env('ADMIN_EMAIL', 'admin@example.com'))->delete();
    }
};