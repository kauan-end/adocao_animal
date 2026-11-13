<?php

    header("Content-Type: application/json; charset=utf-8");

    include "conexao.php";

    if (!$connect) {
        http_response_code(500);
        echo json_encode(["erro" => "Erro na conexão: " . mysqli_connect_error()]);
        exit;
    }

    if ($_SERVER["REQUEST_METHOD"] === "POST") {
        $nome_animal = $_POST["nome"] ?? "";
        $especie_animal = $_POST["especie"] ?? "";
        $raca_animal = $_POST["raca"] ?? "";
        $idade_animal = (int) ($_POST["idade"] ?? 0);
        $sexo_animal = $_POST["sexo"] ?? "";
        $porte_animal = $_POST["porte"] ?? "";

        $stmt = mysqli_prepare($connect, "INSERT INTO animais (nome, especie, raca, idade, porte, sexo) VALUES (?, ?, ?, ?, ?, ?)");
        if (!$stmt) {
            http_response_code(500);
            echo json_encode(["erro" => "Erro ao preparar query: " . mysqli_error($connect)]);
            mysqli_close($connect);
            exit;
        }

        mysqli_stmt_bind_param($stmt, "sssiss", $nome_animal, $especie_animal, $raca_animal, $idade_animal, $porte_animal, $sexo_animal);

        if (mysqli_stmt_execute($stmt)) {
            echo json_encode(["status" => "ok", "mensagem" => "Animal cadastrado com sucesso."]);
        } else {
            http_response_code(500);
            echo json_encode(["erro" => "Erro ao executar query: " . mysqli_stmt_error($stmt)]);
        }

        mysqli_stmt_close($stmt);
    } elseif ($_SERVER["REQUEST_METHOD"] === "GET") {
        $resultado = mysqli_query($connect, "SELECT * FROM animais");
        if (!$resultado) {
            http_response_code(500);
            echo json_encode(["erro" => "Erro ao consultar animais: " . mysqli_error($connect)]);
            mysqli_close($connect);
            exit;
        }

        $animais = [];
        while ($linha = mysqli_fetch_assoc($resultado)) {
            $animais[] = $linha;
        }

        echo json_encode($animais);
    } else {
        http_response_code(405);
        echo json_encode(["erro" => "Método não permitido."]);
    }

    mysqli_close($connect);

?>