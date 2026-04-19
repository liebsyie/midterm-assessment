<?php
// ============================================================
// FILE: login_procedural.php
// METHOD: MySQLi PROCEDURAL
// ============================================================
// 📌 WHAT IS MySQLi PROCEDURAL?
// MySQLi stands for "MySQL Improved".
// In procedural style, we use FUNCTIONS to connect and query
// the database — like mysqli_connect() and mysqli_query().
// It is called "procedural" because we write code step by step
// using functions, not objects.
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

require_once 'db_config.php'; // Load database credentials (host, user, pass, dbname)
session_start();              // Start the session so we can store login info

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

    // Step 1: Connect to the database using MySQLi PROCEDURAL style
    $conn = mysqli_connect(DB_HOST, DB_USER, DB_PASS, DB_NAME);

    // Step 2: Check if connection was successful
    if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
    }

    // Step 3: Run the query
    $result = mysqli_query($conn, $query);

    // Step 4: Check if any user was found
    if ($result && mysqli_num_rows($result) > 0) {
        // ✅ Login successful — store user info in session
        $user = mysqli_fetch_assoc($result);
        $_SESSION['user'] = $user['username'];
        $_SESSION['method'] = 'MySQLi Procedural';
        header("Location: dashboard.php"); // Redirect to dashboard
    } else {
        // ❌ Login failed — show error and the query that was executed
        echo "<div style='font-family:sans-serif;max-width:600px;margin:50px auto;padding:20px;background:#fff3cd;border:1px solid #ffc107;border-radius:8px;'>";
        echo "<h3>❌ Login Failed — MySQLi Procedural</h3>";
        echo "<p><strong>Query executed:</strong><br><code>" . htmlspecialchars($query) . "</code></p>";
        echo "<p><a href='signin.html'>← Try Again</a></p>";
        echo "</div>";
    }

    // Step 5: Close the connection
    mysqli_close($conn);
}
?>
