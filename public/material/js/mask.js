$(document).ready(function(){
    $('#cpf').mask('000.000.000-00');
    $('#cpfModal').mask('000.000.000-00');
    $('#valor_bruto').mask('999.999.990,00', {reverse:true});
    $('#valor_liquido_liberado').mask('999.999.990,00', {reverse:true});
    $('#valor_parcela').mask('999.999.990,00', {reverse:true});
    $('#salario_1').mask('999.999.990,00', {reverse:true});
    $('#salario_1Modal').mask('999.999.990,00', {reverse:true});
    $('#salario_2').mask('999.999.990,00', {reverse:true});
    $('#salario_2Modal').mask('999.999.990,00', {reverse:true});
    $('#tx_juros').mask('0,0 %', {reverse:true});
    $('.regraComissao').mask('990,00%', {reverse:true});

    /* mask celular e fixo */
    $("#telefone_1").mask("(00) 0000-00009")
    $("#telefone_1").blur(function(event){
        if($(this).val().length == 15){
            $("#telefone_1").mask("(00) 00000-0009")
        }else{
            $("#telefone_1").mask("(00) 0000-00009")
        }
    })
    $("#telefone_1Modal").mask("(00) 0000-00009")
    $("#telefone_1Modal").blur(function(event){
        if($(this).val().length == 15){
            $("#telefone_1Modal").mask("(00) 00000-0009")
        }else{
            $("#telefone_1Modal").mask("(00) 0000-00009")
        }
    })

    $("#telefone_2").mask("(00) 0000-00009")
    $("#telefone_2").blur(function(event){
        if($(this).val().length == 15){
            $("#telefone_2").mask("(00) 00000-0009")
        }else{
            $("#telefone_2").mask("(00) 0000-00009")
        }
    })
    $("#telefone_2Modal").mask("(00) 0000-00009")
    $("#telefone_2Modal").blur(function(event){
        if($(this).val().length == 15){
            $("#telefone_2Modal").mask("(00) 00000-0009")
        }else{
            $("#telefone_2Modal").mask("(00) 0000-00009")
        }
    })

    $("#telefone_3").mask("(00) 0000-00009")
    $("#telefone_3").blur(function(event){
        if($(this).val().length == 15){
            $("#telefone_3").mask("(00) 00000-0009")
        }else{
            $("#telefone_3").mask("(00) 0000-00009")
        }
    })
    $("#telefone_3Modal").mask("(00) 0000-00009")
    $("#telefone_3Modal").blur(function(event){
        if($(this).val().length == 15){
            $("#telefone_3Modal").mask("(00) 00000-0009")
        }else{
            $("#telefone_3Modal").mask("(00) 0000-00009")
        }
    })
})