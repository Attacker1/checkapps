<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'login' => 'required',
            'password' => 'required',
        ];
    }

    public function messages()
    {
        return [
            'required' => 'Данное поле обязательно для заполнения',
        ];
    }
}
