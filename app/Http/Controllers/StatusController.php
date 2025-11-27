<?php

namespace App\Http\Controllers;

use App\Models\Status;
use App\Models\StatusTipo;
use Illuminate\Http\Request;

class StatusController extends Controller
{

    public function __construct()
    {
        $this->middleware('can:status.index')->only('index');
        $this->middleware('can:status.create')->only('create', 'store');
        $this->middleware('can:status.edit')->only('edit', 'update');
        $this->middleware('can:status.destroy')->only('destroy');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $statuses = Status::paginate();
        return view('status.index', compact('statuses'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $status_tipos = StatusTipo::pluck('tipo_status', 'id');

        return view('status.create', compact('status_tipos'));
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
            'status' => 'required'
        ]);

        $status = new Status;                
        $status->status = $request->status;
        $status->status_tipo_id = $request->status_tipo;
        $status->save();   

        return redirect()->route('status.edit', $status)->with('info', 'Status criado com sucesso!');
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
    public function edit(Status $status)
    {
        $status_tipos = StatusTipo::pluck('tipo_status', 'id');
        return view('status.edit', compact('status', 'status_tipos'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Status $status)
    {
        $request->validate([
            'status' => 'required'
        ]);

        $status->status = $request->status;
        $status->status_tipo_id = $request->status_tipo;
        $status->save();
        return redirect()->route('status.edit', $status)->with('info', 'Status atualizada com sucesso!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Status $status)
    {
        $status->delete();

        return redirect()->route('status.index')->with('info', 'Status excluido com sucesso!');
    }
}
