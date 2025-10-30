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
    <meta charset="UTF-8">
    <title>Login</title>
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>
    <div class="container">
        <h1>Login</h1>

        <?php if (!empty($error_message)) echo '<p class="error">' . $error_message . '</p>'; ?>

        <form method="POST">
            <label>E-mail:</label>
            <input type="email" name="email" required>

            <label>Senha:</label>
            <input type="password" name="password" required>

            <button type="submit">Entrar</button>
        </form>

        <a href="register.php">Criar conta</a>
    </div>
</body>
</html>