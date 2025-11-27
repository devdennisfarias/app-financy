<?php

namespace App\Http\Controllers;

use App\Models\Cliente;
use App\Models\Proposta;
use App\Models\Atendimento;
use App\Models\Status;
use App\Models\StatusTipo;
use App\Models\User;
use Illuminate\Http\Request;
use LengthException;

class EsteiraController extends Controller
{

    public function __construct()
    {
        $this->middleware('can:esteira.index')->only('index');        
        $this->middleware('can:esteira.edit')->only('edit', 'update');        
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {           
        
        // por padrão listar todos os cliente se não tiver busca
        $vendedores = User::all();
        $propostas = Proposta::paginate();
        $atendimentos = Atendimento::orderBy('id', 'DESC')->get();
        $status_tipos = StatusTipo::all(); 
        //dd($status_tipos);
        

        if(!empty($request->cpf)) {
            //consulta por cpf
            $cliente = Cliente::where('cpf', $request->cpf)->first();
            if(!empty($cliente)){
                $propostas = $cliente->propostas()->get();
            } else {
                return redirect()
                ->route('esteira.producao')
                ->withDanger('Nenhum registro encontrado!');
            }            

        } else if(!empty($request->numero_nexus)){
            // consulta por numero nexus
            $propostas = Proposta::where('id', $request->numero_nexus)->paginate();  

        } else if(!empty($request->status_tipo_id)){
            // consulta por tipo de status
            $propostas = Proposta::where('status_tipo_atual_id', $request->status_tipo_id)->paginate();

        } else if(!empty($request->vendedor)){            
            $propostas = Proposta::where('user_id', $request->vendedor)->paginate(1);
        
        } /*else if(!empty($request->data_final)){
            //dd($request->all());
            //consulta por vendedor e data
            $prospostas = Proposta::where('created_at', '>=', $request->data_inicial)
                                    ->orWhere('created_at', '<=', $request->data_final)
                                    ->get();

        } */        
        
        return view('esteira.index', compact('atendimentos', 'propostas', 'status_tipos', 'vendedores'));
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
        $proposta = Proposta::find($id);
        $status_tipos = StatusTipo::all();
        $statuss = Status::all();
        $status_atual = $proposta->status_atual()->get();
        $status_tipo_atual = $proposta->status_tipo_atual()->get();
        $atendimentos = Atendimento::where('proposta_id', $id)->orderBy('id', 'desc')->paginate(5);

        if($proposta){
            return view('esteira.edit',[
                'proposta' => $proposta,
                'statuss' => $statuss,
                'status_tipos' => $status_tipos,
                'atendimentos' => $atendimentos,
                'status_atual' => $status_atual,
                'status_tipo_atual' => $status_tipo_atual
            ]);    
        }

        return redirect()->route('esteira.listar');
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

    public function pesquisar(Request $request)
    {
        $cpf = $request->cpf;        
        $cliente = Cliente::where("cpf", $cpf)->first();

        if(empty($cliente)){
            return false;
        }
        
        $propostas = Proposta::where('cliente_id', $cliente->id)->get();
        return $propostas;
        
    }
}