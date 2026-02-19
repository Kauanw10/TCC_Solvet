<?php 
    session_start();
    require_once "../../dbsolvet.php";
    if (!isset($_SESSION['user_id'])) {
        header("Location: ../../../login.html");
        exit;
    }

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $titulo = trim($_POST['titulo']);
        $categoria = trim($_POST['categoria']);
        $conteudo = trim($_POST['conteudo']); 

        if (empty($conteudo)) { 
        // Conteúdo vazio não deve ser inserido 
        header("Location: ../home.php"); 
        exit;
        }

        $usuario_id = $_SESSION['user_id']; 
        $stmt = $conexao->prepare("INSERT INTO desafios (usuario_id, titulo, descricao, categoria, criado_em) VALUES (?, ?, ?, ?, DEFAULT)"); 
        $stmt->bind_param("isss", $usuario_id, $titulo, $conteudo, $categoria); 
        if ($stmt->execute()) { 
           $novo_id = $stmt->insert_id;
           header("Location: ../home.php#desafio-$novo_id");
            exit;
        } else { 
            echo "Erro ao salvar postagem: " . $stmt->error; 
        } 
        $stmt->close();
    }
?>