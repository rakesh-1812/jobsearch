<?php
// Database connection settings
$host = "localhost"; // XAMPP default host
$dbname = "jobhub"; // Your database name
$username = "root"; // Default MySQL username in XAMPP
$password = ""; // No password by default in XAMPP

try {
    // Create a PDO connection
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);
    // Set PDO to throw exceptions for errors
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Database connection failed: " . $e->getMessage());
}
?>
