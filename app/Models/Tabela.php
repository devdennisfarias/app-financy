<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Tabela extends Model
{
    use HasFactory;    
    use SoftDeletes;

    protected $table = 'tabelas';


    public function produtos()
    {        
        return $this->belongsToMany(Produto::class, 'produtos_tabelas', 'tabela_id', 'produto_id');
    }
}
