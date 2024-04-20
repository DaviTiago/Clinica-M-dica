<?php

require "conexao-mysql.php";

$pdo = conexaoMysql();
$especialidade = htmlspecialchars($_GET["especialidade"]) ?? "";

$sql = <<<SQL
    SELECT pe.nome
    FROM pessoa pe
    INNER JOIN medico m
    ON pe.codigo = m.codigo
    WHERE m.especialidade = ?; 
SQL;

$stmt = $pdo->prepare($sql);
$stmt->execute([$especialidade]);
$medicos = $stmt->fetchAll();

header("Content-type: application/json; charset=utf-8");
echo json_encode($medicos);