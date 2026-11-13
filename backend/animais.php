<?php
header("Content-Type: application/json; charset=utf-8");
include "conexao.php";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $nome = $_POST["nome"] ?? "";
    $especie = $_POST["especie"] ?? "";
    $raca = $_POST["raca"] ?? "";
    $idade = (int) ($_POST["idade"] ?? 0);
    $porte = $_POST["porte"] ?? "";
    $sexo = $_POST["sexo"] ?? "";

    $stmt = mysqli_prepare($connect, "INSERT INTO animais (nome, especie, raca, idade, porte, sexo) VALUES (?, ?, ?, ?, ?, ?)");
    mysqli_stmt_bind_param($stmt, "sssiss", $nome, $especie, $raca, $idade, $porte, $sexo);
    mysqli_stmt_execute($stmt);

    echo json_encode(["status" => "ok"]);
} else {
    $res = mysqli_query($connect, "SELECT * FROM animais");
    echo json_encode(mysqli_fetch_all($res, MYSQLI_ASSOC));
}
?>
