<?php

namespace App\Repositories;

use App\Interfaces\CategoryInterface;
use App\Models\Category;
use Illuminate\Database\Eloquent\Collection;

class CategoryRepository implements CategoryInterface
{
    public function getAll(): Collection
    {
        return Category::all();
    }

    public function find(int $id): ? Category
    {
        return Category::findOrFail($id)->first();
    }

    public function create(array $data): ? Category
    {
        return Category::create([
            'name' => $data['categoryName'],
            'description' => $data['description']
        ]);
    }

    public function update(int $id, array $data): mixed
    {
        return Category::where('id', $id)->update([
            'name' => $data['name'],
            'description' => $data['description']
        ]);
    }

    public function delete(int $id): void
    {
        Category::findOrFail($id)->delete();
    }
}
