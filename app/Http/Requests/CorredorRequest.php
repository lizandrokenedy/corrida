<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CorredorRequest extends FormRequest
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
            'nome' => 'required|string|max:255',
            'cpf' => 'required|string|max:11',
            'data_nascimento' => 'required|date',
            'idade' => 'required|integer|max:3',
        ];
    }
}
