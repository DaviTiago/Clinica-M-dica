<?php

require "conexao-mysql.php";
require "sessionVerification.php";

session_start();
exitWhenNotMedico();


$pdo = conexaoMysql();

$nome = htmlspecialchars($_POST["nome"]) ?? NULL;
$sexo = htmlspecialchars($_POST["sexo"]) ?? NULL;
$email = htmlspecialchars($_POST["email"]) ?? NULL;
$telefone = htmlspecialchars($_POST["telefone"]) != "" ? htmlspecialchars($_POST["telefone"]) : NULL;
$cep = htmlspecialchars($_POST["cep"]) ?? NULL;
$logradouro = htmlspecialchars($_POST["logradouro"]) ?? NULL;
$cidade = htmlspecialchars($_POST["cidade"]) ?? NULL;
$estado = htmlspecialchars($_POST["estado"]) ?? NULL;
$peso = htmlspecialchars($_POST["peso"]) ?? NULL;
$altura = htmlspecialchars($_POST["altura"]) ?? NULL;
$tipoSanguineo = htmlspecialchars($_POST["tipo-sanguineo"]) ?? NULL;

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
} catch (PDOException $e) {
    $pdo->rollBack();
    http_response_code(500);
    header("Content-type: application/json; charset=utf-8");
    echo json_encode(["erro" => "Ocorreu um erro ao tentar cadastrar o paciente."]);
    exit();
} catch (Exception $e) {
    $pdo->rollBack();
    http_response_code(500);
    header("Content-type: application/json; charset=utf-8");
    echo json_encode(["erro" => "Ocorreu um erro inesperado."]);
    exit();
}
