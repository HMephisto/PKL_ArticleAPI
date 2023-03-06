<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'username' => $this->username,
            'full_name' => $this->full_name,
            'email' => $this->email,
            // 'password' => $this->password,
            'gender' => $this->gender,
            'birthday' => $this->birthday,
            'description' => $this->description,
            'verifikasi' => $this->verifikasi,
            'profile_picture' => secure_url('storage/images/' . $this->profile_picture),
            'profile_cover' => secure_url('storage/images/' . $this->profile_cover),
            'article' => ArticleResource::collection($this->whenLoaded('article')),
            'liked_article' => ArticleResource::collection($this->whenLoaded('likes')),
            'followers' => $this->followers_count,
            'following' => $this->followings_count,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
