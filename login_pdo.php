<?php
// ============================================================
// FILE: login_pdo.php
// METHOD: PDO (PHP Data Objects)
// ============================================================
// 📌 WHAT IS PDO?
// PDO stands for PHP Data Objects.
// It is the most FLEXIBLE and MODERN way to connect PHP to a database.
// Unlike MySQLi which only works with MySQL,
// PDO supports many databases: MySQL, PostgreSQL, SQLite, etc.
//
// PDO uses a DSN (Data Source Name) to connect:
//   $dsn = "mysql:host=localhost;dbname=auth_demo"
//   $pdo = new PDO($dsn, $user, $pass)
//
// 📌 WHY PDO IS NORMALLY THE MOST SECURE:
// PDO has built-in support for PREPARED STATEMENTS which
// completely prevent SQL injection. Example of secure PDO:
//   $stmt = $pdo->prepare("SELECT * FROM users WHERE username=?");
//   $stmt->execute([$username]);
//
// 📌 WHY THIS VERSION IS STILL VULNERABLE:
// We INTENTIONALLY removed prepared statements and used
// direct string concatenation instead — to demonstrate that
// PDO is only secure IF you use it correctly.
// The vulnerability is in the CODING PRACTICE, not the method!
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
    //
    // ✅ SECURE VERSION (using prepared statements) would be:
    //   $stmt = $pdo->prepare("SELECT * FROM users WHERE username=? AND password=?");
    //   $stmt->execute([$username, $password]);
    // ============================================================
    $query = "SELECT * FROM users WHERE username='$username' AND password='$password'";

    try {
        // Step 1: Create DSN (Data Source Name) — tells PDO how to connect
        $dsn = "mysql:host=" . DB_HOST . ";dbname=" . DB_NAME . ";charset=utf8";

        // Step 2: Create PDO object to connect to database
        $pdo = new PDO($dsn, DB_USER, DB_PASS);

        // Step 3: Set error mode so exceptions are thrown on error
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // Step 4: Run the vulnerable query directly (no prepared statements!)
        $stmt = $pdo->query($query);

        // Step 5: Check if any user was found
        if ($stmt && $stmt->rowCount() > 0) {
            // ✅ Login successful — store user info in session
            $user = $stmt->fetch(PDO::FETCH_ASSOC);
            $_SESSION['user'] = $user['username'];
            $_SESSION['method'] = 'PDO';
            header("Location: dashboard.php"); // Redirect to dashboard
        } else {
            // ❌ Login failed — show error and the query that was executed
            echo "<div style='font-family:sans-serif;max-width:600px;margin:50px auto;padding:20px;background:#fff3cd;border:1px solid #ffc107;border-radius:8px;'>";
            echo "<h3>❌ Login Failed — PDO</h3>";
            echo "<p><strong>Query executed:</strong><br><code>" . htmlspecialchars($query) . "</code></p>";
            echo "<p><a href='signin.html'>← Try Again</a></p>";
            echo "</div>";
        }

    } catch (PDOException $e) {
        // Show database error with the query attempted
        echo "<div style='font-family:sans-serif;max-width:600px;margin:50px auto;padding:20px;background:#f8d7da;border:1px solid #f5c6cb;border-radius:8px;'>";
        echo "<h3>⚠️ Database Error</h3>";
        echo "<p>" . $e->getMessage() . "</p>";
        echo "<p><strong>Query attempted:</strong><br><code>" . htmlspecialchars($query) . "</code></p>";
        echo "<p><a href='signin.html'>← Try Again</a></p>";
        echo "</div>";
    }
}
?>
