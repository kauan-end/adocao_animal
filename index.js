
async function cadastrarAnimal() {

    var form = document.getElementById('formAnimal');
    var dados = new FormData(form);

    var promise = await fetch("backend/animais.php", {
        method: "POST",
        body: dados
    });

    var resposta = await promise.json();

    if (promise.ok) {
        alert(resposta.mensagem || "Animal cadastrado com sucesso!");
        form.reset();
    } else {
        alert(resposta.mensagem || "Erro ao cadastrar animal");
    }

    carregarAnimais();
}


async function editarAnimal() {

    var form = document.getElementById('formEditarAnimal');
    var dados = new FormData(form);
    dados.append("acao", "editar");

    var promise = await fetch("backend/animais.php", {
        method: "POST",
        body: dados
    });

    var resposta = await promise.json();

    if (promise.ok) {
        alert(resposta.mensagem || "Animal atualizado com sucesso!");
        form.reset();
    } else {
        alert(resposta.mensagem || "Erro ao atualizar animal");
    }

    carregarAnimais();
    carregarSolicitacoes();
    administrar();
}


async function excluirAnimal() {

    var form = document.getElementById('formExcluirAnimal');
    var dados = new FormData(form);
    dados.append("acao", "excluir");

    var promise = await fetch("backend/animais.php", {
        method: "POST",
        body: dados
    });

    var resposta = await promise.json();

    if (promise.ok) {
        alert(resposta.mensagem || "Animal excluído com sucesso!");
        form.reset();
    } else {
        alert(resposta.mensagem || "Erro ao excluir animal");
    }

    carregarAnimais();
    carregarSolicitacoes();
    acompanhar();
    administrar();
}


async function cadastrarInteressado() {

    var form = document.getElementById('formInteressado');
    var dados = new FormData(form);

    var promise = await fetch("backend/interessados.php", {
        method: "POST",
        body: dados
    });

    var resposta = await promise.json();

    if (promise.ok) {
        alert(resposta.mensagem || "Usuário cadastrado com sucesso!");
        form.reset();
    } else {
        alert(resposta.mensagem || "Erro ao cadastrar usuário");
    }

    carregarInteressados();
}


async function editarInteressado() {

    var form = document.getElementById('formEditarInteressado');
    var dados = new FormData(form);
    dados.append("acao", "editar");

    var promise = await fetch("backend/interessados.php", {
        method: "POST",
        body: dados
    });

    var resposta = await promise.json();

    if (promise.ok) {
        alert(resposta.mensagem || "Usuário atualizado com sucesso!");
        form.reset();
    } else {
        alert(resposta.mensagem || "Erro ao atualizar usuário");
    }

    carregarInteressados();
    carregarSolicitacoes();
    administrar();
}


async function excluirInteressado() {

    var form = document.getElementById('formExcluirInteressado');
    var dados = new FormData(form);
    dados.append("acao", "excluir");

    var promise = await fetch("backend/interessados.php", {
        method: "POST",
        body: dados
    });

    var resposta = await promise.json();

    if (promise.ok) {
        alert(resposta.mensagem || "Usuário excluído com sucesso!");
        form.reset();
    } else {
        alert(resposta.mensagem || "Erro ao excluir usuário");
    }

    carregarInteressados();
    carregarSolicitacoes();
    acompanhar();
    administrar();
}


async function solicitarAdocao() {

    var form = document.getElementById('formAdocao');
    var dados = new FormData(form);

    var promise = await fetch("backend/solicitacoes.php", {
        method: "POST",
        body: dados
    });

    var resposta = await promise.json();

    if (promise.ok) {
        alert(resposta.mensagem || "Solicitação registrada com sucesso!");
        form.reset();
    } else {
        alert(resposta.mensagem || "Erro ao registrar solicitação");
    }

    carregarSolicitacoes();
    acompanhar();
    administrar();
}


async function excluirSolicitacao() {

    var form = document.getElementById('formExcluirSolicitacao');
    var dados = new FormData(form);
    dados.append("acao", "excluir");

    var promise = await fetch("backend/solicitacoes.php", {
        method: "POST",
        body: dados
    });

    var resposta = await promise.json();

    if (promise.ok) {
        alert(resposta.mensagem || "Solicitação excluída com sucesso!");
        form.reset();
    } else {
        alert(resposta.mensagem || "Erro ao excluir solicitação");
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

    var tabela = document.getElementById('listaAnimais');
    tabela.innerHTML = "";

    var selectAnimal = document.getElementById('animalSelect');
    var selectEditar = document.getElementById('animalEditarSelect');
    var selectExcluir = document.getElementById('animalExcluirSelect');

    if (selectAnimal) {
        selectAnimal.innerHTML = '<option value="">Selecione</option>';
    }
    if (selectEditar) {
        selectEditar.innerHTML = '<option value="">Selecione</option>';
    }
    if (selectExcluir) {
        selectExcluir.innerHTML = '<option value="">Selecione</option>';
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

        var textoOpcao = (animal.nome || ('Animal #' + animal.id)) + ' (' + (animal.especie || '') + ')';

        if (selectAnimal) {
            var opt = document.createElement('option');
            opt.value = animal.id;
            opt.textContent = textoOpcao;
            selectAnimal.appendChild(opt);
        }

        if (selectEditar) {
            var optEditar = document.createElement('option');
            optEditar.value = animal.id;
            optEditar.textContent = textoOpcao;
            selectEditar.appendChild(optEditar);
        }

        if (selectExcluir) {
            var optExcluir = document.createElement('option');
            optExcluir.value = animal.id;
            optExcluir.textContent = textoOpcao;
            selectExcluir.appendChild(optExcluir);
        }

    });

}


