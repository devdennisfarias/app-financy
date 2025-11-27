<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Regra extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = 'regras';

    public function produtos()
    {        
        return $this->belongsToMany(Produto::class, 'regras_produtos', 'regra_id', 'produto_id');
    }

    public function regra_produto(){
        //HASMANY
    //@ 1 Modelo com qual me relaciono
    //@ 2 FK na tabela com que me relaciono
    //@ 3 FK que esta tabela envia
    return $this->hasMany(RegraProduto::class, 'regra_id', 'id');
    }

    public function vendedores()
    {
        //HASMANY
        //@ 1 Modelo com qual me relaciono
        //@ 2 FK na tabela com que me relaciono
        //@ 3 FK que esta tabela envia
        return $this->hasMany(User::class, 'regra_id', 'id');
    }
}
