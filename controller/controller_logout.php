<?php
// mata a sessão do usuário e volta para a tela de login

session_start();
session_destroy();
header('Location: ../login.php');
exit;
?>