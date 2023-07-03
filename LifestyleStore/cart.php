<?php
require 'connection.php';
session_start();
if (!isset($_SESSION['email'])) {
    header('location: login.php');
}
$user_id = $_SESSION['id'];
$user_products_query = "select it.id, it.name, it.price, ut.quantity from users_items ut inner join items it on it.id=ut.item_id where ut.user_id='$user_id'";
$user_products_result = mysqli_query($con, $user_products_query) or die(mysqli_error($con));
$no_of_user_products = mysqli_num_rows($user_products_result);
$sum = 0;

if (isset($_SESSION['email'])) {
    $user_id = $_SESSION['id'];
    $display_cart_count_query = "SELECT COUNT(DISTINCT item_id) AS item_count FROM users_items WHERE user_id = $user_id";
    $cart_count_result = mysqli_query($con, $display_cart_count_query) or die(mysqli_error($con));
    $row = mysqli_fetch_assoc($cart_count_result);
    $item_count = $row['item_count'];
}

if ($no_of_user_products == 0) {
    //echo "Add items to cart first.";
    ?>

    <script>
        window.alert("No items in the cart!!");
    </script>
    <?php
} else {
    while ($row = mysqli_fetch_array($user_products_result)) {
        $sum = $sum + ($row['price'] * $row['quantity']);
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

    <script type="text/javascript">
        $(document).ready(function () {
            $('.quantity').change(function () {
                var id = $(this).attr('data-id');
                var quantity = $(this).val();
                $.ajax({
                    url: "update_quantity.php",
                    method: "POST",
                    data: {
                        item_id: id,
                        quantity: quantity
                    },
                    success: function (data) {
                        window.location.reload(true);
                    }
                });
            });
        });
    </script>

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
                        <th>Item Number</th>
                        <th>Item Name</th>
                        <th>Price</th>
                        <th>Quantity</th>
                        <th></th>
                    </tr>
                    <?php
                    $user_products_result = mysqli_query($con, $user_products_query) or die(mysqli_error($con));
                    $no_of_user_products = mysqli_num_rows($user_products_result);
                    $counter = 1;
                    while ($row = mysqli_fetch_array($user_products_result)) {

                        ?>
                        <tr>
                            <th>
                                <?php echo $counter ?>
                            </th>
                            <th>
                                <?php echo $row['name'] ?>
                            </th>
                            <th>
                                <?php echo $row['price'] ?>
                            </th>
                            <th><input type="number" value="<?php echo $row['quantity'] ?>" min="1" max="10"
                                    data-id="<?php echo $row['id'] ?>" class="quantity"></th>
                            <th><a href='cart_remove.php?id=<?php echo $row['id'] ?>' class="btn btn-primary">Remove</a>
                            </th>
                        </tr>
                        <?php $counter = $counter + 1;
                    } ?>
                    <tr>
                        <th></th>
                        <th>Total</th>
                        <th>Rs
                            <?php echo $sum; ?>/-
                        </th>
                        <th><a href="success.php?id=<?php echo $user_id ?>" class="btn btn-primary">Confirm Order</a>
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

    <script type="text/javascript">
        const cartCountElement = document.getElementById("cartcount");
        cartCountElement.innerHTML = '<?php echo $item_count; ?>';
    </script>

</body>

</html>