<?php
function check_if_added_to_cart($item_id){
    //session_start();
    require 'connection.php';
    $user_id = $_SESSION['id'];

    $product_check_query = "SELECT * FROM users_items WHERE item_id = :item_id AND user_id = :user_id AND status = 'Added to cart'";
    $product_check_stmt = $con->prepare($product_check_query);
    $product_check_stmt->bindParam(':item_id', $item_id);
    $product_check_stmt->bindParam(':user_id', $user_id);
    $product_check_stmt->execute();

    $num_rows = $product_check_stmt->rowCount();
    if ($num_rows >= 1) {
        return 1;
    }
    return 0;
}
?>
