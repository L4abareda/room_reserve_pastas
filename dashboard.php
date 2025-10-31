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
    <meta charset="utf-8" />
    <title>Painel - Sistema de Reservas</title>
    <link rel="stylesheet" href="assets/css/style.css?v=1.2">
</head>
<body>
    <div class="container">
        <header style="display:flex;justify-content:space-between;align-items:center;margin-bottom:16px;">
            <h1 style="margin:0;font-size:20px;">Sistema de Reservas</h1>
            <button type="button" onclick="location.href='logout.php'">Sair</button>
        </header>

        <main>
            <h2 style="margin-top:0;font-size:16px;">Salas disponíveis</h2>

            <ul style="list-style:none;padding:0;margin:0;display:flex;flex-direction:column;gap:12px;">
                <li style="display:flex;justify-content:space-between;align-items:center;padding:12px;border:1px solid #eef0f3;border-radius:8px;background:#fff;">
                    <div>
                        <div style="font-weight:700;">Sala A</div>
                        <div class="small" style="margin-top:4px;color:#666;">Capacidade: 8</div>
                    </div>
                    <div>
                        <button type="button" onclick="alert('Reservar Sala A')">Reservar</button>
                        <a href="reserve.php"></a>
                    </div>
                </li>

                <li style="display:flex;justify-content:space-between;align-items:center;padding:12px;border:1px solid #eef0f3;border-radius:8px;background:#fff;">
                    <div>
                        <div style="font-weight:700;">Sala B</div>
                        <div class="small" style="margin-top:4px;color:#666;">Capacidade: 12</div>
                    </div>
                    <div>
                        <button type="button" onclick="alert('Reservar Sala B')">Reservar</button>
                    </div>
                </li>

                <li style="display:flex;justify-content:space-between;align-items:center;padding:12px;border:1px solid #eef0f3;border-radius:8px;background:#fff;">
                    <div>
                        <div style="font-weight:700;">Sala de Reunião</div>
                        <div class="small" style="margin-top:4px;color:#666;">Capacidade: 20</div>
                    </div>
                    <div>
                        <button type="button" onclick="alert('Reservar Sala de Reunião')">Reservar</button>
                    </div>
                </li>
            </ul>
        </main>
    </div>
</body>
</html>
