<?php

require "conexao-mysql.php";

$pdo = conexaoMysql();

$nome = htmlspecialchars($_POST["nome"]) ?? "";
$sexo = htmlspecialchars($_POST["sexo"]) ?? "";
$email = htmlspecialchars($_POST["email"]);
$especialidade = htmlspecialchars($_POST["especialidade"]);
$nomeMedico = htmlspecialchars($_POST["medico"]);
$data = htmlspecialchars($_POST["data"]) ?? "";
$horario = htmlspecialchars($_POST["horario"]) ?? "";

try {
    $pdo->beginTransaction();

    $sql1 = <<<SQL
        SELECT pe.codigo
        FROM pessoa pe
        INNER JOIN medico m
        ON pe.codigo = m.codigo
        WHERE m.especialidade = ? 
        AND pe.nome = ?;
    SQL;

    $stmt1 = $pdo->prepare($sql1);
    $stmt1->execute([$especialidade, $nomeMedico]);
    $result = $stmt1->fetch();
    $codigoMedico = $result['codigo'];

    $sql2 = <<<SQL
        INSERT INTO agenda (codigo_medico, data, horario, nome, sexo, email)
        VALUES (?, ?, ?, ?, ?, ?);
    SQL;

    $stmt2 = $pdo->prepare($sql2);
    $stmt2->execute([$codigoMedico, $data, $horario, $nome, $sexo, $email]);

    $pdo->commit();

    header("Location: https://ppi-matheus.infinityfreeapp.com/Clinica-Medica/agendamento.html");
} catch (Exception $e) {
    $pdo->rollBack();
    exit("Ocorreu um erro ao tentar realizar o agendamento: " . $e->getMessage());
}