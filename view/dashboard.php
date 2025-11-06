<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="utf-8" />
    <title>Painel - Sistema de Reservas</title>
    <link rel="stylesheet" href="../view/css/style.css?v=1.2">
</head>
<body>
    <div class="container">
        <header style="display:flex;justify-content:space-between;align-items:center;margin-bottom:16px;">
            <h1 style="margin:0;font-size:20px;">Sistema de Reservas</h1>
            <button type="button" onclick="location.href='../controller/logout.php'">Sair</button>
        </header>

        <main>
            <h2 style="margin-top:0;font-size:16px;">Salas disponíveis</h2>

            <ul style="list-style:none;padding:0;margin:0;display:flex;flex-direction:column;gap:12px;">
                <?php require_once(
                    '../controller/controller_dashboard.php'
                ); ?>
                <?php foreach ($rooms as $room): ?>
                    <li style="display:flex;justify-content:space-between;align-items:center;padding:12px;border:1px solid #eef0f3;border-radius:8px;background:#fff;">
                        <div>
                            <div style="font-weight:700;">
                                <?= htmlspecialchars($room['name']) ?>
                            </div>
                            <div class="small" style="margin-top:4px;color:#666;">
                                Capacidade: <?= htmlspecialchars($room['capacity']) ?>
                            </div>
                        </div>
                        <div>
                            <!-- Botão funcional para reserva -->
                            <a href="../view/reserve.php?room_id=<?= urlencode($room['id']) ?>" 
                               style="display:inline-block;padding:8px 14px;background:#007BFF;color:#fff;border-radius:6px;text-decoration:none;font-weight:600;">
                                Reservar
                            </a>
                        </div>
                    </li>
                <?php endforeach; ?>
            </ul>
        </main>
    </div>
</body>
</html>