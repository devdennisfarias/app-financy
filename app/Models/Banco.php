<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Banco extends Model
{
	protected $fillable = [
		'nome',
		'codigo',
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
		return $this->hasMany(Produto::class);
	}

	public function comissoes()
	{
		return $this->hasMany(Comissao::class);
	}
}
