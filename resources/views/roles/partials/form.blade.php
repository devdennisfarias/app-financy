<div class="col-md-3">
    <div class="form-group">
        {!! Form::label('name', 'Nome', ['class' => 'bmd-label-floating']) !!}
        {!! Form::text('name', null, ['class' => 'form-control']) !!}
        @error('name')
            <small class="text-danger">
                {{ $message }}
            </small>
        @enderror
    </div>
</div>


<div class="row">

    <div class="col-md-3">
        <div class="card">
            <div class="card-body">
                <h4>Dashboard</h4>
                @foreach ($permissions as $permission)
                    @if ($permission->group == 'home')
                        <div class="form-group">
                            <label class="bmd-label-floating">
                                {!! Form::checkbox('permissions[]', $permission->id, null, ['class' => 'mr-2']) !!}
                                {{ $permission->description }}
                            </label>
                        </div>
                    @endif
                @endforeach
            </div>
        </div>
    </div>

    <div class="col-md-3">
        <div class="card">
            <div class="card-body">
                <h4>Clientes</h4>
                @foreach ($permissions as $permission)
                    @if ($permission->group == 'clientes')
                        <div class="form-group">
                            <label class="bmd-label-floating">
                                {!! Form::checkbox('permissions[]', $permission->id, null, ['class' => 'mr-2']) !!}
                                {{ $permission->description }}
                            </label>
                        </div>
                    @endif
                @endforeach
            </div>
        </div>
    </div>

    <div class="col-md-3">
        <div class="card">
            <div class="card-body">
                <h4>Propostas</h4>
                @foreach ($permissions as $permission)
                    @if ($permission->group == 'propostas')
                        <div class="form-group">
                            <label class="bmd-label-floating">
                                {!! Form::checkbox('permissions[]', $permission->id, null, ['class' => 'mr-2']) !!}
                                {{ $permission->description }}
                            </label>
                        </div>
                    @endif
                @endforeach
            </div>
        </div>
    </div>

    <div class="col-md-3">
        <div class="card">
            <div class="card-body">
                <h4>Esteira</h4>
                @foreach ($permissions as $permission)
                    @if ($permission->group == 'esteira')
                        <div class="form-group">
                            <label class="bmd-label-floating">
                                {!! Form::checkbox('permissions[]', $permission->id, null, ['class' => 'mr-2']) !!}
                                {{ $permission->description }}
                            </label>
                        </div>
                    @endif
                @endforeach
            </div>
        </div>
    </div>

    <div class="col-md-3">
        <div class="card">
            <div class="card-body">
                <h4>Atendimentos</h4>
                @foreach ($permissions as $permission)
                    @if ($permission->group == 'atendimentos')
                        <div class="form-group">
                            <label class="bmd-label-floating">
                                {!! Form::checkbox('permissions[]', $permission->id, null, ['class' => 'mr-2']) !!}
                                {{ $permission->description }}
                            </label>
                        </div>
                    @endif
                @endforeach
            </div>
        </div>
    </div>

    <div class="col-md-3">
        <div class="card">
            <div class="card-body">
                <h4>Situações</h4>
                @foreach ($permissions as $permission)
                    @if ($permission->group == 'status')
                        <div class="form-group">
                            <label class="bmd-label-floating">
                                {!! Form::checkbox('permissions[]', $permission->id, null, ['class' => 'mr-2']) !!}
                                {{ $permission->description }}
                            </label>
                        </div>
                    @endif
                @endforeach
            </div>
        </div>
    </div>

    <div class="col-md-3">
        <div class="card">
            <div class="card-body">
                <h4>Usuários</h4>
                @foreach ($permissions as $permission)
                    @if ($permission->group == 'users')
                        <div class="form-group">
                            <label class="bmd-label-floating">
                                {!! Form::checkbox('permissions[]', $permission->id, null, ['class' => 'mr-2']) !!}
                                {{ $permission->description }}
                            </label>
                        </div>
                    @endif
                @endforeach
            </div>
        </div>
    </div>

    <div class="col-md-3">
        <div class="card">
            <div class="card-body">
                <h4>Permissões</h4>
                @foreach ($permissions as $permission)
                    @if ($permission->group == 'roles')
                        <div class="form-group">
                            <label class="bmd-label-floating">
                                {!! Form::checkbox('permissions[]', $permission->id, null, ['class' => 'mr-2']) !!}
                                {{ $permission->description }}
                            </label>
                        </div>
                    @endif
                @endforeach
            </div>
        </div>
    </div>

    <div class="col-md-3">
        <div class="card">
            <div class="card-body">
                <h4>Lojas</h4>
                @foreach ($permissions as $permission)
                    @if ($permission->group == 'lojas')
                        <div class="form-group">
                            <label class="bmd-label-floating">
                                {!! Form::checkbox('permissions[]', $permission->id, null, ['class' => 'mr-2']) !!}
                                {{ $permission->description }}
                            </label>
                        </div>
                    @endif
                @endforeach
            </div>
        </div>
    </div>

    <div class="col-md-3">
        <div class="card">
            <div class="card-body">
                <h4>Equipes</h4>
                @foreach ($permissions as $permission)
                    @if ($permission->group == 'equipes')
                        <div class="form-group">
                            <label class="bmd-label-floating">
                                {!! Form::checkbox('permissions[]', $permission->id, null, ['class' => 'mr-2']) !!}
                                {{ $permission->description }}
                            </label>
                        </div>
                    @endif
                @endforeach
            </div>
        </div>
    </div>

    <div class="col-md-3">
        <div class="card">
            <div class="card-body">
                <h4>Produtos</h4>
                @foreach ($permissions as $permission)
                    @if ($permission->group == 'produtos')
                        <div class="form-group">
                            <label class="bmd-label-floating">
                                {!! Form::checkbox('permissions[]', $permission->id, null, ['class' => 'mr-2']) !!}
                                {{ $permission->description }}
                            </label>
                        </div>
                    @endif
                @endforeach
            </div>
        </div>
    </div>

    <div class="col-md-3">
        <div class="card">
            <div class="card-body">
                <h4>Comissões</h4>
                @foreach ($permissions as $permission)
                    @if ($permission->group == 'comissoes')
                        <div class="form-group">
                            <label class="bmd-label-floating">
                                {!! Form::checkbox('permissions[]', $permission->id, null, ['class' => 'mr-2']) !!}
                                {{ $permission->description }}
                            </label>
                        </div>
                    @endif
                @endforeach
            </div>
        </div>
    </div>

    <div class="col-md-3">
        <div class="card">
            <div class="card-body">
                <h4>Tabelas</h4>
                @foreach ($permissions as $permission)
                    @if ($permission->group == 'tabelas')
                        <div class="form-group">
                            <label class="bmd-label-floating">
                                {!! Form::checkbox('permissions[]', $permission->id, null, ['class' => 'mr-2']) !!}
                                {{ $permission->description }}
                            </label>
                        </div>
                    @endif
                @endforeach
            </div>
        </div>
    </div>

    <div class="col-md-3">
        <div class="card">
            <div class="card-body">
                <h4>Regras</h4>
                @foreach ($permissions as $permission)
                    @if ($permission->group == 'regras')
                        <div class="form-group">
                            <label class="bmd-label-floating">
                                {!! Form::checkbox('permissions[]', $permission->id, null, ['class' => 'mr-2']) !!}
                                {{ $permission->description }}
                            </label>
                        </div>
                    @endif
                @endforeach
            </div>
        </div>
    </div>

    <div class="col-md-3">
        <div class="card">
            <div class="card-body">
                <h4>Metas</h4>
                @foreach ($permissions as $permission)
                    @if ($permission->group == 'metas')
                        <div class="form-group">
                            <label class="bmd-label-floating">
                                {!! Form::checkbox('permissions[]', $permission->id, null, ['class' => 'mr-2']) !!}
                                {{ $permission->description }}
                            </label>
                        </div>
                    @endif
                @endforeach
            </div>
        </div>
    </div>

    <div class="col-md-3">
        <div class="card">
            <div class="card-body">
                <h4>Produção</h4>
                @foreach ($permissions as $permission)
                    @if ($permission->group == 'producao')
                        <div class="form-group">
                            <label class="bmd-label-floating">
                                {!! Form::checkbox('permissions[]', $permission->id, null, ['class' => 'mr-2']) !!}
                                {{ $permission->description }}
                            </label>
                        </div>
                    @endif
                @endforeach
            </div>
        </div>
    </div>
    
    <div class="col-md-3">
        <div class="card">
            <div class="card-body">
                <h4>Minha Carteira de Clientes</h4>
                @foreach ($permissions as $permission)
                    @if ($permission->group == 'minha-carteira')
                        <div class="form-group">
                            <label class="bmd-label-floating">
                                {!! Form::checkbox('permissions[]', $permission->id, null, ['class' => 'mr-2']) !!}
                                {{ $permission->description }}
                            </label>
                        </div>
                    @endif
                @endforeach
            </div>
        </div>
    </div>

    <div class="col-md-3">
        <div class="card">
            <div class="card-body">
                <h4>Minhas Propostas</h4>
                @foreach ($permissions as $permission)
                    @if ($permission->group == 'minhas-propostas')
                        <div class="form-group">
                            <label class="bmd-label-floating">
                                {!! Form::checkbox('permissions[]', $permission->id, null, ['class' => 'mr-2']) !!}
                                {{ $permission->description }}
                            </label>
                        </div>
                    @endif
                @endforeach
            </div>
        </div>
    </div>

    <div class="col-md-3">
        <div class="card">
            <div class="card-body">
                <h4>Minha Produção</h4>
                @foreach ($permissions as $permission)
                    @if ($permission->group == 'minha-producao')
                        <div class="form-group">
                            <label class="bmd-label-floating">
                                {!! Form::checkbox('permissions[]', $permission->id, null, ['class' => 'mr-2']) !!}
                                {{ $permission->description }}
                            </label>
                        </div>
                    @endif
                @endforeach
            </div>
        </div>
    </div>

</div>
