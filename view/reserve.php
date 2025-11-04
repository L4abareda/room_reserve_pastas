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