<?php
require_once('../config/config.php');
session_start();

// Verifica login
if (!isset($_SESSION['user_id'])) {
    header('Location: ../view/login.php');
    exit;
}

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