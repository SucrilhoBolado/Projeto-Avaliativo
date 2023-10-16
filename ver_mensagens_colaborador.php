<?php
session_start();

if (!isset($_SESSION['usuario_id']) || $_SESSION['usuario_tipo'] !== 'Colaborador') {
    header("Location: login.php");
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

if (isset($_GET['chamado_id'])) {
    $chamado_id = $_GET['chamado_id'];

    // Consulta SQL para obter mensagens do chamado de ambos o cliente e colaborador
    $sql = "SELECT remetente, mensagem, data_envio FROM mensagens WHERE chamado_id = ? ORDER BY data_envio";
    $consulta = $conexao->prepare($sql);
    $consulta->bind_param("i", $chamado_id);
    $consulta->execute();
    $resultado = $consulta->get_result();

    $mensagens = [];
    while ($row = $resultado->fetch_assoc()) {
        $mensagens[] = $row;
    }
    $consulta->close();
} else {
    echo "Chamado não especificado.";
    exit();
}

$conexao->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ver Mensagens</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <div class="container">
            <a class="navbar-brand" href="#">Ver Mensagens</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ml-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="colaborador_dashboard.php">Voltar</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="container mt-4">
        <h1 class="mb-4">Mensagens do Chamado</h1>

        <table class="table">
            <thead>
                <tr>
                    <th>Remetente</th>
                    <th>Mensagem</th>
                    <th>Data de Envio</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($mensagens as $mensagem) : ?>
                    <tr>
                        <td><?php echo $mensagem['remetente']; ?></td>
                        <td><?php echo $mensagem['mensagem']; ?></td>
                        <td><?php echo $mensagem['data_envio']; ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
