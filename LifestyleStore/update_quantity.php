<?php
require 'connection.php';
session_start();
$user_id = $_SESSION['id'];

if (isset($_POST['item_id']) && isset($_POST['quantity'])) {
    $item_id = $_POST['item_id'];
    $quantity = $_POST['quantity'];

    // Update the quantity for the selected item
    $update_query = "UPDATE users_items SET quantity='$quantity' WHERE user_id='$user_id' AND item_id='$item_id'";
    mysqli_query($con, $update_query) or die(mysqli_error($con));

    header("location: cart.php");
    exit();
} else {
    header("location: cart.php");
    exit();
}
?>