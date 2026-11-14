<?php
session_start();
header("Content-Type: application/json; charset=utf-8");
include "conexao.php";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    if (!isset($_SESSION["usuario_id"])) {
        http_response_code(401);
        echo json_encode(["status" => "erro", "mensagem" => "Faça login para atualizar o acompanhamento."]);
        exit;
    }

    $solicitacao_id = (int) ($_POST["solicitacao_id"] ?? 0);
    $etapa = trim($_POST["etapa"] ?? "");
    $observacao = trim($_POST["observacao"] ?? "");

    if ($solicitacao_id <= 0 || $etapa === "") {
        http_response_code(400);
        echo json_encode(["status" => "erro", "mensagem" => "Selecione a solicitação e a etapa."]);
        exit;
    }

    $stmt = mysqli_prepare($connect, "UPDATE solicitacao_adocao SET statos = ?, observacao = ? WHERE id = ?");
    mysqli_stmt_bind_param($stmt, "ssi", $etapa, $observacao, $solicitacao_id);
    mysqli_stmt_execute($stmt);

    echo json_encode(["status" => "ok", "mensagem" => "Acompanhamento atualizado com sucesso!"]);
} else {
    $res = mysqli_query($connect, "SELECT id AS solicitacao, statos AS etapa, COALESCE(observacao, '') AS observacao FROM solicitacao_adocao");
    echo json_encode(mysqli_fetch_all($res, MYSQLI_ASSOC));
}
?>
