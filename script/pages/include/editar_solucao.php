<?php
session_start();
require_once "../../dbsolvet.php";

if (!isset($_SESSION['user_id'])) {
    header("Location: ../../../login.html");
    exit;
}

if (!isset($_GET['id'])) {
    echo "ID do comentário não especificado.";
    exit;
}

$comentario_id = $_GET['id'];

$stmt = $conexao->prepare("SELECT descricao, usuario_id FROM solucoes WHERE id = ?");
$stmt->bind_param("i", $comentario_id);
$stmt->execute();
$res = $stmt->get_result();

if ($res->num_rows === 0) {
    echo "Comentário não encontrado.";
    exit;
}

$comentario = $res->fetch_assoc();
$stmt->close();

if ($comentario['usuario_id'] != $_SESSION['user_id']) {
    echo "Você não tem permissão para editar este comentário.";
    exit;
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

     <link rel="stylesheet" href="../../../css/home.css">  
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-SgOJa3DmI69IUzQ2PVdRZhwQ+dy64/BUtbMJw1MZ8t5HZApcHrRKUc4W0kG879m7" crossorigin="anonymous">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link rel="icon" type="text/img" href="../../../IMG/iconesolvet.png">
    
    <title>Editar Solução</title>
</head>
<body>

    <div class="container">
        <div class="post">
            <div class="textiinput">   
                <div class="form-container">
                    <div class="textarea-wrapper">

                   <h2>Editar Solução</h2>
                    <form action="salvar_edicao_solucao.php" method="post">
                        <input type="hidden" name="id" value="<?= $comentario_id ?>">
                        <textarea name="comentario" rows="2" cols="50" required><?= htmlspecialchars($comentario['descricao']) ?></textarea><br>
                        <button class="submit-btn" type="submit">Salvar</button>
                    </form>

                    </div>
                </div>
            </div>
        </div>    
    </div>
</body>
</html>


