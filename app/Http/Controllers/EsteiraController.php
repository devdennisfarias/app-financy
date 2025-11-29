<?php

namespace App\Http\Controllers;

use App\Models\Proposta;
use App\Models\StatusTipo;
use App\Models\User;
use Illuminate\Http\Request;

class EsteiraController extends Controller
{
    public function __construct()
    {
        // você pode usar 'producao.index' ou criar 'esteira.index' se quiser ser mais granular
        $this->middleware('can:producao.index')->only('index');
    }

    /**
     * Esteira de Propostas (pipeline)
     */
    public function index(Request $request)
    {
        // Filtros
        $filtros = $request->only([
            'data_inicio',
            'data_fim',
            'user_id',
            'produto',
            'orgao',
        ]);

        $query = Proposta::with(['cliente', 'produto', 'user', 'statusTipoAtual']);

        if (!empty($filtros['data_inicio'])) {
            $query->whereDate('created_at', '>=', $filtros['data_inicio']);
        }

        if (!empty($filtros['data_fim'])) {
            $query->whereDate('created_at', '<=', $filtros['data_fim']);
        }

        if (!empty($filtros['user_id'])) {
            $query->where('user_id', $filtros['user_id']);
        }

        if (!empty($filtros['produto'])) {
            $query->whereHas('produto', function ($q) use ($filtros) {
                $q->where('produto', 'like', '%' . $filtros['produto'] . '%')
                  ->orWhere('nome', 'like', '%' . $filtros['produto'] . '%');
            });
        }

        if (!empty($filtros['orgao'])) {
            $query->where('orgao', 'like', '%' . $filtros['orgao'] . '%');
        }

        // Todas as propostas filtradas, vamos agrupar por status_tipo
        $propostas = $query->get()->groupBy('status_tipo_atual_id');

        // status_tipos em ordem de fluxo (ajuste o 'ordem' ou 'id' conforme sua tabela)
        $statusTipos = StatusTipo::orderBy('id', 'asc')->get();

        $usuarios = User::orderBy('name')->get();

        return view('esteira.index', [
            'statusTipos'        => $statusTipos,
            'propostasPorStatus' => $propostas,
            'usuarios'           => $usuarios,
            'filtros'            => $filtros,
            'activePage'         => 'esteira',
        ]);
    }
}
