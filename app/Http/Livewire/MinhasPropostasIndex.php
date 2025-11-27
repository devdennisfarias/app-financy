<?php

namespace App\Http\Livewire;

use App\Models\Proposta;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\WithPagination;

class MinhasPropostasIndex extends Component
{
    use WithPagination;

    public $search;

    public function updatingSearch(){
        $this->resetPage();
    }

    public function render()
    {         
        $loggedId = Auth::id();
        $propostas = Proposta::where('user_id', $loggedId)
                            ->where('id', 'LIKE', '%'.$this->search.'%')->paginate();

        return view('livewire.minhas-propostas-index', compact('propostas'));
    }
}
