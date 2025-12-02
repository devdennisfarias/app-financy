<?php

namespace App\Http\Controllers;

use App\Models\Banco;
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
	public function index(Request $request)
	{
		$query = Produto::with('instituicao');

		// filtros
		if ($request->filled('instituicao_id')) {
			$query->where('banco_id', $request->instituicao_id);
		}

		if ($request->filled('tipo_instituicao')) {
			$query->whereHas('instituicao', function ($q) use ($request) {
				$q->where('tipo', $request->tipo_instituicao);
			});
		}

		// paginação
		$produtos = $query->orderBy('produto')
			->paginate(15)
			->appends($request->query());

		// obtém filtros atuais para preencher os selects no front
		$instituicaoFiltro = $request->input('instituicao_id');
		$tipoFiltro = $request->input('tipo_instituicao');

		// lista de instituições e tipos
		$instituicoes = Banco::orderBy('nome')->get();

		$tiposInstituicao = [
			'banco' => 'Banco',
			'promotora' => 'Promotora',
			'fintech' => 'Fintech',
			'corresp' => 'Correspondente',
			'outro' => 'Outro',
		];

		return view('produtos.index', compact(
			'produtos',
			'instituicoes',
			'tiposInstituicao',
			'instituicaoFiltro',
			'tipoFiltro'
		));
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	// app/Http/Controllers/ProdutoController.php

	public function create()
	{
		$instituicoes = Banco::orderBy('nome')->get();
		$tiposInstituicao = $this->listaTiposInstituicao();

		return view('produtos.create', compact(
			'instituicoes',
			'tiposInstituicao'
		));
	}


	public function edit(Produto $produto)
	{
		$instituicoes = Banco::orderBy('nome')->get();
		$tiposInstituicao = $this->listaTiposInstituicao();

		return view('produtos.edit', compact(
			'produto',
			'instituicoes',
			'tiposInstituicao'
		));
	}


	/**
	 * Store a newly created resource in storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @return \Illuminate\Http\Response
	 */
	public function store(Request $request)
	{
		$dados = $request->validate([
			'produto' => 'required|string|max:255',
			'descricao' => 'nullable|string|max:255',
			'banco_id' => 'nullable|exists:bancos,id',

			// campos da nova instituição (opcionais)
			'nova_instituicao_nome' => 'nullable|string|max:255',
			'nova_instituicao_tipo' => 'nullable|string|max:30',
			'nova_instituicao_codigo' => 'nullable|string|max:10',
		]);

		// Se o usuário digitou uma nova instituição, criamos aqui
		if (!empty($dados['nova_instituicao_nome'])) {
			$nova = Banco::create([
				'nome' => $dados['nova_instituicao_nome'],
				'tipo' => $dados['nova_instituicao_tipo'] ?: 'banco',
				'codigo' => $dados['nova_instituicao_codigo'] ?? null,
			]);

			$dados['banco_id'] = $nova->id;
		}

		// Remove campos auxiliares do array antes de salvar o produto
		unset($dados['nova_instituicao_nome'], $dados['nova_instituicao_tipo'], $dados['nova_instituicao_codigo']);

		Produto::create($dados);

		return redirect()
			->route('produtos.index')
			->with('success', 'Produto cadastrado com sucesso.');
	}

	public function update(Request $request, Produto $produto)
	{
		$dados = $request->validate([
			'produto' => 'required|string|max:255',
			'descricao' => 'nullable|string|max:255',
			'banco_id' => 'nullable|exists:bancos,id',

			'nova_instituicao_nome' => 'nullable|string|max:255',
			'nova_instituicao_tipo' => 'nullable|string|max:30',
			'nova_instituicao_codigo' => 'nullable|string|max:10',
		]);

		if (!empty($dados['nova_instituicao_nome'])) {
			$nova = Banco::create([
				'nome' => $dados['nova_instituicao_nome'],
				'tipo' => $dados['nova_instituicao_tipo'] ?: 'banco',
				'codigo' => $dados['nova_instituicao_codigo'] ?? null,
			]);

			$dados['banco_id'] = $nova->id;
		}

		unset($dados['nova_instituicao_nome'], $dados['nova_instituicao_tipo'], $dados['nova_instituicao_codigo']);

		$produto->update($dados);

		return redirect()
			->route('produtos.edit', $produto)
			->with('success', 'Produto atualizado com sucesso.');
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

	private function listaInstituicoesParaProduto()
	{
		return Banco::orderBy('nome')->get(); // ou ->whereIn('tipo', ['banco', 'promotora'])->get();
	}

	private function listaTiposInstituicao()
	{
		return [
			'banco' => 'Banco',
			'promotora' => 'Promotora',
			'fintech' => 'Fintech',
			'corresp' => 'Correspondente',
			'outro' => 'Outro',
		];
	}


}
