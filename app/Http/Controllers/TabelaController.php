<?php

namespace App\Http\Controllers;

use App\Models\Tabela;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class TabelaController extends Controller
{

	public function __construct()
	{
		$this->middleware('can:tabelas.index')->only('index');
		$this->middleware('can:tabelas.create')->only('create', 'store');
		$this->middleware('can:tabelas.edit')->only('edit', 'update');
		$this->middleware('can:tabelas.destroy')->only('destroy');
	}

	/**
	 * Display a listing of the resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function index()
	{
		$tabelas = Tabela::all();
		return view('tabelas.index', [
			'tabelas' => $tabelas
		]);
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function create()
	{
		return view('tabelas.create');
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @return \Illuminate\Http\Response
	 */
	public function store(Request $request)
	{
		$dados = $request->all();

		$validator = Validator::make($dados, [
			'cod' => ['required', 'string',],
			'nome' => ['required', 'string'],
			'prazo' => ['required', 'string',],
			'coeficiente' => ['required', 'string'],
			'taxa' => ['required', 'string'],
			'vigencia' => ['required', 'string'],
		]);

		if ($validator->fails()) {
			return redirect()->route('tabelas.create')
				->withErrors($validator)
				->withInput();
		}

		$tabela = new Tabela;
		$tabela->cod = $dados['cod'];
		$tabela->nome = $dados['nome'];
		$tabela->prazo = $dados['prazo'];
		$tabela->coeficiente = $dados['coeficiente'];
		$tabela->taxa = $dados['taxa'];
		$tabela->vigencia = $dados['vigencia'];
		$tabela->save();

		return redirect()->route('tabelas.index')->withSuccess('Tabela criada.');
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function show($id)
	{
		//
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function edit(Tabela $tabela)
	{
		return view('tabelas.edit', compact('tabela'));
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function update(Request $request, Tabela $tabela)
	{
		$dados = $request->all();

		$validator = Validator::make($dados, [
			'cod' => ['required', 'string',],
			'nome' => ['required', 'string'],
			'prazo' => ['required', 'string',],
			'coeficiente' => ['required', 'string'],
			'taxa' => ['required', 'string'],
			'vigencia' => ['required', 'string'],
		]);

		if ($validator->fails()) {
			return redirect()->route('tabelas.edit', compact('tabela'))
				->withErrors($validator)
				->withInput();
		}

		$tabela->cod = $dados['cod'];
		$tabela->nome = $dados['nome'];
		$tabela->prazo = $dados['prazo'];
		$tabela->coeficiente = $dados['coeficiente'];
		$tabela->taxa = $dados['taxa'];
		$tabela->vigencia = $dados['vigencia'];
		$tabela->save();

		return redirect()->route('tabelas.index')->withSuccess('Tabela atualizada.');

	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function destroy(Tabela $tabela)
	{
		$tabela->delete();

		return redirect()->route('tabelas.index')->withSuccess('Tabela exluída.');
	}
}
