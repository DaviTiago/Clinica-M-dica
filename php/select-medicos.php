<?php

require "conexao-mysql.php";

$pdo = conexaoMysql();
$especialidade = $_GET["especialidade"] ?? NULL;

$sql = <<<SQL
    SELECT pe.nome
    FROM pessoa pe
    INNER JOIN medico m
    ON pe.codigo = m.codigo
    WHERE m.especialidade = ?
    ORDER BY pe.nome; 
SQL;

try {
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$especialidade]);
    $medicos = $stmt->fetchAll();
    header("Content-type: application/json; charset=utf-8");
    echo json_encode($medicos);
} catch (PDOException $e) {
    http_response_code(500);
    header("Content-type: application/json; charset=utf-8");
    echo json_encode(["erro" => "Ocorreu um erro ao tentar buscar os médicos."]);
    exit();
}