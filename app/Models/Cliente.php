<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Cliente extends Model
{
    use SoftDeletes;
    use HasFactory;

    protected $table = 'clientes';

    public function vendedor(){   
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function propostas(){
        return $this->hasMany(Proposta::class, 'cliente_id', 'id');
    }

}
