<?php
session_start();
require_once "../../dbsolvet.php";

if (!isset($_SESSION['user_id'])) {
    header("Location: ../../../login.html");
    exit;
}

if (!isset($_GET['id'])) {
    echo "ID da postagem não especificado.";
    exit;
}

$desafio_id = $_GET['id'];

$stmt = $conexao->prepare("SELECT titulo, descricao, categoria, usuario_id FROM desafios WHERE id = ?");
$stmt->bind_param("i", $desafio_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    echo "Desafio não encontrada.";
    exit;
}

$desafio = $result->fetch_assoc();
$stmt->close();

if ($desafio['usuario_id'] != $_SESSION['user_id']) {
    echo "Você não tem permissão para editar esta desafio.";
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
    
    <title>Editar Desafio</title>
</head>
<body>

    <div class="container">
        <div class="post">
            <div class="textiinput">   
                <div class="form-container">
                    <div class="textarea-wrapper">

                    <h2>Editar Desafio</h2>
                        <form action="salvar_edicao_desafio.php" method="post">
                            <input type="hidden" name="id" value="<?= $desafio_id ?>">
                            <input type="text" name="titulo" value="<?= htmlspecialchars($desafio['titulo'])?>">
                            <input type="text" name="categoria" value="<?= htmlspecialchars($desafio['categoria'])?>">
                            <textarea name="descricao" rows="4" cols="50" required><?= htmlspecialchars($desafio['descricao']) ?></textarea><br>
                            <button class="submit-btn" type="submit">Salvar</button>
                        </form>

                    </div>
                </div>
            </div>
        </div>    
    </div>
</body>
</html>