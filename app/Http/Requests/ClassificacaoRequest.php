<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ClassificacaoRequest extends FormRequest
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
            'posicao' => 'required|integer',
            'corredor_id' => 'required|integer',
            'prova_id' => 'required|integer',
            'tipo_classificacao_id' => 'required|integer',
        ];
    }
}
