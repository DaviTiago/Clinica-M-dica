<?php

require "conexao-mysql.php";

$pdo = conexaoMysql();

$nome = htmlspecialchars($_POST["nome"]) ?? "";
$sexo = htmlspecialchars($_POST["sexo"]) ?? "";
$email = htmlspecialchars($_POST["email"]) ?? "";
$telefone = !empty($_POST["telefone"]) ? htmlspecialchars($_POST["telefone"]) : NULL;
$cep = htmlspecialchars($_POST["cep"]) ?? "";
$logradouro = htmlspecialchars($_POST["logradouro"]) ?? "";
$cidade = htmlspecialchars($_POST["cidade"]) ?? "";
$estado = htmlspecialchars($_POST["estado"]) ?? "";
$peso = htmlspecialchars($_POST["peso"]) ?? "";
$altura = htmlspecialchars($_POST["altura"]) ?? "";
$tipoSanguineo = htmlspecialchars($_POST["tipo-sanguineo"]) ?? "";

try {
    $pdo->beginTransaction();

    $sql1 = <<<SQL
        INSERT INTO pessoa (nome, sexo, email, telefone, cep, logradouro, cidade, estado)
        VALUES (?, ?, ?, ?, ?, ?, ?, ?);
    SQL;

    $stmt1 = $pdo->prepare($sql1);
    $stmt1->execute([$nome, $sexo, $email, $telefone, $cep, $logradouro, $cidade, $estado]);

    $codigoPessoa = $pdo->lastInsertId();

    $sql2 = <<<SQL
        INSERT INTO paciente (codigo, peso, altura, tipo_sanguineo)
        VALUES (?, ?, ?, ?);
    SQL;

    $stmt2 = $pdo->prepare($sql2);
    $stmt2->execute([$codigoPessoa, $peso, $altura, $tipoSanguineo]);

    $pdo->commit();
    header("Location: https://ppi-matheus.infinityfreeapp.com/Clinica-Medica/cadastro-paciente.html");
} catch (Exception $e) {
    $pdo->rollBack();
    exit("Erro ao cadastrar paciente: " . $e->getMessage());
}