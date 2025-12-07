<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Convenio extends Model
{
	use HasFactory;

	protected $table = 'convenios';

	protected $fillable = [
		'nome',
		'slug',
		'ativo',
	];

	public function clientes()
	{
		return $this->hasMany(Cliente::class, 'convenio_id');
	}

	public function orgaos()
	{
		return $this->hasMany(Orgao::class);
	}

}
