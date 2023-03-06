<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class EditUserRequest extends FormRequest
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
            "profile_picture" => [
                "nullable",
                "string",
            ],
            "profile_cover" => [
                "nullable",
                "string",
            ],
            "username" => [
                "nullable",
                "unique:users,username," . $this->getId(),
            ],
            "full_name" => [
                "nullable"
            ],
            "description" => [
                "nullable",
                "string",
                "max:255"
            ],
            "gender" => [
                "required",
                "in:L,P"
            ],
            "birthday" => [
                "required",
                "date"
            ]
        ];
    }

    private function getId()
    {
        return Str::after(Request::url(), 'users/');
    }
}
