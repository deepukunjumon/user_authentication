<?php
require 'config.php';

$message = '';
$class = '';
if (isset($_SESSION['message'])) {
    $message = $_SESSION['message'];
    $class = $_SESSION['class'];
    unset($_SESSION['message'], $_SESSION['class']);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = trim($_POST['username']);
    $email = trim($_POST['email']);
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

    $stmt = $conn->prepare("INSERT INTO users (username, email, password_hash) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $username, $email, $password);

    if ($stmt->execute()) {
        $_SESSION['message'] = "Registration successful!";
        $_SESSION['class'] = "success";
    } else {
        $_SESSION['message'] = "Error: " . $stmt->error;
        $_SESSION['class'] = "error";
    }

    $stmt->close();

    header("Location: register.php");
    exit;
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Register</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="form-wrapper">
        <form method="POST">
            <h2>Register</h2>
            <label for="username">Username:</label>
            <input id="username" name="username" type="text" required>

            <label for="email">Email:</label>
            <input id="email" name="email" type="email" required>

            <label for="password">Password:</label>
            <input id="password" name="password" type="password" required>

            <button type="submit">Register</button>
    
            <p>Already have an account? <a href="login.php">Login here</a></p>
        </form>

        <?php if ($message): ?>
            <div class="popup-message <?= $class ?>"><?= $message ?></div>
        <?php endif; ?>
    </div>
</body>
</html>
