<?php
session_start();
include_once '../Db/conn.php';  // Database connection file

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);

    if (!empty($email) && !empty($password)) {
        $sql = "SELECT id, name, email, password FROM evac_user WHERE email = ?";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$email]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user) {
            if ($password === $user['password']) { // TODO: password_hash verify
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['user_name'] = $user['name'];
                $_SESSION['user_email'] = $user['email'];

                header("Location: dashboard.php");
                exit;
            } else {
                $error = "Invalid password!";
            }
        } else {
            $error = "No account found with this email!";
        }
    } else {
        $error = "Please enter email and password.";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Login - Evan Vista</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;500;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="./Assests/style.css">  
</head>
<body>

    <!-- Login Box -->
    <div class="login-container">
        <!-- Logo + Title Inside -->
        <div class="logo-section">
            <img src="../Assests/images/logo 1.png" alt="Logo">
            <h1>ECO VISTA</h1>
            <p>ARCHITECTS AND CONSULTANTS</p>
        </div>

        <h2>User Login</h2>

        <?php if (!empty($error)) echo "<p class='error'>$error</p>"; ?>

        <form method="POST" action="">
            <input type="email" name="email" placeholder="Enter your email" required>
            <input type="password" name="password" placeholder="Enter your password" required>
            <button type="submit">Login</button>
        </form>
    </div>

</body>
</html>
