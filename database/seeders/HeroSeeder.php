<?php

namespace Database\Seeders;

use App\Models\Landlord\Hero;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class HeroSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            'language_id' => 1,
            'heading' => 'Peoplepro is a HRM software.',
            'sub_heading' => 'Take care of all your products, sales, purchases, stores related tasks from an easy-to-use platform, from anywhere you want, anytime you want',
            'button_text' => 'Try for free',
            'image' => '202310010734541.png',
        ];

        Hero::create($data);
    }
}
