<?php

namespace App\Http\Controllers;

use App\Models\Orgao;
use App\Models\Convenio;
use Illuminate\Http\Request;

class OrgaoController extends Controller
{
	public function __construct()
	{
		$this->middleware('can:orgaos.index')->only('index');
		$this->middleware('can:orgaos.create')->only(['create', 'store']);
		$this->middleware('can:orgaos.edit')->only(['edit', 'update']);
		$this->middleware('can:orgaos.destroy')->only('destroy');
	}

	public function index(Request $request)
	{
		// Garante que todas as chaves existam, mesmo sem filtro
		$filtros = $request->only(['q', 'convenio_id', 'ativo']);
		$filtros['q'] = $filtros['q'] ?? null;
		$filtros['convenio_id'] = $filtros['convenio_id'] ?? null;
		$filtros['ativo'] = $filtros['ativo'] ?? null;

		$query = Orgao::with('convenio');

		// Filtro texto (nome)
		if (!empty($filtros['q'])) {
			$q = $filtros['q'];
			$query->where('nome', 'like', "%{$q}%");
		}

		// Filtro por convênio
		if (!empty($filtros['convenio_id'])) {
			$query->where('convenio_id', $filtros['convenio_id']);
		}

		// Filtro ativo/inativo – aqui usamos a chave com ?? null
		$ativoFiltro = $filtros['ativo'];

		if ($ativoFiltro !== null && $ativoFiltro !== '') {
			// converte '0'/'1' para boolean
			$query->where('ativo', (bool) $ativoFiltro);
		}

		$orgaos = $query
			->orderBy('nome')
			->paginate(20);

		$convenios = Convenio::orderBy('nome')->get();

		return view('orgaos.index', compact('orgaos', 'convenios', 'filtros'));
	}

	public function create()
	{
		$convenios = Convenio::where('ativo', true)
			->orderBy('nome')
			->get();

		return view('orgaos.create', compact('convenios'));
	}

	public function store(Request $request)
	{
		$dados = $request->validate([
			'nome' => ['required', 'string', 'max:191'],
			'convenio_id' => ['required', 'exists:convenios,id'],
			'ativo' => ['nullable', 'boolean'],
		]);

		$dados['ativo'] = !empty($dados['ativo']);

		Orgao::create($dados);

		return redirect()
			->route('orgaos.index')
			->withSuccess('Órgão pagador cadastrado com sucesso.');
	}

	public function edit($id)
	{
		$orgao = Orgao::with('convenio')->findOrFail($id);

		$convenios = Convenio::where('ativo', true)
			->orderBy('nome')
			->get();

		return view('orgaos.edit', compact('orgao', 'convenios'));
	}

	public function update(Request $request, $id)
	{
		$orgao = Orgao::findOrFail($id);

		$dados = $request->validate([
			'nome' => ['required', 'string', 'max:191'],
			'convenio_id' => ['required', 'exists:convenios,id'],
			'ativo' => ['nullable', 'boolean'],
		]);

		$dados['ativo'] = !empty($dados['ativo']);

		$orgao->update($dados);

		return redirect()
			->route('orgaos.edit', $orgao->id)
			->withSuccess('Órgão pagador atualizado com sucesso.');
	}

	public function destroy($id)
	{
		$orgao = Orgao::findOrFail($id);

		// Aqui você pode colocar regra para impedir excluir se tiver clientes/propostas vinculados

		$orgao->delete();

		return redirect()
			->route('orgaos.index')
			->withSuccess('Órgão pagador excluído com sucesso.');
	}
}
