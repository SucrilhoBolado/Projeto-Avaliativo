<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Visualizar Mensagens</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>
<body>
    <div class="container">
        <h1 class="mt-4">Mensagens do Chamado</h1>
        <a href="cliente_dashboard.php" class="btn btn-secondary mt-2">Voltar</a>
        <table class="table mt-4">
            <thead>
                <tr>
                    <th>Remetente</th>
                    <th>Mensagem</th>
                    <th>Data de Envio</th>
                </tr>
            </thead>
            <tbody>
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

                // Verifique se o chamado_id é passado pela URL
                if (isset($_GET['chamado_id'])) {
                    $chamado_id = $_GET['chamado_id'];

                    // Consulta SQL para obter mensagens do chamado
                    $sql = "SELECT remetente_id, mensagem, data_envio FROM mensagens WHERE chamado_id = ?";
                    $consulta = $conexao->prepare($sql);
                    $consulta->bind_param("i", $chamado_id);
                    $consulta->execute();
                    $resultado = $consulta->get_result();

                    while ($row = $resultado->fetch_assoc()) {
                        echo "<tr>";
                        echo "<td>" . $row['remetente_id'] . "</td>";
                        echo "<td>" . $row['mensagem'] . "</td>";
                        echo "<td>" . $row['data_envio'] . "</td>";
                        echo "</tr>";
                    }
                    $consulta->close();
                } else {
                    // Se o chamado_id não for passado, redirecione para o painel do cliente
                    header("Location: cliente_dashboard.php");
                }

                // Adicione uma consulta para obter mensagens enviadas pelo colaborador.
                $sqlColaborador = "SELECT remetente_id, mensagem, data_envio FROM mensagens WHERE chamado_id = ? AND remetente_id = 'Colaborador'";
                $consultaColaborador = $conexao->prepare($sqlColaborador);
                $consultaColaborador->bind_param("i", $chamado_id);
                $consultaColaborador->execute();
                $resultadoColaborador = $consultaColaborador->get_result();

                while ($row = $resultadoColaborador->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td>" . $row['remetente_id'] . "</td>";
                    echo "<td>" . $row['mensagem'] . "</td>";
                    echo "<td>" . $row['data_envio'] . "</td>";
                    echo "</tr>";
                }
                $consultaColaborador->close();

                $conexao->close();
                ?>
            </tbody>
        </table>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
