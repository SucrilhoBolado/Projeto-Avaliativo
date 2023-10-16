<?php
$host = "localhost";
$usuario = "root";
$senha = "";
$banco = "projeto_avaliativo";
$conexao = new mysqli($host, $usuario, $senha, $banco);

if ($conexao->connect_error) {
    die("Falha na conexão: " . $conexao->connect_error);
}

$nome_completo = $_POST['nome_completo'];
$cpf = $_POST['cpf'];
$email = $_POST['email'];
$senha = password_hash($_POST['senha'], PASSWORD_BCRYPT);
$tipo = $_POST['tipo'];

$verifica_duplicidade = $conexao->prepare("SELECT id FROM usuarios WHERE email = ? OR cpf = ?");
$verifica_duplicidade->bind_param("ss", $email, $cpf);
$verifica_duplicidade->execute();
$verifica_duplicidade->store_result();

if ($verifica_duplicidade->num_rows > 0) {
    echo "Este e-mail ou CPF já estão cadastrados.<br>";
    $verifica_duplicidade->close();
    $conexao->close();
    header("Location: cadastro.html?erro=duplicado");
    exit();
}

$verifica_duplicidade->close();

$inserir_usuario = $conexao->prepare("INSERT INTO usuarios (nome_completo, cpf, email, senha, tipo) VALUES (?, ?, ?, ?, ?)");
$inserir_usuario->bind_param("sssss", $nome_completo, $cpf, $email, $senha, $tipo);

if ($inserir_usuario->execute()) {
    echo "Usuário cadastrado com sucesso.<br>";
    header("Location: cadastro.html?sucesso=true");
} else {
    echo "Erro ao cadastrar o usuário.<br>";
    header("Location: cadastro.html?erro=bd");
}

$inserir_usuario->close();
$conexao->close();
?>
