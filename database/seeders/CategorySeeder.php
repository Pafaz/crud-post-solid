<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Category::create([
            'name' => 'Olahraga',
            'description' => 'Kategori ini berisi artikel-artikel tentang olahraga',
        ]);
        Category::create([
            'name' => 'Politik',
            'description' => 'Kategori ini berisi artikel-artikel tentang politik',
        ]);
    }
}
