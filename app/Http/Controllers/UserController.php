<?php

namespace App\Http\Controllers;

use App\Models\Equipe;
use App\Models\Loja;
use App\Models\Regra;
use App\Models\User;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Spatie\Permission\Models\Role;

class UserController extends Controller
{

    public function __construct()
    {
        $this->middleware('can:users.index')->only('index');
        $this->middleware('can:users.create')->only('create', 'store');
        $this->middleware('can:users.edit')->only('edit', 'update');
        $this->middleware('can:users.destroy')->only('destroy');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {        
        return view('users.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $roles = Role::all();
        $lojas = Loja::pluck('loja', 'id');
        $regras = Regra::pluck('regra', 'id');

        return view('users.create', compact('roles', 'regras', 'lojas'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = $request->only([
            'name',
            'email',
            'password',
            'password_confirmation',
            'regra',
            'equipe'
        ]);

        $rules = [
            'name' => ['required', 'string', 'max:100'],
            'email' => ['required', 'string', 'email', 'max:100', 'unique:users'],
            'password' => ['required', 'string', 'min:4', 'confirmed']
        ];

        // Verifica se foi marcado VENDEDOR e torna o campo regra de comissão obrigatório, pois não pode exister um vendedor sem regra de comissão
        // Verifica se foi marcado VENDEDOR e torna o campo equipe obrigatório, pois não pode exister um vendedor sem equipe
        // ID 2 é de perfil de vendedor
        if(!empty($request->roles))
            for($i = 0; $i < count($request->roles); $i++){
                if($request->roles[$i] == 2){
                    $rules['regra'] = ['required'];
                    $rules['equipe'] = ['required'];
                }
        }        

        $validator = Validator::make($data, $rules);
            
        if($validator->fails()){
            return redirect()->route('users.create')
            ->withErrors($validator)
            ->withInput();
        }

        $user = new User;
        $user->name = $data['name'];
        $user->email = $data['email'];
        $user->password = Hash::make($data['password']);
        $user->equipe_id = $request->equipe;
        $user->regra_id = $request->regra;
        $user->save();

        $user->roles()->sync($request->roles);

        return redirect()->route('users.index');
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
    public function edit(User $user)
    {
        $roles = Role::all();
        $equipes = Equipe::pluck('equipe', 'id');
        $regras = Regra::pluck('regra', 'id');
        $lojas = Loja::pluck('loja', 'id');

        return view('users.edit', compact('user', 'roles', 'equipes', 'regras', 'lojas'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $user)
    {    
        
        $data = $request->only([
            'regra',
            'equipe'
        ]);

        // Verifica se foi marcado VENDEDOR e torna o campo regra de comissão obrigatório, pois não pode exister um vendedor sem regra de comissão
        // Verifica se foi marcado VENDEDOR e torna o campo equipe obrigatório, pois não pode exister um vendedor sem equipe
        // ID 2 é de perfil de vendedor
        if(!empty($request->roles))
            for($i = 0; $i < count($request->roles); $i++){
                if($request->roles[$i] == 2){
                    $rules['regra'] = ['required'];
                    $rules['equipe'] = ['required'];
                }            
        }        

        // Verifica se não esta vazia as validações
        if(!empty($rules)){
            $validator = Validator::make($data, $rules);
            if($validator->fails()){
                return redirect()->route('users.edit', $user)
                ->withErrors($validator)
                ->withInput();
            }
        }
        

        $user->equipe_id = $request->equipe;
        $user->regra_id = $request->regra;
        $user->save();
        $user->roles()->sync($request->roles);

        return redirect()->route('users.edit', $user)->with('info', 'Usuário atualizado com sucesso!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        $loggedId = Auth::id();

        if($loggedId !== $user->id){
            $user->delete();
            return redirect()->route('users.index')->with('info', 'Usuário excluido com sucesso!');
        }
        return redirect()->route('users.index')->with('danger', 'Você não pode excluir seu próprio usuário!');
        
    }

    public function getVendedores(Request $request, $id){
        if($request->ajax()){
            $vendedores = User::vendedores($id);
            return response()->json($vendedores);
        }
    }
}
