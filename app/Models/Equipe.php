<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Equipe extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = 'equipes';

    public function loja()
    {
        //@ 1 Modelo com qual me relaciono
        //@ 2 FK nesta tabela
        //@ 3 Referencia que a FK faz
        return $this->belongsTo(Loja::class, 'loja_id', 'id');
    }

    public function vendedores()
    {
        //HASMANY
        //@ 1 Modelo com qual me relaciono
        //@ 2 FK na tabela com que me relaciono
        //@ 3 FK que esta tabela envia
        return $this->hasMany(User::class, 'equipe_id', 'id');
    }

    public static function equipes($id)
    {
        return Equipe::where('loja_id', '=', $id)->get();
    }

    public static function qtdPagos($id)
    {
        return Proposta::join('users', 'users.id', '=', 'propostas.user_id')
            ->join('equipes', 'equipes.id', '=', 'users.equipe_id')
            ->select('propostas.*')
            ->where('equipes.id', '=', $id)
            ->where('status_tipo_atual_id', '=', 4)
            ->count();
    }

    public static function totalLiqPago($id)
    {
        return Proposta::join('users', 'users.id', '=', 'propostas.user_id')
            ->join('equipes', 'equipes.id', '=', 'users.equipe_id')
            ->select('propostas.*')
            ->where('equipes.id', '=', $id)
            ->where('status_tipo_atual_id', '=', 4)
            ->sum('valor_liquido_liberado');
    }

    public static function qtdDigitados($id)
    {
        return Proposta::join('users', 'users.id', '=', 'propostas.user_id')
            ->join('equipes', 'equipes.id', '=', 'users.equipe_id')
            ->select('propostas.*')
            ->where('equipes.id', '=', $id)
            ->count();
    }

    public static function totalEmAndamento($id)
    {
        return Proposta::join('users', 'users.id', '=', 'propostas.user_id')
            ->join('equipes', 'equipes.id', '=', 'users.equipe_id')
            ->select('propostas.*')
            ->where('equipes.id', '=', $id)
            ->where('status_tipo_atual_id', '!=', 5) //TODOS MENOS OS CANCELADOS
            ->sum('valor_liquido_liberado');
    }

    public static function qtdCancelado($id)
    {
        return Proposta::join('users', 'users.id', '=', 'propostas.user_id')
            ->join('equipes', 'equipes.id', '=', 'users.equipe_id')
            ->select('propostas.*')
            ->where('equipes.id', '=', $id)
            ->where('status_tipo_atual_id', '=', 5)
            ->count();
    }

    public static function totalLiqCancelado($id)
    {
        return Proposta::join('users', 'users.id', '=', 'propostas.user_id')
            ->join('equipes', 'equipes.id', '=', 'users.equipe_id')
            ->select('propostas.*')
            ->where('equipes.id', '=', $id)
            ->where('status_tipo_atual_id', '=', 5)
            ->sum('valor_liquido_liberado');
    }
}
