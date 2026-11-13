<?php

    header("Content-Type: application/json; charset=utf-8");

    include "conexao.php";

    if (!$connect) {
        http_response_code(500);
        echo json_encode(["erro" => "Erro na conexão: " . mysqli_connect_error()]);
        exit;
    }

    if ($_SERVER["REQUEST_METHOD"] === "POST") {
        $usuario_id = (int) ($_POST["usuario_id"] ?? 0);
        $animais_id = (int) ($_POST["animais_id"] ?? 0);
        $justificativa = trim($_POST["justificativa"] ?? "");
        $statos = "Em análise";

        if ($usuario_id <= 0 || $animais_id <= 0 || $justificativa === "") {
            http_response_code(400);
            echo json_encode(["erro" => "Interessado, animal e justificativa são obrigatórios."]);
            mysqli_close($connect);
            exit;
        }

        $stmt = mysqli_prepare($connect, "INSERT INTO solicitacao_adocao (animais_id, usuario_id, `motivação`, statos) VALUES (?, ?, ?, ?)");
        if (!$stmt) {
            http_response_code(500);
            echo json_encode(["erro" => "Erro ao preparar query: " . mysqli_error($connect)]);
            mysqli_close($connect);
            exit;
        }

        mysqli_stmt_bind_param($stmt, "iiss", $animais_id, $usuario_id, $justificativa, $statos);

        if (mysqli_stmt_execute($stmt)) {
            echo json_encode([
                "status" => "ok",
                "mensagem" => "Solicitação cadastrada com sucesso.",
                "id" => mysqli_insert_id($connect)
            ]);
        } else {
            http_response_code(500);
            echo json_encode(["erro" => "Erro ao executar query: " . mysqli_stmt_error($stmt)]);
        }

        mysqli_stmt_close($stmt);
    } elseif ($_SERVER["REQUEST_METHOD"] === "GET") {
        $sql = "SELECT s.id,
                       COALESCE(u.nome, CONCAT('Usuário #', s.usuario_id)) AS interessado,
                       COALESCE(a.nome, CONCAT('Animal #', s.animais_id)) AS animal,
                       s.`motivação` AS justificativa,
                       s.statos AS etapa
                FROM solicitacao_adocao s
                LEFT JOIN usuario u ON u.id = s.usuario_id
                LEFT JOIN animais a ON a.id = s.animais_id
                ORDER BY s.id DESC";

        $resultado = mysqli_query($connect, $sql);
        if (!$resultado) {
            http_response_code(500);
            echo json_encode(["erro" => "Erro ao consultar solicitações: " . mysqli_error($connect)]);
            mysqli_close($connect);
            exit;
        }

        $solicitacoes = [];
        while ($linha = mysqli_fetch_assoc($resultado)) {
            $solicitacoes[] = $linha;
        }

        echo json_encode($solicitacoes);
    } else {
        http_response_code(405);
        echo json_encode(["erro" => "Método não permitido."]);
    }

    mysqli_close($connect);

?>
