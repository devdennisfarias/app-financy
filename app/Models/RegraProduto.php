<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class RegraProduto extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = 'regras_produtos';

    public function regra()
    {
        return $this->belongsTo(Regra::class, 'regra_id', 'id');
    }

    public function produto()
    {
        return $this->belongsTo(Produto::class, 'produto_id', 'id');
    }
    
}
