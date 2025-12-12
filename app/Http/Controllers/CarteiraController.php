<?php

namespace App\Http\Controllers;

use App\Models\Cliente;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CarteiraController extends Controller
{

	public function __construct()
	{
		$this->middleware('can:carteiras.index')->only('index');
		$this->middleware('can:carteiras.create')->only('create', 'store');
		$this->middleware('can:carteiras.edit')->only('edit', 'update');
		$this->middleware('can:carteiras.destroy')->only('destroy');
	}

	/**
	 * Display a listing of the resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function index()
	{
		return view('carteiras.index');
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function create()
	{
		//
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @return \Illuminate\Http\Response
	 */
	public function store(Request $request)
	{
		//
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
	public function edit($id)
	{
		//
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function update(Request $request, $id)
	{
		//
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function destroy($id)
	{
		//
	}

	/**
	 * Formulário de importação da carteira de clientes.
	 */
	public function importForm()
	{
		return view('carteiras.import');
	}

	/**
	 * Recebe o arquivo de importação e dispara a Job em background.
	 */
	public function importStore(Request $request)
	{
		$request->validate([
			'file' => ['required', 'file', 'mimes:csv,txt'],
		]);

		$userId = Auth::id();

		// Salva o arquivo em storage/app/imports/carteiras
		$path = $request->file('file')->store('imports/carteiras');

		// Conta rapidamente quantas linhas existem (pra preencher total_items)
		$fullPath = storage_path('app/' . $path);
		$total = 0;

		if (($handle = fopen($fullPath, 'r')) !== false) {
			while (($row = fgetcsv($handle, 0, ';')) !== false) {
				if (count(array_filter($row)) === 0) {
					continue;
				}
				$total++;
			}
			fclose($handle);
		}

		// Cria a operação longa
		$operation = \App\Models\LongOperation::create([
			'user_id' => $userId,
			'type' => 'import_carteira',
			'description' => 'Importação de carteira de clientes',
			'status' => 'pending',
			'total_items' => $total,
			'processed_items' => 0,
		]);

		// Dispara a job na fila
		\App\Jobs\ProcessCarteiraImportJob::dispatch($operation->id, $path, $userId);

		return redirect()
			->route('carteiras.index')
			->with('success', 'Importação iniciada! Você pode acompanhar o progresso na barra de status.');
	}

}
