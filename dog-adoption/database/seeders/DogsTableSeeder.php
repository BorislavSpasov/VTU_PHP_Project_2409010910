<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Dog;

class DogsTableSeeder extends Seeder
{
    public function run(): void
    {
        Dog::create([
            'name' => 'Buddy',
            'breed' => 'Golden Retriever',
            'age' => 3,
            'gender' => 'male',
            'description' => 'Friendly and energetic.',
            'image_url' => 'dogs/buddy.jpg',
            'is_adopted' => false,
        ]);

        Dog::create([
            'name' => 'Luna',
            'breed' => 'Labrador',
            'age' => 2,
            'gender' => 'female',
            'description' => 'Loves to play fetch.',
            'image_url' => 'dogs/luna.jpg',
            'is_adopted' => false,
        ]);

        Dog::create([
            'name' => 'Charlie',
            'breed' => 'Beagle',
            'age' => 4,
            'gender' => 'male',
            'description' => 'Very curious and friendly.',
            'image_url' => 'dogs/charlie.jpg',
            'is_adopted' => false,
        ]);

        Dog::create([
            'name' => 'Bella',
            'breed' => 'Poodle',
            'age' => 1,
            'gender' => 'female',
            'description' => 'Smart and gentle.',
            'image_url' => 'dogs/bella.jpg',
            'is_adopted' => false,
        ]);
    }
}
