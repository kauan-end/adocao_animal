
async function cadastrarAnimal() {

    var form = document.getElementById('formAnimal');

    var dados = new FormData(form);

    var promise = await fetch("php/animais.php", {
        method: "POST",
        body: dados
    });

    var resposta = await promise.json();

    console.log(resposta);

    carregarAnimais();

}


async function cadastrarInteressado() {

    var form = document.getElementById('formInteressado');

    var dados = new FormData(form);

    var promise = await fetch("php/interessados.php", {
        method: "POST",
        body: dados
    });

    var resposta = await promise.json();

    console.log(resposta);

    carregarInteressados();

}


async function solicitarAdocao() {

    var form = document.getElementById('formAdocao');

    var dados = new FormData(form);

    var promise = await fetch("php/solicitacoes.php", {
        method: "POST",
        body: dados
    });

    var resposta = await promise.json();

    console.log(resposta);

    carregarSolicitacoes();

}


async function carregarAnimais() {

    var promise = await fetch("php/animais.php", {
        method: "GET"
    });

    var resposta = await promise.json();

    console.log(resposta);

    var tabela = document.getElementById('listaAnimais');

    tabela.innerHTML = "";

    resposta.forEach(function(animal) {

        adicionarLinha('listaAnimais', [
            animal.nome,
            animal.especie,
            animal.raca,
            animal.idade,
            animal.sexo,
            animal.porte,
            animal.descricao
        ]);

    });

}


async function carregarInteressados() {

    var promise = await fetch("php/interessados.php", {
        method: "GET"
    });

    var resposta = await promise.json();

    console.log(resposta);

    var tabela = document.getElementById('listaInteressados');

    tabela.innerHTML = "";

    resposta.forEach(function(interessado) {

        adicionarLinha('listaInteressados', [
            interessado.nome,
            interessado.email,
            interessado.telefone
        ]);

    });

}


async function carregarSolicitacoes() {

    var promise = await fetch("php/solicitacoes.php", {
        method: "GET"
    });

    var resposta = await promise.json();

    console.log(resposta);

    var tabela = document.getElementById('listaSolicitacoes');

    tabela.innerHTML = "";

    resposta.forEach(function(solicitacao) {

        adicionarLinha('listaSolicitacoes', [
            solicitacao.interessado,
            solicitacao.animal,
            solicitacao.justificativa
        ]);

    });

}


async function acompanhar() {

    var promise = await fetch("php/acompanhamento.php", {
        method: "GET"
    });

    var resposta = await promise.json();

    console.log(resposta);

    var tabela = document.getElementById('historico');

    tabela.innerHTML = "";

    resposta.forEach(function(item) {

        adicionarLinha('historico', [
            item.solicitacao,
            item.etapa,
            item.observacao
        ]);

    });

}


async function atualizarAcompanhamento() {

    var form = document.getElementById('formAcompanhamento');

    var dados = new FormData(form);

    var promise = await fetch("php/acompanhamento.php", {
        method: "POST",
        body: dados
    });

    var resposta = await promise.json();

    console.log(resposta);

    acompanhar();

}


async function administrar() {

    var promise = await fetch("php/administracao.php", {
        method: "GET"
    });

    var resposta = await promise.json();

    console.log(resposta);

    var tabela = document.getElementById('listaAdmin');

    tabela.innerHTML = "";

    resposta.forEach(function(solicitacao) {

        adicionarLinha('listaAdmin', [
            solicitacao.interessado,
            solicitacao.animal,
            solicitacao.justificativa,
            solicitacao.status
        ]);

    });

}


async function decidirSolicitacao() {

    var form = document.getElementById('formAdmin');

    var dados = new FormData(form);

    var promise = await fetch("php/administracao.php", {
        method: "POST",
        body: dados
    });

    var resposta = await promise.json();

    console.log(resposta);

    administrar();

}



function adicionarLinha(idTabela, valores) {

    var tabela = document.getElementById(idTabela);

    var linha = document.createElement('tr');

    valores.forEach(function(valor) {

        var coluna = document.createElement('td');

        coluna.textContent = valor ?? "";

        linha.appendChild(coluna);

    });

    tabela.appendChild(linha);

}




carregarAnimais();

carregarInteressados();

carregarSolicitacoes();
