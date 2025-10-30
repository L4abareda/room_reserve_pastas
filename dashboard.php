<?php
// Painel principal com a listagem das salas disponíveis

session_start();
require 'config.php';

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}

$stmt = $pdo->query('SELECT * FROM rooms');
$rooms = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!-- HTMl lixo-->
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Painel</title>
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>
    <div class="container">
        <h1>Bem-vindo ao Sistema de Reservas</h1>
        <a href="logout.php">Sair</a>

        <h2>Salas disponíveis</h2>
        <ul>
            <?php foreach ($rooms as $room): ?>
                <li><?= htmlspecialchars($room['name']) ?> (Capacidade: <?= $room['capacity'] ?>)
                    - <a href="reserve.php?room_id=<?= $room['id'] ?>">Reservar</a>
                </li>
            <?php endforeach; ?>
        </ul>
    </div>
</body>
</html>