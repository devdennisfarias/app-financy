<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Atendimento extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = 'atendimentos';

        
    public function status(){
        //@ 1 Modelo com qual me relaciono
        //@ 2 FK nesta tabela
        //@ 3 Referencia que a FK faz
        return $this->belongsTo(Status::class, 'status_id', 'id');
    }

    public function proposta(){
        //@ 1 Modelo com qual me relaciono
        //@ 2 FK nesta tabela
        //@ 3 Referencia que a FK faz
        return $this->belongsTo(Proposta::class, 'proposta_id', 'id');
    }
}
