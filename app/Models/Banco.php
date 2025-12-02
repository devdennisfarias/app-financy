<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;


class Banco extends Model
{
	protected $fillable = [
		'nome',
		'codigo',
		'tipo',
	];


	public function contas()
	{
		return $this->hasMany(ContaBancaria::class);
	}

	public function promotoras()
	{
		return $this->belongsToMany(Promotora::class, 'banco_promotora');
	}

	public function produtos()
	{
		return $this->hasMany(Produto::class, 'banco_id');
	}

	public function comissoes()
	{
		return $this->hasMany(Comissao::class);
	}
	public function ufs()
	{
		return $this->hasMany(\App\Models\BancoUf::class);
	}
	public function getEstadosAtuacaoAttribute()
	{
		return $this->ufs->pluck('uf')->toArray();
	}
}
