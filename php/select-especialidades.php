<?php

require "conexao-mysql.php";

$pdo = conexaoMysql();

$sql = <<<SQL
    SELECT DISTINCT m.especialidade
    FROM medico m;
SQL;

$stmt = $pdo->query($sql);

$especialidades = $stmt->fetchAll();

header("Content-type: application/json; charset=utf-8");
echo json_encode($especialidades);