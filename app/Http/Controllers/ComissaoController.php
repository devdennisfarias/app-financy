<?php

namespace App\Http\Controllers;

use App\Models\Comissao;
use Illuminate\Http\Request;

class ComissaoController extends Controller
{

    public function index()
    {
        //
    }

    public function metas(){
        return view('comissoes.metas');
    }

    public function regras(){
        return view('comissoes.regras');
    }

    public function tabelas(){
        return view('comissoes.tabelas');
    }


    public function create()
    {
        //
    }

 
    public function store(Request $request)
    {
        //
    }


    public function show(Comissao $comissao)
    {
        //
    }

    public function edit(Comissao $comissao)
    {
        //
    }

    public function update(Request $request, Comissao $comissao)
    {
        //
    }

 
    public function destroy(Comissao $comissao)
    {
        //
    }
}
