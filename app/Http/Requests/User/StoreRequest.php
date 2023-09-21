<?php

namespace App\Http\Requests\User;

use Illuminate\Foundation\Http\FormRequest;

class StoreRequest extends FormRequest
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
            'name' => [
                'required',
                'string',
                'filled'
            ],
            'phone' => [
                'required',
                'numeric',
            ],
            'password' => [
                'required',
            ],
            'email' => [
                'nullable',
                'email:rfc,dns',
            ],
            'avatar' => [
                'nullable',
                'mimes:jpeg,png,jpg,gif',
            ],
            'role' => [
                'required',
                'numeric',
            ]
        ];
    }
}
