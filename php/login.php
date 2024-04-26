<?php
require "conexao-mysql.php";

class RequestResponse
{
    public $success;
    public $detail;
    public $message;

    function __construct($success, $detail, $message)
    {
        $this->success = $success;
        $this->detail = $detail;
        $this->message = $message;
    }
}

function checkUserCredentials($pdo, $email, $senha)
{
    $sql = <<<SQL
        SELECT p.codigo, f.codigo AS codigoFuncionario,
        f.senha_hash, m.codigo AS codigoMedico
        FROM pessoa p
        INNER JOIN funcionario f ON p.codigo = f.codigo
        LEFT JOIN medico m ON p.codigo = m.codigo
        WHERE p.email = ?
    SQL;

    try {
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$email]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);


        if ($user) {
            if (password_verify($senha, $user['senha_hash'])) {
                if ($user['codigoMedico']) {
                    return new RequestResponse(true, "listagem-consultas-medico.php", "");
                } else {
                    return new RequestResponse(true, "cadastro-funcionario.php", "");
                }
            } else {
                return new RequestResponse(false, "", "Senha incorreta");
            }
        } else {
            return new RequestResponse(false, "", "Email não encontrado");
        }
    } catch (PDOException $e) {
        return new RequestResponse(false, "", "Erro de conexão ou consulta ao banco de dados");
    }
}

$email = $_POST["email"] ?? '';
$senha = $_POST["senha"] ?? '';

$pdo = conexaoMysql();

$response = checkUserCredentials($pdo, $email, $senha);

if ($response->success) {
    $cookieParams = session_get_cookie_params();
    $cookieParams['httponly'] = true;
    session_set_cookie_params($cookieParams);

    session_start();
    $_SESSION['loggedIn'] = true;
    $_SESSION['user'] = $email;
    $_SESSION['isMedico'] = $response->detail == 'listagem-consultas-medico.php';
} else {
    session_start();
    session_destroy();
}

echo json_encode($response);
