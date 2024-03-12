<nav class="navbar navbar-inverse navabar-fixed-top">
    <div class="container">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#myNavbar">
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a href="index.php" class="navbar-brand">Lifestyle Store</a>
        </div>

        <div class="collapse navbar-collapse" id="myNavbar">
            <ul class="nav navbar-nav navbar-right">
                <?php
                if (isset($_SESSION['email'])) {
                    require 'connection.php';
                    
                    $user_id = $_SESSION['id'];
                    $cart_count_query = "SELECT COUNT(*) AS cart_count FROM users_items WHERE user_id = :user_id AND status = 'Added to cart'";
                    $cart_count_stmt = $con->prepare($cart_count_query);
                    $cart_count_stmt->bindParam(':user_id', $user_id);
                    $cart_count_stmt->execute();
                    $cart_count_row = $cart_count_stmt->fetch(PDO::FETCH_ASSOC);
                    $cart_count = $cart_count_row['cart_count'];
                    ?>
                    <li><a href="cart.php"><span class="glyphicon glyphicon-shopping-cart"></span> Cart <span class="badge"><?php echo $cart_count; ?></span></a></li>
                    <li><a href="settings.php"><span class="glyphicon glyphicon-cog"></span> Settings</a></li>
                    <li><a href="logout.php"><span class="glyphicon glyphicon-log-out"></span> Logout</a></li>
                    <?php
                } else {
                    ?>
                    <li><a href="signup.php"><span class="glyphicon glyphicon-user"></span> Sign Up</a></li>
                    <li><a href="login.php"><span class="glyphicon glyphicon-log-in"></span> Login</a></li>
                    <?php
                }
                ?>
            </ul>
        </div>
    </div>
</nav>