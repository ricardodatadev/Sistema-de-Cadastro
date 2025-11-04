<?php
session_start();
include 'config.php';

$erro = "";
$sucesso = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $usuario = trim($_POST['name']);
    $senha = $_POST['password'];
    $email = trim($_POST['email']);
    $confirmar_senha = $_POST['confirm-password'];

    // Verifica se os campos foram preenchidos corretamente
    if (empty($usuario) || empty($senha) || empty($email) || empty($confirmar_senha)) {
        $erro = "Todos os campos são obrigatórios.";
    } elseif (strpos($usuario, ' ') !== false) { 
        $erro = "O nome de usuário não pode conter espaços.";
    } elseif ($senha !== $confirmar_senha) {
        $erro = "As senhas não coincidem.";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $erro = "E-mail inválido.";
    } elseif (!preg_match('/^(?=.*[A-Za-z])(?=.*[!@#$%^&*])[A-Za-z\d!@#$%^&*]{8,}$/', $senha)) {
        $erro = "A senha deve ter pelo menos 8 caracteres, incluindo 1 letra e 1 caractere especial.";
    } else {
        // Verificar se o nome de usuário já existe
        $sql_check_usuario = "SELECT * FROM usuarios WHERE usuario = ?";
        $stmt = $conn->prepare($sql_check_usuario);
        $stmt->bind_param("s", $usuario);
        $stmt->execute();
        $result_usuario = $stmt->get_result();

        if ($result_usuario->num_rows > 0) {
            $erro = "Este nome de usuário já está cadastrado.";
        } else {
            // Verificar se o e-mail já existe
            $sql_check_email = "SELECT * FROM usuarios WHERE email = ?";
            $stmt = $conn->prepare($sql_check_email);
            $stmt->bind_param("s", $email);
            $stmt->execute();
            $result_email = $stmt->get_result();

            if ($result_email->num_rows > 0) {
                $erro = "Este e-mail já está cadastrado.";
            } else {
                // Criptografando a senha antes de armazenar no banco
                $senha_hash = password_hash($senha, PASSWORD_DEFAULT);

                // Inserindo o novo usuário no banco de dados
                $sql = "INSERT INTO usuarios (usuario, senha, email) VALUES (?, ?, ?)";
                $stmt = $conn->prepare($sql);
                $stmt->bind_param("sss", $usuario, $senha_hash, $email);

                if ($stmt->execute()) {
                    $sucesso = "Cadastro realizado com sucesso!";
                } else {
                    $erro = "Erro ao cadastrar. Tente novamente.";
                }
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title>Cadastro de Usuário</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="my-login.css">
</head>
<body class="my-login-page">
    <section class="h-100 d-flex justify-content-center align-items-center">
        <div class="container-fluid h-100 d-flex justify-content-center align-items-center">
            <div class="row justify-content-md-center">
                <div class="col-xxl-12 col-xl-5 col-lg-5 col-md-7 col-sm-9">
                    <div class="card fat">
                        <div class="card-body">
                            <h4 class="card-title text-center">Cadastro de Usuário</h4>

                            <!-- Exibir mensagens de erro ou sucesso -->
                            <?php if (!empty($erro)): ?>
                                <div class="alert alert-danger text-center"><?php echo $erro; ?></div>
                            <?php endif; ?>

                            <?php if (!empty($sucesso)): ?>
                                <div class="alert alert-success text-center"><?php echo $sucesso; ?></div>
                            <?php endif; ?>

                            <form action="" method="POST" class="my-login-validation">
                                <div class="form-group">
                                    <label for="name">Usuário</label>
                                    <input id="name" type="text" class="form-control" name="name" value="<?php echo isset($usuario) ? htmlspecialchars($usuario) : ''; ?>" required>
                                </div>

                                <div class="form-group">
                                    <label for="email">E-Mail</label>
                                    <input id="email" type="email" class="form-control" name="email" value="<?php echo isset($email) ? htmlspecialchars($email) : ''; ?>" required>
                                </div>

                                <div class="form-group">
                                    <label for="password">Senha</label>
                                    <input id="password" type="password" class="form-control" name="password" required>
                                </div>

                                <div class="form-group">
                                    <label for="confirm-password">Confirmar Senha</label>
                                    <input id="confirm-password" type="password" class="form-control" name="confirm-password" required>
                                </div>

                                <div class="form-group mt-4 d-flex justify-content-center">
                                    <button type="submit" class="btn btn-primary btn-block">
                                        Cadastrar
                                    </button>
                                </div>
                                <div class="mt-4 text-center">
                                    Já é cadastrado? <a href="index.php">Logar agora</a>
                                </div>
                            </form>
                        </div>
                    </div>
                    <div class="footer text-center">
                        Copyright &copy; 2025 &mdash; Ricardo Pereira
                    </div>
                </div>
            </div>
        </div>
    </section>
</body>
</html>

