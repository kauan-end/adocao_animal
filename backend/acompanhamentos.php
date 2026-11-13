<?php
header("Content-Type: application/json; charset=utf-8");
include "conexao.php";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $solicitacao_id = (int) ($_POST["solicitacao_id"] ?? 0);
    $etapa = $_POST["etapa"] ?? "";

    $stmt = mysqli_prepare($connect, "UPDATE solicitacao_adocao SET statos = ? WHERE id = ?");
    mysqli_stmt_bind_param($stmt, "si", $etapa, $solicitacao_id);
    mysqli_stmt_execute($stmt);

    echo json_encode(["status" => "ok"]);
} else {
    $res = mysqli_query($connect, "SELECT id AS solicitacao, statos AS etapa, '' AS observacao FROM solicitacao_adocao");
    echo json_encode(mysqli_fetch_all($res, MYSQLI_ASSOC));
}
?>
