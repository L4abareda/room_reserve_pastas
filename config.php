<?php
// conexão com o banco de dados 

$host = 'localhost';
$dbname = 'room_booking'; // nome do banco
$user = 'root';               // usuário padrão 
$password = '';               // senha vazia 

try {
    // Conexão 
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $user, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    // Mensagem de erro se não conectar
    die('Erro na conexão com o banco de dados: ' . $e->getMessage());
}
?>