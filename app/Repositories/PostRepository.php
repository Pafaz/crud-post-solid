<?php

namespace App\Repositories;

use App\Interfaces\PostInterface;
use App\Models\Post;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Collection;

class PostRepository implements PostInterface
{
    public function getAll(?string $category = null): Collection
    {   
        $query = Post::query();

        if ($category) {
            $query->where('category_id', $category);
        }
    
        return $query->get();
    }

    public function find(int $id): ?Post
    {
        return Post::with(['category', 'tags', 'user', 'comments'])->findOrFail($id);
    }

    public function create(array $data): ?Post
    {
        $post = Post::create([
            'user_id' => Auth::id(),
            'title' => $data['title'],
            'content' => $data['content'],
            'category_id' => $data['category']
        ]); 
        return $post;
    }

    public function update(int $id, array $data): bool
    {
        $post = Post::findOrFail($id);
        $post->update([
            'title' => $data['title'],
            'content' => $data['content'],
            'category_id' => $data['category']
        ]);
        return true;
    }

    public function delete(int $id): void
    {
        Post::findOrFail($id)->delete();
    }
    
}
