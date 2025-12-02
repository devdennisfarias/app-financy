<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Model;

class Promotora extends Model
{
    protected $fillable = [
        'nome',
        'cnpj',
        'contato',
        'ativo',
    ];

    public function bancos()
    {
        return $this->belongsToMany(Banco::class, 'banco_promotora');
    }

    public function comissoes()
    {
        return $this->hasMany(Comissao::class);
    }
}
