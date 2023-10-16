<?php
session_start();

if (!isset($_SESSION['usuario_id']) || $_SESSION['usuario_tipo'] !== 'Cliente') {
    header("Location: login.php");
    exit();
}

if (isset($_GET['chamado_id'])) {
    $chamado_id = $_GET['chamado_id'];
} else {
    // Redirecione o usuário de volta ao painel do cliente se o chamado não estiver especificado.
    header("Location: cliente_dashboard.php");
    exit();
}

$host = "localhost";
$usuario = "seu_usuario";
$senha = "sua_senha";
$banco = "projeto_avaliativo";
$conexao = new mysqli($host, $usuario, $senha, $banco);

if ($conexao->connect_error) {
    die("Falha na conexão: " . $conexao->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $cliente_id = $_SESSION['usuario_id'];
    $mensagem = $_POST['mensagem'];

    // Consulta SQL para inserir a mensagem no banco de dados associada ao chamado.
    $sql = "INSERT INTO mensagens (chamado_id, remetente, mensagem) VALUES (?, 'Cliente', ?)";
    $consulta = $conexao->prepare($sql);
    $consulta->bind_param("is", $chamado_id, $mensagem);

    if ($consulta->execute()) {
        // Redirecione de volta para a página de ver mensagens após o envio da mensagem.
        header("Location: ver_mensagens.php?chamado_id=$chamado_id");
        exit();
    } else {
        $erro = "Erro ao enviar a mensagem. Por favor, tente novamente.";
    }

    $consulta->close();
}

$conexao->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Enviar Mensagem</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <div class="container">
            <a class="navbar-brand" href="#">Enviar Mensagem</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ml-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="cliente_dashboard.php">Voltar</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="container mt-4">
        <h1 class="mb-4">Enviar Mensagem</h1>

        <?php if (isset($erro)) : ?>
            <div class="alert alert-danger" role="alert">
                <?php echo $erro; ?>
            </div>
        <?php endif; ?>

        <form method="POST">
            <div class="form-group">
                <label for="mensagem">Mensagem</label>
                <textarea class="form-control" id="mensagem" name="mensagem" rows="5" required></textarea>
            </div>
            <button type="submit" class="btn btn-primary mt-3">Enviar Mensagem</button>
        </form>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
