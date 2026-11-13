<?php
header("Content-Type: application/json; charset=utf-8");
include "conexao.php";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $nome = $_POST["nome"] ?? "";
    $email = $_POST["email"] ?? "";
    $telefone = $_POST["telefone"] ?? "";
    $senha = "";

    $stmt = mysqli_prepare($connect, "INSERT INTO usuario (nome, email, telefone, senha) VALUES (?, ?, ?, ?)");
    mysqli_stmt_bind_param($stmt, "ssss", $nome, $email, $telefone, $senha);
    mysqli_stmt_execute($stmt);

    echo json_encode(["status" => "ok"]);
} else {
    $res = mysqli_query($connect, "SELECT id, nome, email, telefone FROM usuario");
    echo json_encode(mysqli_fetch_all($res, MYSQLI_ASSOC));
}
?>
