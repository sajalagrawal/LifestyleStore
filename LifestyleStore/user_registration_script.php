<?php
require 'connection.php';
session_start();

$name = $_POST['name'];
$email = $_POST['email'];
$regex_email = "/^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[_a-z0-9-]+)*(\.[a-z]{2,3})$/";
if (!preg_match($regex_email, $email)) {
    echo "Incorrect email. Redirecting you back to registration page...";
    ?>
    <meta http-equiv="refresh" content="2;url=signup.php" />
    <?php
    exit(); // Stop execution after redirection
}

$password = md5(md5($_POST['password']));
if (strlen($password) < 6) {
    echo "Password should have at least 6 characters. Redirecting you back to registration page...";
    ?>
    <meta http-equiv="refresh" content="2;url=signup.php" />
    <?php
    exit(); // Stop execution after redirection
}

$contact = $_POST['contact'];
$city = $_POST['city'];
$address = $_POST['address'];

// Check if the email already exists
$duplicate_user_query = "SELECT id FROM users WHERE email = :email";
$duplicate_user_stmt = $con->prepare($duplicate_user_query);
$duplicate_user_stmt->bindParam(':email', $email);
$duplicate_user_stmt->execute();
$rows_fetched = $duplicate_user_stmt->rowCount();

if ($rows_fetched > 0) {
    ?>
    <script>
        window.alert("Email already exists in our database!");
    </script>
    <meta http-equiv="refresh" content="1;url=signup.php" />
    <?php
} else {
    $user_registration_query = "INSERT INTO users(name, email, password, contact, city, address) VALUES (:name, :email, :password, :contact, :city, :address)";
    $user_registration_stmt = $con->prepare($user_registration_query);
    $user_registration_stmt->bindParam(':name', $name);
    $user_registration_stmt->bindParam(':email', $email);
    $user_registration_stmt->bindParam(':password', $password);
    $user_registration_stmt->bindParam(':contact', $contact);
    $user_registration_stmt->bindParam(':city', $city);
    $user_registration_stmt->bindParam(':address', $address);

    $user_registration_result = $user_registration_stmt->execute();

    echo "User successfully registered";
    $_SESSION['email'] = $email;
    $_SESSION['id'] = $con->lastInsertId();

    ?>
    <meta http-equiv="refresh" content="3;url=products.php" />
    <?php
}
?>
