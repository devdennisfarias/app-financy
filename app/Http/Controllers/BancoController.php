<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Banco;
use Illuminate\Http\Request;

class BancoController extends Controller
{
	public function __construct()
	{
		$this->middleware('can:bancos.index')->only(['index', 'show']);
		$this->middleware('can:bancos.create')->only(['create', 'store']);
		$this->middleware('can:bancos.edit')->only(['edit', 'update']);
		$this->middleware('can:bancos.destroy')->only(['destroy']);
	}

	/**
	 * Listagem de bancos.
	 */
	public function index()
	{
		$bancos = Banco::orderBy('nome')->paginate(20);

    return view('financeiro.bancos.index', [
        'bancos'     => $bancos,
        'activePage' => 'bancos',
    ]);
	}

	/**
	 * Formulário de criação.
	 */
	public function create()
	{
		return view('financeiro.bancos.create');
	}

	/**
	 * Salva um novo banco.
	 */
	public function store(Request $request)
	{
		$dados = $request->validate([
			'nome' => 'required|string|max:255',
			'codigo' => 'nullable|string|max:10',
		]);

		Banco::create($dados);

		return redirect()
			->route('bancos.index')
			->withSuccess('Banco cadastrado com sucesso.');
	}

	/**
	 * Exibe detalhes de um banco (se precisar).
	 */
	public function show($id)
	{
		$banco = Banco::findOrFail($id);

		return view('financeiro.bancos.show', compact('banco'));
	}

	/**
	 * Formulário de edição.
	 */
	public function edit($id)
	{
		$banco = Banco::findOrFail($id);

		return view('financeiro.bancos.edit', compact('banco'));
	}

	/**
	 * Atualiza um banco.
	 */
	public function update(Request $request, $id)
	{
		$banco = Banco::findOrFail($id);

		$dados = $request->validate([
			'nome' => 'required|string|max:255',
			'codigo' => 'nullable|string|max:10',
		]);

		$banco->update($dados);

		return redirect()
			->route('bancos.index')
			->withSuccess('Banco atualizado com sucesso.');
	}

	/**
	 * Remove um banco.
	 */
	public function destroy($id)
	{
		$banco = Banco::findOrFail($id);

		// Se quiser, pode testar se há contas vinculadas antes de excluir
		if ($banco->contas()->exists()) {
			return redirect()
				->route('bancos.index')
				->withDanger('Não é possível excluir um banco que possui contas bancárias vinculadas.');
		}

		$banco->delete();

		return redirect()
			->route('bancos.index')
			->withSuccess('Banco excluído com sucesso.');
	}
}
