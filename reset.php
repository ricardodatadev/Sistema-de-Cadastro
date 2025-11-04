<?php
include 'config.php';

$senhaAtualizada = false;
$erro = '';
$sucesso = '';
$mensagemSenha = '';
$token = isset($_GET['token']) ? $_GET['token'] : '';

// Verifica token via prepared statement
if ($token) {
    $stmt = $conn->prepare("SELECT id FROM usuarios WHERE reset_token = ? AND reset_token_expira > NOW() LIMIT 1");
    if ($stmt) {
        $stmt->bind_param('s', $token);
        $stmt->execute();
        $result = $stmt->get_result();
        if ($result && $result->num_rows > 0) {
            $user = $result->fetch_assoc();
            $userId = (int) $user['id'];
        } else {
            $erro = "Link de redefinição inválido ou expirado.";
        }
        $stmt->close();
    } else {
        $erro = 'Erro interno ao validar o token.';
    }
} else {
    $erro = 'Token não encontrado.';
}

if (empty($erro) && $_SERVER['REQUEST_METHOD'] === 'POST') {
    $newPassword = isset($_POST['password']) ? $_POST['password'] : '';

    if (!preg_match('/^(?=.*[A-Za-z])(?=.*[!@#$%^&*])[A-Za-z\d!@#$%^&*]{8,}$/', $newPassword)) {
        $mensagemSenha = 'A senha deve ter pelo menos 8 caracteres, incluindo uma letra e um caractere especial (!@#$%^&*).';
    } else {
        $hashedPassword = password_hash($newPassword, PASSWORD_DEFAULT);
        $up = $conn->prepare("UPDATE usuarios SET senha = ?, reset_token = NULL, reset_token_expira = NULL WHERE id = ?");
        if ($up) {
            $up->bind_param('si', $hashedPassword, $userId);
            if ($up->execute()) {
                $senhaAtualizada = true;
                $sucesso = 'Senha atualizada com sucesso! Redirecionando para o login...';
                header('Refresh: 3; url=index.php');
            } else {
                $erro = 'Erro ao atualizar a senha.';
            }
            $up->close();
        } else {
            $erro = 'Erro interno ao preparar a atualização.';
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="author" content="Kodinger">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title>Redefinir Senha</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <link rel="stylesheet" type="text/css" href="my-login.css">
</head>
<body class="my-login-page">
    <section class="h-100">
        <div class="container h-100">
            <div class="row justify-content-md-center align-items-center h-100">
                <div class="card-wrapper">
                    <div class="card fat">
                        <div class="card-body">
                            <h4 class="card-title">Cadastrar Nova Senha</h4>
                            
                            <!-- Exibir mensagem de sucesso ou erro -->
                            <?php if ($sucesso): ?>
                                <div class="alert alert-success">
                                    <?php echo $sucesso; ?>
                                </div>
                            <?php endif; ?>

                            <?php if ($erro): ?>
                                <div class="alert alert-danger">
                                    <?php echo $erro; ?>
                                </div>
                            <?php endif; ?>

                            <?php if ($mensagemSenha): ?>
                                <div class="alert alert-warning">
                                    <?php echo $mensagemSenha; ?>
                                </div>
                            <?php endif; ?>

                            <form method="POST" class="my-login-validation" novalidate="">
                                <div class="form-group">
                                    <label for="new-password">Insira uma nova senha</label>
                                    <input id="new-password" type="password" class="form-control" name="password" required autofocus data-eye 
                                        pattern="^(?=.*[A-Za-z])(?=.*[!@#$%^&*])[A-Za-z\d!@#$%^&*]{8,}$" 
                                        title="A senha deve ter pelo menos 8 caracteres, incluindo uma letra e um caractere especial (!@#$%^&*).">
                                    <div class="invalid-feedback">
                                        Password is required
                                    </div>
                                    <div class="form-text text-muted">
                                        Crie uma senha fácil de você lembrar
                                    </div>
                                </div>

                                <div class="form-group m-0">
                                    <button type="submit" class="btn btn-primary btn-block">
                                        Criar Nova Senha
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                    <div class="footer">
                        Copyright &copy; 2025 &mdash; PCMA
                    </div>
                </div>
            </div>
        </div>
    </section>

    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
    <script src="js/my-login.js"></script>
</body>
</html>

