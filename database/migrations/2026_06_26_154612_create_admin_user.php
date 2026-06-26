<?php

use App\Models\User;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Hash;

return new class extends Migration
{
    public function up()
    {
        // Check if admin exists
        $adminEmail = env('ADMIN_EMAIL', 'admin@example.com');
        
        if (!User::where('email', $adminEmail)->exists()) {
            User::create([
                'name' => env('ADMIN_NAME', 'Admin User'),
                'email' => $adminEmail,
                'password' => Hash::make(env('ADMIN_PASSWORD', 'password123')),
                'email_verified_at' => now(),
            ]);
            
            echo " Admin user created!\n";
        }
    }

    public function down()
    {
        // Optional: remove admin user
        User::where('email', env('ADMIN_EMAIL', 'admin@example.com'))->delete();
    }
};