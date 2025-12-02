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
	public function index()
	{
		$bancos = Banco::orderBy('nome')->paginate(20);

		return view('financeiro.bancos.index', [
			'bancos' => $bancos,
			'activePage' => 'bancos',
		]);
	}

	/**
	 * Formulário de criação.
	 */
	public function create()
	{
		$promotoras = Promotora::orderBy('nome')->get();
		$ufs = $this->listaUfs(); // aquele helper de UFs que te passei

		return view('financeiro.bancos.form', compact('promotoras', 'ufs'));
	}



	/**
	 * Salva um novo banco.
	 */
	public function store(Request $request)
	{
		$ufsValidas = array_keys($this->listaUfs());

		$dados = $request->validate([
			'nome' => 'required|string|max:255',
			'codigo' => 'nullable|string|max:20',

			'promotoras' => 'nullable|array',
			'promotoras.*' => 'exists:promotoras,id',

			'ufs' => 'nullable|array',
			'ufs.*' => 'in:' . implode(',', $ufsValidas),
		]);

		// Cria o banco
		$banco = Banco::create([
			'nome' => $dados['nome'],
			'codigo' => $dados['codigo'] ?? null,
		]);

		// Relaciona promotoras
		$banco->promotoras()->sync($dados['promotoras'] ?? []);

		// Salva estados de atuação
		if (!empty($dados['ufs'])) {
			foreach ($dados['ufs'] as $uf) {
				$banco->ufs()->create(['uf' => $uf]);
			}
		}

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
	 * Formulário de edição.
	 */
	public function edit($id)
	{
		$banco = Banco::with(['promotoras', 'ufs'])->findOrFail($id);
		$promotoras = Promotora::orderBy('nome')->get();
		$ufs = $this->listaUfs();

		// Se quiser pode mandar os arrays já prontos, mas a view também calcula se não vierem
		$promotorasSelecionadas = $banco->promotoras->pluck('id')->toArray();
		$ufsSelecionadas = $banco->ufs->pluck('uf')->toArray();

		return view('financeiro.bancos.form', compact(
			'banco',
			'promotoras',
			'ufs',
			'promotorasSelecionadas',
			'ufsSelecionadas'
		));
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

}
