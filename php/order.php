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

// Topping Variables
$totalPrice = 0;
$selectedCount = 0;
$maxToppings = 3;
$errorFlag = false;

// Display the Toppings
if (isset($_SESSION['toppingName']) && isset($_SESSION['toppingPrice'])) {
    $toppingNames = $_SESSION['toppingName'];
    $toppingPrices = $_SESSION['toppingPrice'];
    $toppingNamesString = implode(',', $toppingNames);
    $toppingPricesString = implode(',', $toppingPrices);

    foreach ($toppingPrices as $toppingPrice) {
        $totalPrice += $toppingPrice;
    }
}

// The Selected Toppings will show in order.php
if (isset($_POST['submitToppings']) && isset($_POST['toppings'])) {
    $selectedToppings = $_POST['toppings'];
    

    if (count($selectedToppings) > $maxToppings) {
        $errorFlag = true;
    } else {
        foreach ($selectedToppings as $toppingIndex) {
            $selectedTopping = $_SESSION['toppingsArray'][$toppingIndex];
            $toppingNames[] = $selectedTopping->get_name();
            $toppingPrices[] = $selectedTopping->get_price();
            $totalPrice += $selectedTopping->get_price(); // Update totalPrice
        }
    }
}

if ($errorFlag) {
    echo "<h5>Maximum $maxToppings toppings allowed. <br> Choose again!</h5>";
} else {
    // Update total price and session variables
    $_SESSION['toppingName'] = $toppingNames;
    $_SESSION['toppingPrice'] = $toppingPrices;
    $_SESSION['totalPrice'] = $totalPrice;
}


// Display the selected filling name and price in order.php
if (isset($_SESSION['fillingName']) && isset($_SESSION['fillingPrice'])) {
    $selectedFillingName = $_SESSION['fillingName'];
    $selectedFillingPrice = $_SESSION['fillingPrice'];
} elseif (!isset($_SESSION['fillingName']) && !isset($_SESSION['fillingPrice'])) {
    // Default selection
    $selectedFillingName = "None Selected";
    $selectedFillingPrice = 0;
}

// Chosen Quantity
$chosenQuantity = isset($_GET['quantity']) ? $_GET['quantity'] : 1;
$_SESSION['chosenQuantity'] = $chosenQuantity;

if (isset($_GET['quantitySubmit'])) {
    $quantity = isset($_GET['quantity']) ? $_GET['quantity'] : 0;
}

// Direct to Payment Page
if (isset($_POST['paySubmit'])) {
    
    if (isset($_SESSION['fillingName']) && isset($_SESSION['toppingName']) && isset($_SESSION['chosenQuantity'])) {
        header("Location: ../php/payment.php?selectedDonutName=$selectedDonutName&selectedDonutPrice=$selectedDonutPrice&toppingName=$toppingNamesString&toppingPrice=$toppingPricesString&totalPrice=$totalPrice&selectedFillingName=$selectedFillingName&selectedFillingPrice=$selectedFillingPrice&chosenQuantity=$chosenQuantity");
    } else {
        echo "<h5> Please complete your order before being directed to the Payment Page! </h5>";
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
    <div class="buttons">
        <?php logOut(); ?>
    </div>
    <?php echo "<p>Hi $username! </p>" ?>
    <h1> Order at Dropping Donuts</h1>
    <p> Make your selection from our various options! </p>

    <!-- Order Answer -->
    <div class="orderSummary">
        <h3> Summary of Order:</h3>
        <table>
            <tr>
                <th>
                    <h4> Donut Type: </h4>
                </th>
                <th>
                    <h4> Donut Topping: </h4>
                </th>
                <th>
                    <h4> Donut Filling: </h4>
                </th>
                <th>
                    <h4> Number of Donuts: </h4>
                </th>
            </tr>
            <tr>
                <td>
                    <?php echo "<p>$selectedDonutName - R $selectedDonutPrice</p>" ?>
                </td>
                <td>
                    <?php if (!empty($toppingNames)) {
                        for ($i = 0; $i < count($toppingNames); $i++) {
                            echo "<p>{$toppingNames[$i]} - R {$toppingPrices[$i]}</p>";
                        }
                    } else {
                        echo "<p>No Toppings Selected</p>";
                    } ?>
                    <?php echo "<p>Total: R $totalPrice</p>"; ?>
                </td>
                <td>
                    <?php echo "<p>$selectedFillingName - R $selectedFillingPrice</p>" ?>
                </td>
                <td>
                    <div class="quantityField">
                        <form method="GET" action="order.php">
                            <input type="number" name="quantity" required value="1">
                            <button type="submit" class="submitStyle" name="quantitySubmit"> Submit </button>
                        </form>
                        <?php echo "<p>Chosen Quantity: $chosenQuantity</p>";
                        if ($quantity > 0) {
                            header("Location: ../php/order.php?quantity=$quantity");
                            exit();
                        } elseif ($quantity < 0) {
                            echo "<h6>Only positive numbers are allowed! <br> You can't have a negative donut! </h6>";
                        } ?>
                    </div>
                </td>
            </tr>
        </table>

        <div class="quantityField">
            <?php directPayment(); ?>
        </div>

    </div>

    <!-- Donut Type -->
    <div class="donutAnswer1">
        <h3> Your Donut Type:</h3>
        <?php chooseDonuts(); ?>
    </div>

    <!-- Donut Topping -->
    <form method="POST" action="order.php">

        <div class="donutAnswer2">
            <h3> Your Donut Topping:</h3>

            <?php chooseToppings(); ?>

            <div class="ing1">
                <button type="submit" class="submitStyle" name="submitToppings">Choose Toppings</button>
                <button type="submit" class="submitStyle" name="clearTopping">Clear Toppings</button>
            </div>
        </div>
    </form>

    <div class="donutAnswer3">
        <h3> Your Donut Filling:</h3>

        <?php chooseFillings(); ?>
    </div>

</body>

</html>