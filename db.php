<?php
$host = '127.0.1.30'; // Точный IP из логов OpenServer 6
$user = 'root';
$pass = '';           // Если появится ошибка "Access Denied", поменяй на 'root'
$db   = 'shan_auto';
$port = '3306';

try {
    $dsn = "mysql:host=$host;dbname=$db;port=$port;charset=utf8";
    $pdo = new PDO($dsn, $user, $pass, [
        PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        PDO::ATTR_EMULATE_PREPARES   => false,
    ]);
} catch (PDOException $e) {
    die("Ошибка подключения к базе данных: " . $e->getMessage());
}