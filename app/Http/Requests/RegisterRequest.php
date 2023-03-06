<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Validation\Rules\Password;

class RegisterRequest extends FormRequest
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
            "full_name" => [
                "required",
                "string",
                "max:255",
                "regex:/^[a-zA-Z ]+$/u",
                "min:3"
            ],
            "username" => [
                "required",
                "string",
                "regex:/^[a-zA-Z0-9]+$/",
                "max:255",
                "unique:users,username",
                "min:6"
            ],
            "email" => [
                "required",
                "email",
                "unique:users,email",
                "max:255"
            ],
            "password" => [
                "required",
                "confirmed",
                "max:255",
                Password::min(8)->numbers(),
            ],
            "password_confirmation" => [
                "required",
                "same:password"
            ]
        ];
    }

    public function messages()
    {
        return [
            'email.unique' => 'email sudah di pakai',
        ];
    }
}
