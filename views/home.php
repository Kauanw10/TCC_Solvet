<?php 
    session_start();
    if (!isset($_SESSION['user_id'])) {
        header("Location: login.html");
        exit;
    }
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/home.css">  
    <link rel="shortcut icon" type="imagex/png" href="../IMG/iconesolvet.png">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-SgOJa3DmI69IUzQ2PVdRZhwQ+dy64/BUtbMJw1MZ8t5HZApcHrRKUc4W0kG879m7" crossorigin="anonymous">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    
    <title>Home</title>

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


      <section class="hero">
        <div class="hero-left">
            <div class="tagline">Solvet+ está aqui para ajudar!</div>
            <h1 class="hero-title">Seu problema, nossa solução.</h1>
            <p class="hero-subtitle">A melhor plataforma de crowdsourcing para gestão empresarial.</p>
            <h1>Bem vindo(a)
                 <?= htmlspecialchars($_SESSION['user_nome'])?>,
                ao feed!</h1>
        </div>
        <div class="hero-right">
            <div class="hero-right-object">
                <img src="../IMG/iconesolvet.png" style="max-width: 100%;">
            </div>
        </div>
        
        </section>

       <div class="container">
        <div class="post">
            <div class="post-header">
                <img src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcSL33i3KUARlJQAbV6AA5fur3hQ0ndQxWdjyzsags3LcMsdBtXavh5-mhst4OTJuFtBhcY&usqp=CAU" alt="User">
                <span class="username"> <?= htmlspecialchars($_SESSION['user_nome'])?> </span>
                
            </div>
        
             
          <div class="textiinput">
              <div class="form-container">
                <form id="form-desafio" action="../models/novo_desafio.php" method="post">
                    <div class="textarea-wrapper">
                        <label for="conteudo">Compartilhe seus desafios:</label>
                        <br>
                        <input type="text" name="titulo" id="titulo" placeholder="Dê um titulo aqui...">
                        <br>
                        <br>
                        <input type="text" name="categoria" id="categoria" placeholder="Digite a cetegoria aqui...">
                        <br><br>
                        <textarea id="conteudo" name="conteudo" placeholder="Descreva aqui seus desafios ou dificuldades..." ></textarea>
                    </div>
                    <button type="submit" class="submit-btn">Enviar</button>
                </form>
            </div>
          </div>
        </div>
      </div>

        <?php 
        require_once "../config/dbsolvet.php"; 
         $sql = "SELECT desafios.id, desafios.usuario_id, desafios.titulo, desafios.descricao, desafios.categoria, desafios.criado_em, usuarios.nome FROM desafios JOIN usuarios ON desafios.usuario_id = usuarios.id ORDER BY desafios.criado_em DESC";

          $resultado = $conexao->query($sql); 
          if ($resultado && $resultado->num_rows > 0): 
            while ($post = $resultado->fetch_assoc()): 
            $desafio_id = $post['id']; 
            $usuario_id = $_SESSION['user_id'];

            // Total de curtidas 
            $stmtLikes = $conexao->prepare("SELECT COUNT(*) AS total FROM interacoes WHERE desafio_id = ?");
             $stmtLikes->bind_param("i", $desafio_id); 
             $stmtLikes->execute(); 
             $resLikes = $stmtLikes->get_result();
             $totalLikes = $resLikes->fetch_assoc()['total']; 
             $stmtLikes->close();

             // Verifica se usuário curtiu
              $stmtVerifica = $conexao->prepare("SELECT id FROM interacoes WHERE desafio_id = ? AND usuario_id = ?"); 
              $stmtVerifica->bind_param("ii", $desafio_id, $usuario_id);
              $stmtVerifica->execute();
              $resVerifica = $stmtVerifica->get_result();
              $jaCurtiu = $resVerifica->num_rows > 0; 
              $stmtVerifica->close(); 
        ?>


