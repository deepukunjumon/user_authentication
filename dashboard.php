<?php
require 'config.php';

if (!isset($_SESSION['user_id']) ||
    $_SESSION['user_agent'] !== $_SERVER['HTTP_USER_AGENT'] ||
    $_SESSION['ip'] !== $_SERVER['REMOTE_ADDR']) {
    header("Location: login.php");
    exit;
}

$username = htmlspecialchars($_SESSION['username']);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Dashboard</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <a class="logout-btn" href="logout.php">Logout</a>
    <div class="dashboard-container">
        <h2>Welcome, <?= ucwords($username) ?>!</h2>
        <p>You have successfully logged in.</p>
    </div>
</body>
</html>
