<?php

    header("Content-Type: application/json; charset=utf-8");

    include "conexao.php";

    if (!$connect) {
        http_response_code(500);
        echo json_encode(["erro" => "Erro na conexão: " . mysqli_connect_error()]);
        exit;
    }

    if ($_SERVER["REQUEST_METHOD"] === "POST") {
        $nome = trim($_POST["nome"] ?? "");
        $email = trim($_POST["email"] ?? "");
        $telefone = trim($_POST["telefone"] ?? "");
        $senha = substr($_POST["senha"] ?? "", 0, 10);

        if ($nome === "" || $email === "") {
            http_response_code(400);
            echo json_encode(["erro" => "Nome e e-mail são obrigatórios."]);
            mysqli_close($connect);
            exit;
        }

        $stmt = mysqli_prepare($connect, "INSERT INTO usuario (nome, email, telefone, senha) VALUES (?, ?, ?, ?)");
        if (!$stmt) {
            http_response_code(500);
            echo json_encode(["erro" => "Erro ao preparar query: " . mysqli_error($connect)]);
            mysqli_close($connect);
            exit;
        }

        mysqli_stmt_bind_param($stmt, "ssss", $nome, $email, $telefone, $senha);

        if (mysqli_stmt_execute($stmt)) {
            echo json_encode([
                "status" => "ok",
                "mensagem" => "Interessado cadastrado com sucesso.",
                "id" => mysqli_insert_id($connect)
            ]);
        } else {
            http_response_code(500);
            echo json_encode(["erro" => "Erro ao executar query: " . mysqli_stmt_error($stmt)]);
        }

        mysqli_stmt_close($stmt);
    } elseif ($_SERVER["REQUEST_METHOD"] === "GET") {
        $resultado = mysqli_query($connect, "SELECT id, nome, email, telefone FROM usuario ORDER BY id DESC");
        if (!$resultado) {
            http_response_code(500);
            echo json_encode(["erro" => "Erro ao consultar interessados: " . mysqli_error($connect)]);
            mysqli_close($connect);
            exit;
        }

        $interessados = [];
        while ($linha = mysqli_fetch_assoc($resultado)) {
            $interessados[] = $linha;
        }

        echo json_encode($interessados);
    } else {
        http_response_code(405);
        echo json_encode(["erro" => "Método não permitido."]);
    }

    mysqli_close($connect);

?>
