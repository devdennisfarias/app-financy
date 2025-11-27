<?php

namespace App\Http\Controllers;

use App\Models\AcessoExterno;
use App\Models\Banco;
use Illuminate\Http\Request;

class AcessoExternoController extends Controller
{
	public function __construct()
	{
		$this->middleware('can:acessos-externos.index')->only(['index']);
		$this->middleware('can:acessos-externos.create')->only(['create', 'store']);
		$this->middleware('can:acessos-externos.edit')->only(['edit', 'update']);
		$this->middleware('can:acessos-externos.destroy')->only(['destroy']);
	}

	/**
	 * Lista todos os acessos externos.
	 */
	public function index(Request $request)
	{
		$query = AcessoExterno::query();

		// Filtro por banco/sistema (usando o nome do banco)
		if ($request->filled('banco')) {
			$query->where('nome', $request->banco);
		}

		// Filtro por texto (nome, link ou usuário)
		if ($request->filled('q')) {
			$busca = $request->q;
			$query->where(function ($q) use ($busca) {
				$q->where('nome', 'like', "%{$busca}%")
					->orWhere('link', 'like', "%{$busca}%")
					->orWhere('usuario', 'like', "%{$busca}%");
			});
		}

		$acessos = $query
			->orderBy('nome')
			->paginate(20);

		// Lista de bancos/sistemas direto do cadastro de bancos
		// (vou usar nome como chave e valor, já que salvamos texto no campo nome)
		$bancos = Banco::orderBy('nome')->pluck('nome', 'nome');

		$filtros = $request->only(['banco', 'q']);

		return view('acessos-externos.index', compact('acessos', 'bancos', 'filtros'));
	}


	/**
	 * Formulário de criação.
	 */
	public function create()
	{
		// lista de bancos/sistemas direto do cadastro de bancos
		$bancos = Banco::orderBy('nome')->pluck('nome', 'nome');

		// objeto vazio só pra reaproveitar o form
		$acesso = new AcessoExterno();

		return view('acessos-externos.create', compact('acesso', 'bancos'));
	}

	public function edit($id)
	{
		$acesso = AcessoExterno::findOrFail($id);

		// mesma lista de bancos pra manter padrão
		$bancos = Banco::orderBy('nome')->pluck('nome', 'nome');

		return view('acessos-externos.edit', compact('acesso', 'bancos'));
	}

	public function store(Request $request)
	{
		$dados = $request->validate([
			'nome' => 'required|string|max:255',   // vem do select de bancos
			'link' => 'nullable|string|max:255',
			'usuario' => 'nullable|string|max:255',
			'senha' => 'nullable|string|max:255',   // texto normal
			'observacao' => 'nullable|string|max:1000',
		]);

		// se tiver a coluna updated_by, mantém, senão pode remover essa linha
		if (\Schema::hasColumn('acessos_externos', 'updated_by')) {
			$dados['updated_by'] = auth()->id();
		}

		AcessoExterno::create($dados);

		return redirect()
			->route('acessos-externos.index')
			->withSuccess('Acesso externo criado com sucesso.');
	}

	public function update(Request $request, $id)
	{
		$acesso = AcessoExterno::findOrFail($id);

		$dados = $request->validate([
			'nome' => 'required|string|max:255',
			'link' => 'nullable|string|max:255',
			'usuario' => 'nullable|string|max:255',
			'senha' => 'nullable|string|max:255',
			'observacao' => 'nullable|string|max:1000',
		]);

		if (\Schema::hasColumn('acessos_externos', 'updated_by')) {
			$dados['updated_by'] = auth()->id();
		}

		$acesso->update($dados);

		return redirect()
			->route('acessos-externos.index')
			->withSuccess('Acesso externo atualizado com sucesso.');
	}
	/**
	 * Remove acesso.
	 */
	public function destroy($id)
	{
		$acesso = AcessoExterno::findOrFail($id);
		$acesso->delete();

		return redirect()
			->route('acessos-externos.index')
			->withSuccess('Acesso externo excluído com sucesso.');
	}
}
