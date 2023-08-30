<?php
session_start();
require 'connection.php';
if (!isset($_SESSION['email'])) {
    header('location: login.php');
    exit(); // Stop execution after redirection
}
$user_id = $_SESSION['id'];

$user_products_query = "SELECT it.id, it.name, it.price FROM users_items ut INNER JOIN items it ON it.id = ut.item_id WHERE ut.user_id = :user_id";
$user_products_stmt = $con->prepare($user_products_query);
$user_products_stmt->bindParam(':user_id', $user_id);
$user_products_stmt->execute();

$no_of_user_products = $user_products_stmt->rowCount();
$sum = 0;

if ($no_of_user_products == 0) {
    ?>
    <script>
        window.alert("No items in the cart!!");
    </script>
    <?php
} else {
    while ($row = $user_products_stmt->fetch(PDO::FETCH_ASSOC)) {
        $sum += $row['price'];
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <link rel="shortcut icon" href="img/lifestyleStore.png" />
    <title>Lifestyle Store</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- latest compiled and minified CSS -->
    <link rel="stylesheet" href="bootstrap/css/bootstrap.min.css" type="text/css">
    <!-- jquery library -->
    <script type="text/javascript" src="bootstrap/js/jquery-3.2.1.min.js"></script>
    <!-- Latest compiled and minified javascript -->
    <script type="text/javascript" src="bootstrap/js/bootstrap.min.js"></script>
    <!-- External CSS -->
    <link rel="stylesheet" href="css/style.css" type="text/css">
</head>
<body>
<div>
    <?php
    require 'header.php';
    ?>
    <br>
    <div class="container">
        <table class="table table-bordered table-striped">
            <tbody>
            <tr>
                <th>Item Number</th><th>Item Name</th><th>Price</th><th></th>
            </tr>
            <?php
            $user_products_stmt->execute(); // Execute the query again to reset the cursor
            $no_of_user_products = $user_products_stmt->rowCount();
            $counter = 1;
            while ($row = $user_products_stmt->fetch(PDO::FETCH_ASSOC)) {
                ?>
                <tr>
                    <th><?php echo $counter ?></th><th><?php echo $row['name'] ?></th><th><?php echo $row['price'] ?></th>
                    <th><a href='cart_remove.php?id=<?php echo $row['id'] ?>'>Remove</a></th>
                </tr>
                <?php $counter = $counter + 1;
            } ?>
            <tr>
                <th></th><th>Total</th><th>Rs <?php echo $sum; ?>/-</th><th><a href="success.php?id=<?php echo $user_id ?>"
                                                                               class="btn btn-primary">Confirm Order</a>
                </th>
            </tr>
            </tbody>
        </table>
    </div>
    <br><br><br><br><br><br><br><br><br><br>
    <footer class="footer">
        <div class="container">
            <center>
                <p>Copyright &copy Lifestyle Store. All Rights Reserved. | Contact Us: +91 90000 00000</p>
                <p>This website is developed by Sajal Agrawal</p>
            </center>
        </div>
    </footer>
</div>
</body>
</html>
