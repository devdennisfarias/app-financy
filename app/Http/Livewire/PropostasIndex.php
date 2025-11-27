<?php

namespace App\Http\Livewire;

use App\Models\Proposta;
use Livewire\Component;
use Livewire\WithPagination;

class PropostasIndex extends Component
{
    use WithPagination;

    public $search;

    public function updatingSearch(){
        $this->resetPage();
    }

    public function render()
    {          
        $propostas = Proposta::where('id', 'LIKE', '%'.$this->search.'%')->paginate();

        return view('livewire.propostas-index', compact('propostas'));
    }
}
