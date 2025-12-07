<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdatePropostaRequest extends FormRequest
{
	/**
	 * Determine if the user is authorized to make this request.
	 */
	public function authorize(): bool
	{
		// Aqui você pode usar Policy se quiser algo mais fino:
		// return $this->user()->can('update', $this->route('proposta'));
		return true;
	}

	/**
	 * Get the validation rules that apply to the request.
	 */
	public function rules(): array
	{
		return [
			'produto_id' => 'required|exists:produtos,id',
			'banco_id' => 'nullable|exists:bancos,id',
			'banco' => 'nullable|string',
			'orgao' => 'nullable|string',
			'valor_bruto' => 'nullable|numeric',
			'valor_liquido_liberado' => 'nullable|numeric',
			'tx_juros' => 'nullable|numeric',
			'valor_parcela' => 'nullable|numeric',
			'qtd_parcelas' => 'nullable|integer',
			'status_atual_id' => 'nullable|exists:status,id',
		];
	}

	public function messages(): array
	{
		return [
			'produto_id.required' => 'Selecione um produto.',
			'produto_id.exists' => 'O produto informado é inválido.',
			'banco_id.exists' => 'O banco informado é inválido.',
			'status_atual_id.exists' => 'O status informado é inválido.',
		];
	}
}
