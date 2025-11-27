<?php

namespace App\Http\Livewire;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

use Livewire\WithPagination;

class UsersIndex extends Component
{
    use WithPagination;

    public $search;

    public function updatingSearch(){
        $this->resetPage();
    }

    public function render()
    {  
        $loggedId = Auth::id();
        $users = User::where('name', 'LIKE', '%'.$this->search.'%')
                        ->orWhere('email', 'LIKE', '%'.$this->search.'%')
                        ->paginate();
        /*$users = User::where('id', '<>', 2)
                        ->paginate();*/

        return view('livewire.users-index', compact('users', 'loggedId'));
    }
}
