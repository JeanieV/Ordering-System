<?php
session_start();
require './functions.php';

// Username
if (isset($_SESSION['username'])) {
    $username = $_SESSION['username'];
}

// Order button
if (isset($_GET['orderButton'])) {
    header("Location: ../php/order.php");
}

$selectedFillingName = $_GET['selectedFillingName'];
$selectedFillingPrice = $_GET['selectedFillingPrice'];
$selectedDonutName = $_GET['selectedDonutName'];
$selectedDonutPrice = $_GET['selectedDonutPrice'];
$chosenQuantity = $_GET['chosenQuantity'];
$toppingNames = explode(',', $_GET['toppingName']); 
$toppingPrices = explode(',', $_GET['toppingPrice']); 
$totalPrice = $_GET['totalPrice'];

?>

<!DOCTYPE html>
<html>

<head>
    <meta charset='utf-8'>
    <meta http-equiv='X-UA-Compatible' content='IE=edge'>
    <title>Payment Page</title>
    <meta name='viewport' content='width=device-width, initial-scale=1'>
    <link rel='stylesheet' type='text/css' media='screen' href='../css/stylePayment.css'>
</head>

<body>

    <div class="buttons">
        <?php backToOrder(); ?>
    </div>

    <h1> Payment at Dropping Donuts </h1>

    <div class="paymentSummary">
        <?php echo "<h3> Thank you for Ordering $username! </h3>" ?>
        <p> Your order summary looks like this: </p>

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
                        <?php echo "<p>Chosen Quantity: $chosenQuantity</p>"; ?>
                    </div>
                </td>
            </tr>
        </table>
    </div>

    <form method="POST" class="paymentSummaryFinal">
        <h2> Your Payment Details: </h2>

    </form>


</body>

</html>