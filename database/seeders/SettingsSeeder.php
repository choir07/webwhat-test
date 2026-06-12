<?php

namespace Database\Seeders;

use App\Models\Setting;
use Illuminate\Database\Seeder;

class SettingsSeeder extends Seeder
{
    public function run(): void
    {
        // General Settings
        Setting::set('general.site_name', 'My Filament App', 'general', true);
        Setting::set('general.site_description', 'A powerful Filament application', 'general', true);
        Setting::set('general.timezone', 'UTC', 'general', true);
        Setting::set('general.date_format', 'Y-m-d', 'general', true);
        
        // Appearance Settings
        Setting::set('appearance.theme', 'light', 'appearance', false);
        Setting::set('appearance.primary_color', '#f59e0b', 'appearance', false);
        Setting::set('appearance.sidebar_collapsed', false, 'appearance', false);
        
        // Email Settings
        Setting::set('email.from_address', 'noreply@example.com', 'email', false);
        Setting::set('email.from_name', 'My App', 'email', false);
        
        // Security Settings
        Setting::set('security.session_timeout', 120, 'security', false);
        Setting::set('security.max_login_attempts', 5, 'security', false);
        
        // Feature Toggles
        Setting::set('features.user_registration', true, 'general', false);
        Setting::set('features.api_access', false, 'integrations', false);
    }
}