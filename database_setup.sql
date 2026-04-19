-- ============================================================
-- FILE: database_setup.sql
-- PURPOSE: Create the database and table for the login system
-- ============================================================
-- 📌 HOW TO USE THIS FILE:
-- 1. Open phpMyAdmin (http://localhost/phpmyadmin)
-- 2. Click on any database on the left sidebar
-- 3. Click the "SQL" tab at the top
-- 4. Copy and paste everything below into the text box
-- 5. Click "Go"
--
-- 📌 WHAT THIS FILE DOES:
-- 1. Drops (deletes) the old auth_demo database if it exists
-- 2. Creates a fresh auth_demo database
-- 3. Creates a "users" table inside it
-- 4. Inserts one test user for the demo
--
-- 📌 ABOUT THE USERS TABLE:
-- id         = auto-incrementing unique number for each user
-- username   = the login name
-- email      = the email address (must be unique)
-- password   = the password (plain text for demo purposes only!)
-- created_at = timestamp when the account was created
--
-- ⚠️ NOTE: In real applications, NEVER store plain text passwords!
-- Always use password_hash() to encrypt passwords.
-- We use plain text here intentionally so SQL injection is easier
-- to demonstrate during the presentation.
-- ============================================================

-- Step 1: Delete old database if it exists (fresh start)
DROP DATABASE IF EXISTS auth_demo;

-- Step 2: Create the new database
CREATE DATABASE auth_demo;

-- Step 3: Select/use the database
USE auth_demo;

-- Step 4: Create the users table
CREATE TABLE users (
    id         INT AUTO_INCREMENT PRIMARY KEY, -- Unique ID for each user
    username   VARCHAR(100) NOT NULL,          -- Login username
    email      VARCHAR(150) NOT NULL UNIQUE,   -- Email (must be unique)
    password   VARCHAR(255) NOT NULL,          -- Password (plain text for demo)
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP -- Auto timestamp
);

-- Step 5: Insert a test user for the demo
-- Username: testuser
-- Password: password123
INSERT INTO users (username, email, password) VALUES 
('testuser', 'test@example.com', 'password123');

-- ============================================================
-- ✅ After running this, you should see:
--    auth_demo database → users table → 1 record (testuser)
--
-- 💥 SQL INJECTION PAYLOAD TO USE DURING DEMO:
--    Username: ' OR '1'='1
--    Password: ' OR '1'='1
--
-- This works on all 3 methods:
--    ✅ MySQLi Procedural (login_procedural.php)
--    ✅ MySQLi OOP        (login_oop.php)
--    ✅ PDO               (login_pdo.php)
-- ============================================================
