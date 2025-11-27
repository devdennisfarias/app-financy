<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Proposta extends Model
{
	use HasFactory;
	use SoftDeletes;

	protected $table = 'propostas';


	public function cliente()
	{
		//@ 1 Modelo com qual me relaciono
		//@ 2 FK nesta tabela
		//@ 3 Referencia que a FK faz
		return $this->belongsTo(Cliente::class, 'cliente_id', 'id');
	}

	public function vendedor()
	{
		//@ 1 Modelo com qual me relaciono
		//@ 2 FK nesta tabela
		//@ 3 Referencia que a FK faz
		return $this->belongsTo(User::class, 'user_id', 'id');
	}

	public function produto()
	{
		//@ 1 Modelo com qual me relaciono
		//@ 2 FK nesta tabela
		//@ 3 Referencia que a FK faz
		return $this->belongsTo(Produto::class, 'produto_id', 'id');
	}

	public function documentos()
	{
		//HASMANY
		//@ 1 Modelo com qual me relaciono
		//@ 2 FK na tabela com que me relaciono
		//@ 3 FK que esta tabela envia
		return $this->hasMany(Documento::class, 'proposta_id', 'id');
	}

	public function atendimentos()
	{
		//HASMANY
		//@ 1 Modelo com qual me relaciono
		//@ 2 FK na tabela com que me relaciono
		//@ 3 FK que esta tabela envia
		return $this->hasMany(PropostaAten::class, 'proposta_id', 'id');
	}

	public function status_atual()
	{
		//@ 1 Modelo com qual me relaciono
		//@ 2 FK nesta tabela
		//@ 3 Referencia que a FK faz
		return $this->belongsTo(Status::class, 'status_atual_id', 'id');
	}

	public function statusAtual()
	{
		return $this->belongsTo(\App\Models\Status::class, 'status_atual_id');
	}


	public function status_tipo_atual()
	{
		//@ 1 Modelo com qual me relaciono
		//@ 2 FK nesta tabela
		//@ 3 Referencia que a FK faz
		return $this->belongsTo(StatusTipo::class, 'status_tipo_atual_id', 'id');
	}

	public static function propostasVendedor($id)
	{
		return Proposta::where('user_id', '=', $id)->get();
	}


	public static function qtdPagos()
	{
		return Proposta::select('propostas.*')
			->where('status_tipo_atual_id', '=', 4)
			->count();
	}

	public static function totalLiqPago()
	{
		return Proposta::select('propostas.*')
			->where('status_tipo_atual_id', '=', 4)
			->sum('valor_liquido_liberado');
	}

	public static function qtdDigitados()
	{
		return Proposta::select('propostas.*')->count();
	}

	public static function totalEmAndamento()
	{
		return Proposta::select('propostas.*')
			->where('status_tipo_atual_id', '!=', 5) //TODOS MENOS OS CANCELADOS
			->sum('valor_liquido_liberado');
	}

	public static function qtdCancelado()
	{
		return Proposta::select('propostas.*')
			->where('status_tipo_atual_id', '=', 5)
			->count();
	}

	public static function totalLiqCancelado()
	{
		return Proposta::select('propostas.*')
			->where('status_tipo_atual_id', '=', 5)
			->sum('valor_liquido_liberado');
	}


}
