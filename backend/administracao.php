<?php
session_start();
header("Content-Type: application/json; charset=utf-8");
include "conexao.php";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    if (!isset($_SESSION["usuario_id"])) {
        http_response_code(401);
        echo json_encode(["status" => "erro", "mensagem" => "Faça login para administrar solicitações."]);
        exit;
    }

    $solicitacao_id = (int) ($_POST["solicitacao_id"] ?? 0);
    $status = trim($_POST["status"] ?? "");

    if ($solicitacao_id <= 0 || $status === "") {
        http_response_code(400);
        echo json_encode(["status" => "erro", "mensagem" => "Selecione a solicitação e a decisão."]);
        exit;
    }

    $stmt = mysqli_prepare($connect, "UPDATE solicitacao_adocao SET statos = ? WHERE id = ?");
    mysqli_stmt_bind_param($stmt, "si", $status, $solicitacao_id);
    mysqli_stmt_execute($stmt);

    echo json_encode(["status" => "ok", "mensagem" => "Decisão registrada com sucesso!"]);
} else {
    $sql = "SELECT s.id, u.nome AS interessado, a.nome AS animal, s.`motivação` AS justificativa, s.statos AS status
            FROM solicitacao_adocao s
            INNER JOIN usuario u ON u.id = s.usuario_id
            INNER JOIN animais a ON a.id = s.animais_id";
    $res = mysqli_query($connect, $sql);
    echo json_encode(mysqli_fetch_all($res, MYSQLI_ASSOC));
}
?>
