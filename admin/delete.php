<?php
session_start();
require_once __DIR__ . '/../db.php';
$pdo->prepare("DELETE FROM cars WHERE id = ?")->execute([$_GET['id']]);
header("Location: index.php");