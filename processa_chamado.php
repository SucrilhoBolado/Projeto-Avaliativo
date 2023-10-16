<?php
session_start();

if (!isset($_SESSION['usuario_id']) || $_SESSION['usuario_tipo'] !== 'Cliente') {
    header("Location: login.php");
    exit();
}

// Conexão com o banco de dados
$host = "localhost";
$usuario = "seu_usuario";
$senha = "sua_senha";
$banco = "projeto_avaliativo";
$conexao = new mysqli($host, $usuario, $senha, $banco);

if ($conexao->connect_error) {
    die("Falha na conexão: " . $conexao->connect_error);
}

$titulo = $_POST['titulo'];
$descricao = $_POST['descricao'];
$anexos = $_FILES['anexos']['name'];

$cliente_id = $_SESSION['usuario_id'];

$inserir_chamado = $conexao->prepare("INSERT INTO chamados (titulo, descricao, anexos, status, cliente_id) VALUES (?, ?, ?, 'Aberto', ?)");
$inserir_chamado->bind_param("sssi", $titulo, $descricao, $anexos, $cliente_id);

if ($inserir_chamado->execute()) {
    // Redireciona para a página do cliente com um parâmetro de sucesso na URL
    header("Location: cliente_dashboard.php?sucesso=true");
} else {
    header("Location: abertura_chamado.php?erro=bd");
}

$inserir_chamado->close();
$conexao->close();
?>
