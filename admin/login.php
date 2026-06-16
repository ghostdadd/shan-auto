<?php
session_start();

// Укажи здесь свой логин и пароль
$admin_user = 'admin';
$admin_pass = 'password'; // В реальности лучше использовать password_hash

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if ($_POST['username'] === $admin_user && $_POST['password'] === $admin_pass) {
        $_SESSION['admin_logged_in'] = true;
        header("Location: index.php");
        exit;
    } else {
        $error = "Неверный логин или пароль!";
    }
}
?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Вход в админку</title>
    <style>
        body { background: #0f172a; color: white; display: flex; justify-content: center; align-items: center; height: 100vh; font-family: sans-serif; }
        form { background: #1e293b; padding: 30px; border-radius: 15px; width: 300px; }
        input { width: 100%; padding: 10px; margin: 10px 0; border-radius: 5px; border: none; }
        button { width: 100%; padding: 10px; background: #3b82f6; color: white; border: none; border-radius: 5px; cursor: pointer; }
    </style>
</head>
<body>
    <form method="POST">
        <h2>Вход</h2>
        <?php if (isset($error)) echo "<p style='color:red;'>$error</p>"; ?>
        <input type="text" name="username" placeholder="Логин" required>
        <input type="password" name="password" placeholder="Пароль" required>
        <button type="submit">Войти</button>
    </form>
</body>
</html>