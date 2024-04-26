<?php

require "conexao-mysql.php";

$pdo = conexaoMysql();

$nome = $_POST["nome"] ?? NULL;
$sexo = $_POST["sexo"] ?? NULL;
$email = $_POST["email"] ?? NULL;
$especialidade = $_POST["especialidade"] ?? NULL; 
$nomeMedico = $_POST["medico"] ?? NULL;
$data = $_POST["data"] ?? NULL;
$horario = $_POST["horario"] ?? NULL;

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

    if ($result === false) {
        throw new Exception("Médico não encontrado");
    }

    $codigoMedico = $result['codigo'];

    $sql2 = <<<SQL
        INSERT INTO agenda (codigo_medico, data, horario, nome, sexo, email)
        VALUES (?, ?, ?, ?, ?, ?);
    SQL;

    $stmt2 = $pdo->prepare($sql2);
    $stmt2->execute([$codigoMedico, $data, $horario, $nome, $sexo, $email]);

    if ($stmt2->rowCount() === 0) {
        throw new Exception("Falha ao inserir na agenda");
    }

    $pdo->commit();

    header("Content-type: application/json; charset=utf-8");
    echo json_encode(["sucesso" => "Funcionário cadastrado com sucesso."]);
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