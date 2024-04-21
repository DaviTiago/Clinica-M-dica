<?php
require "conexao-mysql.php";
$pdo = conexaoMysql();

try {

    $sql = <<<SQL
    SELECT a.data, a.horario, m.codigo
    FROM agenda a INNER JOIN medico m 
    ON a.codigo_medico = m.codigo
    SQL;

    $stmt = $pdo->query($sql);
    $listagem = $stmt->fetchAll();
} catch (Exception $e) {
    exit('Ocorreu uma falha: ' . $e->getMessage());
}

header("Content-type: application/json; charset=UTF-8");
echo json_encode($listagem);
