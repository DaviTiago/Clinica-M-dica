<?php

require "conexao-mysql.php";

$pdo = conexaoMysql();

$cep = $_POST["cep"] ?? NULL;
$logradouro = $_POST["logradouro"] ?? NULL;
$cidade = $_POST["cidade"] ?? NULL;
$estado = $_POST["estado"] ?? NULL;

$sql = <<<SQL
    INSERT INTO base_enderecos
    VALUES (?, ?, ?, ?);
SQL;

try {
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$cep, $logradouro, $cidade, $estado]);
    header("Location: http://clinica-medica.infinityfreeapp.com/cadastro-endereco.html");
} catch (PDOException $e) {
    http_response_code(500);
    header("Content-type: application/json; charset=utf-8");
    echo json_encode(["erro" => "Ocorreu um erro ao tentar cadastrar o endereço."]);
    exit();
}
