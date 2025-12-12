<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class WhatsappTemplate extends Model
{
	protected $fillable = [
		'name',
		'meta_template_id',
		'category',
		'language',
		'body',
	];
}
