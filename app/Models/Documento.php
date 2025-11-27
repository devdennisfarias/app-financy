<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Documento extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = 'documentos';

    public function proposta(){
            // BELONGSTO
        //@ 1 Modelo com qual me relaciono
        //@ 2 FK nesta tabela
        //@ 3 Referencia que a FK faz
        return $this->belongsTo(Proposta::class, 'proposta_id', 'id');
    }
}
