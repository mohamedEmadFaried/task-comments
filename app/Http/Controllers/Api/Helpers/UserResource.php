<?php

namespace App\Http\Controllers\Api\Helpers;


use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{

    public function toArray($request)
    {
      
        return [
            'id' => $this->id,
            'username'  => $this->username,
            'email' => $this->email,
            'phone' => $this->phone,
            'created_at' => $this->created_at?->diffForHumans()
        ];
    }
}
