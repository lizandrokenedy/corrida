<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ResultadoRequest extends FormRequest
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
            'prova_id' => 'required|integer|exists:provas,id',
            'hora_inicio_prova' => 'required|datetime',
            'hora_conclusao_prova' => 'required|datetime',
        ];
    }
}
