<?php 
    require_once 'dbsolvet.php';
    session_start();

    if($_SERVER['REQUEST_METHOD'] === 'POST' && !empty($_POST['email']) && !empty($_POST['senha'])){
       
        $email = trim($_POST['email']);
        $senha = $_POST['senha'];

         $dominio = substr(strrchr($email, "@"), 1);

        if (filter_var($email, FILTER_VALIDATE_EMAIL) && checkdnsrr($dominio, "MX")) {
            $emailVerif = $email;
        } else {
            echo "<script>alert('ERROR: E-mail Invalido... Tente Novamente!')</script>";
            exit;
        }

        $stmt = $conexao->prepare("SELECT * FROM usuarios WHERE email = (?)");
        $stmt->bind_param("s", $emailVerif);
        $stmt->execute();

        $resultado = $stmt->get_result();

        if($resultado->num_rows === 1){
            
            $user = $resultado->fetch_assoc();
            $senhaHash = $user["senha"];
            
            if (password_verify($senha, $senhaHash)){
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['user_nome'] = $user['nome'];
                $_SESSION['user_email'] = $user['email'];
                $_SESSION['user_nome_empresa'] = $user['nome_empresa'];
                $_SESSION['user_cargo'] = $user['cargo'];
                $_SESSION['user_nivel_tecnico'] = $user['nivel_tecnico'];
              
                header("Location: pages/home.php");
                exit;

            }else{
                echo "<script>alert('Senha Incorreta...Tente Novamente!');history.back();</script>";
                exit;
            }
        }else{
            echo "<script>alert('E-mail não encontrado...tente novamente');history.back();</script>";
            exit;
        }
        $stmt->close();
    }
?>