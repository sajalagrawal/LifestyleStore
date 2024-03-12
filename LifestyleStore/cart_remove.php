<?php
require 'connection.php';
session_start();
$item_id = $_GET['id'];
$user_id = $_SESSION['id'];

$delete_query = "DELETE FROM users_items WHERE user_id = :user_id AND item_id = :item_id";
$delete_query_stmt = $con->prepare($delete_query);
$delete_query_stmt->bindParam(':user_id', $user_id);
$delete_query_stmt->bindParam(':item_id', $item_id);
$delete_query_result = $delete_query_stmt->execute();

header('location: cart.php');
?>
