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
                // Verifica se o funcionário é médico
                if ($user['codigoMedico']) {
                    // O funcionário é médico, então redireciona para a página de cadastro de paciente
                    return new RequestResponse(true, "listagem-consultas-medico.php", "");
                } else {
                    // O funcionário não é médico, então redireciona para a página de cadastro de funcionário
                    return new RequestResponse(true, "cadastro-funcionario.html", "");
                }
            } else {
                // Senha incorreta
                return new RequestResponse(false, "", "Senha incorreta");
            }
        } else {
            // Email não encontrado
            return new RequestResponse(false, "", "Email não encontrado");
        }
    } catch (PDOException $e) {
        // Erro de conexão ou consulta
        return new RequestResponse(false, "", "Erro de conexão ou consulta ao banco de dados");
    }
}

// Captura os dados do formulário
$email = $_POST["email"] ?? '';
$senha = $_POST["senha"] ?? '';

// Conexão com o banco de dados
$pdo = conexaoMysql();

// Verifica as credenciais do usuário

// if(checkUserCredentials($pdo, $email, $senha)){
//     $cookieParams = session_get_cookie_params();
//     $cookieParams['httponly'] = true;
//     session_set_cookie_params($cookieParams);

//     session_start();
//     $_SESSION['loggedIn'] = true;
//     $_SESSION['user'] = $email;
//     $response = new RequestResponse(true, 'php/cadastro-paciente.php', '');
// }
// else{
//     session_start();
//     session_destroy();
//     $response = new RequestResponse(false, '', '');


$response = checkUserCredentials($pdo, $email, $senha);

if($response->success){
    $cookieParams = session_get_cookie_params();
    $cookieParams['httponly'] = true;
    session_set_cookie_params($cookieParams);

    session_start();
    $_SESSION['loggedIn'] = true;
    $_SESSION['user'] = $email;
    $_SESSION['isMedico'] = $response->detail == 'listagem-consultas-medico.php';
}
else{
    session_start();
    session_destroy();
}

// }
$response = checkUserCredentials($pdo, $email, $senha);

// Retorna a resposta em JSON
echo json_encode($response);
?>

