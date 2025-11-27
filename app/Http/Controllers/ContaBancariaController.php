<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Banco;
use App\Models\ContaBancaria;
use Illuminate\Http\Request;

class ContaBancariaController extends Controller
{
    public function __construct()
    {
        $this->middleware('can:contas-bancarias.index')->only(['index', 'show']);
        $this->middleware('can:contas-bancarias.create')->only(['create', 'store']);
        $this->middleware('can:contas-bancarias.edit')->only(['edit', 'update']);
        $this->middleware('can:contas-bancarias.destroy')->only(['destroy']);
    }

    /**
     * Listagem de contas bancárias.
     */
    public function index()
    {
        $contas = ContaBancaria::with('banco')
            ->orderBy('nome')
            ->paginate(20);

        return view('financeiro.contas-bancarias.index', compact('contas'));
    }

    /**
     * Formulário de criação.
     */
    public function create()
    {
        $bancos = Banco::orderBy('nome')->get();

        return view('financeiro.contas-bancarias.create', compact('bancos'));
    }

    /**
     * Salva nova conta bancária.
     */
    public function store(Request $request)
    {
        $dados = $request->validate([
            'banco_id'      => 'required|exists:bancos,id',
            'nome'          => 'required|string|max:255',
            'agencia'       => 'nullable|string|max:50',
            'conta'         => 'nullable|string|max:50',
            'tipo_conta'    => 'nullable|string|max:50',
            'saldo_inicial' => 'nullable|numeric',
        ]);

        ContaBancaria::create($dados);

        return redirect()
            ->route('contas-bancarias.index')
            ->withSuccess('Conta bancária cadastrada com sucesso.');
    }

    /**
     * Detalhes (se precisar).
     */
    public function show($id)
    {
        $conta = ContaBancaria::with('banco')->findOrFail($id);

        return view('financeiro.contas-bancarias.show', compact('conta'));
    }

    /**
     * Formulário de edição.
     */
    public function edit($id)
    {
        $conta  = ContaBancaria::findOrFail($id);
        $bancos = Banco::orderBy('nome')->get();

        return view('financeiro.contas-bancarias.edit', compact('conta', 'bancos'));
    }

    /**
     * Atualiza conta bancária.
     */
    public function update(Request $request, $id)
    {
        $conta = ContaBancaria::findOrFail($id);

        $dados = $request->validate([
            'banco_id'      => 'required|exists:bancos,id',
            'nome'          => 'required|string|max:255',
            'agencia'       => 'nullable|string|max:50',
            'conta'         => 'nullable|string|max:50',
            'tipo_conta'    => 'nullable|string|max:50',
            'saldo_inicial' => 'nullable|numeric',
        ]);

        $conta->update($dados);

        return redirect()
            ->route('contas-bancarias.index')
            ->withSuccess('Conta bancária atualizada com sucesso.');
    }

    /**
     * Remove conta bancária.
     */
    public function destroy($id)
    {
        $conta = ContaBancaria::findOrFail($id);

        // Se quiser, pode testar se há lançamentos vinculados antes de excluir
        if ($conta->lancamentos()->exists()) {
            return redirect()
                ->route('contas-bancarias.index')
                ->withDanger('Não é possível excluir uma conta com lançamentos financeiros vinculados.');
        }

        $conta->delete();

        return redirect()
            ->route('contas-bancarias.index')
            ->withSuccess('Conta bancária excluída com sucesso.');
    }
}
