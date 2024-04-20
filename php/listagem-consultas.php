<?php

require "conexao-mysql.php";
$pdo = conexaoMysql();

try {

    $sql = <<<SQL
    SELECT m.codigo, m.especialidade, p.nome, a.data, a.horario
    FROM pessoa p INNER JOIN medico m ON p.codigo = m.codigo 
    INNER JOIN agenda a ON m.codigo = a.codigo_medico
    ORDER BY a.horario
    SQL;

    $stmt = $pdo->query($sql);
    $listagem = $stmt->fetchAll();
} catch (Exception $e) {
    exit('Ocorreu uma falha: ' . $e->getMessage());
}

header("Content-type: application/json; charset=UTF-8");
echo json_encode($listagem);
