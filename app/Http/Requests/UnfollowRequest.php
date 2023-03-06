<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UnfollowRequest extends FormRequest
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
                Rule::exists('users_follow')->where(function ($query) {
                    return $query->where('user_id', $this->user_id)
                        ->where('follower_id', $this->follower_id);
                }),
            ],
            "follower_id" => [
                "required",
                "exists:users,id",
            ]
        ];
    }

    public function messages()
    {
        return [
            'user_id.exists' => 'The user didn\'t follow the following user',
        ];
    }
}
