<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StorePropostaRequest extends FormRequest
{
	/**
	 * Determine if the user is authorized to make this request.
	 */
	public function authorize(): bool
	{
		// Se você tiver Gate/Policy para proposta, pode trocar por algo como:
		// return $this->user()->can('create', Proposta::class);
		return true;
	}

	/**
	 * Get the validation rules that apply to the request.
	 */
	public function rules(): array
	{
		return [
			'cpf' => 'required|string',
			'produto_id' => 'required|exists:produtos,id',
			'banco_id' => 'nullable|exists:bancos,id',
			'banco' => 'nullable|string',
			'orgao' => 'nullable|string',
			'valor_bruto' => 'nullable|numeric',
			'valor_liquido_liberado' => 'nullable|numeric',
			'tx_juros' => 'nullable|numeric',
			'valor_parcela' => 'nullable|numeric',
			'qtd_parcelas' => 'nullable|integer',
		];
	}

	/**
	 * Mensagens personalizadas (opcional).
	 */
	public function messages(): array
	{
		return [
			'cpf.required' => 'O campo CPF é obrigatório.',
			'produto_id.required' => 'Selecione um produto.',
			'produto_id.exists' => 'O produto informado é inválido.',
			'banco_id.exists' => 'O banco informado é inválido.',
		];
	}
}
