<?php
// ============================================================
// FILE: login_oop.php
// METHOD: MySQLi OOP (Object-Oriented Programming)
// ============================================================
// 📌 WHAT IS MySQLi OOP?
// OOP stands for Object-Oriented Programming.
// Instead of using functions like procedural style,
// we create an OBJECT of the mysqli class:
//   $conn = new mysqli(...)
// Then we call methods on that object:
//   $conn->query(...)
//   $conn->close()
// Same functionality as procedural — just different coding style.
//
// 📌 DIFFERENCE FROM PROCEDURAL:
//   Procedural:  mysqli_connect()  / mysqli_query()
//   OOP:         new mysqli()      / $conn->query()
//
// 📌 WHAT IS SQL INJECTION?
// SQL Injection is an attack where the hacker types SQL code
// into the input field instead of a normal username/password.
// Because our query directly uses the user's input without
// checking it, the SQL code gets executed by the database.
//
// 📌 WHY IS THIS VULNERABLE?
// The query directly concatenates (joins) the user input:
//   $query = "SELECT * FROM users WHERE username='$username'..."
// If the user types:  ' OR '1'='1
// The query becomes:
//   SELECT * FROM users WHERE username='' OR '1'='1' AND password='' OR '1'='1'
// Since '1'='1' is ALWAYS TRUE, the database returns a user
// and login is granted — even without valid credentials!
//
// ⚠️ NOTE: This is INTENTIONALLY vulnerable for educational demo.
// In real applications, ALWAYS use prepared statements!
// ============================================================

require_once 'db_config.php'; // Load database credentials
session_start();              // Start session to store login info

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    // Get the username and password from the login form
    // ❌ NO sanitization here — this is what makes it vulnerable!
    $username = $_POST['username'];
    $password = $_POST['password'];

    // ============================================================
    // ⚠️ VULNERABLE QUERY — input is directly placed in the query
    //
    // TO DEMONSTRATE SQL INJECTION, use these inputs:
    //   Username: ' OR '1'='1
    //   Password: ' OR '1'='1
    //
    // The query will become:
    //   SELECT * FROM users WHERE username='' OR '1'='1'
    //   AND password='' OR '1'='1'
    // '1'='1' is always TRUE → login bypassed! 💥
    // ============================================================
    $query = "SELECT * FROM users WHERE username='$username' AND password='$password'";

    // Step 1: Connect using MySQLi OOP style (creating an object)
    $conn = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);

    // Step 2: Check if connection was successful
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Step 3: Run the query using the object method
    $result = $conn->query($query);

    // Step 4: Check if any user was found
    if ($result && $result->num_rows > 0) {
        // ✅ Login successful — store user info in session
        $user = $result->fetch_assoc();
        $_SESSION['user'] = $user['username'];
        $_SESSION['method'] = 'MySQLi OOP';
        header("Location: dashboard.php"); // Redirect to dashboard
    } else {
        // ❌ Login failed — show error and the query that was executed
        echo "<div style='font-family:sans-serif;max-width:600px;margin:50px auto;padding:20px;background:#fff3cd;border:1px solid #ffc107;border-radius:8px;'>";
        echo "<h3>❌ Login Failed — MySQLi OOP</h3>";
        echo "<p><strong>Query executed:</strong><br><code>" . htmlspecialchars($query) . "</code></p>";
        echo "<p><a href='signin.html'>← Try Again</a></p>";
        echo "</div>";
    }

    // Step 5: Close the connection using object method
    $conn->close();
}
?>
