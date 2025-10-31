<?php

 // página de Login
session_start();
require 'config.php'; // faz a conexão com o banco

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'] ?? '';
    $password = $_POST['password'] ?? '';

    // Busca o usuário pelo e-mail
    $stmt = $pdo->prepare('SELECT * FROM users WHERE email = :email');
    $stmt->bindParam(':email', $email);
    $stmt->execute();

    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    // Verifica se o e-mail e a senha são iguais
    if ($user && password_verify($password, $user['password'])) {
        $_SESSION['user_id'] = $user['id'];
        header('Location: dashboard.php');
        exit;
    } else {
        $error_message = 'E-mail ou senha incorretos!';
    }
}
?>

<!-- HTMl lixo -->
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="utf-8" />
    <title>Login — Sistema de Reservas</title>
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>
    <div class="container" role="main" aria-labelledby="login-title">
        <h1 id="login-title">Entrar</h1>
        <p class="small">Use seu e-mail e senha para acessar.</p>

        <!-- Mensagem de erro vinda do PHP -->
        <?php if (!empty($error_message)): ?>
            <p class="error"><?= htmlspecialchars($error_message) ?></p>
        <?php endif; ?>

        <form action="login.php" method="post" autocomplete="on" novalidate>
            <label for="email">E-mail</label>
            <input id="email" name="email" type="email" required placeholder="gmail@exemplo.com" autofocus>

            <label for="password">Senha</label>
            <input id="password" name="password" type="password" required placeholder="••••••••">

            <div style="display:flex;justify-content:space-between;align-items:center;margin-top:12px;">
                <button type="submit">Entrar</button>
                <a href="register.php" class="small">Criar conta</a>
            </div>
        </form>
    </div>
</body>
</html>