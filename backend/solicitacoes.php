<?php
session_start();
header("Content-Type: application/json; charset=utf-8");
include "conexao.php";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    if (!isset($_SESSION["usuario_id"])) {
        http_response_code(401);
        echo json_encode(["status" => "erro", "mensagem" => "Faça login para registrar ou gerenciar solicitações."]);
        exit;
    }

    $acao = $_POST["acao"] ?? "cadastrar";

    if ($acao === "excluir") {
        $id = (int) ($_POST["solicitacao_id"] ?? 0);
        if ($id <= 0) {
            http_response_code(400);
            echo json_encode(["status" => "erro", "mensagem" => "Selecione uma solicitação válida para excluir."]);
            exit;
        }

        $stmt = mysqli_prepare($connect, "DELETE FROM solicitacao_adocao WHERE id = ?");
        mysqli_stmt_bind_param($stmt, "i", $id);
        mysqli_stmt_execute($stmt);

        echo json_encode(["status" => "ok", "mensagem" => "Solicitação excluída com sucesso!"]);
        exit;
    }

    $animais_id = (int) ($_POST["animais_id"] ?? 0);
    $usuario_id = (int) ($_POST["usuario_id"] ?? 0);
    $justificativa = trim($_POST["justificativa"] ?? "");
    $statos = "Em análise";

    if ($animais_id <= 0 || $usuario_id <= 0 || $justificativa === "") {
        http_response_code(400);
        echo json_encode(["status" => "erro", "mensagem" => "Selecione o interessado, o animal e informe a justificativa."]);
        exit;
    }

    $stmt = mysqli_prepare($connect, "INSERT INTO solicitacao_adocao (animais_id, usuario_id, `motivação`, statos) VALUES (?, ?, ?, ?)");
    mysqli_stmt_bind_param($stmt, "iiss", $animais_id, $usuario_id, $justificativa, $statos);
    mysqli_stmt_execute($stmt);

    echo json_encode(["status" => "ok", "mensagem" => "Solicitação registrada com sucesso!"]);
} else {
    $sql = "SELECT s.id, u.nome AS interessado, a.nome AS animal, s.`motivação` AS justificativa, s.statos AS status
            FROM solicitacao_adocao s
            INNER JOIN usuario u ON u.id = s.usuario_id
            INNER JOIN animais a ON a.id = s.animais_id";
    $res = mysqli_query($connect, $sql);
    echo json_encode(mysqli_fetch_all($res, MYSQLI_ASSOC));
}
?>
