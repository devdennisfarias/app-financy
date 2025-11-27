<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Status extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = 'status';


    public function status_tipo()
    {
        return $this->belongsTo(StatusTipo::class, 'status_tipo_id', 'id');
    }

    public function atendimentos()
    {
        //HASMANY
        //@ 1 Modelo com qual me relaciono
        //@ 2 FK na tabela com que me relaciono
        //@ 3 FK que esta tabela envia
        return $this->hasMany(Atendimento::class, 'status_id', 'id');
    }

    public function propostas()
    {
        //HASMANY
        //@ 1 Modelo com qual me relaciono
        //@ 2 FK na tabela com que me relaciono
        //@ 3 FK que esta tabela envia
        return $this->hasMany(Proposta::class, 'status_atual_id', 'id');
    }

}
