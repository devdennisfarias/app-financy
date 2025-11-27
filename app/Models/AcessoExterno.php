<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AcessoExterno extends Model
{
    use HasFactory;

    protected $table = 'acessos_externos';

    protected $fillable = [
        'nome',
        'link',
        'usuario',
        'senha',
        'observacao',
        'updated_by',
    ];

    public function usuarioAtualizador()
    {
        return $this->belongsTo(User::class, 'updated_by');
    }
}
