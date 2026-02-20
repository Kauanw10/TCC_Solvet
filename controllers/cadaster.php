<?php 
    require_once "../config/dbsolvet.php";
    session_start();

    if($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['nome']) && isset($_POST['email']) && isset($_POST['senha'])){
        
        $nome = trim($_POST['nome']);
        $email = trim($_POST['email']);
        $senha = $_POST['senha'];
        $nome_empresa = $_POST['nome_empresa'] ?? "";
        $cargo = $_POST['cargo'] ?? "";
        $nivel_tecnico = $_POST['nivel_tecnico'] ?? "";

        $dominio = substr(strrchr($email, "@"), 1);

        if (filter_var($email, FILTER_VALIDATE_EMAIL) && checkdnsrr($dominio, "MX")) {
            $emailVerif = $email;
        } else {
            echo "<script>alert('ERROR: E-mail Invalido... Tente Novamente!')</script>";
            exit;
        }
        
        $senhaHash = password_hash($senha, PASSWORD_DEFAULT);

            $stmt = $conexao->prepare("INSERT INTO usuarios (id, nome, email, senha, biografia, nome_empresa, cargo, nivel_tecnico) values (default, ?, ?, ?, default, ?, ?, ?)");
            $stmt->bind_param("ssssss", $nome, $email, $senhaHash, $nome_empresa, $cargo, $nivel_tecnico);
            if($stmt->execute()){
                echo "Usuario Registrado com sucesso!";
                header("Location: ../views/login.html");
            }else {
                echo "Erro ao registrar: " . $stmt->error;
                exit;
            }
            
            $stmt->close();
    }
   
?>
