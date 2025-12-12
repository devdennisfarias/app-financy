<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Cliente extends Model
{
	use SoftDeletes;

	protected $table = 'clientes';

	/**
	 * Campos que podem ser preenchidos em massa (create/update)
	 */
	protected $fillable = [
		'nome',
		'cpf',
		'rg',
		'data_exp',
		'orgao_emissor',
		'data_nascimento',

		'orgao_id',          // vínculo com orgão pagador
		'telefone_1',
		'telefone_2',
		'telefone_3',
		'email',

		'cep',
		'endereco',
		'numero',
		'complemento',
		'bairro',
		'cidade',
		'estado',

		'nome_mae',
		'nome_pai',
		'estado_civil',
		'nacionalidade',

		'alfabetizado',
		'figura_publica',

		'telefone_2',
		'telefone_3',
		'primeiro_contato',
		'respondeu',
		'descricao_carteira',

		'user_id',           // usuário que cadastrou / responsável
	];

	/**
	 * Casts de campos especiais
	 */
	protected $casts = [
		'data_nascimento' => 'date',
		'data_exp' => 'date',
		'alfabetizado' => 'boolean',
		'figura_publica' => 'boolean',
		'primeiro_contato' => 'boolean',
		'respondeu' => 'boolean',
	];

	/**
	 * Relacionamentos
	 */

	// Cliente pertence a um órgão pagador
	public function orgao()
	{
		return $this->belongsTo(Orgao::class, 'orgao_id');
	}

	// Através do órgão, acessa o convênio (se quiser usar)
	public function convenio()
	{
		return $this->hasOneThrough(
			Convenio::class,
			Orgao::class,
			'id',          // Foreign key em Orgao (tabela orgaos)
			'id',          // Foreign key em Convenio
			'orgao_id',    // FK em Cliente apontando para Orgao
			'convenio_id'  // FK em Orgao apontando para Convenio
		);
	}

	// Propostas do cliente
	public function propostas()
	{
		return $this->hasMany(Proposta::class);
	}
}