<?php
$host = "localhost";
$usuario = "root";
$senha = "";
$banco = "projeto_avaliativo";
$conexao = new mysqli($host, $usuario, $senha, $banco);

if ($conexao->connect_error) {
    die("Falha na conexão: " . $conexao->connect_error);
}

// Agora você pode continuar o seu script de processamento de login aqui.
// Lembre-se de verificar os dados do formulário de login e compará-los com o banco de dados.
// Por razões de segurança, evite exibir mensagens detalhadas sobre erros no login para o usuário final.
// Em vez disso, você pode redirecionar o usuário para uma página de erro em caso de falha no login.

// Exemplo de verificação de login (lembre-se de personalizá-lo para atender às suas necessidades):
$login_email = $_POST['email'];
$login_senha = $_POST['senha'];

// Consulta SQL para verificar se o usuário existe no banco de dados.
$verificar_login = $conexao->prepare("SELECT id, email, senha, tipo FROM usuarios WHERE email = ?");
$verificar_login->bind_param("s", $login_email);
$verificar_login->execute();
$verificar_login->store_result();

if ($verificar_login->num_rows == 1) {
    $verificar_login->bind_result($id, $email, $senha_hash, $tipo);
    $verificar_login->fetch();

    // Verifique a senha usando password_verify.
    if (password_verify($login_senha, $senha_hash)) {
        // Senha correta, inicie a sessão ou implemente sua lógica de login aqui.
        session_start();
        $_SESSION['usuario_id'] = $id;
        $_SESSION['usuario_tipo'] = $tipo;
        
        // Redirecione para a página apropriada após o login.
        if ($tipo === 'Cliente') {
            header("Location: cliente_dashboard.php");
        } elseif ($tipo === 'Colaborador') {
            header("Location: colaborador_dashboard.php");
        } else {
            // Tipo de usuário desconhecido. Trate esse caso adequadamente.
            header("Location: index.php");
        }
    } else {
        // Senha incorreta.
        header("Location: login.php?erro=senha");
    }
} else {
    // Usuário não encontrado.
    header("Location: login.php?erro=usuario");
}

$verificar_login->close();
$conexao->close();
?>
