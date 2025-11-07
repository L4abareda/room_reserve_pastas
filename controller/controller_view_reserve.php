<?php
if (!isset($error_message)) $error_message = '';
if (!isset($success_message)) $success_message = '';
?>


<?php 

// Página para fazer uma reserva de sala
session_start();
require '../config/config.php';

if (!isset($_SESSION['user_id'])) {
    header('Location: ../view/login.php');
    exit;
}

// Pega o ID da sala da URL
$room_id = $_GET['room_id'] ?? null;
if (!$room_id) {
    header('Location: ../view/dashboard.php');
    exit;
}

// Pega dados da sala (opcional, para mostrar nome)
$stmt_room = $pdo->prepare("SELECT * FROM rooms WHERE id = :room_id");
$stmt_room->execute(['room_id' => $room_id]);
$room = $stmt_room->fetch(PDO::FETCH_ASSOC);

if (!$room) {
    header('Location: ../view/dashboard.php');
    exit;
}

