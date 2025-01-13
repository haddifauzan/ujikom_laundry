<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\HomePageSettings;

class HomepageSettingsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        HomePageSettings::create([
            'hero_title' => 'Welcome to Our Platform',
            'hero_description' => 'We provide the best services for your needs. Join us to explore more.',
            'hero_image' => 'homepage/bg1.jpg',
            'about_title' => 'About Us',
            'about_description' => 'Our platform is dedicated to providing excellent services to our clients.',
            'about_image' => 'homepage/bg5.jpg',
            'services_title' => 'Our Services',
            'services_description' => 'We offer a variety of services tailored to meet your requirements.',
            'suppliers_title' => 'Trusted Suppliers',
            'suppliers_description' => 'Our suppliers are carefully selected to ensure quality and reliability.',
        ]);
    }
}
