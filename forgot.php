<?php
include 'config.php'; 

require 'PHPMailer/src/PHPMailer.php';
require 'PHPMailer/src/SMTP.php';
require 'PHPMailer/src/Exception.php';

use PHPMailer\PHPMailer\PHPMailer; 

// Variáveis para mensagem
$message = '';
$message_class = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $input = trim($_POST['email']); // Pode ser e-mail ou nome de usuário

    // Monta consulta preparada por tipo de input
    if (filter_var($input, FILTER_VALIDATE_EMAIL)) {
        $stmt = $conn->prepare("SELECT id, email, usuario FROM usuarios WHERE email = ? LIMIT 1");
    } else {
        $stmt = $conn->prepare("SELECT id, email, usuario FROM usuarios WHERE usuario = ? LIMIT 1");
    }

    if ($stmt) {
        $stmt->bind_param('s', $input);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result && $result->num_rows > 0) {
            $user = $result->fetch_assoc();

            $token = bin2hex(random_bytes(50));
            $expira = date("Y-m-d H:i:s", strtotime('+1 hour'));

            $up = $conn->prepare("UPDATE usuarios SET reset_token = ?, reset_token_expira = ? WHERE id = ?");
            if ($up) {
                $up->bind_param('ssi', $token, $expira, $user['id']);
                if ($up->execute()) {
                    // Gera link absoluto para reset.php
                    $scheme = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') ? 'https' : 'http';
                    $host = $_SERVER['HTTP_HOST'];
                    $basePath = rtrim(dirname($_SERVER['PHP_SELF']), '/\\');
                    $link = $scheme . '://' . $host . $basePath . '/reset.php?token=' . urlencode($token);

                    $mail = new PHPMailer();
                    $mail->setFrom('contato@rdatadev.site', 'Equipe PCMA');
                    $mail->addAddress($user['email']);
                    $mail->Subject = 'Redefinir sua senha';
                    $mail->Body = "Olá,\n\nRecebemos uma solicitação para redefinir a sua senha. Se foi você, acesse o link abaixo para criar uma nova senha:\n\n"
                                  . $link . "\n\nO link é válido por 1 hora. Se você não solicitou, ignore este e-mail.\n\nAtenciosamente,\nRicardo Pereira";

                    if ($mail->send()) {
                        $message = 'Enviamos um e-mail para você! Verifique sua caixa de entrada para redefinir sua senha.';
                        $message_class = 'alert-success';
                    } else {
                        $message = 'Erro ao enviar o e-mail. Por favor, tente novamente.';
                        $message_class = 'alert-danger';
                    }
                } else {
                    $message = 'Erro ao atualizar o banco de dados.';
                    $message_class = 'alert-danger';
                }
                $up->close();
            } else {
                $message = 'Erro interno ao preparar a atualização.';
                $message_class = 'alert-danger';
            }
        } else {
            $message = 'Este e-mail ou nome de usuário não está registrado. Por favor, tente novamente.';
            $message_class = 'alert-danger';
        }
        $stmt->close();
    } else {
        $message = 'Erro interno ao preparar a consulta.';
        $message_class = 'alert-danger';
    }
}
?>



<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta name="author" content="Kodinger">
	<meta name="viewport" content="width=device-width,initial-scale=1">
	<title>Minha Página de Login &mdash; Redefinir Senha</title>
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
	<link rel="stylesheet" type="text/css" href="my-login.css">
</head>
<body class="my-login-page">
	<section class="h-100">
		<div class="container h-100">
			<div class="row justify-content-md-center align-items-center h-100">
				<div class="card-wrapper">
					
					<div class="card fat">
						<div class="text-center mt-3">
						    
							<h4 class="card-title">Problemas para acessar sua conta?</h4>

                            <!-- Exibe a mensagem de erro/sucesso -->
                            <?php if ($message): ?>
                                <div class="alert <?php echo $message_class; ?>">
                                    <?php echo $message; ?>
                                </div>
                            <?php endif; ?>
							
                            <form action="" method="POST" class="my-login-validation" novalidate="">

								<!-- Input para e-mail ou nome de usuário -->
								<div class="form-group">
									<label for="email">Insira seu email ou nome de usuário e enviaremos um link para você voltar a acessar sua conta</label>
									<input id="email" type="text" class="form-control" name="email" value="" required autofocus> <!-- Mudança aqui para permitir texto -->

									<div class="invalid-feedback">
										Email ou nome de usuário inválido
									</div>
								</div>

								<div class="form-group m-0">
									<button type="submit" class="btn btn-primary btn-block">
										Enviar Link
									</button>
								</div>
							</form>
							
							<!-- Links para criar uma nova conta e voltar ao login -->
							<div class="text-center mt-3">
								<p><a href="register.php" class="btn btn-link">Criar uma nova conta</a></p>
								<p><a href="index.php" class="btn btn-link">Voltar ao Login</a></p>
							</div>

						</div>
					</div>
					<div class="footer">
						Copyright &copy; 2025 &mdash; Ricardo Pereira
					</div>
				</div>
			</div>
		</div>
	</section>

	<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
	<script src="js/my-login.js"></script>
</body>
</html> 
