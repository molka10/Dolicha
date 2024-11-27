<?php
// Database Configuration
define('DB_HOST', 'localhost');      // Database host (usually localhost)
define('DB_NAME', 'dolicha0.2'); // Name of your database
define('DB_USER', 'root');          // Database username
define('DB_PASS', '');              // Database password (leave blank for XAMPP)

// Establish Database Connection
try {
    $pdo = new PDO("mysql:host=" . DB_HOST . ";dbname=" . DB_NAME, DB_USER, DB_PASS);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); // Enable exceptions
} catch (PDOException $e) {
    die("Database connection failed: " . $e->getMessage());
}
?>
