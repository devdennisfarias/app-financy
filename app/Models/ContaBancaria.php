<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ContaBancaria extends Model
{
	protected $fillable = [
		'banco_id',
		'nome',
		'agencia',
		'conta',
		'tipo_conta',
		'saldo_inicial',
	];
	protected $table = 'contas_bancarias';

	public function banco()
	{
		return $this->belongsTo(Banco::class);
	}

	public function lancamentos()
	{
		return $this->hasMany(LancamentoFinanceiro::class);
	}
}
