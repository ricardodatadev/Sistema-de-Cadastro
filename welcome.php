<?php
session_start();

if (!isset($_SESSION['name'])) {
    $_SESSION['error_message'] = "Você precisa estar logado para acessar esta página.";
    header("Location: index.php");
    exit();
}
// CSRF token
if (empty($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}
?>


<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Sistema de Gestão</title>
	<link rel="stylesheet" type="text/css" href="bootstrap/css/bootstrap.min.css">
</head>
<body>
    <nav class="navbar navbar-expand-lg bg-body-tertiary">
      <div class="container-fluid">
        <a class="navbar-brand" href="#">Sistema de Gestão</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
          <ul class="navbar-nav me-auto mb-2 mb-lg-0">
            <li class="nav-item">
              <a class="nav-link active" aria-current="page" href="welcome.php">Home</a>
            </li>
            
            <li class="nav-item dropdown">
              <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                Equipamentos
              </a>
              <ul class="dropdown-menu">
                <li><a class="dropdown-item" href="?page=marca-listar">Listar</a></li>
                <li><a class="dropdown-item" href="?page=marca-cadastrar">Cadastrar</a></li>
              </ul>
            </li>
            <li class="nav-item dropdown">
              <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                Colaboradores
              </a>
              <ul class="dropdown-menu">
                <li><a class="dropdown-item" href="?page=colaborador-listar">Listar</a></li>
                <li><a class="dropdown-item" href="?page=colaborador-cadastrar">Cadastrar</a></li>
              </ul>
            </li>
            <li class="nav-item dropdown">
              <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                Fornecedores
              </a>
              <ul class="dropdown-menu">
                <li><a class="dropdown-item" href="?page=fornecedor-listar">Listar</a></li>
                <li><a class="dropdown-item" href="?page=fornecedor-cadastrar">Cadastrar</a>
                </li>
              </ul>
            </li>
            <li class="nav-item dropdown">
              <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                Dashboards
              </a>
              <ul class="dropdown-menu">
                <li><a class="dropdown-item" href="#">Controle de OS</a></li>
                <li><a class="dropdown-item" href="#">Acompanhamento Reforma</a>
                <li><a class="dropdown-item" href="#">Orçamento Automotivo</a></li>
                </li>
              </ul>
            </li>
            <li class="nav-item dropdown">
              <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                Chat
              </a>
              <ul class="dropdown-menu">
                <li><a class="dropdown-item" href="#">Listar</a></li>
                <li><a class="dropdown-item" href="#">Cadastrar</a>
                </li>
              </ul>
            </li>
            
            
          </ul>
          <?php // sessão já iniciada no topo ?>
            <div class="d-flex align-items-center">
              <img src="login.png" alt="User" class="rounded-circle me-2 img-fluid" style="max-width: 40px;">
              <span class="fw-bold"><?php echo isset($_SESSION['name']) ? $_SESSION['name'] : 'Usuário'; ?></span>
              <a href="logout.php" class="ms-3 btn btn-outline-danger btn-sm">Sair</a>
            </div>
      </div>
    </nav>
    <div class="container">
        <div class="row">
            <div class="col">
                <?php
                    //arquivo que faz a conexão com o banco
                    include('config.php');
                    
                    //includes das páginas
                switch (@$_REQUEST['page']) {
                    // Equipamentos
                    case 'marca-listar':
                        include('marca-listar.php');
                        break;
                    case 'marca-cadastrar':
                        include('marca-cadastrar.php');
                        break;
                    case 'marca-editar':
                        include('marca-editar.php');
                        break;
                    case 'marca-excluir':
                        include('marca-excluir.php');
                        break;
                    case 'marca-salvar':
                        include('marca-salvar.php');
                        break;

                    // Colaboradores
                    case 'colaborador-listar':
                        include('colaborador-listar.php');
                        break;
                    case 'colaborador-cadastrar':
                        include('colaborador-cadastrar.php');
                        break;
                    case 'colaborador-editar':
                        include('colaborador-editar.php');
                        break;
                    case 'colaborador-salvar':
                        include('colaborador-salvar.php');
                        break;
                    case 'colaborador-excluir':
                        include('colaborador-excluir.php');
                        break;

                    // Fornecedores (mantidos para futura implementação)
                    case 'fornecedor-listar':
                        include('fornecedor-listar.php');
                        break;
                    case 'fornecedor-cadastrar':
                        include('fornecedor-cadastrar.php');
                        break;
                    case 'fornecedor-editar':
                        include('fornecedor-editar.php');
                        break;
                    case 'fornecedor-salvar':
                        include('fornecedor-salvar.php');
                        break;

                    default:
                        print "<div class='py-5'>
                                <div class='row g-4'>
                                  <div class='col-md-4'>
                                    <div class='card h-100 shadow-sm'>
                                      <img src='cadastrofrota.jpg' class='card-img-top' alt='Frotas'>
                                      <div class='card-body'>
                                        <h5 class='card-title'>Equipamentos / Frotas</h5>
                                        <p class='card-text'>Cadastre e gerencie os equipamentos da frota.</p>
                                        <a href='?page=marca-listar' class='btn btn-primary me-2'>Listar</a>
                                        <a href='?page=marca-cadastrar' class='btn btn-outline-primary'>Cadastrar</a>
                                      </div>
                                    </div>
                                  </div>
                                  <div class='col-md-4'>
                                    <div class='card h-100 shadow-sm'>
                                      <img src='Cadastro.jpg' class='card-img-top' alt='Colaboradores'>
                                      <div class='card-body'>
                                        <h5 class='card-title'>Colaboradores</h5>
                                        <p class='card-text'>Controle de colaboradores e registros.</p>
                                        <a href='?page=colaborador-listar' class='btn btn-primary me-2'>Listar</a>
                                        <a href='?page=colaborador-cadastrar' class='btn btn-outline-primary'>Cadastrar</a>
                                      </div>
                                    </div>
                                  </div>
                                  <div class='col-md-4'>
                                    <div class='card h-100 shadow-sm'>
                                      <img src='config.jpg' class='card-img-top' alt='Configurações'>
                                      <div class='card-body'>
                                        <h5 class='card-title'>Configurações</h5>
                                        <p class='card-text'>Ajustes gerais do sistema e preferências.</p>
                                        <a href='#' class='btn btn-secondary disabled'>Em breve</a>
                                      </div>
                                    </div>
                                  </div>
                                </div>
                              </div>";
                        break;
                }
                
                ?>
            </div>
        </div>
    </div>
	<script type="text/javascript" src="bootstrap/js/bootstrap.bundle.min.js"></script>
</body>
</html>
