<?php
session_start();
require_once "../../dbsolvet.php";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $comentario_id = $_POST['id'];
    $comentario = trim($_POST['comentario']);

    $stmt = $conexao->prepare("UPDATE solucoes SET descricao = ? WHERE id = ? AND usuario_id = ?");
    $stmt->bind_param("sii", $comentario, $comentario_id, $_SESSION['user_id']);
    $stmt->execute();
    $stmt->close();
}

header("Location: ../home.php");
exit;
