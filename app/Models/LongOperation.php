<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LongOperation extends Model
{
	protected $fillable = [
		'user_id',
		'type',
		'description',
		'status',
		'total_items',
		'processed_items',
		'extra',
		'started_at',
		'finished_at',
	];

	protected $casts = [
		'extra' => 'array',
		'started_at' => 'datetime',
		'finished_at' => 'datetime',
	];

	public function user()
	{
		return $this->belongsTo(User::class);
	}

	// Percentual de progresso (0–100)
	public function getProgressAttribute(): int
	{
		if ($this->total_items <= 0) {
			return 0;
		}

		return (int) round(($this->processed_items / $this->total_items) * 100);
	}
}
