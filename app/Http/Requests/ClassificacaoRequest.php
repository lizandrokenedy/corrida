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
            'prova_id' => 'required|integer|exists:provas,id',
        ];
    }


    public function messages()
    {
        return [
            'prova_id.exists' => 'Prova não encontrada.',
            'prova_id.required' => 'É necessário informar uma prova para gerar as classificações.'
        ];
    }
}
