<?php
session_start();
require '../config/config.php';

if (!isset($_SESSION['user_id'])) {
    header('Location: ../view/login.php');
    exit;
}

// Pega o ID da sala da URL
$room_id = $_POST['room_id'] ?? null;

if (!$room_id) {
    header('Location: ../view/dashboard.php');
    exit;
}

$error_message = '';
$success_message = '';
$currentYear = date('Y'); // Ano atual

// =========================
// CRIAR SALA
// =========================
if (isset($_POST['create_room'])) {
    $room_name = trim($_POST['new_room_name']);
    $capacity = (int) $_POST['new_room_capacity']; // pega a capacidade digitada

    try {
        $stmt = $pdo->prepare("INSERT INTO rooms (name, capacity) VALUES (:name, :capacity)");
        $stmt->execute([
            'name' => $room_name,
            'capacity' => $capacity
        ]);

        header('Location: ../view/dashboard.php');
        exit;

    } catch (PDOException $e) {
        die("Erro ao criar sala: " . $e->getMessage());
    }
}

// =========================
// EXCLUIR SALA
// =========================
if (isset($_POST['delete_room'])) {
    $room_id = $_POST['delete_room_id'];

    try {
        $stmt = $pdo->prepare("DELETE FROM rooms WHERE id = :id");
        $stmt->execute(['id' => $room_id]);

        header('Location: ../view/dashboard.php');
        exit;

    } catch (PDOException $e) {
        die("Erro ao excluir sala: " . $e->getMessage());
    }
}

// =========================
// FAZER RESERVA
// =========================
if (isset($_POST['make_reservation'])) {
    $room_id = $_POST['room_id'];
    $reservation_date = $_POST['reservation_date'];
    $start_time = $_POST['start_time'];
    $end_time = $_POST['end_time'];
    $user_id = $_SESSION['user_id'];

    try {
        $stmt = $pdo->prepare("
            INSERT INTO reservations (room_id, user_id, reservation_date, start_time, end_time)
            VALUES (:room_id, :user_id, :reservation_date, :start_time, :end_time)
        ");
        $stmt->execute([
            'room_id' => $room_id,
            'user_id' => $user_id,
            'reservation_date' => $reservation_date,
            'start_time' => $start_time,
            'end_time' => $end_time
        ]);

        header("Location: ../view/dashboard.php");
        exit;

    } catch (PDOException $e) {
        die("Erro ao fazer reserva: " . $e->getMessage());
    }
}

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
                header('Location: ../view/dashboard.php');
            } else {
                $error_message = 'Erro ao fazer reserva.';
            }
        }
    }
}
