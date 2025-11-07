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
            <button type="button" onclick="location.href='../controller/controller_logout.php'">Sair</button>
        </header>

        <main>
            <h2 style="margin-top:0;font-size:16px;">Salas disponíveis</h2>

            <ul style="list-style:none;padding:0;margin:0;display:flex;flex-direction:column;gap:12px;">
                <?php require_once('../controller/controller_dashboard.php'); ?>
                <?php foreach ($rooms as $room): ?>
                    <li style="display:flex;justify-content:space-between;align-items:center;padding:12px;border:1px solid #eef0f3;border-radius:8px;background:#fff;">
                        <div>
                            <div style="font-weight:700;">
                                <?= htmlspecialchars($room['name']) ?> - <?= htmlspecialchars($room['id']) ?>
                            </div>
                            <div class="small" style="margin-top:4px;color:#666;">
                                Capacidade: <?= htmlspecialchars($room['capacity']) ?> pessoas
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

            <!-- Formulário para criar nova sala -->
            <section style="margin-top: 24px;">
                <h3 style="font-size:16px;">Criar Nova Sala</h3>
                <form method="POST" action="../controller/controller_reserve.php"
                      style="display:flex;flex-direction:column;gap:8px;max-width:300px;">

                    <input type="text" name="new_room_name" placeholder="Nome da nova sala" required>

                    <input type="number" name="new_room_capacity" placeholder="Capacidade (número de pessoas)"
                           min="1" required>

                    <button type="submit" name="create_room"
                            style="padding:8px 12px;background:#007bff;color:#fff;border:none;border-radius:6px;cursor:pointer;">
                        Criar Sala
                    </button>
                </form>
            </section>

            <!-- Formulário para excluir uma sala -->
            <section style="margin-top: 16px;">
                <h3 style="font-size:16px;">Excluir Sala</h3>
                <form method="POST" action="../controller/controller_reserve.php"
                      style="display:flex;flex-direction:column;gap:8px;max-width:300px;">

                    <input type="number" name="delete_room_id" placeholder="ID da sala para excluir" required>

                    <button type="submit" name="delete_room"
                            style="padding:8px 12px;background:#dc3545;color:#fff;border:none;border-radius:6px;cursor:pointer;">
                        Excluir Sala
                    </button>
                </form>
            </section>
        </main>
    </div>
</body>
</html>