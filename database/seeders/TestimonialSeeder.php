<?php

namespace Database\Seeders;

use App\Models\Landlord\Testimonial;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TestimonialSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            'name' => 'Mark Williamson',
            'description' => 'Great Customer Support Ever! The support guy was really helpful!',
            'business_name' => 'LionCoders',
            'position' => 1,
            'image' => 'logo.png',
        ];

        Testimonial::create($data);
    }
}
