<?php
require 'connection.php';
session_start();

$email = $_POST['email'];
$regex_email = "/^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[_a-z0-9-]+)*(\.[a-z]{2,3})$/";
if (!preg_match($regex_email, $email)) {
    echo "Incorrect email. Redirecting you back to login page...";
    ?>
    <meta http-equiv="refresh" content="2;url=login.php" />
    <?php
    exit(); // Stop execution after redirection
}

$password = md5(md5($_POST['password']));
if (strlen($password) < 6) {
    echo "Password should have at least 6 characters. Redirecting you back to login page...";
    ?>
    <meta http-equiv="refresh" content="2;url=login.php" />
    <?php
    exit(); // Stop execution after redirection
}

$user_authentication_query = "SELECT id, email FROM users WHERE email = :email AND password = :password";
$user_authentication_stmt = $con->prepare($user_authentication_query);
$user_authentication_stmt->bindParam(':email', $email);
$user_authentication_stmt->bindParam(':password', $password);
$user_authentication_stmt->execute();

$rows_fetched = $user_authentication_stmt->rowCount();
if ($rows_fetched == 0) {
    ?>
    <script>
        window.alert("Wrong username or password");
    </script>
    <meta http-equiv="refresh" content="1;url=login.php" />
    <?php
} else {
    $row = $user_authentication_stmt->fetch(PDO::FETCH_ASSOC);
    $_SESSION['email'] = $email;
    $_SESSION['id'] = $row['id'];  //user id
    header('location: products.php');
}
?>
