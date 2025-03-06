<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PostDetailResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id'        => $this->id,
            'title'     => $this->title,
            'content'   => $this->content,
            'author'    => $this->user->name,
            'category'  => $this->category->name,
            'tags'      => $this->tags->pluck('name'),
            'comments'  => $this->comments->map(fn($comment) => [
                'user'      => $comment->user->name,
                'comment'   => $comment->body,
                'created_at'=> $comment->created_at->format('Y-m-d H:i:s'),
            ]),
            'created_at'=> $this->created_at->format('Y-m-d H:i:s'),
            'updated_at'=> $this->updated_at->format('Y-m-d H:i:s'),
        ];
    }
}
