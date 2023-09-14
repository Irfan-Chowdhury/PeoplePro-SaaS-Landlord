<?php

namespace Database\Seeders;

use App\Facades\Utility;
use App\Models\Landlord\Page;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $title1 = 'Privacy Policy';
        $title2 = 'Terms & Conditions';
        $description = 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.';

        $data = [
            [
                'language_id' => 1,
                'title' => $title1,
                'slug' => Utility::slugGenerate($title1),
                'description' => $description,
                'meta_title' => $title1,
                'meta_description' => $description,
            ],
            [
                'language_id' => 1,
                'title' => $title2,
                'slug' => Utility::slugGenerate($title2),
                'description' => $description,
                'meta_title' => $title2,
                'meta_description' => $description,
            ],
        ];

        Page::insert($data);
    }
}
