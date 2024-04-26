<?php

require "conexao-mysql.php";

$pdo = conexaoMysql();

$especialidade = $_GET["especialidade"] ?? NULL;
$nomeMedico = $_GET["medico"] ?? NULL;
$data = $_GET["data"] ?? NULL;

$sql = <<<SQL
    SELECT a.horario
    FROM agenda a
    INNER JOIN medico m
    ON a.codigo_medico = m.codigo
    INNER JOIN pessoa p
    ON m.codigo = p.codigo
    WHERE m.especialidade = ?
    AND p.nome = ?
    AND a.data = ?;
SQL;

try {
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$especialidade, $nomeMedico, $data]);
    $horariosDisponiveis = $stmt->fetchAll();
    header("Content-type: application/json; charset=utf-8");
    echo json_encode($horariosDisponiveis);
} catch (PDOException $e) {
    http_response_code(500);
    header("Content-type: application/json; charset=utf-8");
    echo json_encode(["erro" => "Ocorreu um erro ao tentar buscar os horários disponíveis."]);
    exit();
}