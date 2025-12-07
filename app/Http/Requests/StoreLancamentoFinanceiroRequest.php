<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreLancamentoFinanceiroRequest extends FormRequest
{
	public function authorize(): bool
	{
		// Se quiser pode integrar com Gate/Policy:
		// return $this->user()?->can('lancamentos.create') ?? false;
		return true;
	}

	public function rules(): array
	{
		return [
			'tipo' => 'required|in:receita,despesa',
			'natureza' => 'required|in:pagar,receber',
			'conta_bancaria_id' => 'nullable|exists:contas_bancarias,id',
			'descricao' => 'required|string|max:255',
			'categoria' => 'nullable|string|max:255',
			'data_competencia' => 'nullable|date',
			'data_vencimento' => 'nullable|date',
			'data_pagamento' => 'nullable|date',
			'valor_previsto' => 'required|numeric',
			'valor_pago' => 'nullable|numeric',
			'status' => 'required|in:aberto,pago,atrasado,cancelado',

			// campos relacionais opcionais (se tiver no form)
			'fornecedor_id' => 'nullable|exists:fornecedores,id',
			'cliente_id' => 'nullable|exists:clientes,id',
		];
	}

	public function messages(): array
	{
		return [
			'tipo.required' => 'O tipo do lançamento é obrigatório.',
			'tipo.in' => 'O tipo deve ser receita ou despesa.',
			'natureza.required' => 'A natureza é obrigatória.',
			'natureza.in' => 'A natureza deve ser pagar ou receber.',
			'descricao.required' => 'A descrição é obrigatória.',
			'valor_previsto.required' => 'O valor previsto é obrigatório.',
			'valor_previsto.numeric' => 'O valor previsto deve ser numérico.',
			'conta_bancaria_id.exists' => 'A conta bancária informada é inválida.',
			'fornecedor_id.exists' => 'O fornecedor informado é inválido.',
			'cliente_id.exists' => 'O cliente informado é inválido.',
		];
	}
}