async function carregarInteressados() {

    var promise = await fetch("backend/interessados.php", {
        method: "GET"
    });

    var resposta = await promise.json();

    var tabela = document.getElementById('listaInteressados');
    tabela.innerHTML = "";

    var selectInteressado = document.getElementById('interessadoSelect');
    var selectEditar = document.getElementById('interessadoEditarSelect');
    var selectExcluir = document.getElementById('interessadoExcluirSelect');

    if (selectInteressado) {
        selectInteressado.innerHTML = '<option value="">Selecione</option>';
    }
    if (selectEditar) {
        selectEditar.innerHTML = '<option value="">Selecione</option>';
    }
    if (selectExcluir) {
        selectExcluir.innerHTML = '<option value="">Selecione</option>';
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

        if (selectEditar) {
            var optEditar = document.createElement('option');
            optEditar.value = interessado.id;
            optEditar.textContent = interessado.nome + ' (' + interessado.email + ')';
            selectEditar.appendChild(optEditar);
        }

        if (selectExcluir) {
            var optExcluir = document.createElement('option');
            optExcluir.value = interessado.id;
            optExcluir.textContent = interessado.nome + ' (' + interessado.email + ')';
            selectExcluir.appendChild(optExcluir);
        }

    });

}


async function carregarSolicitacoes() {

    var promise = await fetch("backend/solicitacoes.php", {
        method: "GET"
    });

    var resposta = await promise.json();

    var tabela = document.getElementById('listaSolicitacoes');
    tabela.innerHTML = "";

    var selectSolicitacao = document.getElementById('solicitacaoSelect');
    var selectExcluir = document.getElementById('solicitacaoExcluirSelect');

    if (selectSolicitacao) {
        selectSolicitacao.innerHTML = '<option value="">Selecione</option>';
    }
    if (selectExcluir) {
        selectExcluir.innerHTML = '<option value="">Selecione</option>';
    }

    resposta.forEach(function(solicitacao) {

        adicionarLinha('listaSolicitacoes', [
            solicitacao.interessado,
            solicitacao.animal,
            solicitacao.justificativa
        ]);

        var textoSolicitacao = '#' + solicitacao.id + ' - ' + solicitacao.interessado + ' / ' + solicitacao.animal;

        if (selectSolicitacao) {
            var opt = document.createElement('option');
            opt.value = solicitacao.id;
            opt.textContent = textoSolicitacao;
            selectSolicitacao.appendChild(opt);
        }

        if (selectExcluir) {
            var optExcluir = document.createElement('option');
            optExcluir.value = solicitacao.id;
            optExcluir.textContent = textoSolicitacao;
            selectExcluir.appendChild(optExcluir);
        }

    });

}


async function acompanhar() {

    var promise = await fetch("backend/acompanhamentos.php", {
        method: "GET"
    });

    var resposta = await promise.json();

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

    if (promise.ok) {
        alert(resposta.mensagem || "Acompanhamento atualizado com sucesso!");
        form.reset();
    } else {
        alert(resposta.mensagem || "Erro ao atualizar acompanhamento");
    }

    acompanhar();
    administrar();

}


// ADMINISTRAÇÃO - FUNÇÕES ADICIONADAS

async function administrar() {

    var promise = await fetch("backend/administracao.php", {
        method: "GET"
    });

    var resposta = await promise.json();

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

    if (promise.ok) {
        alert(resposta.mensagem || "Decisão registrada com sucesso!");
        form.reset();
        administrar();
        acompanhar();
    } else {
        alert(resposta.mensagem || "Erro ao registrar decisão");
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
    var linkAdocao = document.getElementById('linkAdocao');
    var linkAcompanhamento = document.getElementById('linkAcompanhamento');
    var linkAdmin = document.getElementById('linkAdmin');

    if (resposta.logado) {
        linkLogin.style.display = "none";
        btnLogout.style.display = "inline-block";
        linkAdocao.style.display = "inline-block";
        linkAcompanhamento.style.display = "inline-block";
        linkAdmin.style.display = "inline-block";
        statusSessao.textContent = "Olá, " + (resposta.usuario_nome || "usuário");
    } else {
        linkLogin.style.display = "inline-block";
        btnLogout.style.display = "none";
        linkAdocao.style.display = "none";
        linkAcompanhamento.style.display = "none";
        linkAdmin.style.display = "none";
        statusSessao.textContent = "";
    }

}


carregarAnimais();

carregarInteressados();

carregarSolicitacoes();

acompanhar();

administrar();

verificarSessao();
