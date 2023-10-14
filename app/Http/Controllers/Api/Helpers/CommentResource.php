<?php

namespace App\Http\Controllers\Api\Helpers;


use Illuminate\Http\Resources\Json\JsonResource;

class CommentResource extends JsonResource
{

    public function toArray($request)
    {
      
        return [
            'id' => $this->id,
            'body' => $this->body,
            'user' => $this->user ? $this->user->email : null,
            'article' => $this->article ? $this->article->title : null,
            'created_at' => $this->created_at ? $this->created_at->diffForHumans() : null,
        ];
        
    }
}
