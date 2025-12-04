<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Proposta extends Model
{
	use HasFactory;
	use SoftDeletes;

	protected $fillable = [
		'orgao',
		'banco',
		'valor_bruto',
		'valor_liquido_liberado',
		'tx_juros',
		'valor_parcela',
		'qtd_parcelas',
		'produto_id',
		'banco_id',
		'cliente_id',
		'user_id',
	];


	protected $table = 'propostas';


	public function cliente()
	{
		//@ 1 Modelo com qual me relaciono
		//@ 2 FK nesta tabela
		//@ 3 Referencia que a FK faz
		return $this->belongsTo(Cliente::class, 'cliente_id', 'id');
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
		return $this->hasMany(Proposta::class, 'proposta_id', 'id');
	}

	public function status_atual()
	{
		return $this->belongsTo(\App\Models\Status::class, 'status_atual_id');
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

	// use App\Models\StatusTipo;  <-- garante que tenha esse use no topo

	public function statusTipoAtual()
	{
		return $this->belongsTo(StatusTipo::class, 'status_tipo_atual_id');
	}

	/**
	 * Texto amigável do status (vem de status_tipos)
	 */
	public function getStatusTipoDescricaoAttribute()
	{
		// ajuste o campo conforme sua migration/status_tipos (descricao, nome, titulo, etc)
		return optional($this->statusTipoAtual)->descricao ?? 'Não informado';
	}

	/**
	 * Classe CSS do badge, baseado no tipo/status_tipos.
	 * Se você tiver um campo 'slug' ou 'codigo' em status_tipos, melhor usar ele.
	 */
	public function getStatusTipoBadgeClassAttribute()
	{
		// se tiver 'slug' em status_tipos, use:
		$slug = optional($this->statusTipoAtual)->slug;

		return match ($slug) {
			'cadastrada' => 'badge-secondary',
			'andamento' => 'badge-info',
			'pendente' => 'badge-warning',
			'concluida' => 'badge-success',
			'cancelada' => 'badge-danger',
			default => 'badge-default',
		};

		// Se ainda não tiver slug e quiser manter por ID:
		/*
		return match ($this->status_tipo_atual_id) {
				1 => 'badge-secondary',
				2 => 'badge-info',
				3 => 'badge-warning',
				4 => 'badge-success',
				5 => 'badge-danger',
				default => 'badge-default',
		};
		*/
	}

	public function instituicao()
	{
		return $this->belongsTo(\App\Models\Banco::class, 'banco_id');
	}
	public function user()
	{
		return $this->belongsTo(User::class);
	}

	public function produto()
	{
		return $this->belongsTo(Produto::class);
	}

	public function banco()
	{
		return $this->belongsTo(Banco::class, 'banco_id');
	}

	public function vendedor()
	{
		return $this->belongsTo(User::class, 'user_id');
	}

}
