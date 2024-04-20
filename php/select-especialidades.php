<?php

require "conexao-mysql.php";

$pdo = conexaoMysql();

$sql = <<<SQL
    SELECT DISTINCT m.especialidade
    FROM medico m;
SQL;

try {
    $stmt = $pdo->query($sql);
    $especialidades = $stmt->fetchAll();
    header("Content-type: application/json; charset=utf-8");
    echo json_encode($especialidades);
} catch (PDOException $e) {
    http_response_code(500);
    header("Content-type: application/json; charset=utf-8");
    echo json_encode(["erro" => "Ocorreu um erro ao tentar buscar as especialidades."]);
    exit();
}