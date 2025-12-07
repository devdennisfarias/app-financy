<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Proposta;
use App\Models\Status;
use App\Models\Banco;
use App\Models\Produto;
use App\Models\User;

class PropostasIndex extends Component
{
	use WithPagination;

	public $search = '';

	public $status = '';
	public $banco = '';
	public $produto = '';
	public $vendedor = '';
	public $data_inicio;
	public $data_fim;

	public $perPage = 15;

	protected $updatesQueryString = [
		'search' => ['except' => ''],
		'status' => ['except' => ''],
		'banco' => ['except' => ''],
		'produto' => ['except' => ''],
		'vendedor' => ['except' => ''],
		'data_inicio' => ['except' => null],
		'data_fim' => ['except' => null],
		'page' => ['except' => 1],
	];

	protected $paginationTheme = 'bootstrap';

	public function updatingSearch()
	{
		$this->resetPage();
	}
	public function updatingStatus()
	{
		$this->resetPage();
	}
	public function updatingBanco()
	{
		$this->resetPage();
	}
	public function updatingProduto()
	{
		$this->resetPage();
	}
	public function updatingVendedor()
	{
		$this->resetPage();
	}
	public function updatingDataInicio()
	{
		$this->resetPage();
	}
	public function updatingDataFim()
	{
		$this->resetPage();
	}

	public function render()
	{
		$query = Proposta::with([
			'cliente',
			'produto',
			'banco',
			'status_atual',
			'vendedor',
		])
			->latest();

		// Busca geral
		if ($this->search) {
			$search = '%' . $this->search . '%';

			$query->where(function ($q) use ($search) {
				$q->where('id', 'like', $search)
					->orWhereHas('cliente', function ($q2) use ($search) {
						$q2->where('nome', 'like', $search)
							->orWhere('cpf', 'like', $search);
					})
					->orWhereHas('banco', function ($q3) use ($search) {
						$q3->where('nome', 'like', $search);
					})
					->orWhere('banco', 'like', $search)
					->orWhereHas('produto', function ($q4) use ($search) {
						$q4->where('produto', 'like', $search);
					})
					->orWhereHas('vendedor', function ($q5) use ($search) {
						$q5->where('name', 'like', $search);
					});
			});
		}

		// Filtros
		if ($this->status !== '' && $this->status !== null) {
			$query->where('status_atual_id', $this->status);
		}

		if ($this->banco !== '' && $this->banco !== null) {
			$query->where('banco_id', $this->banco);
		}

		if ($this->produto !== '' && $this->produto !== null) {
			$query->where('produto_id', $this->produto);
		}

		if ($this->vendedor !== '' && $this->vendedor !== null) {
			$query->where('user_id', $this->vendedor);
		}

		if ($this->data_inicio) {
			$query->whereDate('created_at', '>=', $this->data_inicio);
		}

		if ($this->data_fim) {
			$query->whereDate('created_at', '<=', $this->data_fim);
		}

		$propostas = $query->paginate($this->perPage);

		// Listas para selects
		$statusList = Status::orderBy('status')->get();
		$bancos = Banco::orderBy('nome')->get();
		$produtos = Produto::orderBy('produto')->get();
		$vendedores = User::orderBy('name')->get();

		return view('livewire.propostas-index', [
			'propostas' => $propostas,
			'statusList' => $statusList,
			'bancos' => $bancos,
			'produtos' => $produtos,
			'vendedores' => $vendedores,
		]);
	}
}
