<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Visualização de Chamados</title>
    <link rel="stylesheet" href="css/bootstrap.min.css"> <!-- Certifique-se de ter o Bootstrap instalado na pasta css. -->
</head>
<body>
    <div class="container">
        <h1>Visualização de Chamados</h1>

        <?php
        // Verifica se o usuário está autenticado como Cliente (adapte isso à sua lógica de autenticação).
        $tipo_usuario = "Cliente"; // Suponha que o tipo de usuário seja "Cliente".

        // Se o usuário for um Cliente, exiba o botão de abertura de chamado.
        if ($tipo_usuario === "Cliente") {
            echo '<a href="abertura_chamado.php" class="btn btn-primary">Abrir Chamado</a>';
        }

        // Conexão com o banco de dados (substitua as credenciais conforme necessário).
        $host = "localhost";
        $usuario = "root";
        $senha = "";
        $banco = "myhmsdb";
        $conexao = new mysqli($host, $usuario, $senha, $banco);

        // Verifica se a conexão foi bem-sucedida.
        if ($conexao->connect_error) {
            die("Falha na conexão: " . $conexao->connect_error);
        }

        // Consulta para recuperar os chamados.
        $consulta_chamados = "SELECT * FROM chamados";
        $resultado = $conexao->query($consulta_chamados);

        if ($resultado->num_rows > 0) {
            echo '<h2>Chamados</h2>';
            echo '<table class="table">';
            echo '<thead><tr><th>Título</th><th>Descrição</th><th>Anexos</th><th>Status</th></tr></thead>';
            echo '<tbody>';

            while ($chamado = $resultado->fetch_assoc()) {
                echo '<tr>';
                echo '<td>' . $chamado['titulo'] . '</td>';
                echo '<td>' . $chamado['descricao'] . '</td>';
                echo '<td>' . $chamado['anexos'] . '</td>';
                echo '<td>' . $chamado['status'] . '</td>';
                echo '</tr>';
            }

            echo '</tbody>';
            echo '</table>';
        } else {
            echo '<p>Nenhum chamado encontrado.</p>';
        }

        $conexao->close();
        ?>

    </div>
</body>
</html>
