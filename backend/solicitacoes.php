<?php
header("Content-Type: application/json; charset=utf-8");
include "conexao.php";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $animais_id = (int) ($_POST["animais_id"] ?? 0);
    $usuario_id = (int) ($_POST["usuario_id"] ?? 0);
    $justificativa = $_POST["justificativa"] ?? "";
    $statos = "Em análise";

    $stmt = mysqli_prepare($connect, "INSERT INTO solicitacao_adocao (animais_id, usuario_id, `motivação`, statos) VALUES (?, ?, ?, ?)");
    mysqli_stmt_bind_param($stmt, "iiss", $animais_id, $usuario_id, $justificativa, $statos);
    mysqli_stmt_execute($stmt);

    echo json_encode(["status" => "ok"]);
} else {
    $sql = "SELECT s.id, u.nome AS interessado, a.nome AS animal, s.`motivação` AS justificativa
            FROM solicitacao_adocao s
            LEFT JOIN usuario u ON u.id = s.usuario_id
            LEFT JOIN animais a ON a.id = s.animais_id";
    $res = mysqli_query($connect, $sql);
    echo json_encode(mysqli_fetch_all($res, MYSQLI_ASSOC));
}
?>
