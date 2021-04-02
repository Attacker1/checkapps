<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PurchaseListRequest extends FormRequest
{
    protected function prepareForValidation()
    {
        if (!$this->has('page')) {
            $this->merge(['page' => rand(1, 10000)]);
        }
        if (!$this->has('limit')) {
            $this->merge(['limit' => 10]);
        }
    }


    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'token_id' => 'required',
            'page' => 'numeric',
            'limit' => 'numeric',
        ];
    }

    public function messages()
    {
        return [
            'required' => 'Данное поле обязательно для заполнения',
        ];
    }
}
