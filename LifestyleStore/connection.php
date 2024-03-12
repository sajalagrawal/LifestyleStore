<?php
$host = getenv('MYSQL_HOST'); // Replace with MySQL host
$dbname = getenv('MYSQL_DATABASE');  // Replace with db name
$user = getenv('MYSQL_USER'); 
$password = getenv('MYSQL_PASSWORD'); 

try {
    $con = new PDO("mysql:host=$host;dbname=$dbname", $user, $password);
    $con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Connection failed: " . $e->getMessage());
}
?>
