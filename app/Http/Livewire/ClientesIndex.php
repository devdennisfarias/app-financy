<?php

namespace App\Http\Livewire;

use App\Models\Cliente;
use Livewire\Component;
use Livewire\WithPagination;

class ClientesIndex extends Component
{    
    use WithPagination;

    public $search;

    public function updatingSearch(){
        $this->resetPage();
    }

    public function render()
    {          
        $clientes = Cliente::where('nome', 'LIKE', '%'.$this->search.'%')
                        ->paginate();

        return view('livewire.clientes-index', compact('clientes'));
    }
}
