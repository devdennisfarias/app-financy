<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Campaign extends Model
{
	protected $fillable = [
		'user_id',
		'name',
		'segment_filters',
		'message_template_id',
		'custom_message',
		'scheduled_at',
		'status',
		'config',
		'long_operation_id',
	];

	protected $casts = [
		'segment_filters' => 'array',
		'config' => 'array',
		'scheduled_at' => 'datetime',
	];

	public function user()
	{
		return $this->belongsTo(User::class);
	}

	public function messages()
	{
		return $this->hasMany(CampaignMessage::class);
	}

	public function longOperation()
	{
		return $this->belongsTo(LongOperation::class);
	}

	public function template()
	{
		return $this->belongsTo(WhatsappTemplate::class, 'message_template_id');
	}
}
