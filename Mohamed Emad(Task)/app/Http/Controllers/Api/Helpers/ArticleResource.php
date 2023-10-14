<?php

namespace App\Http\Controllers\Api\Helpers;


use Illuminate\Http\Resources\Json\JsonResource;

class ArticleResource extends JsonResource
{

    public function toArray($request)
    {

        return [
            'id' => $this->id,
            'title' => $this->title,
            'content' => $this->content,
            'user' => $this->user ? $this->user->username : null,
            'comments' => $this->when(!is_null($this->comments), function () {
                return $this->comments->map(function ($comment) {
                    return [
                        'id' => $comment->id,
                        'body' => $comment->body,
                        'created_at' => $comment->created_at ? $comment->created_at->diffForHumans() : null,
                    ];
                });
            }),            
            'created_at' => $this->created_at ? $this->created_at->diffForHumans() : null,
        ];
    }
}
