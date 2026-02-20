<?php 
    session_start();
    if (!isset($_SESSION['user_id'])) {
        header("Location: login.html");
        exit;
    }

    require_once "../config/dbsolvet.php";

    if (isset($_GET['atualizado']) && $_GET['atualizado'] == 1) {
    echo "<script>alert('Perfil atualizado com sucesso!');</script>";
  }

    $stmt = $conexao->prepare("SELECT * FROM usuarios WHERE id = ?");
    $stmt->bind_param("i", $_SESSION['user_id']);
    $stmt->execute();
    $resultado = $stmt->get_result();
    $linha = $resultado->fetch_assoc();
    $stmt->close();
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/perfil.css">
    <link rel="shortcut icon" type="imagex/png" href="../IMG/iconesolvet.png">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-SgOJa3DmI69IUzQ2PVdRZhwQ+dy64/BUtbMJw1MZ8t5HZApcHrRKUc4W0kG879m7" crossorigin="anonymous">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
   
    <title>Meu perfil</title>

<body>

      <nav class="navbar navbar-expand-lg bg-body-tertiary fixed-top">
        <div class="container-fluid">
            <a class="navbar-brand" href="home.php">
              <img src="../IMG/iconesolvet.png" alt="Logo" width="35" height="35" class="d-inline-block align-text-top">
              Solvet+
            </a>
          </div>
      
          <div class="container-fluid">
     
          <div class="collapse navbar-collapse" id="navbarSupportedContent">
           

            <ul class="nav">
              <li class="nav-item">
                <a class="nav-link active" aria-current="page" href="home.php">Home</a>
              </li>
    
            
              <li class="nav-item">
                <a class="nav-link active" aria-current="page" href="perfil.php">Perfil</a>
              </li>
                
               
              <li class="nav-item">
                <a class="nav-link active" aria-current="page" href="sair.php">Sair</a>
              </li>
            </ul>
          </div>
        </div>
      </nav>

      <div class="border">
         

 

      <form class="profile-info-fields" action="../models/editar_perfil.php" method="post">
          <div class="forms">
                  <label for="name">Nome</label>
                  <input type="text" name="nome" value="<?=$linha['nome']?>" placeholder="Digite aqui seu nome...">

                  <label for="email">E-mail</label>
                  <input type="text" name="email" value="<?=$linha['email']?>" placeholder="Digite aqui seu email...">

                  <label for="senha">SENHA:</label>
                        <div class="senha-container">
                            <input type="password" name="senha" id="senha">
                            <button type="button" class="toggle-senha" onclick="mostrarSenha()">👀</button>
                        </div>
                  
                  <div class="form-group">
                      <label for="display-name">Nome da Empresa</label>
                      <input type="text" name="nome_empresa" value="<?=$linha['nome_empresa']?>" placeholder="Digite aqui o nome da sua empresa...">
                  </div>

                    <div class="form-group">
                      <label for="display-name">Cargo</label>
                      <input type="text" name="cargo" value="<?=$linha['cargo']?>" placeholder="Digite aqui o seu cargo...">
                    </div>
                  </div>

              <div class="biografia">
                  <label for="biografia">Biografia...</label>
                  <textarea name="biografia" placeholder="Conte um pouco sobre você" ><?=$linha['biografia']?></textarea>
              </div>
              <button type="submit" class="meu-botao">Salvar</button>
          </div>
      </form>

      <div vw class="enabled">
        <div vw-access-button class="active"></div>
        <div vw-plugin-wrapper>
          <div class="vw-plugin-top-wrapper"></div>
        </div>
      </div>
      <script src="https://vlibras.gov.br/app/vlibras-plugin.js"></script>
      <script>
        new window.VLibras.Widget('https://vlibras.gov.br/app');
      </script>

      <script>
          function mostrarSenha() {
              const campoSenha = document.getElementById("senha");
              campoSenha.type = campoSenha.type === "password" ? "text" : "password";
                }
      </script>


</body>
</head>
</html>