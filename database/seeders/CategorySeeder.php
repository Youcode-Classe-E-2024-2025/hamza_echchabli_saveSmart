<?php

use Illuminate\Database\Seeder;
use App\Models\Categorie;

class CategorySeeder extends Seeder
{
    public function run()
    {
        $defaultCategories = [
            ['title' => 'rent', 'type_id' => 3, 'user_id' => null], // null means available for all
            ['title' => 'travling', 'type_id' => 2, 'user_id' => null],
            ['title' => 'Freelance', 'type_id' => 1, 'user_id' => null],
        ];

        foreach ($defaultCategories as $category) {
            Categorie::firstOrCreate([
                'title' => $category['title'],
                'type_id' => $category['type_id'],
                'user_id' => $category['user_id'],
            ]);
        }
    }
    
}
$this->call(CategorySeeder::class);