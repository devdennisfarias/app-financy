<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CampaignMessage extends Model
{
	protected $fillable = [
		'campaign_id',
		'cliente_id',
		'phone',
		'status',
		'provider_message_id',
		'error_code',
		'error_message',
		'sent_at',
		'delivered_at',
		'read_at',
	];

	protected $casts = [
		'sent_at' => 'datetime',
		'delivered_at' => 'datetime',
		'read_at' => 'datetime',
	];

	public function campaign()
	{
		return $this->belongsTo(Campaign::class);
	}

	public function cliente()
	{
		return $this->belongsTo(Cliente::class);
	}
}
