<?php 
    session_start();
    require_once "../config/dbsolvet.php";
    if (!isset($_SESSION['user_id'])) {
        header("Location: ../views/login.html");
        exit;
    }

    if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_SESSION["user_id"])) { 
    
    $usuario_id = $_SESSION["user_id"]; 
    $desafio_id = $_POST["desafio_id"]; 

    // Verificar se já curtiu 
    $sql = "SELECT id FROM interacoes WHERE usuario_id = ? AND desafio_id = ?"; 
    
    if (!$stmt = $conexao->prepare($sql)) {
    die("Erro no prepare: " . $conexao->error);
    }
    $stmt->bind_param("ii", $usuario_id, $desafio_id); 
    $stmt->execute(); 
    $resultado = $stmt->get_result(); 
    
    if ($resultado->num_rows > 0) { 
        // Já curtiu — remove a curtida 
    $sqlDelete = "DELETE FROM interacoes WHERE usuario_id = ? AND desafio_id = ?"; 
    $stmtDel = $conexao->prepare($sqlDelete); 
    $stmtDel->bind_param("ii", $usuario_id, $desafio_id); 
    $stmtDel->execute(); 
    $stmtDel->close(); 
} else { 
        // Ainda não curtiu — adiciona 
        $sqlInsert = "INSERT INTO interacoes (usuario_id, desafio_id) VALUES (?, ?)";
         $stmtIns = $conexao->prepare($sqlInsert); 
         $stmtIns->bind_param("ii", $usuario_id, $desafio_id); 
         $stmtIns->execute(); 
         $stmtIns->close(); 
    } 
        $stmt->close(); 
} 
?>