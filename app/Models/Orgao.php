<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Orgao extends Model
{
	protected $table = 'orgaos';

	protected $fillable = ['nome', 'convenio_id', 'ativo'];

	public function convenio()
	{
		return $this->belongsTo(Convenio::class);
	}

	public function clientes()
	{
		return $this->hasMany(Cliente::class);
	}
}

