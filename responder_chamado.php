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

if (isset($_GET['id'])) {
    $chamado_id = $_GET['id'];

    $sql = "SELECT id, titulo, descricao, status FROM chamados WHERE id = ?";
    $consulta = $conexao->prepare($sql);
    $consulta->bind_param("i", $chamado_id);
    
    if (!$consulta) {
        die("Erro na preparação da consulta: " . $conexao->error);
    }

    $consulta->execute();
    $resultado = $consulta->get_result();

    if ($resultado->num_rows > 0) {
        $chamado = $resultado->fetch_assoc();
        $consulta->close();
    } else {
        echo "Chamado não encontrado.";
        exit();
    }

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $resposta = $_POST['resposta'];
        
        // Atualizar o status do chamado para "Em atendimento".
        $novoStatus = "Em atendimento";
        $sqlAtualizarStatus = "UPDATE chamados SET status = ? WHERE id = ?";
        $consultaAtualizarStatus = $conexao->prepare($sqlAtualizarStatus);
        
        if (!$consultaAtualizarStatus) {
            die("Erro na preparação da consulta: " . $conexao->error);
        }
        
        $consultaAtualizarStatus->bind_param("si", $novoStatus, $chamado_id);
        
        if ($consultaAtualizarStatus->execute()) {
            // Insira a resposta do colaborador no banco de dados.
            $sqlInserirResposta = "INSERT INTO mensagens (chamado_id, mensagem, remetente) VALUES (?, ?, ?)";
            $consultaInserirResposta = $conexao->prepare($sqlInserirResposta);
            
            if (!$consultaInserirResposta) {
                die("Erro na preparação da consulta: " . $conexao->error);
            }
            
            $remetente = 'Colaborador'; // Suponha que o colaborador seja o remetente da resposta.
            $consultaInserirResposta->bind_param("iss", $chamado_id, $resposta, $remetente);

            if ($consultaInserirResposta->execute()) {
                echo "Resposta enviada e chamado atualizado com sucesso.";
            } else {
                echo "Erro ao inserir a resposta: " . $conexao->error;
            }

            $consultaInserirResposta->close();
        } else {
            echo "Erro ao atualizar o chamado: " . $conexao->error;
        }

        $consultaAtualizarStatus->close();
    }
} else {
    echo "ID do chamado não especificado.";
    exit();
}

$conexao->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Responder Chamado</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>
<body>
    <div class="container">
        <h1 class="mt-4">Responder Chamado</h1>

        <form method="post">
            <div class="mb-3">
                <label for="titulo" class="form-label">Título do Chamado</label>
                <input type="text" class="form-control" id="titulo" name="titulo" value="<?php echo $chamado['titulo']; ?>" disabled>
            </div>
            <div class="mb-3">
                <label for="descricao" class="form-label">Descrição do Chamado</label>
                <textarea class="form-control" id="descricao" name="descricao" rows="4" disabled><?php echo $chamado['descricao']; ?></textarea>
            </div>
            <div class="mb-3">
                <label for="resposta" class="form-label">Resposta</label>
                <textarea class="form-control" id="resposta" name="resposta" rows="4" required></textarea>
            </div>
            <button type="submit" class="btn btn-primary">Enviar Resposta</button>
        </form>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
