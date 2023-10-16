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
    $resposta = $_POST['resposta'];

    // Atualize o status do chamado para "Em atendimento" e adicione a resposta.
    $atualizar_chamado = $conexao->prepare("UPDATE chamados SET status = 'Em atendimento' WHERE id = ?");
    $atualizar_chamado->bind_param("i", $chamado_id);

    if ($atualizar_chamado->execute()) {
        $atualizar_chamado->close();

        // Insira a resposta no banco de dados (substitua isso de acordo com sua estrutura de dados).
        // Aqui, estou assumindo que você tem uma tabela de respostas para associar a resposta ao chamado.
        $inserir_resposta = $conexao->prepare("INSERT INTO respostas (chamado_id, resposta) VALUES (?, ?)");
        $inserir_resposta->bind_param("is", $chamado_id, $resposta);

        if ($inserir_resposta->execute()) {
            header("Location: resposta_chamado.php?chamado_id=$chamado_id&sucesso=true");
        } else {
            header("Location: resposta_chamado.php?chamado_id=$chamado_id&erro=bd");
        }

        $inserir_resposta->close();
    } else {
        header("Location: resposta_chamado.php?chamado_id=$chamado_id&erro=bd");
    }

    $conexao->close();
}
