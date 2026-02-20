<?php
session_start();
require_once "../config/dbsolvet.php";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $id = $_POST['id'];

    $stmt = $conexao->prepare("DELETE FROM solucoes WHERE id = ? AND usuario_id = ?");
    $stmt->bind_param("ii", $id, $_SESSION['user_id']);
    $stmt->execute();
    $stmt->close();
}

header("Location: ../views/home.php");
exit;
?>