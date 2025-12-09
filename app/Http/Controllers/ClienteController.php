<?php

namespace App\Http\Controllers;

use App\Models\Cliente;
use App\Models\Orgao;
use App\Models\Convenio;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class ClienteController extends Controller
{
	public function __construct()
	{
		$this->middleware('can:clientes.index')->only('index');
		$this->middleware('can:clientes.create')->only(['create', 'store']);
		$this->middleware('can:clientes.edit')->only(['edit', 'update']);
		$this->middleware('can:clientes.destroy')->only('destroy');
	}

	/**
	 * Lista de clientes (pode ser controlada por Livewire)
	 */
	public function index()
	{
		return view('clientes.index');
	}

	/**
	 * Carteira (seu layout já usa essa view)
	 */
	public function carteira()
	{
		return view('clientes.carteira');
	}

	/**
	 * Formulário de criação
	 */
	public function create()
	{
		$convenios = Convenio::orderBy('nome')->get();
		$orgaos = Orgao::with('convenio')
			->where('ativo', true)
			->orderBy('nome')
			->get();

		return view('clientes.create', [
			'convenios' => $convenios,
			'orgaos' => $orgaos,
		]);
	}

	/**
	 * Salva novo cliente
	 */
	public function store(Request $request)
	{
		$dados = $request->all();
		$loggedId = Auth::id();

		$validator = Validator::make($dados, [
			'nome' => ['required', 'string', 'max:150'],
			'cpf' => ['required', 'string', 'unique:clientes,cpf', 'max:14'],
			'data_nascimento' => ['required', 'date'],
			'nome_mae' => ['required', 'string', 'max:150'],
			'telefone_1' => ['required', 'string', 'max:150'],
			'orgao_id' => ['nullable', 'exists:orgaos,id'],
		]);

		if ($validator->fails()) {
			return redirect()
				->route('clientes.create')
				->withErrors($validator)
				->withInput();
		}

		$cliente = new Cliente();

		// Campos principais
		$cliente->nome = $dados['nome'] ?? null;
		$cliente->cpf = $dados['cpf'] ?? null;
		$cliente->rg = $dados['rg'] ?? null;
		$cliente->data_exp = $dados['data_exp'] ?? null;
		$cliente->orgao_emissor = $dados['orgao_emissor'] ?? null;
		$cliente->data_nascimento = $dados['data_nascimento'] ?? null;

		// Órgão pagador (novo relacionamento)
		$cliente->orgao_id = $dados['orgao_id'] ?? null;

		// Contato / endereço básicos
		$cliente->telefone_1 = $dados['telefone_1'] ?? null;
		$cliente->telefone_2 = $dados['telefone_2'] ?? null;
		$cliente->telefone_3 = $dados['telefone_3'] ?? null;
		$cliente->email = $dados['email'] ?? null;

		$cliente->cep = $dados['cep'] ?? null;
		$cliente->endereco = $dados['endereco'] ?? null;
		$cliente->numero = $dados['numero'] ?? null;
		$cliente->complemento = $dados['complemento'] ?? null;
		$cliente->bairro = $dados['bairro'] ?? null;
		$cliente->cidade = $dados['cidade'] ?? null;
		$cliente->estado = $dados['estado'] ?? null;

		// Campos de perfil
		$cliente->nome_mae = $dados['nome_mae'] ?? null;
		$cliente->nome_pai = $dados['nome_pai'] ?? null;
		$cliente->estado_civil = $dados['estado_civil'] ?? null;
		$cliente->nacionalidade = $dados['nacionalidade'] ?? null;

		// Flags (alfabetizado, figura pública)
		$cliente->alfabetizado = !empty($dados['alfabetizado']) ? 1 : 0;
		$cliente->figura_publica = !empty($dados['figura_publica']) ? 1 : 0;

		// Quem cadastrou
		$cliente->user_id = $loggedId;

		$cliente->save();

		// Se veio de fluxo de proposta, só volta pra trás
		if ($request->has('proposta') && $request->boolean('proposta')) {
			return redirect()
				->back()
				->withSuccess('Cliente criado com sucesso.');
		}

		// ✅ Se veio da edição de clientes, volta para edição.        
		if ($request->filled('from') && $request->from === 'clientes.edit') {
			return redirect()
				->route('clientes.edit', $cliente->id)
				->withSuccess('Cliente criado com sucesso.');
		}
		// ✅ Se veio da proposta, volta para a proposta
		if ($request->filled('from') && $request->from === 'propostas.create') {
			return redirect()
				->route('propostas.create')
				->with('cliente_id', $cliente->id)
				->withSuccess('Cliente cadastrado com sucesso. Continue a proposta.');
		}

		// ✅ Fluxo normal
		return redirect()
			->route('clientes.index')
			->withSuccess('Cliente cadastrado com sucesso.');

	}


	/**
	 * Formulário de edição
	 */
	public function edit($id)
	{
		$cliente = Cliente::with('orgao.convenio')->find($id);

		if (!$cliente) {
			return redirect()->route('clientes.index');
		}

		$convenios = Convenio::orderBy('nome')->get();
		$orgaos = Orgao::with('convenio')
			->where('ativo', true)
			->orderBy('nome')
			->get();

		return view('clientes.edit', [
			'cliente' => $cliente,
			'convenios' => $convenios,
			'orgaos' => $orgaos,
		]);
	}

	/**
	 * Atualiza cliente
	 */
	public function update(Request $request, $id)
	{
		$cliente = Cliente::findOrFail($id);

		$dados = $request->validate([
			'nome' => 'required|string|max:255',
			'cpf' => 'required|string|max:20',
			'rg' => 'nullable|string|max:30',
			'data_exp' => 'nullable|date',
			'orgao_emissor' => 'nullable|string|max:50',
			'data_nascimento' => 'nullable|date',
			'orgao_id' => 'nullable|exists:orgaos,id',
			'telefone_1' => 'nullable|string|max:20',
			'telefone_2' => 'nullable|string|max:20',
			'telefone_3' => 'nullable|string|max:20',
			'email' => 'nullable|email|max:255',
			'cep' => 'nullable|string|max:20',
			'endereco' => 'nullable|string|max:255',
			'numero' => 'nullable|string|max:20',
			'complemento' => 'nullable|string|max:255',
			'bairro' => 'nullable|string|max:100',
			'cidade' => 'nullable|string|max:100',
			'estado' => 'nullable|string|max:2',
			'nome_mae' => 'nullable|string|max:255',
			'nome_pai' => 'nullable|string|max:255',
			'estado_civil' => 'nullable|string|max:50',
			'nacionalidade' => 'nullable|string|max:100',
			'alfabetizado' => 'nullable|boolean',
			'figura_publica' => 'nullable|boolean',
		]);

		// checkbox vem como "on" ou null, então garantimos boolean
		$dados['alfabetizado'] = $request->has('alfabetizado');
		$dados['figura_publica'] = $request->has('figura_publica');

		$cliente->update($dados);

		return redirect()
			->route('clientes.edit', $cliente->id)
			->withSuccess('Cliente atualizado com sucesso.');
	}


	/**
	 * Exclui cliente
	 */
	public function destroy($id)
	{
		$cliente = Cliente::find($id);

		if (!$cliente) {
			return redirect()
				->route('clientes.index')
				->withDanger('Cliente não encontrado.');
		}

		$cliente->delete();

		return redirect()
			->route('clientes.index')
			->withSuccess('Cliente excluído.');
	}
}
