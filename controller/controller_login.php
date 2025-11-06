<?php

 // página de Login
session_start();
require '../config/config.php'; // faz a conexão com o banco

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
        header('Location: ../view/dashboard.php');
        exit;
    } else {
        $error_message = 'E-mail ou senha incorretos!';
    }
}
?>
