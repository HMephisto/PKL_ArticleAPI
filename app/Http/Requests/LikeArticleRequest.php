<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class LikeArticleRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            "user_id" => [
                "required",
                "exists:users,id",
                "unique_with:article_likes,user_id,article_id"
            ],
            "article_id" => [
                "required",
                "exists:users,id",
                "unique_with:article_likes,user_id,article_id"
            ]
        ];
    }
}
