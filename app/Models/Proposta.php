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

	/**
	 * Campos liberados para mass assignment.
	 * Se tiver mais colunas na tabela, pode acrescentar aqui depois.
	 */
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
		'status_atual_id',
		'status_tipo_atual_id',
		'tabela_digitada',
		'observacao',
	];

	protected $casts = [
		'valor_bruto' => 'float',
		'valor_liquido_liberado' => 'float',
		'tx_juros' => 'float',
		'valor_parcela' => 'float',
		'qtd_parcelas' => 'integer',
	];

	/*
	|--------------------------------------------------------------------------
	| RELACIONAMENTOS
	|--------------------------------------------------------------------------
	*/

	public function cliente()
	{
		return $this->belongsTo(Cliente::class, 'cliente_id');
	}

	public function documentos()
	{
		return $this->hasMany(Documento::class, 'proposta_id', 'id');
	}

	public function atendimentos()
	{
		// Mantido conforme padrão antigo, se você usar.
		return $this->hasMany(Proposta::class, 'proposta_id', 'id');
	}

	/**
	 * Status principal da proposta (tabela status).
	 * Usar nas telas: $proposta->status_atual->status
	 */
	public function status_atual()
	{
		return $this->belongsTo(Status::class, 'status_atual_id');
	}

	/**
	 * Alias: $proposta->status
	 */
	public function status()
	{
		return $this->status_atual();
	}

	/**
	 * Tipo de status (tabela status_tipos).
	 * Usado mais para regras internas (esteira, KPIs, etc).
	 */
	public function status_tipo_atual()
	{
		return $this->belongsTo(StatusTipo::class, 'status_tipo_atual_id', 'id');
	}

	public function statusTipoAtual()
	{
		return $this->status_tipo_atual();
	}

	public function instituicao()
	{
		return $this->belongsTo(Banco::class, 'banco_id');
	}

	public function user()
	{
		return $this->belongsTo(User::class, 'user_id');
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

	/*
	|--------------------------------------------------------------------------
	| MÉTODOS ESTÁTICOS DE KPI (USANDO IDs 4 e 5, COMO JÁ EXISTIA)
	|--------------------------------------------------------------------------
	|
	| Aqui mantenho a lógica original (ID 4 = pago, ID 5 = cancelado),
	| pra não quebrar nada no banco atual.
	|--------------------------------------------------------------------------
	*/

	public static function qtdPagos(): int
	{
		return static::where('status_tipo_atual_id', 4)->count();
	}

	public static function totalLiqPago(): float
	{
		return (float) static::where('status_tipo_atual_id', 4)
			->sum('valor_liquido_liberado');
	}

	public static function qtdDigitados(): int
	{
		return static::count();
	}

	public static function totalEmAndamento(): float
	{
		// Aqui considerei "em andamento" tudo que NÃO é cancelado (5).
		// Se quiser excluir os pagos (4) também, é só usar whereNotIn([4,5]).
		return (float) static::where('status_tipo_atual_id', '!=', 5)
			->sum('valor_liquido_liberado');
	}

	public static function qtdCancelado(): int
	{
		return static::where('status_tipo_atual_id', 5)->count();
	}

	public static function totalLiqCancelado(): float
	{
		return (float) static::where('status_tipo_atual_id', 5)
			->sum('valor_liquido_liberado');
	}

	/*
	|--------------------------------------------------------------------------
	| ACCESSORS PARA STATUS_TIPO (caso queira usar em chips/badges)
	|--------------------------------------------------------------------------
	*/

	public function getStatusTipoDescricaoAttribute(): ?string
	{
		$tipo = $this->status_tipo_atual;

		if (!$tipo) {
			return null;
		}

		return $tipo->descricao
			?? $tipo->nome
			?? null;
	}

	public function getStatusTipoBadgeClassAttribute(): string
	{
		$tipoId = optional($this->status_tipo_atual)->id;

		return match ($tipoId) {
			4 => 'badge-success', // pago
			5 => 'badge-danger',  // cancelado
			default => 'badge-default',
		};
	}
}
