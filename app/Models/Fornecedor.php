<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Fornecedor extends Model
{
	protected $fillable = [
		'nome',
		'documento',
		'telefone',
		'email',
		'contato',
		'endereco',
	];
	protected $table = 'fornecedores';

	public function lancamentos()
	{
		return $this->hasMany(LancamentoFinanceiro::class);
	}
}
