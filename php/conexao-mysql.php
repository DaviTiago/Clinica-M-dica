<?php

function conexaoMysql()
{
    $db_name = "if0_35771744_clinica";
    $db_host = "sql205.infinityfree.com";
    $db_username = "if0_35771744";
    $db_password = "ya8RmGDhOzI3fa";

    $options = [
        PDO::ATTR_EMULATE_PREPARES => false,
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
    ];

    $dsn = "mysql:host=$db_host;dbname=$db_name;charset=utf8mb4";

    try {
        return new PDO($dsn, $db_username, $db_password, $options);
    } catch (Exception $e) {
        exit("Ocorreu uma falha na conexão com o MySQL: " . $e->getMessage());
    }
}
