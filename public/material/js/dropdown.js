/*$("#loja").change(function(event){
    $.get("lista-equipes/"+event.target.value+"",function(response, loja){
        console.log(response);
        $("#equipe").empty();
        for(var i=0; i<response.length; i++){
            $("#equipe").append("<option value='"+response[i].id+"'> "+response[i].equipe+"</option>");
        }        
    });
});*/

$("#loja").change(event => {
    $.get(`lista-equipes/${event.target.value}`, function(response, loja){
        $("#equipe").empty();
        $("#vendedor").empty();
        $("#vendedor").append(`<option value="0">Selecione um vendedor</option>`);
        $("#equipe").append(`<option value="0">Selecione uma equipe</option>`);
        response.forEach(element => {
            $("#equipe").append(`<option value=${element.id}> ${element.equipe} </option>`);
        });
    });
});

$("#equipe").change(event => {
    $.get(`lista-vendedores/${event.target.value}`, function(response, equipe){
        $("#vendedor").empty();
        $("#vendedor").append(`<option value="0">Selecione um vendedor</option>`);
        response.forEach(element => {
            $("#vendedor").append(`<option value=${element.id}> ${element.name} </option>`);
        });
    });
});

$("#lojaUser").change(event => {
    $.get(`../lista-equipes/${event.target.value}`, function(response, loja){
        $("#equipeUser").empty();
        $("#equipeUser").append(`<option value="0">Selecione uma equipe</option>`);
        response.forEach(element => {
            $("#equipeUser").append(`<option value=${element.id}> ${element.equipe} </option>`);
        });
    });
});

$("#lojaUserEdit").change(event => {
    $.get(`../../lista-equipes/${event.target.value}`, function(response, loja){
        $("#equipeUserEdit").empty();
        $("#equipeUserEdit").append(`<option value="0">Selecione uma equipe</option>`);
        response.forEach(element => {
            $("#equipeUserEdit").append(`<option value=${element.id}> ${element.equipe} </option>`);
        });
    });
});