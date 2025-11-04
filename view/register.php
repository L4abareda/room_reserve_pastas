<!-- HTML lixo -->
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Criar Conta</title>
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>
    <div class="container">
        <h1>Criar Conta</h1>

        <?php if (!empty($error_message)) echo '<p class="error">' . $error_message . '</p>'; ?>

        <form method="POST">
            <label>Nome:</label>
            <input type="text" name="name" required>

            <label>E-mail:</label>
            <input type="email" name="email" required>

            <label>Senha:</label>
            <input type="password" name="password" required>

            <button type="submit">Registrar</button>
        </form>

        <a href="login.php">Já tenho conta</a>
    </div>
</body>
</html>