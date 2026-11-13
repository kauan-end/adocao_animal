<?php

    header("Content-Type: application/json; charset=utf-8");

    include "conexao.php";

    if (!$connect) {
        http_response_code(500);
        echo json_encode(["erro" => "Erro na conexão: " . mysqli_connect_error()]);
        exit;
    }

    if ($_SERVER["REQUEST_METHOD"] === "POST") {
        $solicitacao_id = (int) ($_POST["solicitacao_id"] ?? 0);
        $etapa = trim($_POST["etapa"] ?? "");

        if ($solicitacao_id <= 0 || $etapa === "") {
            http_response_code(400);
            echo json_encode(["erro" => "Solicitação e etapa são obrigatórias."]);
            mysqli_close($connect);
            exit;
        }

        $stmt = mysqli_prepare($connect, "UPDATE solicitacao_adocao SET statos = ? WHERE id = ?");
        if (!$stmt) {
            http_response_code(500);
            echo json_encode(["erro" => "Erro ao preparar query: " . mysqli_error($connect)]);
            mysqli_close($connect);
            exit;
        }

        mysqli_stmt_bind_param($stmt, "si", $etapa, $solicitacao_id);

        if (mysqli_stmt_execute($stmt)) {
            echo json_encode(["status" => "ok", "mensagem" => "Acompanhamento atualizado com sucesso."]);
        } else {
            http_response_code(500);
            echo json_encode(["erro" => "Erro ao executar query: " . mysqli_stmt_error($stmt)]);
        }

        mysqli_stmt_close($stmt);
    } elseif ($_SERVER["REQUEST_METHOD"] === "GET") {
        $sql = "SELECT s.id,
                       CONCAT('#', s.id, ' - ', COALESCE(u.nome, 'Interessado'), ' / ', COALESCE(a.nome, 'Animal')) AS solicitacao,
                       COALESCE(s.statos, '') AS etapa,
                       '' AS observacao
                FROM solicitacao_adocao s
                LEFT JOIN usuario u ON u.id = s.usuario_id
                LEFT JOIN animais a ON a.id = s.animais_id
                ORDER BY s.id DESC";

        $resultado = mysqli_query($connect, $sql);
        if (!$resultado) {
            http_response_code(500);
            echo json_encode(["erro" => "Erro ao consultar acompanhamento: " . mysqli_error($connect)]);
            mysqli_close($connect);
            exit;
        }

        $historico = [];
        while ($linha = mysqli_fetch_assoc($resultado)) {
            $historico[] = $linha;
        }

        echo json_encode($historico);
    } else {
        http_response_code(405);
        echo json_encode(["erro" => "Método não permitido."]);
    }

    mysqli_close($connect);

?>
