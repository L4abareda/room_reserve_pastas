<?php
// Painel principal com a listagem das salas disponíveis

session_start();
require '../config/config.php';

if (!isset($_SESSION['user_id'])) {
    header('Location: ../view/login.php');
    exit;
}

// Busca todas as salas no banco de dados
$stmt = $pdo->query('SELECT * FROM rooms');
$rooms = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>