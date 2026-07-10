<?php

namespace Database\Seeders;

use App\Models\File;
use Illuminate\Database\Seeder;

class CloudinaryUrlSeeder extends Seeder
{
    public function run(): void
    {
        $urls = [
            'ketum'          => 'https://res.cloudinary.com/dgk1pwiet/image/upload/v1783667549/powerful-posts/ketum.jpg',
            'TV LED'         => 'https://res.cloudinary.com/dgk1pwiet/image/upload/v1783667551/powerful-posts/TV%20LED.webp',
            'mercurial'      => 'https://res.cloudinary.com/dgk1pwiet/image/upload/v1783667554/powerful-posts/mercurial.webp',
            'Gaming-Mouse'   => 'https://res.cloudinary.com/dgk1pwiet/image/upload/v1783667556/powerful-posts/Gaming-Mouse.webp',
            'tumbler 1'      => 'https://res.cloudinary.com/dgk1pwiet/image/upload/v1783667558/powerful-posts/tumbler%201.webp',
            'buku'           => 'https://res.cloudinary.com/dgk1pwiet/image/upload/v1783667560/powerful-posts/buku.jpg',
            'speaker power'  => 'https://res.cloudinary.com/dgk1pwiet/image/upload/v1783667562/powerful-posts/speaker%20power.jpg',
            'iphone-18-pro'  => 'https://res.cloudinary.com/dgk1pwiet/image/upload/v1783667567/powerful-posts/iphone-18-pro.png',
            'laptop'         => 'https://res.cloudinary.com/dgk1pwiet/image/upload/v1783667569/powerful-posts/laptop.webp',
            'straw hat luffy' => 'https://res.cloudinary.com/dgk1pwiet/image/upload/v1783667572/powerful-posts/straw%20hat%20luffy.jpg',
            'earbud 3'       => 'https://res.cloudinary.com/dgk1pwiet/image/upload/v1783667574/powerful-posts/earbud%203.webp',
            'arsenal 2026-06-05 102914' => 'https://res.cloudinary.com/dgk1pwiet/image/upload/v1783667576/powerful-posts/arsenal%202026-06-05%20102914.jpg',
            'earbud 2'       => 'https://res.cloudinary.com/dgk1pwiet/image/upload/v1783667578/powerful-posts/earbud%202.webp',
            'arsenal-away-front' => 'https://res.cloudinary.com/dgk1pwiet/image/upload/v1783667580/powerful-posts/arsenal-away-front.webp',
            'untitled1'      => 'https://res.cloudinary.com/dgk1pwiet/image/upload/v1783667582/powerful-posts/untitled1.jpg',
            'arsenal_HERO'   => 'https://res.cloudinary.com/dgk1pwiet/image/upload/v1783667585/powerful-posts/arsenal_HERO.jpg',
            'Ayam_geprek'    => 'https://res.cloudinary.com/dgk1pwiet/image/upload/v1783667588/powerful-posts/Ayam_geprek.png',
            'Cyber security header_1920x1280px (1)' => 'https://res.cloudinary.com/dgk1pwiet/image/upload/v1783667591/powerful-posts/Cyber%20security%20header_1920x1280px%20%281%29.jpg',
            'testing-web-apps' => 'https://res.cloudinary.com/dgk1pwiet/image/upload/v1783667593/powerful-posts/testing-web-apps.webp',
            'Laptop-harga-murah-lenovo-ideapad-slim-3i' => 'https://res.cloudinary.com/dgk1pwiet/image/upload/v1783667595/powerful-posts/Laptop-harga-murah-lenovo-ideapad-slim-3i.jpg',
            'Screenshot 2026-06-12 093000' => 'https://res.cloudinary.com/dgk1pwiet/image/upload/v1783667597/powerful-posts/Screenshot%202026-06-12%20093000.jpg',
            'Chapter_1185'   => 'https://res.cloudinary.com/dgk1pwiet/image/upload/v1783667600/powerful-posts/Chapter_1185.webp',
        ];

        foreach ($urls as $name => $url) {
            File::where('name', $name)->update(['cloudinary_url' => $url]);
        }

        $this->command->info('Cloudinary URLs updated: ' . File::whereNotNull('cloudinary_url')->count() . ' files');
    }
}