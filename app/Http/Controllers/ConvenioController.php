<?php

namespace App\Http\Controllers;

use App\Models\Convenio;
use Illuminate\Http\Request;

class ConvenioController extends Controller
{
	public function __construct()
	{
		$this->middleware('can:convenios.index')->only('index');
		$this->middleware('can:convenios.create')->only(['create', 'store']);
		$this->middleware('can:convenios.edit')->only(['edit', 'update']);
		$this->middleware('can:convenios.destroy')->only('destroy');
	}

	public function index(Request $request)
	{
		// Garante que as chaves existam mesmo quando nenhum filtro é enviado
		$filtros = $request->only(['q', 'ativo']);
		$filtros['q'] = $filtros['q'] ?? null;
		$filtros['ativo'] = $filtros['ativo'] ?? null;

		$query = Convenio::query();

		// Filtro texto (nome ou slug)
		if (!empty($filtros['q'])) {
			$q = $filtros['q'];
			$query->where(function ($sub) use ($q) {
				$sub->where('nome', 'like', "%{$q}%")
					->orWhere('slug', 'like', "%{$q}%");
			});
		}

		// Filtro ativo/inativo
		$ativoFiltro = $filtros['ativo'];

		if ($ativoFiltro !== null && $ativoFiltro !== '') {
			$query->where('ativo', (bool) $ativoFiltro);
		}

		$convenios = $query
			->orderBy('nome')
			->paginate(20);

		return view('convenios.index', compact('convenios', 'filtros'));
	}

	public function create()
	{
		return view('convenios.create');
	}

	public function store(Request $request)
	{
		$dados = $request->validate([
			'nome' => ['required', 'string', 'max:150'],
			'slug' => ['nullable', 'string', 'max:150', 'unique:convenios,slug'],
			'ativo' => ['nullable', 'boolean'],
		]);

		if (empty($dados['slug'])) {
			$dados['slug'] = \Str::slug($dados['nome'], '-');
		}

		$dados['ativo'] = !empty($dados['ativo']);

		Convenio::create($dados);

		return redirect()
			->route('convenios.index')
			->withSuccess('Convênio cadastrado com sucesso.');
	}

	public function edit($id)
	{
		$convenio = Convenio::findOrFail($id);

		return view('convenios.edit', compact('convenio'));
	}

	public function update(Request $request, $id)
	{
		$convenio = Convenio::findOrFail($id);

		$dados = $request->validate([
			'nome' => ['required', 'string', 'max:150'],
			'slug' => ['nullable', 'string', 'max:150', 'unique:convenios,slug,' . $convenio->id],
			'ativo' => ['nullable', 'boolean'],
		]);

		if (empty($dados['slug'])) {
			$dados['slug'] = \Str::slug($dados['nome'], '-');
		}

		$dados['ativo'] = !empty($dados['ativo']);

		$convenio->update($dados);

		return redirect()
			->route('convenios.edit', $convenio->id)
			->withSuccess('Convênio atualizado com sucesso.');
	}

	public function destroy($id)
	{
		$convenio = Convenio::findOrFail($id);

		// Aqui você pode impedir excluir se tiver órgãos/cliente vinculados, se quiser
		$convenio->delete();

		return redirect()
			->route('convenios.index')
			->withSuccess('Convênio excluído com sucesso.');
	}
	public function byConvenio(Request $request)
	{
		$convenioId = $request->get('convenio_id');

		if (!$convenioId) {
			return response()->json([]);
		}

		$orgaos = \App\Models\Orgao::where('convenio_id', $convenioId)
			->orderBy('nome')
			->get(['id', 'nome']);

		return response()->json($orgaos);
	}


}
