<?php

namespace App\Http\Requests\Post;

use Illuminate\Foundation\Http\FormRequest;

class StoreRequest extends FormRequest
{
   
    public function authorize()
    {
        return true;
    }

   
    public function rules()
    {
        return [
            'heading' => [
                'required',
                'string',
            ],
            'description' => [
                'required',
                'string',
            ],
            'avatar' => [
                'required',
                'mimes:jpeg,png,jpg,gif',
            ],
        ];
    }
}
