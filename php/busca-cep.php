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
$result = $stmt->fetch();

header("Content-type: application/json; charset=utf-8");

if ($result === false) {
    http_response_code(500);
    echo json_encode(["erro" => "CEP não encontrado"]);
} else {
    $endereco = new Endereco($result['logradouro'], $result['cidade'], $result['estado']);
    echo json_encode($endereco);
}