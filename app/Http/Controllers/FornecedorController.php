<?php

namespace App\Http\Controllers;

use App\Models\Fornecedor;
use Illuminate\Http\Request;

class FornecedorController extends Controller
{
    public function __construct()
    {
        $this->middleware('can:fornecedores.index')->only(['index', 'show']);
        $this->middleware('can:fornecedores.create')->only(['create', 'store']);
        $this->middleware('can:fornecedores.edit')->only(['edit', 'update']);
        $this->middleware('can:fornecedores.destroy')->only(['destroy']);
    }

    public function index()
    {
        $fornecedores = Fornecedor::orderBy('nome')->paginate(20);
        return view('financeiro.fornecedores.index', compact('fornecedores'));
    }

    public function create()
    {
        return view('financeiro.fornecedores.create');
    }

    public function store(Request $request)
    {
        $dados = $request->validate([
            'nome'      => 'required|string|max:255',
            'documento' => 'nullable|string|max:50',
            'telefone'  => 'nullable|string|max:50',
            'email'     => 'nullable|email|max:255',
            'contato'   => 'nullable|string|max:255',
            'endereco'  => 'nullable|string|max:255',
        ]);

        Fornecedor::create($dados);

        return redirect()
            ->route('fornecedores.index')
            ->withSuccess('Fornecedor cadastrado com sucesso.');
    }

    public function edit(Fornecedor $fornecedor)
    {
        return view('financeiro.fornecedores.edit', compact('fornecedor'));
    }

    public function update(Request $request, Fornecedor $fornecedor)
    {
        $dados = $request->validate([
            'nome'      => 'required|string|max:255',
            'documento' => 'nullable|string|max:50',
            'telefone'  => 'nullable|string|max:50',
            'email'     => 'nullable|email|max:255',
            'contato'   => 'nullable|string|max:255',
            'endereco'  => 'nullable|string|max:255',
        ]);

        $fornecedor->update($dados);

        return redirect()
            ->route('fornecedores.index')
            ->withSuccess('Fornecedor atualizado com sucesso.');
    }

    public function destroy(Fornecedor $fornecedor)
    {
        $fornecedor->delete();

        return redirect()
            ->route('fornecedores.index')
            ->withSuccess('Fornecedor excluído com sucesso.');
    }
}
