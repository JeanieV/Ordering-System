<?php
session_start();
require './functions.php';


?>

<!DOCTYPE html>
<html>

<head>
    <meta charset='utf-8'>
    <meta http-equiv='X-UA-Compatible' content='IE=edge'>
    <title>Ordering Page</title>
    <meta name='viewport' content='width=device-width, initial-scale=1'>
    <link rel='stylesheet' type='text/css' media='screen' href='../css/styleDonut.css'>
</head>

<body>
    <?php backToHome(); ?>
    <h1> Order </h1>
    <h3> Your Donut Type:</h3>

    <div class="backDonut">
        <?php chooseDonuts(); ?>
    </div>

    <h3> Your Donut Topping:</h3>
    
    <div class="backDonut1">
        <?php chooseToppings(); ?>
    </div>

</body>

</html>