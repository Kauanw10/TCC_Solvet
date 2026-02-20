<?php
session_start();
require_once "../config/dbsolvet.php";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $desafio_id = $_POST['id'];
    $titulo = trim($_POST['titulo']);
    $categoria = trim($_POST['categoria']);
    $descricao = trim($_POST['descricao']);

    $stmt = $conexao->prepare("UPDATE desafios SET titulo = ?, categoria = ?, descricao = ? WHERE id = ? AND usuario_id = ?");
    $stmt->bind_param("sssii", $titulo, $categoria, $descricao, $desafio_id, $_SESSION['user_id']);
    $stmt->execute();
    $stmt->close();
}

header("Location: ../views/home.php");
exit;
