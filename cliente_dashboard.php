<?php
session_start();

if (!isset($_SESSION['usuario_id']) || $_SESSION['usuario_tipo'] !== 'Cliente') {
    header("Location: login.php");
    exit();
}

$host = "localhost";
$usuario = "root";
$senha = "";
$banco = "projeto_avaliativo";
$conexao = new mysqli($host, $usuario, $senha, $banco);

if ($conexao->connect_error) {
    die("Falha na conexão: " . $conexao->connect_error);
}

$cliente_id = $_SESSION['usuario_id'];

$sql = "SELECT id, titulo, status, data_abertura FROM chamados WHERE cliente_id = ?";
$consulta = $conexao->prepare($sql);
$consulta->bind_param("i", $cliente_id);
$consulta->execute();
$resultado = $consulta->get_result();

$chamados = [];
while ($row = $resultado->fetch_assoc()) {
    $chamados[] = $row;
}
$consulta->close();
$conexao->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Painel do Cliente</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <div class="container">
            <a class="navbar-brand" href="#">Painel do Cliente</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ml-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="abrir_chamado.php">Abrir Chamado</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="login.html">Sair</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="container mt-4">
        <h1 class="mb-4">Meus Chamados</h1>

        <table class="table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Título</th>
                    <th>Status</th>
                    <th>Data de Abertura</th>
                    <th>Ações</th>
                </tr>
            </thead>
            <tbody>
                <?php if (count($chamados) > 0) : ?>
                    <?php foreach ($chamados as $chamado) : ?>
                        <tr>
                            <td><?php echo $chamado['id']; ?></td>
                            <td><?php echo $chamado['titulo']; ?></td>
                            <td><?php echo $chamado['status']; ?></td>
                            <td><?php echo $chamado['data_abertura']; ?></td>
                            <td>
                                <a href="ver_mensagens.php?chamado_id=<?php echo $chamado['id']; ?>" class="btn btn-info">Ver Mensagens</a>
                                <!-- Adicione um botão para enviar mensagem -->
                                <a href="enviar_mensagem.php?chamado_id=<?php echo $chamado['id']; ?>" class="btn btn-primary">Enviar Mensagem</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else : ?>
                    <tr>
                        <td colspan="5">Nenhum chamado encontrado.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
