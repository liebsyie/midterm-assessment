# Midterm Assessment: Login System with SQL Injection Demo

**PHP + MySQL** Login System using **3 different methods**  
**MySQLi Procedural | MySQLi OOP | PDO**

This project demonstrates how **all three** authentication methods are **vulnerable to SQL Injection** when prepared statements are not used. Created as a requirement for the Midterm Exam (Test 3 Number 2).

---

## 🚀 Features
- Login using **3 different PHP-MySQL methods**
- Registration page (OOP, PDO, Procedural versions)
- Intentional **SQL Injection vulnerability** for educational demo
- Dashboard after successful login
- Plain-text password (for easier SQLi demonstration)

---

## 👥 Group Members & Roles

| Member     | Role                  | Tasks During Presentation                  |
|------------|-----------------------|--------------------------------------------|
| Member 1   | Presenter / Leader    | Introduction, explains 3 methods, wrap-up |
| Member 2   | Demo Handler          | Handles screen sharing & live demo        |
| Member 3   | Code Explainer        | Opens VS Code and explains vulnerable code|

---

## 🛠️ Technologies Used
- **PHP** (MySQLi Procedural, MySQLi OOP, PDO)
- **MySQL** (via phpMyAdmin)
- **XAMPP** (Apache + MySQL)
- HTML + CSS (simple UI)

---

## 📁 Project Files

- `signin.html` → Login page (with method selector)
- `signup.html` → Registration page
- `login_procedural.php`
- `login_oop.php`
- `login_pdo.php`
- `register_procedural.php`, `register_oop.php`, `register_pdo.php`
- `dashboard.php`
- `db_config.php` → Database connection
- `database_setup.sql` → Database & table setup

---

## ⚙️ Setup Instructions (Before Presentation)

1. Start **XAMPP** → Apache + MySQL
2. Import `database_setup.sql` sa phpMyAdmin (database name: `auth_demo`)
3. Copy all files to `htdocs/midterm/` folder
4. Open browser → `http://localhost/signin.html`

**Test Credentials:**
- Username: `testuser`
- Password: `password123`

---

## 🎯 Demo Steps (Exactly as in Presentation Guide)

1. **Normal Login**
2. **Wrong Password**
3. **SQL Injection Bypass** (same payload for all 3 methods):

   **Username:** `' OR '1'='1`  
   **Password:** `' OR '1'='1`

All three methods (Procedural, OOP, PDO) will be **successfully bypassed**.

---

## ⚠️ Security Note

> This project is **intentionally vulnerable** to demonstrate SQL Injection.  
> In a real-world application, **always use prepared statements** with `bind_param()` or `bindValue()`.

**Vulnerable query (what we used):**
```php
$query = "SELECT * FROM users WHERE username='$username' AND password='$password'";
