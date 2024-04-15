<?php

require "conexao-mysql.php";

$pdo = conexaoMysql();

$cep = htmlspecialchars($_POST["cep"]) ?? "";
$logradouro = htmlspecialchars($_POST["logradouro"]) ?? "";
$cidade = htmlspecialchars($_POST["cidade"]) ?? "";
$estado = htmlspecialchars($_POST["estado"]) ?? "";

$sql = <<<SQL
    INSERT INTO base_enderecos
    VALUES (?, ?, ?, ?);
SQL;

$stmt = $pdo->prepare($sql);
$stmt->execute([$cep, $logradouro, $cidade, $estado]);

header("Location: https://ppi-matheus.infinityfreeapp.com/Clinica-Medica/cadastro-endereco.html");