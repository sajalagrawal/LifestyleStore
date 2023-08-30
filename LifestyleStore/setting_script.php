<?php
session_start();
require 'connection.php';

if (!isset($_SESSION['email'])) {
    header('location: index.php');
    exit(); // Stop execution after redirection
}

$old_password = md5(md5($_POST['oldPassword']));
$new_password = md5(md5($_POST['newPassword']));
$email = $_SESSION['email'];

$password_from_database_query = "SELECT password FROM users WHERE email = :email";
$password_from_database_stmt = $con->prepare($password_from_database_query);
$password_from_database_stmt->bindParam(':email', $email);
$password_from_database_stmt->execute();

$row = $password_from_database_stmt->fetch(PDO::FETCH_ASSOC);

if ($row['password'] == $old_password) {
    $update_password_query = "UPDATE users SET password = :new_password WHERE email = :email";
    $update_password_stmt = $con->prepare($update_password_query);
    $update_password_stmt->bindParam(':new_password', $new_password);
    $update_password_stmt->bindParam(':email', $email);
    $update_password_result = $update_password_stmt->execute();

    echo "Your password has been updated.";
    ?>
    <meta http-equiv="refresh" content="3;url=products.php" />
    <?php
} else {
    ?>
    <script>
        window.alert("Wrong password!!");
    </script>
    <meta http-equiv="refresh" content="1;url=settings.php" />
    <?php
}
?>
