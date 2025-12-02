<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Produto extends Model
{
	use HasFactory;
	use SoftDeletes;

	protected $fillable = [
		'produto',
		'descricao',
		'banco_id',
	];

	public function instituicao()
	{
		return $this->belongsTo(Banco::class, 'banco_id');
	}
	protected $table = 'produtos';


	public function tabelas()
	{
		return $this->belongsToMany(Tabela::class, 'produtos_tabelas', 'produto_id', 'tabela_id');
	}

	public function regras()
	{
		return $this->belongsToMany(Regra::class, 'regras_produtos', 'produto_id', 'regra_id');
	}

	public function regra_produto()
	{
		//HASMANY
		//@ 1 Modelo com qual me relaciono
		//@ 2 FK na tabela com que me relaciono
		//@ 3 FK que esta tabela envia
		return $this->hasMany(RegraProduto::class, 'produto_id', 'id');
	}

	public function metas()
	{
		//HASMANY
		//@ 1 Modelo com qual me relaciono
		//@ 2 FK na tabela com que me relaciono
		//@ 3 FK que esta tabela envia
		return $this->hasMany(Metas::class, 'produto_id', 'id');
	}

	public function propostas()
	{
		//HASMANY
		//@ 1 Modelo com qual me relaciono
		//@ 2 FK na tabela com que me relaciono
		//@ 3 FK que esta tabela envia
		return $this->hasMany(Proposta::class, 'produto_id', 'id');
	}

	public function banco()
	{
		return $this->belongsTo(Banco::class);
	}

	public function comissoes()
	{
		return $this->hasMany(Comissao::class);
	}

}
