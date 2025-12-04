<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Proposta;
use App\Models\Produto;
use App\Models\Banco;
use App\Models\Status;

class PropostasIndex extends Component
{
	use WithPagination;

	// filtros
	public $search = '';
	public $cpf = '';
	public $produtoId = '';
	public $bancoId = '';
	public $statusId = '';

	// coleções usadas nos selects
	public $produtos = [];
	public $bancos = [];
	public $statuses = [];

	protected $updatesQueryString = [
		'search',
		'cpf',
		'produtoId',
		'bancoId',
		'statusId',
	];

	public function mount()
	{
		// carrega as listas para os filtros
		$this->produtos = Produto::orderBy('produto')->get();
		$this->bancos = Banco::orderBy('nome')->get();
		$this->statuses = Status::orderBy('status')->get();
	}

	// sempre que mudar algum filtro, volta pra página 1
	public function updatingSearch()
	{
		$this->resetPage();
	}
	public function updatingCpf()
	{
		$this->resetPage();
	}
	public function updatingProdutoId()
	{
		$this->resetPage();
	}
	public function updatingBancoId()
	{
		$this->resetPage();
	}
	public function updatingStatusId()
	{
		$this->resetPage();
	}

	public function render()
	{
		$query = Proposta::query()
			->with(['vendedor', 'cliente', 'produto', 'status_atual']);

		// busca livre
		if (!empty($this->search)) {
			$s = '%' . $this->search . '%';

			$query->where(function ($q) use ($s) {
				$q->where('id', 'like', $s)
					->orWhere('orgao', 'like', $s)
					->orWhere('banco', 'like', $s)
					->orWhereHas('cliente', function ($sub) use ($s) {
						$sub->where('nome', 'like', $s)
							->orWhere('cpf', 'like', $s);
					});
			});
		}

		// filtro por CPF (cliente)
		if (!empty($this->cpf)) {
			$cpfLimpo = preg_replace('/\D/', '', $this->cpf);

			$query->whereHas('cliente', function ($q) use ($cpfLimpo) {
				$q->where('cpf', 'like', '%' . $cpfLimpo . '%');
			});
		}

		// filtro por Produto
		if (!empty($this->produtoId)) {
			$query->where('produto_id', $this->produtoId);
		}

		// filtro por Banco (campo banco_id da proposta)
		if (!empty($this->bancoId)) {
			$query->where('banco_id', $this->bancoId);
		}

		// filtro por Status
		if (!empty($this->statusId)) {
			$query->where('status_atual_id', $this->statusId);
		}

		$propostas = $query
			->orderByDesc('created_at')
			->paginate(15);

		return view('livewire.propostas-index', [
			'propostas' => $propostas,
			'produtos' => $this->produtos,
			'bancos' => $this->bancos,
			'statuses' => $this->statuses,
		]);
	}
}
