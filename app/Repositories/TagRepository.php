<?php

namespace App\Repositories;

use App\Models\Tag;
use App\Interfaces\TagInterface;
use Illuminate\Database\Eloquent\Collection;

class TagRepository implements TagInterface
{
    public function getAll(): Collection
    {
        return Tag::all();
    }

    public function find(int $id): ?Tag
    {
        return Tag::findOrFail($id);
    }

    public function create(array $data): ?Tag
    {
        return Tag::create(['name' => $data['tagName']]);
    }
    
    public function update(int $id, array $data): bool
    {
        return Tag::where('id', $id)->update($data);
    }

    public function delete(int $id): void
    {
        Tag::findOrFail($id)->delete();
    }
}
