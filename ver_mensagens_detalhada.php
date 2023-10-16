<?php
session_start();

if (!isset($_SESSION['usuario_id']) || $_SESSION['usuario_tipo'] !== 'Colaborador') {
    header("Location: login.php");
    exit();
}

if (isset($_GET['chamado_id'])) {
    $chamado_id = $_GET['chamado_id'];

    $host = "localhost";
    $usuario = "seu_usuario";
    $senha = "sua_senha";
    $banco = "projeto_avaliativo";
    $conexao = new mysqli($host, $usuario, $senha, $banco);

    if ($conexao->connect_error) {
        die("Falha na conexão: " . $conexao->connect_error);
    }

    // Consulta SQL para obter informações detalhadas do chamado, incluindo descrição e anexos.
    $sql = "SELECT c.id, c.titulo, c.descricao, c.anexos, c.status, c.data_abertura, u.nome_completo AS nome_cliente
            FROM chamados c
            LEFT JOIN usuarios u ON c.cliente_id = u.id
            WHERE c.id = ?";
    $consulta = $conexao->prepare($sql);
    
    // Corrigido para "s" como o tipo de bind_param
    $consulta->bind_param("s", $chamado_id);
    
    $consulta->execute();
    $resultado = $consulta->get_result();

    if ($resultado->num_rows === 1) {
        $chamado = $resultado->fetch_assoc();

        // Agora, você pode exibir os detalhes do chamado, incluindo a descrição e os anexos.
        echo "<h1>Detalhes do Chamado</h1>";
        echo "<p><strong>Título:</strong> " . $chamado['titulo'] . "</p>";
        echo "<p><strong>Descrição:</strong> " . $chamado['descricao'] . "</p>";

        if (!empty($chamado['anexos'])) {
            // Supondo que os anexos sejam nomes de arquivos separados por vírgulas.
            $anexos = explode(',', $chamado['anexos']);
            echo "<p><strong>Anexos:</strong></p>";
            echo "<ul>";
            foreach ($anexos as $anexo) {
                echo "<li><a href='caminho_para_os_anexos/$anexo' target='_blank'>$anexo</a></li>";
            }
            echo "</ul>";
        }

        echo "<p><strong>Status:</strong> " . $chamado['status'] . "</p>";
        echo "<p><strong>Data de Abertura:</strong> " . $chamado['data_abertura'] . "</p>";
        echo "<p><strong>Cliente:</strong> " . $chamado['nome_cliente'] . "S</p>";
      
        echo "<a href='javascript:history.back()' class='btn btn-primary'>Voltar</a>";
    } else {
        echo "Chamado não encontrado.";
    }

    $consulta->close();
    $conexao->close();
} else {
    echo "ID do chamado não especificado.";
    exit();
}
?>
