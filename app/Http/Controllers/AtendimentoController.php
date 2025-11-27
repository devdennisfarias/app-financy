<?php

namespace App\Http\Controllers;

use App\Models\Atendimento;
use App\Models\Proposta;
use App\Models\Status;
use Illuminate\Http\Request;

class AtendimentoController extends Controller
{

    public function __construct()
    {
        $this->middleware('can:atendimentos.create')->only('create', 'store');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
    public function store(Request $request, $id)
    {
        if (!empty($request->status_id) && !empty($request->descricao)) {
            $atendimento = new Atendimento;
            $proposta = Proposta::find($id);
            $status = Status::find($request->status_id);

            $atendimento->descricao = $request->descricao;
            $atendimento->proposta_id = $id;
            $atendimento->status_id = $request->status_id;

            $proposta->status_tipo_atual_id = $status->status_tipo_id;
            $proposta->status_atual_id = $request->status_id;

            $atendimento->save();
            $proposta->save();

            return redirect()->back();
        }

        return redirect()
                ->back()
                ->withDanger('Preencha todos os campos de atendimento!');

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
}
