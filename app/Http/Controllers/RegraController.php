<?php

namespace App\Http\Controllers;

use App\Models\Produto;
use App\Models\Regra;
use App\Models\RegraProduto;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class RegraController extends Controller
{

    public function __construct()
    {
        $this->middleware('can:regras.index')->only('index');
        $this->middleware('can:regras.create')->only('create', 'store');
        $this->middleware('can:regras.edit')->only('edit', 'update');
        $this->middleware('can:regras.destroy')->only('destroy');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $regras = Regra::all();
        return view('regras.index', compact('regras'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $produtos = Produto::all();
        $regras_produtos = '';

        return view('regras.create', compact('produtos', 'regras_produtos'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'regra' => 'required'
        ]);

        $produtos = $request->produtos;
        $comissoes = $request->comissoes;
        for ($i = 0, $tamanho = count($comissoes); $i < $tamanho; ++$i) {
            $comissoes[$i] = str_replace(",", ".", $comissoes[$i]); // Tira a vírgula
            $comissoes[$i] = str_replace("%", "", $comissoes[$i]); // Tira o %
            if ($comissoes[$i] == "") {
                $comissoes[$i] = 000.00;
            }
        }


        $regra = new Regra;
        $regra->regra = $request->regra;
        $regra->descricao = $request->descricao;
        $regra->save();

        for ($i = 0, $tamanho = count($comissoes); $i < $tamanho; ++$i) {
            DB::table('regras_produtos')->insert([
                'regra_id' => $regra->id,
                'produto_id' => $produtos[$i],
                'comissao' => $comissoes[$i]
            ]);
        }

        return redirect()->route('regras.edit', $regra)->with('info', 'Regra atualizada com sucesso!');
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
    public function edit(Regra $regra)
    {
        $produtos = Produto::all();
        $regras_produtos = RegraProduto::where('regra_id', '=', $regra->id)->get();
        //dd($regra_produto);

        //dd($produtos[0]->regra_produto);
        return view('regras.edit', compact('regra', 'produtos', 'regras_produtos'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Regra $regra)
    {
        $request->validate([
            'regra' => 'required'
        ]);

        $produtos = $request->produtos;
        $comissoes = $request->comissoes;
        for ($i = 0, $tamanho = count($comissoes); $i < $tamanho; ++$i) {
            $comissoes[$i] = str_replace(",", ".", $comissoes[$i]); // Tira a vírgula
            $comissoes[$i] = str_replace("%", "", $comissoes[$i]); // Tira o %
            if ($comissoes[$i] == "") {
                $comissoes[$i] = 000.00;
            }
        }

        $regra->regra = $request->regra;
        $regra->descricao = $request->descricao;
        $regra->save();

        $regra_produto = RegraProduto::where("regra_id", "=", $regra->id)->get();       
        for ($i = 0, $tamanho = count($comissoes); $i < $tamanho; ++$i) {
            if ($regra_produto[$i]->produto_id == $produtos[$i]) {
                $regra_produto[$i]->produto_id = $produtos[$i];
                $regra_produto[$i]->comissao = $comissoes[$i];
                $regra_produto[$i]->save();
            }
        }
        return redirect()->route('regras.edit', $regra)->with('info', 'Regra atualizada com sucesso!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Regra $regra)
    {
        $regra->delete();

        return redirect()->route('regras.index')->with('info', 'Regra excluída com sucesso!');
    }
}
