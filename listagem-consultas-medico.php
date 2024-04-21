<?php
require "php/conexao-mysql.php";
require "php/sessionVerification.php";

session_start();
exitWhenNotMedico();
$pdo = conexaoMysql();

?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@24,400,0,0">
    <link rel="shortcut icon" href="images/favicon.ico" type="image/x-icon">
    <link rel="stylesheet" href="css/header-footer-restrito.css">
    <link rel="stylesheet" href="css/listagem-geral.css">
    <title>Listagem Consultas (Médico)</title>
</head>

<body>
    <header>
        <div>
            <span class="material-symbols-outlined">
                navigate_next
            </span>
        </div>
        <nav>
            <ul>
                <li>
                    <a href="cadastro-funcionario.php">Cadastro de Funcionários</a>
                </li>
                <li>
                    <a href="cadastro-paciente.php">Cadastro de Pacientes</a>
                </li>
                <li>
                    <a href="listagem-funcionarios.php">Listagem Funcionários</a>
                </li>
                <li>
                    <a href="listagem-pacientes.php">Listagem Pacientes</a>
                </li>
                <li>
                    <a href="listagem-enderecos.php">Listagem Endereços</a>
                </li>
                <li>
                    <a href="listagem-consultas.php">Listagem Agendamento de Consultas</a>
                </li>
                <li>
                    <a href="listagem-consultas-medico.php">Listagem Agendamento de Consultas (Médico)</a>
                </li>
                <li>
                    <a href="php/logout.php">Voltar para área pública (Logout)</a>
                </li>
            </ul>
        </nav>
        <div>
            <h1>Clinic Pax Anima</h1>
        </div>
        <div><img src="images/logo.png" alt="Logo Clínica Pax Anima"></div>
    </header>
    <main>
        <button type="button" id="mostrarDados" class="btn btn-success">Mostrar dados</button>
        <h2>Lista Consultas (Médico)</h2>
        <div class="container">
            <div id="listaConsultas" class="tabs tabela">
            </div>
        </div>
    </main>

    <footer>
        <a href="https://linktr.ee/Our_Linkedins">Linkedins</a>
    </footer>

    <script src="js/listagem-geral.js"></script>
    <script src="js/header-restrito.js"></script>
    <script src="js/listagem-consultas-medico.js"></script>
</body>

</html>