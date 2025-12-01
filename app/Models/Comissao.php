<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Comissao extends Model
{
	protected $fillable = [
		'produto_id',
		'banco_id',
		'promotora_id',
		'tipo_comissao',
		'percentual',
		'valor_fixo',
		'vigencia_inicio',
		'vigencia_fim',
		'ativo',
	];

	public function produto()
	{
		return $this->belongsTo(Produto::class);
	}

	public function banco()
	{
		return $this->belongsTo(Banco::class);
	}

	public function promotora()
	{
		return $this->belongsTo(Promotora::class);
	}
}

