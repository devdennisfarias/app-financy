<?php

namespace App\Http\Livewire;

use App\Models\LongOperation;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class LongOperationStatus extends Component
{
	public string $type;
	public ?LongOperation $operation = null;

	public function mount(string $type)
	{
		$this->type = $type;
		$this->loadOperation();
	}

	public function loadOperation()
	{
		$this->operation = LongOperation::where('user_id', Auth::id())
			->where('type', $this->type)
			->orderByDesc('created_at')
			->first();
	}

	public function refreshStatus()
	{
		$this->loadOperation();
	}

	public function render()
	{
		return view('livewire.long-operation-status');
	}
}
