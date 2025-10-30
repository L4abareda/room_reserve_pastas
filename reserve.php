<?php
// Página para fazer uma reserva de sala



// Php é horrivel ou eu sou muito burro

session_start();
require 'config.php';

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}

$room_id = $_GET['room_id'] ?? null;
if (!$room_id) {
    header('Location: dashboard.php');
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $reservation_date = $_POST['reservation_date'];
    $start_time = $_POST['start_time'];
    $end_time = $_POST['end_time'];
    $user_id = $_SESSION['user_id'];

    // Verifica conflito de horário
    $stmt = $pdo->prepare('SELECT * FROM reservations WHERE room_id = :room_id AND reservation_date = :reservation_date AND ((:start_time BETWEEN start_time AND end_time) OR (:end_time BETWEEN start_time AND end_time))');
    $stmt->bindParam(':room_id', $room_id);
    $stmt->bindParam(':reservation_date', $reservation_date);
    $stmt->bindParam(':start_time', $start_time);
    $stmt->bindParam(':end_time', $end_time);
    $stmt->execute();

    if ($stmt->rowCount() > 0) {
        $error_message = 'Já existe uma reserva neste horário!';
    } else {
        $insert = $pdo->prepare('INSERT INTO reservations (user_id, room_id, reservation_date, start_time, end_time) VALUES (:user_id, :room_id, :reservation_date, :start_time, :end_time)');
        $insert->bindParam(':user_id', $user_id);
        $insert->bindParam(':room_id', $room_id);
        $insert->bindParam(':reservation_date', $reservation_date);
        $insert->bindParam(':start_time', $start_time);
        $insert->bindParam(':end_time', $end_time);

        if ($insert->execute()) {
            $success_message = 'Reserva realizada com sucesso!';
        } else {
            $error_message = 'Erro ao fazer reserva.';
        }
    }
}
?>

<!-- HTML lixo-->
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Reservar Sala</title>
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>
    <div class="container">
        <h1>Fazer Reserva</h1>
        <?php if (!empty($error_message)) echo '<p class="error">' . $error_message . '</p>'; ?>
        <?php if (!empty($success_message)) echo '<p class="success">' . $success_message . '</p>'; ?>

        <form method="POST">
            <label>Data da Reserva:</label>
            <input type="date" name="reservation_date" required>

            <label>Horário de Início:</label>
            <input type="time" name="start_time" required>

            <label>Horário de Fim:</label>
            <input type="time" name="end_time" required>

            <button type="submit">Confirmar Reserva</button>
        </form>

        <a href="dashboard.php">Voltar</a>
    </div>
</body>
</html>