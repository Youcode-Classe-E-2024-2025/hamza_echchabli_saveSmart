<?php

namespace Database\Factories;

use App\Models\Categorie;
use Illuminate\Database\Eloquent\Factories\Factory;

class CategorieFactory extends Factory
{
    protected $model = Categorie::class;

    public function definition()
    {
        return [
            'title' => $this->faker->word(),
            'type_id' => \App\Models\Type::factory(),
            'user_id' => \App\Models\User::factory(),
        ];
    }
}