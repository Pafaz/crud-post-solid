<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    protected $table = 'comments';

    protected $fillable = [
        'content',
        'user_id',
        'post_id',
    ];

    // Define the relationship with the User model
    // A comment belongs to a user
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Define the relationship with the Post model
    // A comment belongs to a post
    public function post()
    {
        return $this->belongsTo(Post::class);
    }

}
