<?php
session_start();

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // Store the form values in session variables
    $_SESSION['username'] = $_POST['username'];

    // Redirect to payment.php
    header("Location: ./order.php");
    exit();

    // Check if the username is provided
    if (empty($_SESSION['username'])) {
        $_SESSION["error_message"] = "Please fill in the username.";
    } else {
        // Redirect to order.php
        header("Location: ./payment.php");
        exit();
    }
}


?>

<!DOCTYPE html>
<html>

<head>
    <meta charset='utf-8'>
    <meta http-equiv='X-UA-Compatible' content='IE=edge'>
    <title>Dropping Donuts</title>
    <meta name='viewport' content='width=device-width, initial-scale=1'>
    <link rel='stylesheet' type='text/css' media='screen' href='../css/styleDonut.css'>
</head>

<body>

    <h1> Welcome to Dropping Donuts </h1>
    <div class="formBackground">
        <?php ?>
        <form action="index.php" method="post">
            <h2> Fill in a Dropping Donut User: </h2>
            <p class="description1"> Ordering and Payment will then be much easier!</p>

            <div class="usernameField">
                <label for="username" class="labelStyle">Username: </label>
                <input type="text" name="username" class="inputStyle" required>
                <button type="submit" class="submitStyle"> Sign me up! </button>
            </div>
            <p class="description1"> Next stop, order your donut!</p>

        </form>
    </div>

    <?php
    // Display error message if set
    if (isset($_SESSION["error_message"])) {
        echo '<p>' . $_SESSION["error_message"] . '</p>';
        unset($_SESSION["error_message"]);
    }
    ?>
</body>

</html>