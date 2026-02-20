<?php 
    session_start();
    if (!isset($_SESSION['user_id'])) {
        header("Location: ../views/login.html");
        exit;
    }

    require_once "../config/dbsolvet.php";

    if ($_SERVER['REQUEST_METHOD'] === "POST") {

        $nome = trim($_POST['nome']);
        $email = trim($_POST['email']);
        $senha = $_POST['senha'];
        $empresa = trim($_POST['nome_empresa']);
        $cargo = trim($_POST['cargo']);
        $biografia = trim($_POST['biografia']);
        $id = $_SESSION['user_id'];

        if (empty($nome) || empty($email)) {
             echo "<script>alert('Nome e E-mail são obrigatórios!'); history.back();</script>";
            exit;
        }

        $dominio = substr(strrchr($email, "@"), 1);
        if (!filter_var($email, FILTER_VALIDATE_EMAIL) || !checkdnsrr($dominio, "MX")) {
            echo "<script>alert('ERROR: E-mail inválido... Tente novamente!'); history.back();</script>";
            exit;
        }
        
           if (!empty($senha)) {
        $senhaHash = password_hash($senha, PASSWORD_DEFAULT);
        $sql = "UPDATE usuarios SET nome = ?, email = ?, senha = ?, nome_empresa = ?, cargo = ?, biografia = ? WHERE id = ?";
        $stmt = $conexao->prepare($sql);
        $stmt->bind_param("ssssssi", $nome, $email, $senhaHash, $empresa, $cargo, $biografia, $id);
    } else {
        $sql = "UPDATE usuarios SET nome = ?, email = ?, nome_empresa = ?, cargo = ?, biografia = ? WHERE id = ?";
        $stmt = $conexao->prepare($sql);
        $stmt->bind_param("sssssi", $nome, $email, $empresa, $cargo, $biografia, $id);
    }
        if ($stmt->execute()) {
            $_SESSION['user_nome'] = $nome;
            $_SESSION['user_email'] = $email;
            $_SESSION['user_empresa'] = $empresa;
            $_SESSION['user_cargo'] = $cargo;
            $_SESSION['user_biografia'] = $biografia;

            header("Location: ../views/perfil.php?atualizado=1");
            exit;
            } else {
            echo "Erro ao atualizar: " . $stmt->error;
            }
            $stmt->close();
        }


?>