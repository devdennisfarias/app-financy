@csrf

<div class="row">
    <div class="col-md-8">
        <div class="form-group">
            <label class="bmd-label-floating">Nome *</label>
            <input type="text" name="nome" class="form-control"
                   value="{{ old('nome', $fornecedor->nome ?? '') }}" required>
        </div>
    </div>

    <div class="col-md-4">
        <div class="form-group">
            <label class="bmd-label-floating">Documento (CNPJ/CPF)</label>
            <input type="text" name="documento" class="form-control"
                   value="{{ old('documento', $fornecedor->documento ?? '') }}">
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-4">
        <div class="form-group">
            <label class="bmd-label-floating">Telefone</label>
            <input type="text" name="telefone" class="form-control"
                   value="{{ old('telefone', $fornecedor->telefone ?? '') }}">
        </div>
    </div>

    <div class="col-md-4">
        <div class="form-group">
            <label class="bmd-label-floating">Email</label>
            <input type="email" name="email" class="form-control"
                   value="{{ old('email', $fornecedor->email ?? '') }}">
        </div>
    </div>

    <div class="col-md-4">
        <div class="form-group">
            <label class="bmd-label-floating">Pessoa de contato</label>
            <input type="text" name="contato" class="form-control"
                   value="{{ old('contato', $fornecedor->contato ?? '') }}">
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-12">
        <div class="form-group">
            <label class="bmd-label-floating">Endereço</label>
            <input type="text" name="endereco" class="form-control"
                   value="{{ old('endereco', $fornecedor->endereco ?? '') }}">
        </div>
    </div>
</div>

@if($errors->any())
    <div class="alert alert-danger mt-3">
        <ul class="mb-0">
            @foreach($errors->all() as $e)
                <li>{{ $e }}</li>
            @endforeach
        </ul>
    </div>
@endif
