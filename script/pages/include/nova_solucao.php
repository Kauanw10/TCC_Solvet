<?php 
    session_start();
    require_once "../../dbsolvet.php";
    if (!isset($_SESSION['user_id'])) {
        header("Location: ../../../login.html");
        exit;
    }

    if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_SESSION['user_id'])) {
       $usuario_id = $_SESSION['user_id'];
       $desafio_id = $_POST['desafio_id'];
       $solucao = trim($_POST['solucao']);

       if (!empty($solucao)) {
           $stmt = $conexao->prepare("INSERT INTO solucoes (desafio_id, usuario_id, descricao) VALUES (?, ?, ?)"); 
           if (!$stmt) {
           die("Erro ao preparar: " . $conexao->error);
       }
        $stmt->bind_param("iis", $desafio_id, $usuario_id, $solucao); 
        $stmt->execute(); 
        $stmt->close(); 
       }
    }
     header("Location: ../home.php"); 
        exit; 
?>