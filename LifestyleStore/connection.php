<?php
$host = 'localhost'; // Replace with MySQL host
$dbname = 'store'; // Replace with db name
$user = 'root'; // Replace with db username
$password = 'password'; // Replace with db password

try {
    $con = new PDO("mysql:host=$host;dbname=$dbname", $user, $password);
    $con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Connection failed: " . $e->getMessage());
}
?>
