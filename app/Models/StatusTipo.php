<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class StatusTipo extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = 'status_tipos';

    public function status(){
        //HASMANY
    //@ 1 Modelo com qual me relaciono
    //@ 2 FK na tabela com que me relaciono
    //@ 3 FK que esta tabela envia
    return $this->hasMany(Status::class, 'status_tipo_id', 'id');
    }

    public function propostas(){
        //HASMANY
    //@ 1 Modelo com qual me relaciono
    //@ 2 FK na tabela com que me relaciono
    //@ 3 FK que esta tabela envia
    return $this->hasMany(Proposta::class, 'status_tipo_atual_id', 'id');
    }

}
