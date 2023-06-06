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

// Clear the Toppings
if (isset($_POST['clearTopping'])) {
    $_SESSION['toppingName'] = array();
    $_SESSION['toppingPrice'] = array();
}

// Display the Toppings
if (isset($_SESSION['toppingName']) && isset($_SESSION['toppingPrice'])) {
    $toppingNames = $_SESSION['toppingName'];
    $toppingPrices = $_SESSION['toppingPrice'];
} else {
    $toppingNames = array(); 
    $toppingPrices = array(); 
}

// The Selected Toppings will show in order.php
if (isset($_POST['submitToppings']) && isset($_POST['toppings'])) {
    
    $selectedToppings = $_POST['toppings'];

    foreach ($selectedToppings as $toppingIndex) {
        $selectedTopping = $_SESSION['toppingsArray'][$toppingIndex];
        $toppingNames[] = $selectedTopping->get_name();
        $toppingPrices[] = $selectedTopping->get_price();
    }

    $_SESSION['toppingName'] = $toppingNames;
    $_SESSION['toppingPrice'] = $toppingPrices;

    // Check if an error occurred (totalPrice is 0)
    if ($_SESSION['totalPrice'] === 0) {
        echo "<p class='error'>Maximum toppings limit exceeded. Please make a new selection.</p>";
        $_SESSION['toppingName'] = array();
        $_SESSION['toppingPrice'] = array();
    }
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
    <form method="post" action="order.php">

        <div class="donutAnswer2">
            <h3> Your Donut Topping:</h3>
            <?php if (!empty($toppingNames)) {
                for ($i = 0; $i < count($toppingNames); $i++) {
                    echo "<p>{$toppingNames[$i]} - R {$toppingPrices[$i]}</p>";
                }
            } else {
                echo "<p>No Toppings Selected</p>";
            } ?>
            <?php chooseToppings(); ?>

            <div class="ing1">
                <button type="submit" class="submitStyle" name="submitToppings">Choose Toppings</button>
                <button type="submit" class="submitStyle" name="clearTopping">Clear Toppings</button>
            </div>
        </div>
    </form>

</body>

</html>