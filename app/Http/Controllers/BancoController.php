<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Banco;
use App\Models\Promotora;
use App\Models\BancoUf;



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
	public function index(Request $request)
	{
		$ufs = $this->listaUfs();
		$tiposInstituicao = $this->listaTiposInstituicao();

		$tipoFiltro = $request->get('tipo'); // ex: banco, promotora...
		$ufFiltro = $request->get('uf');   // ex: SP, RJ...

		$query = Banco::query()->with('ufs');

		// Filtro por tipo, se informado
		if (!empty($tipoFiltro)) {
			$query->where('tipo', $tipoFiltro);
		}

		// Filtro por UF:
		// - se a instituição NÃO tiver nenhum registro em banco_ufs => considerada "todos os estados"
		// - se tiver registros em banco_ufs => precisa ter a UF escolhida
		if (!empty($ufFiltro)) {
			$query->where(function ($q) use ($ufFiltro) {
				$q->whereDoesntHave('ufs') // sem estados = todos
					->orWhereHas('ufs', function ($sub) use ($ufFiltro) {
						$sub->where('uf', $ufFiltro);
					});
			});
		}

		$instituicoes = $query
			->orderBy('nome')
			->paginate(15)
			->appends($request->query()); // mantém filtros na paginação

		return view('financeiro.bancos.index', compact(
			'instituicoes',
			'ufs',
			'tiposInstituicao',
			'tipoFiltro',
			'ufFiltro'
		));
	}


	/**
	 * Formulário de criação.
	 */
	public function create()
	{
		$ufs = $this->listaUfs();
		// antes: view('financeiro.bancos.create')
		return view('financeiro.bancos.form', compact('ufs'));
	}
	/**
	 * Formulário de edição.
	 */
	public function edit($id)
	{
		$banco = Banco::findOrFail($id);

		// antes: view('financeiro.bancos.edit', ...)
		return view('financeiro.bancos.form', compact('banco'));
	}

	/**
	 * Salva um novo banco.
	 */
	// app/Http/Controllers/BancoController.php
	public function store(Request $request)
	{
		$dados = $request->validate([
			'nome' => 'required|string|max:255',
			'codigo' => 'nullable|string|max:10',
			'tipo' => 'required|string|max:30', // ADICIONAR
		]);

		Banco::create($dados);

		return redirect()
			->route('bancos.index')
			->withSuccess('Banco criado com sucesso.');
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
	 * Atualiza um banco.
	 */
	public function update(Request $request, $id)
	{
		$banco = Banco::findOrFail($id);
		$ufsValidas = array_keys($this->listaUfs());

		$dados = $request->validate([
			'nome' => 'required|string|max:255',
			'codigo' => 'nullable|string|max:20',

			'promotoras' => 'nullable|array',
			'promotoras.*' => 'exists:promotoras,id',

			'ufs' => 'nullable|array',
			'ufs.*' => 'in:' . implode(',', $ufsValidas),
		]);

		$banco->update([
			'nome' => $dados['nome'],
			'codigo' => $dados['codigo'] ?? null,
		]);

		// Atualiza promotoras vinculadas
		$banco->promotoras()->sync($dados['promotoras'] ?? []);

		// Atualiza estados de atuação
		$banco->ufs()->delete();
		if (!empty($dados['ufs'])) {
			foreach ($dados['ufs'] as $uf) {
				$banco->ufs()->create(['uf' => $uf]);
			}
		}

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

	private function listaUfs()
	{
		return [
			'AC' => 'Acre',
			'AL' => 'Alagoas',
			'AP' => 'Amapá',
			'AM' => 'Amazonas',
			'BA' => 'Bahia',
			'CE' => 'Ceará',
			'DF' => 'Distrito Federal',
			'ES' => 'Espírito Santo',
			'GO' => 'Goiás',
			'MA' => 'Maranhão',
			'MT' => 'Mato Grosso',
			'MS' => 'Mato Grosso do Sul',
			'MG' => 'Minas Gerais',
			'PA' => 'Pará',
			'PB' => 'Paraíba',
			'PR' => 'Paraná',
			'PE' => 'Pernambuco',
			'PI' => 'Piauí',
			'RJ' => 'Rio de Janeiro',
			'RN' => 'Rio Grande do Norte',
			'RS' => 'Rio Grande do Sul',
			'RO' => 'Rondônia',
			'RR' => 'Roraima',
			'SC' => 'Santa Catarina',
			'SP' => 'São Paulo',
			'SE' => 'Sergipe',
			'TO' => 'Tocantins',
		];
	}

	// Helper centralizado dos tipos de instituição
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
