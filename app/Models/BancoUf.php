<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BancoUf extends Model
{
	protected $table = 'banco_ufs';

	protected $fillable = [
		'banco_id',
		'uf',
	];

	public function banco()
	{
		return $this->belongsTo(Banco::class);
	}
}
