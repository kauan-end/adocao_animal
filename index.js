
async function cadastrarAnimal() {

    var form = document.getElementById('formAnimal');
    var dados = new FormData(form);

    var promise = await fetch("backend/animais.php", {
        method: "POST",
        body: dados
    });

    var resposta = await promise.json();

    console.log(resposta);

    if (promise.ok) {
        form.reset();
    }

    carregarAnimais();
}


async function cadastrarInteressado() {

    var form = document.getElementById('formInteressado');
    var dados = new FormData(form);

    var promise = await fetch("backend/interessados.php", {
        method: "POST",
        body: dados
    });

    var resposta = await promise.json();

    console.log(resposta);

    if (promise.ok) {
        form.reset();
    }

    carregarInteressados();
}


async function solicitarAdocao() {

    var form = document.getElementById('formAdocao');
    var dados = new FormData(form);

    var promise = await fetch("backend/solicitacoes.php", {
        method: "POST",
        body: dados
    });

    var resposta = await promise.json();

    console.log(resposta);

    if (promise.ok) {
        form.reset();
    }

    carregarSolicitacoes();
    acompanhar();
    administrar();
}


async function carregarAnimais() {

    var promise = await fetch("backend/animais.php", {
        method: "GET"
    });

    var resposta = await promise.json();

    console.log(resposta);

    var tabela = document.getElementById('listaAnimais');
    tabela.innerHTML = "";

    var selectAnimal = document.getElementById('animalSelect');

    if (selectAnimal) {
        selectAnimal.innerHTML = '<option value="">Selecione</option>';
    }

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

        if (selectAnimal) {
            var opt = document.createElement('option');
            opt.value = animal.id;
            opt.textContent = (animal.nome || ('Animal #' + animal.id)) + ' (' + (animal.especie || '') + ')';
            selectAnimal.appendChild(opt);
        }

    });

}


async function carregarInteressados() {

    var promise = await fetch("backend/interessados.php", {
        method: "GET"
    });

    var resposta = await promise.json();

    console.log(resposta);

    var tabela = document.getElementById('listaInteressados');
    tabela.innerHTML = "";

    var selectInteressado = document.getElementById('interessadoSelect');

    if (selectInteressado) {
        selectInteressado.innerHTML = '<option value="">Selecione</option>';
    }

    resposta.forEach(function(interessado) {

        adicionarLinha('listaInteressados', [
            interessado.nome,
            interessado.email,
            interessado.telefone
        ]);

        if (selectInteressado) {
            var opt = document.createElement('option');
            opt.value = interessado.id;
            opt.textContent = interessado.nome;
            selectInteressado.appendChild(opt);
        }

    });

}


async function carregarSolicitacoes() {

    var promise = await fetch("backend/solicitacoes.php", {
        method: "GET"
    });

    var resposta = await promise.json();

    console.log(resposta);

    var tabela = document.getElementById('listaSolicitacoes');
    tabela.innerHTML = "";

    var selectSolicitacao = document.getElementById('solicitacaoSelect');

    if (selectSolicitacao) {
        selectSolicitacao.innerHTML = '<option value="">Selecione</option>';
    }

    resposta.forEach(function(solicitacao) {

        adicionarLinha('listaSolicitacoes', [
            solicitacao.interessado,
            solicitacao.animal,
            solicitacao.justificativa
        ]);

        if (selectSolicitacao) {
            var opt = document.createElement('option');
            opt.value = solicitacao.id;
            opt.textContent = '#' + solicitacao.id + ' - ' + solicitacao.interessado + ' / ' + solicitacao.animal;
            selectSolicitacao.appendChild(opt);
        }

    });

}


async function acompanhar() {

    var promise = await fetch("backend/acompanhamentos.php", {
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

    var promise = await fetch("backend/acompanhamentos.php", {
        method: "POST",
        body: dados
    });

    var resposta = await promise.json();

    console.log(resposta);

    if (promise.ok) {
        form.reset();
    }

    acompanhar();

}


// ADMINISTRAÇÃO - FUNÇÕES ADICIONADAS

async function administrar() {

    var promise = await fetch("backend/administracao.php", {
        method: "GET"
    });

    var resposta = await promise.json();

    console.log(resposta);

    var tabela = document.getElementById('listaAdmin');
    tabela.innerHTML = "";

    var select = document.getElementById('solicitacaoAdmin');

    select.innerHTML = '<option value="">Selecione</option>';

    resposta.forEach(function(solicitacao) {

        adicionarLinha('listaAdmin', [
            solicitacao.interessado,
            solicitacao.animal,
            solicitacao.justificativa,
            solicitacao.status
        ]);

        var opcao = document.createElement('option');

        opcao.value = solicitacao.id;

        opcao.textContent = 'Solicitação #' + solicitacao.id;

        select.appendChild(opcao);

    });

}


async function decidirSolicitacao() {

    var form = document.getElementById('formAdmin');
    var dados = new FormData(form);

    var promise = await fetch("backend/administracao.php", {
        method: "POST",
        body: dados
    });

    var resposta = await promise.json();

    console.log(resposta);

    if (promise.ok) {
        form.reset();
        administrar();
    }

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



async function login() {

    var form = document.getElementById('formLogin');

    var dados = new FormData(form);

    var promise = await fetch("backend/login.php", {
        method: "POST",
        body: dados
    });

    var resposta = await promise.json();

    console.log(resposta);

    if (promise.ok) {
        form.reset();
        window.location.hash = "#inicio";
        verificarSessao();
    } else {
        alert(resposta.mensagem || "Erro ao fazer login");
    }

}


async function logout() {

    await fetch("backend/logout.php", {
        method: "POST"
    });

    verificarSessao();
    window.location.hash = "#login";

}


async function verificarSessao() {

    var promise = await fetch("backend/login.php", {
        method: "GET"
    });

    var resposta = await promise.json();

    var linkLogin = document.getElementById('linkLogin');
    var btnLogout = document.getElementById('btnLogout');
    var statusSessao = document.getElementById('statusSessao');

    if (resposta.logado) {
        linkLogin.style.display = "none";
        btnLogout.style.display = "inline-block";
        statusSessao.textContent = "Olá, " + (resposta.usuario_nome || "usuário");
    } else {
        linkLogin.style.display = "inline-block";
        btnLogout.style.display = "none";
        statusSessao.textContent = "";
    }

}


carregarAnimais();

carregarInteressados();

carregarSolicitacoes();

acompanhar();

administrar();

verificarSessao();
