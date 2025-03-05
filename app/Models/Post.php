<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    //
    protected $table = 'posts';
    protected $fillable = ['title', 'content', 'category_id', 'user_id'];

    // Many to Many relationship
    public function tags()
    {
        return $this->belongsToMany(Tag::class, 'post_tag', 'post_id', 'tag_id');
    }

    // One to Many relationship
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    // One to Many relationship
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // One to Many relationship
    public function comments()
    {
        return $this->hasMany(Comment::class);
    }
}
