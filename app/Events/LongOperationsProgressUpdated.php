<?php

namespace App\Events;

use App\Models\LongOperation;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcastNow;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class LongOperationProgressUpdated implements ShouldBroadcastNow
{
	use Dispatchable, InteractsWithSockets, SerializesModels;

	public LongOperation $operation;

	public function __construct(LongOperation $operation)
	{
		$this->operation = $operation;
	}

	public function broadcastOn()
	{
		// Canal privado por usuário
		return new PrivateChannel('operations.' . $this->operation->user_id);
	}

	public function broadcastWith()
	{
		return [
			'id' => $this->operation->id,
			'type' => $this->operation->type,
			'status' => $this->operation->status,
			'total_items' => $this->operation->total_items,
			'processed_items' => $this->operation->processed_items,
			'progress' => $this->operation->progress,
			'description' => $this->operation->description,
		];
	}
}
