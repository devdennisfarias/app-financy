<?php

namespace App\Http\Controllers;

use App\Http\Requests\PerfilRequest;
use App\Http\Requests\PasswordRequest;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Hash;

class PerfilController extends Controller
{

    public function index()
    {
        //
    }

    public function create()
    {
        //
    }

    public function store()
    {
        //
    }


    public function edit($id)
    {
        return view('perfil.edit');
    }

    public function update(PerfilRequest $request, $id)
    {
        auth()->user()->update($request->all());

        return back()->withStatus(__('Perfil Atualizado com Sucesso.'));
    }

    public function password(PasswordRequest $request)
    {
        auth()->user()->update(['password' => Hash::make($request->get('password'))]);

        return back()->withStatusPassword(__('Password successfully updated.'));
    }


    public function destroy($id)
    {
        //
    }
}