<div class="container" id="desafio-<?= $desafio_id ?>"> 
  <div class="post"> 
    <div class="post-header"> 
      <img src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcSL33i3KUARlJQAbV6AA5fur3hQ0ndQxWdjyzsags3LcMsdBtXavh5-mhst4OTJuFtBhcY&usqp=CAU" alt="User"> 
      
       <span class="username"><?=htmlspecialchars($post['nome']) ?></span> 
      <i><span>• <?= date("d/m/Y H:i", strtotime($post['criado_em'])) ?></span></i>
      <span class="username"><h4>• <?= htmlspecialchars($post['titulo']) ?></h4></span>
    </div> 
    <div class="post-content"> 
      <p class="desafio-categ"><?= nl2br(htmlspecialchars($post['categoria'])) ?></p>
    </div> 
    
    <div class="post-content"> 
    <p class="desafio-desc"><?= nl2br(htmlspecialchars($post['descricao'])) ?></p> 
    </div>
    <?php if ($post['usuario_id'] == $_SESSION['user_id']): ?>
    <form action="../models/editar_desafio.php" method="get" style="display:inline;">
        <input type="hidden" name="id" value="<?= $desafio_id ?>">
        <button class="editar-apagar" type="submit">Editar</button>
    </form>
    
    <form action="../models/apagar_desafio.php" method="post" style="display:inline;" onsubmit="return confirm('Tem certeza que deseja apagar esta postagem?');">
        <input type="hidden" name="id" value="<?= $desafio_id ?>">
        <button class="editar-apagar" type="submit">Apagar</button>
    </form>
    <?php endif; ?>

                    <!-- Curtir -->
                    <div class="post-actions"> 
                       <form id="like-form" class="form-curtir" data-id="<?= $desafio_id ?>">
                          <button type="submit"><?= $jaCurtiu ? "Descurtir" : "Curtir" ?></button>
                        </form>
                        <span><?= $totalLikes ?> curtida<?= $totalLikes != 1 ? 's' : '' ?></span> 
                    </div>

                      <hr>

                <h5>Soluções</h5>
                <?php
               $sqlSolucoes = "SELECT solucoes.id, solucoes.usuario_id, solucoes.descricao, solucoes.enviado_em, usuarios.nome FROM solucoes JOIN usuarios ON solucoes.usuario_id = usuarios.id WHERE solucoes.desafio_id = ? ORDER BY solucoes.enviado_em ASC";

                $stmt = $conexao->prepare($sqlSolucoes);
                $stmt->bind_param("i", $desafio_id);
                $stmt->execute();
                $solucoes = $stmt->get_result();

                  if ($solucoes->num_rows > 0):
                      while ($solucao = $solucoes->fetch_assoc()):
                  ?>
                 <div style="margin-left: 20px; border-left: 2px solid #ccc; padding-left: 10px;">
                  <p><strong><?= htmlspecialchars($solucao['nome']) ?>:</strong> <?= nl2br(htmlspecialchars($solucao['descricao'])) ?></p>
                  <small>Solucionado em: <?= date("d/m/Y H:i", strtotime($solucao['enviado_em'])) ?></small>

                <?php if ($solucao['usuario_id'] == $_SESSION['user_id']): ?>
                <form action="../models/editar_solucao.php" method="get" style="display:inline;">
                    <input type="hidden" name="id" value="<?= $solucao['id'] ?>">
                    <button type="submit" class="submit-btn">Editar</button>
                </form>

                <form action="../models/apagar_solucao.php" method="post" style="display:inline;" onsubmit="return confirm('Tem certeza que deseja apagar este comentário?');">
                    <input type="hidden" name="id" value="<?= $solucao['id'] ?>">
                    <button type="submit" class="submit-btn">Apagar</button>
                </form>
            <?php endif; ?>
        </div>
    <?php 
        endwhile; 
    else: 
        echo "<p style='margin-left: 20px; color: #555;'>Seja o primeiro a solucionar.</p>"; 
    endif; 
    $stmt->close(); 
    ?>
                 <!-- Formulário de nova solução -->
                <form id="form-solucao" action="../models/nova_solucao.php" method="post" style="margin-left: 20px; margin-top: 10px;">
                    <input type="hidden" name="desafio_id" value="<?= $desafio_id ?>">
                    <textarea name="solucao" rows="2" cols="50" required placeholder="Digite sua solução aqui..."></textarea>
                    <br><br>
                    <button class="submit-btn" type="submit">Enviar</button>
                </form>

              </div> 
              </div> 
              <?php endwhile; else: ?> 
                  <p class="text-muted">Nenhuma postagem ainda.</p> 
              <?php endif; ?>
                    </div>
          </div>
        </div>
      </div>

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
        // Salvar posição antes de enviar qualquer formulário
        document.querySelectorAll('form').forEach(form => {
            form.addEventListener('submit', () => {
                localStorage.setItem('scrollY', window.scrollY);
            });
        });

        // Restaurar a posição ao carregar
        window.addEventListener('load', () => {
            const scrollY = localStorage.getItem('scrollY');
            if (scrollY !== null) {
                window.scrollTo(0, parseInt(scrollY));
                localStorage.removeItem('scrollY');
            }
        });
    </script>

        <script>
document.querySelectorAll('.form-curtir').forEach(form => {
    form.addEventListener('submit', async (e) => {
        e.preventDefault();
        const id = form.dataset.id;

        const res = await fetch('../models/processa_like.php', {
            method: 'POST',
            headers: {'Content-Type': 'application/x-www-form-urlencoded'},
            body: 'desafio_id=' + encodeURIComponent(id)
        });

        if (res.ok) {
            // Atualize o contador de curtidas ou recarregue o post específico
            location.reload(); // ou atualize dinamicamente o trecho desejado
        } else {
            alert('Erro ao curtir/descurtir.');
        }
    });
});
</script>

<script>
window.addEventListener('load', function () {
    const hash = window.location.hash;
    if (hash && document.querySelector(hash)) {
        const elemento = document.querySelector(hash);
        elemento.scrollIntoView({ behavior: 'smooth', block: 'start' });
    }
});
</script>

<script>
document.getElementById("form-desafio").addEventListener("submit", function(e) {
    e.preventDefault();
    const formData = new FormData(this);
    fetch("../models/novo_desafio.php", {
        method: "POST",
        body: formData
    })
    .then(res => res.text())
    .then(data => {
        console.log("Post enviado!");
        location.reload(); // Ou atualize a lista de posts dinamicamente
    });
});
</script>

<script>
document.querySelectorAll("#form-solucao").forEach(form => {
    form.addEventListener("submit", function(e) {
        e.preventDefault();
        const formData = new FormData(form);
        fetch("../models/nova_solucao.php", {
            method: "POST",
            body: formData
        }).then(res => res.text())
          .then(data => {
              console.log("Comentário enviado");
              location.reload(); // Ou atualize os comentários dinamicamente
          });
    });
});
</script>

</body>
</head>
</html>