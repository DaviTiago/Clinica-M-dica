<?php

require "conexao-mysql.php";
require "sessionVerification.php";
session_start();
exitWhenNotLoggedIn();

$pdo = conexaoMysql();

$nome = $_POST["nome"] ?? NULL;
$sexo = $_POST["sexo"] ?? NULL;
$email = $_POST["email"] ?? NULL;
$telefone = $_POST["telefone"] != "" ? $_POST["telefone"] : NULL;
$cep = $_POST["cep"] ?? NULL;
$logradouro = $_POST["logradouro"] ?? NULL;
$cidade = $_POST["cidade"] ?? NULL;
$estado = $_POST["estado"] ?? NULL;
$inicioContrato = $_POST["data-inicio"] ?? NULL;
$salario = $_POST["salario"] ?? NULL;
$senhaHash = password_hash(($_POST["senha"]), PASSWORD_DEFAULT) ?? NULL;
$especialidade = $_POST["especialidade"] ?? NULL;
$crm = $_POST["crm"] ?? NULL;

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
        INSERT INTO funcionario (codigo, data_contrato, salario, senha_hash)
        VALUES (?, ?, ?, ?);
    SQL;

    $stmt2 = $pdo->prepare($sql2);
    $stmt2->execute([$codigoPessoa, $inicioContrato, $salario, $senhaHash]);

    if (!empty($especialidade) && !empty($crm)) {
        $sql3 = <<<SQL
            INSERT INTO medico (codigo, especialidade, crm)
            VALUES (?, ?, ?);
        SQL;

        $stmt3 = $pdo->prepare($sql3);
        $stmt3->execute([$codigoPessoa, $especialidade, $crm]);
    }

    $pdo->commit();
    header("Content-type: application/json; charset=utf-8");
    echo json_encode(["sucesso" => "Funcionário cadastrado com sucesso."]);
} catch (PDOException $e) {
    $pdo->rollBack();
    http_response_code(500);
    header("Content-type: application/json; charset=utf-8");
    echo json_encode(["erro" => "Ocorreu um erro ao tentar cadastrar o funcionário." . $e->getMessage()]);
    exit();
} catch (Exception $e) {
    $pdo->rollBack();
    http_response_code(500);
    header("Content-type: application/json; charset=utf-8");
    echo json_encode(["erro" => "Ocorreu um erro inesperado."]);
    exit();
}
