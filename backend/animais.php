<?php
session_start();
header("Content-Type: application/json; charset=utf-8");
include "conexao.php";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    if (!isset($_SESSION["usuario_id"])) {
        http_response_code(401);
        echo json_encode(["status" => "erro", "mensagem" => "Faça login para gerenciar animais."]);
        exit;
    }

    $acao = $_POST["acao"] ?? "cadastrar";

    if ($acao === "excluir") {
        $id = (int) ($_POST["id"] ?? 0);
        if ($id <= 0) {
            http_response_code(400);
            echo json_encode(["status" => "erro", "mensagem" => "Selecione um animal válido para excluir."]);
            exit;
        }

        $stmt = mysqli_prepare($connect, "DELETE FROM animais WHERE id = ?");
        mysqli_stmt_bind_param($stmt, "i", $id);
        mysqli_stmt_execute($stmt);

        echo json_encode(["status" => "ok", "mensagem" => "Animal excluído com sucesso!"]);
        exit;
    }

    $nome = trim($_POST["nome"] ?? "");
    $especie = trim($_POST["especie"] ?? "");
    $raca = trim($_POST["raca"] ?? "");
    $idade = (int) ($_POST["idade"] ?? 0);
    $porte = trim($_POST["porte"] ?? "");
    $sexo = trim($_POST["sexo"] ?? "");
    $descricao = trim($_POST["descricao"] ?? "");

    if ($especie === "" || $sexo === "" || $porte === "") {
        http_response_code(400);
        echo json_encode(["status" => "erro", "mensagem" => "Preencha espécie, sexo e porte do animal."]);
        exit;
    }

    if ($acao === "editar") {
        $id = (int) ($_POST["id"] ?? 0);
        if ($id <= 0) {
            http_response_code(400);
            echo json_encode(["status" => "erro", "mensagem" => "Selecione um animal válido para editar."]);
            exit;
        }

        $stmt = mysqli_prepare($connect, "UPDATE animais SET nome = ?, especie = ?, raca = ?, idade = ?, porte = ?, sexo = ?, descricao = ? WHERE id = ?");
        mysqli_stmt_bind_param($stmt, "sssisssi", $nome, $especie, $raca, $idade, $porte, $sexo, $descricao, $id);
        mysqli_stmt_execute($stmt);

        echo json_encode(["status" => "ok", "mensagem" => "Animal atualizado com sucesso!"]);
        exit;
    }

    $stmt = mysqli_prepare($connect, "INSERT INTO animais (nome, especie, raca, idade, porte, sexo, descricao) VALUES (?, ?, ?, ?, ?, ?, ?)");
    mysqli_stmt_bind_param($stmt, "sssisss", $nome, $especie, $raca, $idade, $porte, $sexo, $descricao);
    mysqli_stmt_execute($stmt);

    echo json_encode(["status" => "ok", "mensagem" => "Animal cadastrado com sucesso!"]);
} else {
    $res = mysqli_query($connect, "SELECT * FROM animais");
    echo json_encode(mysqli_fetch_all($res, MYSQLI_ASSOC));
}
?>
