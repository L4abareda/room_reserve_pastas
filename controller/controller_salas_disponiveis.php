<?php 
session_start();
require '../config/config.php';

if (!isset($_SESSION['user_id'])) {
    header('Location: ../view/login.php');
    exit;
}

$stmt_salas = $pdo->prepare("SELECT * FROM reservations");
$stmt_sala->execute();
$salas = $stmt_salas->fetch(PDO::FETCH_ASSOC);

?>