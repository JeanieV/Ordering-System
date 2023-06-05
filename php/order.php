<?php
session_start();
require './functions.php';

if (isset($_SESSION['username'])) {
    $username = $_SESSION['username'];
}

// Display the selected donut name and price in order.php
if (isset($_SESSION['donutName']) && isset($_SESSION['donutPrice'])) {
    $selectedDonutName = $_SESSION['donutName'];
    $selectedDonutPrice = $_SESSION['donutPrice'];
} else {
    // Default selection
    $selectedDonutName = "Plain";
    $selectedDonutPrice = 4;
}

// Display the selected topping name and price
if (isset($_SESSION['selectedToppings']) && !empty($_SESSION['selectedToppings'])) {
    $toppingNames = [];
    $totalPrice = 0; // Initialize the total price variable

    foreach ($_SESSION['selectedToppings'] as $toppingIndex) {
        $topping = $_SESSION['toppingsArray'][$toppingIndex];
        $toppingNames[] = $topping->get_name();
        $totalPrice += $topping->get_price(); // Add the topping price to the total
    }

    $selectedToppingNames = implode(', ', $toppingNames);
    $selectedToppingPrices = "R " . $totalPrice;
}

?>

<!DOCTYPE html>
<html>

<head>
    <meta charset='utf-8'>
    <meta http-equiv='X-UA-Compatible' content='IE=edge'>
    <title>Ordering Page</title>
    <meta name='viewport' content='width=device-width, initial-scale=1'>
    <link rel='stylesheet' type='text/css' media='screen' href='../css/styleOrder.css'>
</head>

<body>
    <?php backToHome(); ?>
    <?php echo "<p>Hi $username! </p>" ?>
    <h1> Order at Dropping Donuts</h1>
    <p> Make your selection from our various options! </p>

    <!-- Donut Type -->
    <div class="donutAnswer1">
        <h3> Your Donut Type:</h3>
        <?php echo "<p>$selectedDonutName - R $selectedDonutPrice</p>" ?>
        <?php chooseDonuts(); ?>
    </div>

    <!-- Donut Topping -->
    <form method="POST">

        <div class="donutAnswer2">
            <h3> Your Donut Topping:</h3>
            <?php echo "<p>$selectedToppingNames</p>" ?>
            <?php echo "<p>Total: $selectedToppingPrices</p>" ?>
            <?php chooseToppings(); ?>
            <button type="submit">Submit</button>
        </div>
    </form>

</body>

</html>