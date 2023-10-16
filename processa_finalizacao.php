<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
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

    $chamado_id = $_POST['chamado_id'];

    // Atualize o status do chamado para "Finalizado".
    $atualizar_chamado = $conexao->prepare("UPDATE chamados SET status = 'Finalizado' WHERE id = ?");
    $atualizar_chamado->bind_param("i", $chamado_id);

    if ($atualizar_chamado->execute()) {
        header("Location: finalizacao_chamado.php?sucesso=true");
    } else {
        header("Location: finalizacao_chamado.php?erro=bd");
    }

    $atualizar_chamado->close();
    $conexao->close();
}
