<?php
session_start();
include 'config.php'; // Arquivo de conexão com o banco

$erro = ""; // Variável para armazenar erros

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $usuario = $_POST['name'];
    $senha = $_POST['password'];

    $sql = "SELECT * FROM usuarios WHERE usuario = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $usuario);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $senha_armazenada = $row['senha'];

        if (password_verify($senha, $senha_armazenada)) {
            $_SESSION['name'] = $usuario;
            header("Location: welcome.php");
            exit();
        } else {
            $erro = "Usuário ou senha incorretos!";
        }
    } else {
        $erro = "Usuário ou senha incorretos!";
    }
    $stmt->close();
    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta name="author" content="Muhamad Nauval Azhar">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta name="description" content="This is a login page template based on Bootstrap 5">
	<title>Login</title>
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-BmbxuPwQa2lc/FVzBcNJ7UAyJxM6wuqIj61tLrc4wSX0szH/Ev+nYRRuWlolflfl" crossorigin="anonymous">
</head>

<body>
    
     <?php
    // Exibe a mensagem de erro se ela estiver definida
    if (isset($_SESSION['error_message'])) {
        echo "<div class='alert alert-danger' role='alert'>" . $_SESSION['error_message'] . "</div>";
        unset($_SESSION['error_message']); // Limpa a mensagem após exibi-la
    }
    ?>
    
	<section class="h-100">
		<div class="container h-100">
			<div class="row justify-content-sm-center h-100">
				<div class="col-xxl-4 col-xl-5 col-lg-5 col-md-7 col-sm-9">
					<!-- Ajustei a margem aqui para mover a imagem mais para baixo -->
					<div class="text-center mt-5" style="margin-top: 150px;"> <!-- Tentei 150px para ver o efeito -->
						<img src="log.png" alt="logo" class="w-50">
					</div>
					<div class="card shadow-lg">
						<div class="card-body p-5">
							<!-- Centralizando o título -->
							<h1 class="fs-2 card-title fw-bold mb-4 text-center">Login</h1>

							<!-- Exibir erro aqui se houver -->
							<?php if (!empty($erro)): ?>
								<div class="alert alert-danger" role="alert">
									<?php echo $erro; ?>
								</div>
							<?php endif; ?>

							<form action="" method="POST" class="needs-validation" novalidate="" autocomplete="off">
								<div class="mb-3">
									<label class="mb-2 text-muted" for="name">Usuário</label>
									<input id="email" type="text" class="form-control" name="name" required autofocus>
									<div class="invalid-feedback">
										Email inválido 
									</div>
								</div>

								<div class="mb-3">
									<label class="text-muted" for="password">Senha</label>
									<input id="password" type="password" class="form-control" name="password" required>
								    <div class="invalid-feedback">
								    	É necessário inserir sua senha
							    	</div>
								</div>

								<!-- Centralizando o botão e o link "Esqueceu a senha?" -->
								<div class="d-flex flex-column align-items-center">
									<button type="submit" class="btn btn-primary btn-lg">
										Entrar
									</button>
									<a href="forgot.php" class="mt-3">Esqueceu a senha?</a>
								</div>
							</form>
						</div>
						<div class="card-footer py-3 border-0">
							<div class="text-center">
								Não está cadastrado? <a href="register.php" class="text-dark">Crie seu usuário</a>
							</div>
						</div>
					</div>
					<div class="text-center mt-3 text-muted">
						Desenvolvido por Ricardo Pereira 
					</div>
				</div>
			</div>
		</div>
	</section>

	<script src="js/login.js"></script>
</body>
</html>
