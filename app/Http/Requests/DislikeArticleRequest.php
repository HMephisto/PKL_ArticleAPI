<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class DislikeArticleRequest extends FormRequest
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
                Rule::exists('article_likes')->where(function ($query) {
                    return $query->where('user_id', $this->user_id)
                        ->where('article_id', $this->article_id);
                }),
            ],
            "article_id" => [
                "required",
                "exists:users,id",
            ]
        ];
    }
}
