<?php

require "conexao-mysql.php";

$pdo = conexaoMysql();

$nome = htmlspecialchars($_POST["nome"]) ?? "";
$sexo = htmlspecialchars($_POST["sexo"]) ?? "";
$email = htmlspecialchars($_POST["email"]) ?? "";
$telefone = htmlspecialchars($_POST["telefone"]) ?? "";
$telefone = preg_replace("/\D/", '', $telefone) ?? "";
$cep = htmlspecialchars($_POST["cep"]) ?? "";
$logradouro = htmlspecialchars($_POST["logradouro"]) ?? "";
$cidade = htmlspecialchars($_POST["cidade"]) ?? "";
$estado = htmlspecialchars($_POST["estado"]) ?? "";
$inicioContrato = htmlspecialchars($_POST["data-inicio"]) ?? "";
$salario = htmlspecialchars($_POST["salario"]) ?? "";
$senhaHash = password_hash(htmlspecialchars($_POST["senha"]), PASSWORD_DEFAULT) ?? "";
$especialidade = htmlspecialchars($_POST["especialidade"]) ?? "";
$crm = htmlspecialchars($_POST["crm"]) ?? "";

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

    if(!empty($especialidade) && !empty($crm)) {
        $sql3 = <<<SQL
            INSERT INTO medico (codigo, especialidade, crm)
            VALUES (?, ?, ?);
        SQL;

        $stmt3 = $pdo->prepare($sql3);
        $stmt3->execute([$codigoPessoa, $especialidade, $crm]);
    }

    $pdo->commit();
} catch (Exception $e) {
    $pdo->rollBack();
    exit("Erro ao cadastrar funcionário: " . $e->getMessage());
}