<?php
session_start();

if (!isset($_SESSION['usuario_id'])) {
    header("Location: login.php");
    exit();
}

if ($_SESSION['usuario_tipo'] !== 'Cliente') {
    // Se o usuário não for um cliente, redirecione ou mostre uma mensagem de erro.
    header("Location: acesso_negado.php"); // Página que você pode criar para exibir uma mensagem de erro.
    exit();
}

// O restante do código permanece o mesmo.
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Abertura de Chamado</title>
    <link rel="stylesheet" href="css/bootstrap.min.css"> <!-- Certifique-se de ter o Bootstrap instalado na pasta css. -->
</head>
<body>
    <div class="container">
        <h1 class="mt-4">Abertura de Chamado</h1>
        <form method="post" action="processa_chamado.php" enctype="multipart/form-data">
            <div class="mb-3">
                <label for="titulo" class="form-label">Título do Chamado</label>
                <input type="text" class="form-control" id="titulo" name="titulo" required>
            </div>
            <div class="mb-3">
                <label for "descricao" class="form-label">Descrição do Chamado</label>
                <textarea class="form-control" id="descricao" name="descricao" rows="4" required></textarea>
            </div>
            <div class="mb-3">
                <label for="anexos" class="form-label">Anexos (Opcional)</label>
                <input type="file" class="form-control" id="anexos" name="anexos">
            </div>
            <button type="submit" class="btn btn-primary">Abrir Chamado</button>
        </form>
    </div>
</body>
</html>
