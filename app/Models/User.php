<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use HasFactory, Notifiable;
    use HasRoles;

    protected $table = 'users';

    protected $fillable = [
        'name',
        'email',
        'password',
    ];


    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function clientes()
    {
        //HASMANY
        //@ 1 Modelo com qual me relaciono
        //@ 2 FK na tabela com que me relaciono
        //@ 3 FK que esta tabela envia
        return $this->hasMany(Cliente::class, 'user_id', 'id');
    }

    public function propostas()
    {
        //HASMANY
        //@ 1 Modelo com qual me relaciono
        //@ 2 FK na tabela com que me relaciono
        //@ 3 FK que esta tabela envia
        return $this->hasMany(Proposta::class, 'user_id', 'id');
    }

    public function roles()
    {
        return $this->belongsToMany(Role::class, 'model_has_roles', 'model_id', 'role_id');
    }

    public function equipe()
    {
        //@ 1 Modelo com qual me relaciono
        //@ 2 FK nesta tabela
        //@ 3 Referencia que a FK faz
        return $this->belongsTo(Equipe::class, 'equipe_id', 'id');
    }

    public function regra()
    {
        //@ 1 Modelo com qual me relaciono
        //@ 2 FK nesta tabela
        //@ 3 Referencia que a FK faz
        return $this->belongsTo(Regra::class, 'regra_id', 'id');
    }

    public static function vendedores($id)
    {
        return User::where('equipe_id', '=', $id)->get();
    }

    public static function qtdPagos($id)
    {
        return Proposta::where('user_id', '=', $id)
            ->where('status_tipo_atual_id', '=', 4)
            ->count();
    }

    public static function totalLiqPago($id)
    {
        return Proposta::where('user_id', '=', $id)
            ->where('status_tipo_atual_id', '=', 4)
            ->sum('valor_liquido_liberado');
    }

    public static function qtdDigitados($id)
    {
        return Proposta::where('user_id', '=', $id)
            ->count();
    }

    public static function totalEmAndamento($id)
    {
        return Proposta::where('user_id', '=', $id)
            ->where('status_tipo_atual_id', '!=', 5) //TODOS MENOS OS CANCELADOS
            ->sum('valor_liquido_liberado');
    }

    public static function qtdCancelado($id)
    {
        return Proposta::where('user_id', '=', $id)
            ->where('status_tipo_atual_id', '=', 5)
            ->count();
    }

    public static function totalLiqCancelado($id)
    {
        return Proposta::where('user_id', '=', $id)
            ->where('status_tipo_atual_id', '=', 5)
            ->sum('valor_liquido_liberado');
    }


}
