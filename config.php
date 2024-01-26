<?php
/* Database credentials */
define('DB_SERVER', '104.251.111.203');
define('DB_USERNAME', 'free91057380_home');
define('DB_PASSWORD', 'AmiMotiur27@');
define('DB_NAME', 'free91057380_home');

/* Attempt to connect to MySQL database using PDO */
try {
    $pdo = new PDO("mysql:host=" . DB_SERVER . ";dbname=" . DB_NAME, DB_USERNAME, DB_PASSWORD);
    // Set PDO error mode to exception
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch(PDOException $e) {
    die("ERROR: Could not connect. " . $e->getMessage());
}
?>
