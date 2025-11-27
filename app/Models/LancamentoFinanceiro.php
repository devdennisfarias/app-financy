<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class LancamentoFinanceiro extends Model
{
	protected $table = 'lancamentos_financeiros';

	protected $fillable = [
		'tipo',              // receita / despesa
		'natureza',          // pagar / receber
		'conta_bancaria_id',
		'fornecedor_id',
		'cliente_id',
		'descricao',
		'categoria',
		'data_competencia',
		'data_vencimento',
		'data_pagamento',
		'valor_previsto',
		'valor_pago',
		'status',            // aberto / pago / atrasado / cancelado
		'user_id',
	];

	public function contaBancaria()
	{
		return $this->belongsTo(ContaBancaria::class);
	}

	public function scopeReceitas(Builder $query)
	{
		return $query->where('tipo', 'receita');
	}

	public function scopeDespesas(Builder $query)
	{
		return $query->where('tipo', 'despesa');
	}

	public function scopeAbertos(Builder $query)
	{
		return $query->where('status', 'aberto');
	}

	public function scopePagos(Builder $query)
	{
		return $query->where('status', 'pago');
	}
	public function fornecedor()
	{
		return $this->belongsTo(Fornecedor::class);
	}

	public function cliente()
	{
		return $this->belongsTo(Cliente::class);
	}
}
