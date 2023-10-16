<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Resposta de Chamado</title>
    <link rel="stylesheet" href="css/bootstrap.min.css"> <!-- Certifique-se de ter o Bootstrap instalado na pasta css. -->
</head>
<body>
    <div class="container">
        <h1>Resposta de Chamado</h1>

        <?php
        // Verifica se o usuário está autenticado como Colaborador (adapte isso à sua lógica de autenticação).
        $tipo_usuario = "Colaborador"; // Suponha que o tipo de usuário seja "Colaborador".

        // Se o usuário for um Colaborador, exiba o formulário de resposta de chamado.
        if ($tipo_usuario === "Colaborador") {
            // Lógica para recuperar o chamado que será respondido (substitua isso com a lógica de sua aplicação).
            $chamado_id = 1; // Suponha que o ID do chamado seja 1.

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

            // Consulta para recuperar os detalhes do chamado.
            $consulta_chamado = "SELECT * FROM chamados WHERE id = $chamado_id";
            $resultado = $conexao->query($consulta_chamado);

            if ($resultado->num_rows > 0) {
                $chamado = $resultado->fetch_assoc();

                echo '<h2>Chamado: ' . $chamado['titulo'] . '</h2>';
                echo '<p><strong>Descrição:</strong> ' . $chamado['descricao'] . '</p>';
                echo '<p><strong>Status:</strong> ' . $chamado['status'] . '</p>';

                echo '<h2>Responder ao Chamado</h2>';
                echo '<form method="post" action="processa_resposta.php">';
                echo '<input type="hidden" name="chamado_id" value="' . $chamado_id . '">';
                echo '<div class="mb-3">';
                echo '<label for="resposta" class="form-label">Resposta</label>';
                echo '<textarea class="form-control" id="resposta" name="resposta" rows="4" required></textarea>';
                echo '</div>';
                echo '<button type="submit" class="btn btn-primary">Responder</button>';
                echo '</form>';
            } else {
                echo '<p>Chamado não encontrado.</p>';
            }

            $conexao->close();
        } else {
            echo '<p>Permissão negada. Somente Colaboradores podem responder a chamados.</p>';
        }
        ?>
    </div>
</body>
</html>
