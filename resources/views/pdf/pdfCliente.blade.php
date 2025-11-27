<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>PDF</title>
</head>

<body>

    <h3><strong>Nome: </strong>{{ $cliente->nome }}<br></h3>
    <strong>CPF: </strong>{{ $cliente->cpf }}<br>
    <strong>RG: </strong>{{ $cliente->rg }}<br>
    <strong>Telefone: </strong>{{ $cliente->telefone_1 }}<br>
    <strong>Telefone 2: </strong>{{ $cliente->telefone_2 }}<br>
    <strong>Telefone 3: </strong>{{ $cliente->telefone_3 }}<br>
    <strong>Data Nascimento: </strong>{{ $cliente->data_nascimento }}<br>
    <strong>Orgão: </strong>{{ $cliente->orgao_1 }}<br>
    <strong>Salário: </strong>{{ $cliente->salario_1 }}<br>

</body>

</html>
