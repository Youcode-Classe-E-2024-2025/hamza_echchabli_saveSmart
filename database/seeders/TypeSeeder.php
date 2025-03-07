<?php
use Illuminate\Database\Seeder;
use App\Models\Type;

class TypeSeeder extends Seeder
{
    public function run()
    {
        Type::create(['title' => 'income']);
        Type::create(['title' => 'needs']);
        Type::create(['title' => 'wants']);
        Type::create(['title' => 'savings']);
    }
}
