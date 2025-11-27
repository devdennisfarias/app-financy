<?php

namespace App\Http\Controllers;

use App\Models\Equipe;
use App\Models\Loja;
use Illuminate\Http\Request;

class EquipeController extends Controller
{

    public function __construct()
    {
        $this->middleware('can:equipes.index')->only('index');
        $this->middleware('can:equipes.create')->only('create', 'store');
        $this->middleware('can:equipes.edit')->only('edit', 'update');
        $this->middleware('can:equipes.destroy')->only('destroy');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $equipes = Equipe::all();
        return view('equipes.index', compact('equipes'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $lojas = Loja::all();
        return view('equipes.create', compact('lojas'));
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
            'equipe' => 'required'
        ]);

        $equipe = new Equipe;
        $equipe->equipe = $request->equipe;
        $equipe->loja_id = $request->loja_id;
        $equipe->save();

        return redirect()->route('equipes.edit', $equipe)->with('info', 'Equipe criada com sucesso!');
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
    public function edit(Equipe $equipe)
    {
        $lojas = Loja::all();
        return view('equipes.edit', compact('equipe', 'lojas'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Equipe $equipe)
    {
        $request->validate([
            'equipe' => 'required'
        ]);

        $equipe->equipe = $request->equipe;
        $equipe->loja_id = $request->loja_id;
        $equipe->save();

        return redirect()->route('equipes.edit', $equipe)->with('info', 'Equipe atualizada com sucesso!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Equipe $equipe)
    {
        $equipe->delete();

        return redirect()->route('equipes.index')->with('info', 'Equipe excluída com sucesso!');
    }

    public function getEquipes(Request $request, $id){
        if($request->ajax()){
            $equipes = Equipe::equipes($id);
            return response()->json($equipes);
        }
    }
}
