<?php

namespace App\Http\Livewire;

use App\Models\Cliente;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\WithPagination;

class CarteirasIndex extends Component
{
    use WithPagination;

    public $search;

    public function updatingSearch(){
        $this->resetPage();
    }

    public function render()
    {          
        $loggedId = Auth::id();
        $clientes = Cliente::where('user_id', '=', $loggedId)
                            ->where('nome', 'LIKE', '%'.$this->search.'%')
                            ->paginate();

        return view('livewire.carteiras-index', compact('clientes'));
    }
}
