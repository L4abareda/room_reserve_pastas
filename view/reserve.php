<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Reservar Sala</title>
    <link rel="stylesheet" href="../view/css/style.css">
</head>
<body>
    <div class="container">
        <?php require_once('../controller/controller_view_reserve.php'); ?>
        <h1>Fazer Reserva - <?= htmlspecialchars($room['name']) ?></h1>

        <?php if ($error_message): ?>
            <p class="error"><?= htmlspecialchars($error_message) ?></p>
        <?php endif; ?>
        <?php if ($success_message): ?>
            <p class="success"><?= htmlspecialchars($success_message) ?></p>
        <?php endif; ?>

        <!-- Formulário de reserva -->
        <form method="POST" action="../controller/controller_reserve.php" class="form-reserva">
            <input type="hidden" name="room_id" value="<?= $_GET['room_id'] ?>">
            
            <label>Data da Reserva:</label>
            <input type="date" name="reservation_date" required
                   min="<?= $currentYear ?>-01-01"
                   max="<?= $currentYear ?>-12-31">

            <label>Horário de Início:</label>
            <input type="time" name="start_time" required>

            <label>Horário de Fim:</label>
            <input type="time" name="end_time" required>

            <button type="submit" name="make_reservation" class="btn reservar">Confirmar Reserva</button>
        </form>

        <a href="../view/dashboard.php" class="voltar">Voltar</a>
    </div>
</body>
</html>