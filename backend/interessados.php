<?php
session_start();
header("Content-Type: application/json; charset=utf-8");
include "conexao.php";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $acao = $_POST["acao"] ?? "cadastrar";

    if ($acao !== "cadastrar" && !isset($_SESSION["usuario_id"])) {
        http_response_code(401);
        echo json_encode(["status" => "erro", "mensagem" => "Faça login para editar ou excluir usuários."]);
        exit;
    }

    if ($acao === "excluir") {
        $id = (int) ($_POST["id"] ?? 0);
        if ($id <= 0) {
            http_response_code(400);
            echo json_encode(["status" => "erro", "mensagem" => "Selecione um usuário válido para excluir."]);
            exit;
        }

        $stmt = mysqli_prepare($connect, "DELETE FROM usuario WHERE id = ?");
        mysqli_stmt_bind_param($stmt, "i", $id);
        mysqli_stmt_execute($stmt);

        echo json_encode(["status" => "ok", "mensagem" => "Usuário excluído com sucesso!"]);
        exit;
    }

    $nome = trim($_POST["nome"] ?? "");
    $email = trim($_POST["email"] ?? "");
    $telefone = trim($_POST["telefone"] ?? "");

    if ($nome === "" || $email === "") {
        http_response_code(400);
        echo json_encode(["status" => "erro", "mensagem" => "Nome e e-mail são obrigatórios."]);
        exit;
    }

    if ($acao === "editar") {
        $id = (int) ($_POST["id"] ?? 0);
        if ($id <= 0) {
            http_response_code(400);
            echo json_encode(["status" => "erro", "mensagem" => "Selecione um usuário válido para editar."]);
            exit;
        }

        $stmt = mysqli_prepare($connect, "UPDATE usuario SET nome = ?, email = ?, telefone = ? WHERE id = ?");
        mysqli_stmt_bind_param($stmt, "sssi", $nome, $email, $telefone, $id);
        mysqli_stmt_execute($stmt);

        echo json_encode(["status" => "ok", "mensagem" => "Usuário atualizado com sucesso!"]);
        exit;
    }

    $senha = $_POST["senha"] ?? "";
    if ($senha === "") {
        http_response_code(400);
        echo json_encode(["status" => "erro", "mensagem" => "A senha é obrigatória para o cadastro."]);
        exit;
    }

    $senhaHash = password_hash($senha, PASSWORD_DEFAULT);

    $stmt = mysqli_prepare($connect, "INSERT INTO usuario (nome, email, telefone, senha) VALUES (?, ?, ?, ?)");
    mysqli_stmt_bind_param($stmt, "ssss", $nome, $email, $telefone, $senhaHash);
    $ok = mysqli_stmt_execute($stmt);

    if (!$ok) {
        http_response_code(400);
        echo json_encode(["status" => "erro", "mensagem" => "Erro ao cadastrar usuário (verifique se o e-mail já existe)."]);
        exit;
    }

    echo json_encode(["status" => "ok", "mensagem" => "Usuário cadastrado com sucesso!"]);
} else {
    $res = mysqli_query($connect, "SELECT id, nome, email, telefone FROM usuario");
    echo json_encode(mysqli_fetch_all($res, MYSQLI_ASSOC));
}
?>
