<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PostResource extends JsonResource
{

    /**
     * Transform the resource collection into an array.
     *
     * @return array<int|string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'summary' => substr($this->content, 0, 100). ' ...',
            'category' => $this->category->name ?? null,
            'author' => $this->user->name ?? null,
            'created_at' => $this->created_at->format('Y-m-d H:i:s'),
        ];
    }

}
