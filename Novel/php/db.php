<?php 
$dsn = "mysql:host=DB;dbname=bookstore";
$username = "root";
$password = "root";

try {
    $pdo = new PDO($dsn, $username, $password);
} catch (PDOException $e) {
    echo 'Connection failed: ' . $e->getMessage();
}
?>