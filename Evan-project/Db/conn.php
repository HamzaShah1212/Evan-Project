<?php
$host     = "localhost";
$db       = "evacprojects";
$username = "root";
$password = "";

try {
    // PDO connection
    $pdo = new PDO("mysql:host=$host;dbname=$db;charset=utf8mb4", $username, $password);

    // Error mode ko Exception par set karna (Best practice)
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

  
} catch (PDOException $e) {
    // Error handle
    echo "❌ Connection failed: " . $e->getMessage();
}
?>
