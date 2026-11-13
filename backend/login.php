<?php
session_start();
header("Content-Type: application/json; charset=utf-8");
include "conexao.php";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $email = trim($_POST["email"] ?? "");
    $senha = $_POST["senha"] ?? "";

    $stmt = mysqli_prepare($connect, "SELECT id, nome, senha FROM usuario WHERE email = ? LIMIT 1");
    mysqli_stmt_bind_param($stmt, "s", $email);
    mysqli_stmt_execute($stmt);
    $res = mysqli_stmt_get_result($stmt);
    $user = mysqli_fetch_assoc($res);

    if (!$user || !password_verify($senha, $user["senha"])) {
        http_response_code(401);
        echo json_encode(["status" => "erro", "mensagem" => "E-mail ou senha inválidos"]);
        exit;
    }

    session_regenerate_id(true);
    $_SESSION["usuario_id"] = (int) $user["id"];
    $_SESSION["usuario_nome"] = $user["nome"];

    echo json_encode([
        "status" => "ok",
        "usuario_id" => $_SESSION["usuario_id"],
        "usuario_nome" => $_SESSION["usuario_nome"],
    ]);
    exit;
}

echo json_encode([
    "logado" => isset($_SESSION["usuario_id"]),
    "usuario_id" => $_SESSION["usuario_id"] ?? null,
    "usuario_nome" => $_SESSION["usuario_nome"] ?? null,
]);
