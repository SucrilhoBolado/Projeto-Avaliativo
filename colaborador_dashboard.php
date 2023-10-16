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

// Consulta SQL para obter todos os chamados em andamento e abertos dos clientes
$sql = "SELECT id, titulo, status, data_abertura FROM chamados WHERE status = 'Em atendimento' OR status = 'Aberto' AND cliente_id IS NOT NULL";
$resultado = $conexao->query($sql);

$chamados = [];
while ($row = $resultado->fetch_assoc()) {
    $chamados[] = $row;
}

$conexao->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Painel do Colaborador</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>
<body>
    <nav class "navbar navbar-expand-lg navbar-light bg-light">
        <div class="container">
            <a class="navbar-brand" href="#">Painel do Colaborador</a>
            <a class="nav-link" href="login.html">Sair</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ml-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="login.html">Sair</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="container mt-4">
        <h1 class="mb-4">Chamados em Atendimento e Abertos</h1>

        <table class="table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Título</th>
                    <th>Status</th>
                    <th>Data de Abertura</th>
                    <th>Ação</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($chamados as $chamado) : ?>
                    <tr>
                        <td><?php echo $chamado['id']; ?></td>
                        <td><?php echo $chamado['titulo']; ?></td>
                        <td><?php echo $chamado['status']; ?></td>
                        <td><?php echo $chamado['data_abertura']; ?></td>
                        <td>
                            <a href="responder_chamado.php?id=<?php echo $chamado['id']; ?>" class="btn btn-primary">Responder</a>
                            <a href="finalizar_chamado.php?id=<?php echo $chamado['id']; ?>" class="btn btn-danger">Finalizar</a>
                            <a href="ver_mensagens_colaborador.php?chamado_id=<?php echo $chamado['id']; ?>" class="btn btn-info" data-toggle="tooltip" data-placement="top" title="Visualizar Mensagens">Ver Mensagens</a>
                            <a href="ver_mensagens_detalhada.php?chamado_id=<?php echo $chamado['id']; ?>" class="btn btn-info">Ver Detalhes</a>

                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
