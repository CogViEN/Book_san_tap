<?php

namespace App\Http\Requests\Appointment;

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
            ],
            'phone' => [
                'required',
                'numeric',
            ],
            'pitcharea' => [
                'required',
                'numeric',
            ],
            'require' => [
                'nullable',
                'string',
            ],
            'pitch' => [
                'required',
                'numeric',
            ],
            'willdo' => [
                'required',
                'date'
            ],
            'timeslots_cost' => [
                'required',
                'array',
            ],
            'timeslots' => [
                'required',
                'string',
            ],
        ];
    }

    public function messages()
    {
        return[
            'pitcharea.numeric' => 'Nhập đi thằng cô hồn',
            'pitch.numeric' => 'Đừng để tao nóng',
            'date.required' => 'M làm khách tao hơi lâu rồi đó',
            'timeslots_cost.required' => 'Tao ủi đó nhan',

        ];
    }
}
