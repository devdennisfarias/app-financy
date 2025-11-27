<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreUpdateClienteRequest extends FormRequest
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

    public function rules()
    {
        return [
            'nome' => 'required|min:3|max:160',
            'cpf' => 'required',
            'figura_publica' => '',
            'rg' => '',
            'data_exp' => '',
            'orgao_emissor' => '',
            'data_nascimento' => '',
            'alfabetizado' => '',
            'nome_pai' => '',
            'nome_mae' => '',
            'endereco' => '',
            'nacionalidade' => '',
            'naturalidade' => '',
            'estado_civil' => '',
            'orgao_1' => '',
            'matricula_1' => '',
            'especie_beneficio_1' => '',
            'salario_1' => '',
            'banco_conta_1' => '',
            'agencia_conta_1' => '',
            'conta_bancaria_1' => '',
            'orgao_2' => '',
            'matricula_2' => '',
            'especie_beneficio_2' => '',
            'salario_2' => '',
            'banco_conta_2' => '',
            'agencia_conta_2' => '',
            'conta_bancaria_2' => '',
            'telefone_1' => '',
            'telefone_2' => '',
            'telefone_3' => '',
            'created_at' => '',
        ];
    }
}
