<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Meta extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = 'metas';


    public function produto(){
        //@ 1 Modelo com qual me relaciono
        //@ 2 FK nesta tabela
        //@ 3 Referencia que a FK faz
        return $this->belongsTo(Produto::class, 'produto_id', 'id');
    }
}
