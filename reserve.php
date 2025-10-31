<?php
// Página para fazer uma reserva de sala
session_start();
require 'config.php';

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}

// Pega o ID da sala da URL
$room_id = $_GET['room_id'] ?? null;
if (!$room_id) {
    header('Location: dashboard.php');
    exit;
}

// Pega dados da sala (opcional, para mostrar nome)
$stmt_room = $pdo->prepare("SELECT * FROM rooms WHERE id = :room_id");
$stmt_room->execute(['room_id' => $room_id]);
$room = $stmt_room->fetch(PDO::FETCH_ASSOC);

if (!$room) {
    header('Location: dashboard.php');
    exit;
}

$error_message = '';
$success_message = '';
$currentYear = date('Y'); // Ano atual

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $reservation_date = $_POST['reservation_date'];
    $start_time = $_POST['start_time'];
    $end_time = $_POST['end_time'];
    $user_id = $_SESSION['user_id'];

    // Verifica se a data está no ano atual
    $reservation_year = date('Y', strtotime($reservation_date));
    if ($reservation_year != $currentYear) {
        $error_message = "Só é permitido fazer reservas no ano atual ($currentYear).";
    }
    // Validação básica de horários
    elseif ($start_time >= $end_time) {
        $error_message = 'O horário de início deve ser antes do horário de fim.';
    } else {
        // Verifica conflito de horário
        $stmt = $pdo->prepare('
            SELECT * FROM reservations 
            WHERE room_id = :room_id 
            AND reservation_date = :reservation_date 
            AND (
                (:start_time < end_time AND :end_time > start_time)
            )
        ');
        $stmt->execute([
            'room_id' => $room_id,
            'reservation_date' => $reservation_date,
            'start_time' => $start_time,
            'end_time' => $end_time
        ]);

        if ($stmt->rowCount() > 0) {
            $error_message = 'Já existe uma reserva neste horário!';
        } else {
            // Insere a reserva
            $insert = $pdo->prepare('
                INSERT INTO reservations (user_id, room_id, reservation_date, start_time, end_time)
                VALUES (:user_id, :room_id, :reservation_date, :start_time, :end_time)
            ');
            if ($insert->execute([
                'user_id' => $user_id,
                'room_id' => $room_id,
                'reservation_date' => $reservation_date,
                'start_time' => $start_time,
                'end_time' => $end_time
            ])) {
                $success_message = 'Reserva realizada com sucesso!';
            } else {
                $error_message = 'Erro ao fazer reserva.';
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Reservar Sala</title>
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>
    <div class="container">
        <h1>Fazer Reserva - <?= htmlspecialchars($room['name']) ?></h1>

        <?php if ($error_message): ?>
            <p class="error"><?= htmlspecialchars($error_message) ?></p>
        <?php endif; ?>
        <?php if ($success_message): ?>
            <p class="success"><?= htmlspecialchars($success_message) ?></p>
        <?php endif; ?>

        <form method="POST">
            <label>Data da Reserva:</label>
            <input type="date" name="reservation_date" required
                   min="<?= $currentYear ?>-01-01"
                   max="<?= $currentYear ?>-12-31">

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
