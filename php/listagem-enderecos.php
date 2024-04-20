<?php

require "conexao-mysql.php";
$pdo = conexaoMysql();

try {

    $sql = <<<SQL
    SELECT b.cep, b.logradouro, b.cidade, b.estado 
    FROM base_enderecos b
    SQL;

    $stmt = $pdo->query($sql);
    $listagem = $stmt->fetchAll();
} catch (Exception $e) {
    exit('Ocorreu uma falha: ' . $e->getMessage());
}

header("Content-type: application/json; charset=UTF-8");
echo json_encode($listagem);
