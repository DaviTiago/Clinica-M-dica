<?php

require "conexao-mysql.php";

class Endereco {
    public $logradouro;
    public $cidade;
    public $estado;

    function __construct($logradouro, $cidade, $estado)
    {
        $this->logradouro = $logradouro;
        $this->cidade = $cidade;
        $this->estado = $estado;
    }
}

$pdo = conexaoMysql();

$cep = $_GET["cep"] ?? "";

$sql = <<<SQL
    SELECT b.logradouro, b.cidade, b.estado
    FROM base_enderecos b
    WHERE b.cep = ?;
SQL;

$stmt = $pdo->prepare($sql);
$stmt->execute([$cep]);
$result = $stmt->fetchAll();

$enderecos = [];
foreach ($result as $row) {
    $enderecos[] = new Endereco($row['logradouro'], $row['cidade'], $row['estado']);
}

header("Content-type: application/json; charset=utf-8");
echo json_encode($enderecos);