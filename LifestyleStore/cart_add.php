<?php
require 'connection.php';
//require 'header.php';
session_start();
$item_id = $_GET['id'];
$user_id = $_SESSION['id'];

$add_to_cart_query = "INSERT INTO users_items(user_id, item_id, status) VALUES (:user_id, :item_id, 'Added to cart')";
$add_to_cart_stmt = $con->prepare($add_to_cart_query);
$add_to_cart_stmt->bindParam(':user_id', $user_id);
$add_to_cart_stmt->bindParam(':item_id', $item_id);
$add_to_cart_result = $add_to_cart_stmt->execute();

header('location: products.php');
?>
