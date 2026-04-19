<?php
// register_oop.php - MySQLi OOP Registration
require_once 'db_config.php';
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $email    = $_POST['email'];
    $password = $_POST['password'];

    $conn = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
    if ($conn->connect_error) die("Connection failed: " . $conn->connect_error);

    $check = $conn->query("SELECT id FROM users WHERE email='$email'");
    if ($check->num_rows > 0) {
        echo "<script>alert('Email already registered!');window.location='signup.html';</script>";
        exit;
    }

    $query = "INSERT INTO users (username, email, password) VALUES ('$username', '$email', '$password')";
    if ($conn->query($query)) {
        echo "<script>alert('Account created! Please sign in.');window.location='signin.html';</script>";
    } else {
        echo "Error: " . $conn->error;
    }
    $conn->close();
}
?>
