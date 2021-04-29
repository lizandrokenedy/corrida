<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CorredorEmProvaRequest extends FormRequest
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
     * @return array
     */
    public function rules()
    {
        return [
            'corredor_id' => 'required|integer|exists:corredores,id',
            'prova_id' => 'required|integer|exists:provas,id'
        ];
    }
}
