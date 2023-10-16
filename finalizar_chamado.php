<?php
session_start();

if (!isset($_SESSION['usuario_id']) || $_SESSION['usuario_tipo'] !== 'Colaborador') {
    header("Location: login.php");
    exit();
}

if (isset($_GET['id'])) {
    $chamado_id = $_GET['id'];

    $host = "localhost";
    $usuario = "seu_usuario";
    $senha = "sua_senha";
    $banco = "projeto_avaliativo";
    $conexao = new mysqli($host, $usuario, $senha, $banco);

    if ($conexao->connect_error) {
        die("Falha na conexão: " . $conexao->connect_error);
    }

    // Atualize o status do chamado para "Finalizado".
    $novoStatus = "Finalizado";
    $sqlAtualizarStatus = "UPDATE chamados SET status = ? WHERE id = ?";
    $consultaAtualizarStatus = $conexao->prepare($sqlAtualizarStatus);
    $consultaAtualizarStatus->bind_param("si", $novoStatus, $chamado_id);

    if ($consultaAtualizarStatus->execute()) {
        // Redirecione para colaborador_dashboard.php com uma mensagem de sucesso
        header("Location: colaborador_dashboard.php?success=1");
        exit();
    } else {
        // Redirecione para colaborador_dashboard.php com uma mensagem de erro
        header("Location: colaborador_dashboard.php?error=1");
        exit();
    }

    $consultaAtualizarStatus->close();
    $conexao->close();
} else {
    echo "ID do chamado não especificado.";
    exit();
}
?>
