<?php
require "conexao-mysql.php";
session_start();

$pdo = conexaoMysql();

$email = htmlspecialchars($_SESSION['user']);

try {
    $sql = <<<SQL
    SELECT a.nome, a.data, a.horario
    FROM agenda a
    INNER JOIN medico m
    ON a.codigo_medico = m.codigo
    INNER JOIN pessoa p
    ON m.codigo = p.codigo
    WHERE p.email = ?
    SQL;

    $stmt = $pdo->prepare($sql);
    $stmt->execute([$email]);
    $listagem = $stmt->fetchAll();
} catch (Exception $e) {
    exit('Ocorreu uma falha: ' . $e->getMessage());
}

header("Content-type: application/json; charset=UTF-8");
echo json_encode($listagem);