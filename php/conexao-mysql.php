<?php

require "db-config.php";

function conexaoMysql()
{
    $db_name = DB_NAME;
    $db_host = DB_HOST;
    $db_username = DB_USERNAME;
    $db_password = DB_PASSWORD;

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
