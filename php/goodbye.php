<?php
session_start();
require './functions.php';

// LogOut button
if (isset($_GET['logOutButton'])) {
    session_unset();
    session_destroy();

    header("Location: ../php/index.php");
    exit();
}

// Username
if (isset($_SESSION['username'])) {
    $username = $_SESSION['username'];
}
?>


<!DOCTYPE html>
<html>

<head>
    <meta charset='utf-8'>
    <meta http-equiv='X-UA-Compatible' content='IE=edge'>
    <title>Goodbye Page</title>
    <meta name='viewport' content='width=device-width, initial-scale=1'>
    <link rel='stylesheet' type='text/css' media='screen' href='../css/stylePayment.css'>
</head>

<body>

    <?php echo "<h1> Thank you for completing your order at Dropping Donuts, $username! </h1>"; ?>
    <h2> Visit us again soon! </h2>
    
    <!-- Log out the session -->
    <div class="goodbyeButton">
        <?php logOut(); ?>
    </div>

</body>

</html>