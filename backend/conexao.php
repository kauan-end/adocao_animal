<?php

    $connect = mysqli_connect("localhost:3306", "root", "amora321", "vida_animal");

    if ($connect) {
        mysqli_set_charset($connect, "utf8mb4");
    }

?>