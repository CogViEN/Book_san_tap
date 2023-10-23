<?php

namespace App\Http\Requests\PitchArea;

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
            'owner' => [
                'required',
                'string'
            ],
            'name' => [
                'required',
                'string',
                'min: 5',
                'max: 100'
            ],
            'address' => [
                'required',
                'string',
            ],
            'province' => [
                'required',
                'string',
                'not_in:Select City',
            ],
            'district' => [
                'required',
                'string',
                'not_in:Select District',
            ],
            'requirement' => [
                'nullable',
                'string',
            ],
            'images' => [
                'nullable',
                'array',
            ],
            'imageRemove' => [
                'nullable',
            ]
        ];
    }
}
