<?php
// register_pdo.php - PDO Registration
require_once 'db_config.php';
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $email    = $_POST['email'];
    $password = $_POST['password'];

    try {
        $dsn = "mysql:host=" . DB_HOST . ";dbname=" . DB_NAME . ";charset=utf8";
        $pdo = new PDO($dsn, DB_USER, DB_PASS);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $check = $pdo->query("SELECT id FROM users WHERE email='$email'");
        if ($check->rowCount() > 0) {
            echo "<script>alert('Email already registered!');window.location='signup.html';</script>";
            exit;
        }

        $pdo->query("INSERT INTO users (username, email, password) VALUES ('$username', '$email', '$password')");
        echo "<script>alert('Account created! Please sign in.');window.location='signin.html';</script>";
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
}
?>
