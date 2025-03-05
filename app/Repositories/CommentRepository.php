<?php

namespace App\Repositories;

use App\Models\Comment;
use App\Interfaces\CommentInterface;
use Illuminate\Support\Facades\Auth;

class CommentRepository implements CommentInterface
{

    public function create(array $data): ?Comment
    {
        return Comment::create([
            'user_id' => Auth::id(),
            'post_id' => $data['post_id'],
            'content' => $data['content'],
        ]);
    }

    public function update(int $id, array $data): bool
    {
        return Comment::where('id', $id)->update([
            'content' => $data['content'],
        ]);
    }

    public function delete(int $id): void
    {
        Comment::findOrFail($id)->delete();
    }

    public function deleteByPost(int $id): void
    {
        Comment::where('post_id', $id)->delete();
    }

}
