<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;



class RoleController extends Controller
{

    public function __construct()
    {
        $this->middleware('can:roles.index')->only('index');
        $this->middleware('can:roles.create')->only('create', 'store');
        $this->middleware('can:roles.edit')->only('edit', 'update');
        $this->middleware('can:roles.destroy')->only('destroy');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $roles = Role::paginate();
        return view('roles.index', compact('roles'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $permissions = Permission::all();

        return view('roles.create', compact('permissions'));
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
            'name' => 'required'
        ]);

        $role = Role::create(['name' => $request->name]);
        $role->permissions()->sync($request->permissions);

        return redirect()->route('roles.edit', $role)->with('info', 'Permissão criada com sucesso!');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Role $role)
    {
        return view('roles.show', compact('role'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Role $role)
    {
        $permissions = Permission::all();
        return view('roles.edit', compact('role', 'permissions'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Role $role)
    {
        $request->validate([
            'name' => 'required'
        ]);

        // Não permitir alterar nome das permissões padrãos do sistema, para a consistencia do mesmo
        if($role->id <= 4 && $role->name != $request->name){
            return redirect()->route('roles.edit', $role)
            ->with('danger', 'Nome da permissão não pode ser alterado!');    
        }
        
        $role->name = $request->name;
        $role->save();
        $role->permissions()->sync($request->permissions);
        return redirect()->route('roles.edit', $role)->with('info', 'Permissão atualizada com sucesso!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Role $role)
    {
        // Não permitir excluir as permissões padrãos do sistema, para a consistencia do mesmo
        if($role->id > 4){
            $role->delete();
        } else {
            return redirect()->route('roles.index')->with('danger', 'Permissão não pode ser excluída!');    
        }

        return redirect()->route('roles.index')->with('info', 'Permissão excluída com sucesso!');
    }
}
