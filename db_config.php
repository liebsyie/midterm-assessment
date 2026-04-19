<?php
// ============================================================
// FILE: db_config.php
// PURPOSE: Database Configuration / Credentials
// ============================================================
// 📌 WHAT IS THIS FILE?
// This file stores the database connection details.
// All 3 login methods (Procedural, OOP, PDO) require this file
// using: require_once 'db_config.php'
//
// 📌 WHY USE A SEPARATE CONFIG FILE?
// Instead of typing the credentials in every PHP file,
// we put them here once — so if we need to change the password
// or database name, we only change it in ONE place.
//
// ⚠️ In real projects, this file should NEVER be uploaded
// to public servers or shared — it contains sensitive info!
// ============================================================

define('DB_HOST', 'localhost'); // The server where MySQL is running (XAMPP = localhost)
define('DB_USER', 'root');      // MySQL username (XAMPP default = root)
define('DB_PASS', '');          // MySQL password (XAMPP default = empty)
define('DB_NAME', 'auth_demo'); // The name of our database
?>
