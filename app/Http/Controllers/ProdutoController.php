<?php

namespace App\Http\Controllers;

use App\Models\Produto;
use App\Models\Tabela;
use Illuminate\Http\Request;

class ProdutoController extends Controller
{
    public function __construct()
    {
        $this->middleware('can:produtos.index')->only('index');
        $this->middleware('can:produtos.create')->only('create', 'store');
        $this->middleware('can:produtos.edit')->only('edit', 'update');
        $this->middleware('can:produtos.destroy')->only('destroy');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $produtos = Produto::all();
        return view('produtos.index', compact('produtos'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $tabelas = Tabela::all();

        return view('produtos.create', compact('tabelas'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'produto' => 'required'
        ]);

        $produto = new Produto;
        $produto->produto = $request->produto;
        $produto->descricao = $request->descricao;
        $produto->save();

        $produto->tabelas()->sync($request->tabelas);
        return redirect()->route('produtos.edit', $produto)->with('info', 'Produto atualizada com sucesso!');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Produto  $produto
     * @return \Illuminate\Http\Response
     */
    public function show(Produto $produto)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Produto  $produto
     * @return \Illuminate\Http\Response
     */
    public function edit(Produto $produto)
    {
        $tabelas = Tabela::all();
        return view('produtos.edit', compact('produto', 'tabelas'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Produto  $produto
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Produto $produto)
    {        
        $request->validate([
            'produto' => 'required'
        ]);

        $produto->produto = $request->produto;
        $produto->descricao = $request->descricao;
        $produto->save();
        $produto->tabelas()->sync($request->tabelas);
        return redirect()->route('produtos.edit', $produto)->with('info', 'Produto atualizada com sucesso!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Produto  $produto
     * @return \Illuminate\Http\Response
     */
    public function destroy(Produto $produto)
    {
        $produto->delete();

        return redirect()->route('produtos.index')->with('info', 'Produto excluída com sucesso!');
    }
}
