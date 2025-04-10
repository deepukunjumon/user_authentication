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
    $email = trim($_POST['email']);
    $password = $_POST['password'];

    //Validations
    if (empty($email) || empty($password)) {
        $_SESSION['message'] = "Email and password cannot be empty.";
        $_SESSION['class'] = "error";
        header("Location: login.php");
        exit;
    }

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $_SESSION['message'] = "Invalid email format.";
        $_SESSION['class'] = "error";
        header("Location: login.php");
        exit;
    }

    $stmt = $conn->prepare("SELECT id, username, password_hash FROM users WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows === 1) {
        $stmt->bind_result($id, $username, $password_hash);
        $stmt->fetch();

        if (password_verify($password, $password_hash)) {
            session_regenerate_id(true);

            $_SESSION['user_id'] = $id;
            $_SESSION['username'] = $username;
            $_SESSION['user_agent'] = $_SERVER['HTTP_USER_AGENT'];
            $_SESSION['ip'] = $_SERVER['REMOTE_ADDR'];

            header("Location: dashboard.php");
            exit;
        } else {
            $_SESSION['message'] = "Invalid Credentials.";
            $_SESSION['class'] = "error";
            header("Location: login.php");
            exit;
        }
    } else {
        $_SESSION['message'] = "No user found with this email.";
        $_SESSION['class'] = "error";
        header("Location: login.php");
        exit;
    }

    $stmt->close();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Log In</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="form-wrapper">
        <form method="POST">
            <h2>Log In</h2>

            <label for="email">Email:</label>
            <input id="email" type="email" name="email" required>

            <label for="password">Password:</label>
            <input id="password" type="password" name="password" required>

            <button type="submit">Login</button>
            <p>Don't have an account? <a href="register.php">Click here</a></p>
        </form>

        <?php if ($message): ?>
            <div class="popup-message <?= $class ?>"><?= $message ?></div>
        <?php endif; ?>
    </div>
</body>
</html>
