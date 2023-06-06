<?php
session_start();

// Home button function
function backToHome()
{
    $home = <<<DELIMITER
    <form method="GET" name="myForm">
       <a href="./index.php"><img class="home" src="../img/home.gif"
        alt="Back to Home" title="Back to Home"
        attribution="https://www.flaticon.com/free-animated-icons/home"></a>
    </form>
    DELIMITER;

    echo $home;

    if (isset($_GET['homeButton'])) {
        header("Location: ../php/index.php");
    }
}

// Donut Class
class Donut
{
    public $name;
    public $price;

    function __construct($name, $price)
    {
        $this->name = $name;
        $this->price = $price;
    }

    // Methods
    function set_name($name)
    {
        $this->name = $name;
    }
    public function get_name()
    {
        return $this->name;
    }

    function set_price($price)
    {
        $this->price = $price;
    }
    public function get_price()
    {
        return $this->price;
    }
}

$jsonFile1 = './donuts.json';

// This is where the donuts gets pushed into the donutsArray
function populateDonutsArray($jsonFile1)
{
    $json1 = file_get_contents($jsonFile1);
    $donuts = json_decode($json1)->donuts;
    $donutsArray = array();
    foreach ($donuts as $donut) {
        array_push($donutsArray, new Donut($donut->name, $donut->price));
    }

    return $donutsArray;
}

// 'Storing' the donutsArray
$_SESSION['donutsArray'] = populateDonutsArray($jsonFile1);


// Showing the available donuts
function chooseDonuts()
{
    foreach ($_SESSION['donutsArray'] as $index => $donut) {
        $imageName = $donut->get_name();
        $imagePath = "../img/{$imageName}";

        // Determine the appropriate image extension based on availability
        $imageExtensions = ['webp', 'jpg', 'JPG'];
        foreach ($imageExtensions as $extension) {
            $imageFile = $imagePath . '.' . $extension;
            if (file_exists($imageFile)) {
                $imageExtension = $extension;
                break;
            }
        }

        $donutDisplay = <<<DELIMITER
        <div class="ing">
        <a href="order.php?view=$index" class="btn btn-primary">
                <h3>{$donut->get_name()}</h3>    
                <img src="$imagePath.$imageExtension" alt="Donut Image" class="donuts">
                <h3>R {$donut->get_price()}</h3> 
        </a>
        </div>
        DELIMITER;

        echo $donutDisplay;
    }
}

// Select a donut
if (isset($_GET['view'])) {
    $chosenDonut = $_GET['view'];
    $_SESSION['chosenDonut'] = $chosenDonut;
    $viewDonut = $_SESSION['donutsArray'][$chosenDonut];
    $_SESSION['donutName'] = $viewDonut->get_name();
    $_SESSION['donutPrice'] = $viewDonut->get_price();
}

// Topping Class
class Topping
{
    public $name;
    public $price;

    function __construct($name, $price)
    {
        $this->name = $name;
        $this->price = $price;
    }

    // Methods
    function set_name($name)
    {
        $this->name = $name;
    }
    public function get_name()
    {
        return $this->name;
    }

    function set_price($price)
    {
        $this->price = $price;
    }
    public function get_price()
    {
        return $this->price;
    }
}

$jsonFile2 = './toppings.json';

// This is where the toppings gets pushed into the toppingsArray
function populateToppingsArray($jsonFile2)
{
    $json2 = file_get_contents($jsonFile2);
    $toppings = json_decode($json2)->toppings;
    $toppingsArray = array();
    foreach ($toppings as $topping) {
        array_push($toppingsArray, new Topping($topping->name, $topping->price));
    }

    return $toppingsArray;
}

// 'Storing' the toppingsArray
$_SESSION['toppingsArray'] = populateToppingsArray($jsonFile2);


function chooseToppings()
{
    $totalPrice = 0 || $_SESSION['totalPrice'];
    
    $totalPrice = 0;
    $selectedCount = 0;
    $maxToppings = 3; // Maximum number of toppings allowed
    $errorFlag = false;

    foreach ($_SESSION['toppingsArray'] as $index => $topping) {
        $imageName = $topping->get_name();
        $imagePath = "../img/{$imageName}";

        // Determine the appropriate image extension based on availability
        $imageExtensions = ['webp', 'jpg', 'JPG'];
        foreach ($imageExtensions as $extension) {
            $imageFile = $imagePath . '.' . $extension;
            if (file_exists($imageFile)) {
                $imageExtension = $extension;
                break;
            }
        }

        $toppingDisplay = <<<DELIMITER
        <div class="ing1">
            <h3>{$topping->get_name()}</h3>  
            <input type="checkbox" name="toppings[]" value="$index">  
            <img src="$imagePath.$imageExtension" alt="Donut Image" class="donuts">
            <h3>R {$topping->get_price()}</h3> 
        </div>
        DELIMITER;

        echo $toppingDisplay;

        if (isset($_POST['toppings']) && in_array($index, $_POST['toppings'])) {
            if ($selectedCount >= $maxToppings) {
                $errorFlag = true;
                break;
            }
            $totalPrice += $topping->get_price();
            $selectedCount++;
        }
    }
    if ($errorFlag) {
        echo "<p class='error'>Maximum $maxToppings toppings allowed. <br> Clear Toppings and choose again!</p>";
        $totalPrice = 0; // Reset the total price
    } else {
        echo "<p>Total: R $totalPrice</p>";
    }
    
}


function clearToppings()
{
    $clearDisplay = <<<DELIMITER
        <div class="ing1">
            <button type="submit" name"clearTopping"> Clear </button>
        </div>
        DELIMITER;

    echo $clearDisplay;

    $_SESSION['toppingName'] = array();
    $_SESSION['toppingPrice'] = array();
}


?>