<?php

    include "conexao.php";
    $connect = mysqli_connect("localhost:3306","root","amora321","vida_animal");

    echo "conexao efetuada";

    $nome_animal = $_POST["nome"];
    $especie_animal = $_POST["especie"];
    $raca_animal = $_POST["raca"];
    $idade_animal = $_POST["idade"];
    $sexo_animal = $_POST["sexo"];
    $porte_animal = $_POST["porte"];

    mysqli_query($connect,"INSERT INTO animais (nome,especie,raca,idade,porte,sexo) values ('$nome_animal','$especie_animal','$raca_animal','$idade_animal','$idade_animal','$porte_animal','$sexo_animal')");

    echo "query efetuada."



?>