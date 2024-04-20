<?php

require "conexao-mysql.php";

$pdo = conexaoMysql();

$especialidade = htmlspecialchars($_GET["especialidade"]) ?? "";
$nomeMedico = htmlspecialchars($_GET["medico"]) ?? "";
$data = htmlspecialchars($_GET["data"]) ?? "";

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

$stmt = $pdo->prepare($sql);
$stmt->execute([$especialidade, $nomeMedico, $data]);
$horariosDisponiveis = $stmt->fetchAll();

header("Content-type: application/json; charset=utf-8");
echo json_encode($horariosDisponiveis);