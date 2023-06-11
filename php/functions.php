<?php
session_start();


// Log out function
function logOut()
{
    $logOUT = <<<DELIMITER
    <form method="GET">
    <button type="submit" name="logOutButton"><img class="logOutStyle" src="../img/logout.png" 
    alt="Log Out" title="Log Out" attribution="https://www.flaticon.com/free-icons/logout"></button>
    </form>
    DELIMITER;

    echo $logOUT;
}

// Back to Order Page
function backToOrder()
{
    $orderPage = <<<DELIMITER
    <form method="GET">
    <button type="submit" name="orderButton"><img class="logOutStyle" src="../img/order.png" 
    alt="Back to Order" title="Back to Order" attribution="https://www.flaticon.com/free-icons/list"></button>
    </form>
    DELIMITER;

    echo $orderPage;
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
                <p>{$donut->get_name()} - R {$donut->get_price()} </p>    
                <img src="$imagePath.$imageExtension" alt="Donut Image" class="donuts">
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
            <p>{$topping->get_name()} - R {$topping->get_price()}</p>  
            <input type="checkbox" name="toppings[]" value="$index">  
            <img src="$imagePath.$imageExtension" alt="Donut Image" class="donuts">
        </div>
        DELIMITER;

        echo $toppingDisplay;
    }
}

function clearToppings()
{
    $clearDisplay = <<<DELIMITER
        <div class="ing1">
            <button type="submit" name"=clearTopping"> Clear </button>
        </div>
        DELIMITER;

    echo $clearDisplay;

    $_SESSION['toppingName'] = array();
    $_SESSION['toppingPrice'] = array();
}


// Topping Class
class Filling
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

$jsonFile3 = './fillings.json';

// This is where the toppings gets pushed into the fillingsArray
function populateFillingsArray($jsonFile3)
{
    $json3 = file_get_contents($jsonFile3);
    $fillings = json_decode($json3)->fillings;
    $fillingsArray = array();
    foreach ($fillings as $filling) {
        array_push($fillingsArray, new Filling($filling->name, $filling->price));
    }

    return $fillingsArray;
}

// 'Storing' the fillingsArray
$_SESSION['fillingsArray'] = populateFillingsArray($jsonFile3);


function chooseFillings()
{
    foreach ($_SESSION['fillingsArray'] as $index => $filling) {
        $imageName = $filling->get_name();
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

        $fillingDisplay = <<<DELIMITER
        <div class="ingFill">
        <a href="order.php?fill=$index" class="btn btn-primary">
                <p>{$filling->get_name()} - R {$filling->get_price()}</p>    
                <img src="$imagePath.$imageExtension" alt="Donut Image" class="donuts">
                 
        </a>
        </div>
        DELIMITER;

        echo $fillingDisplay;

        // Check if filling is already selected in the session
        if (!isset($_SESSION['fillingName']) || !isset($_SESSION['fillingPrice'])) {
            // Default selection
            $_SESSION['fillingName'] = "None Selected";
            $_SESSION['fillingPrice'] = 0;
        }
    }
}


// Select a Filling
if (isset($_GET['fill'])) {
    $chosenFilling = $_GET['fill'];
    $_SESSION['chosenFilling'] = $chosenFilling;
    $viewFilling = $_SESSION['fillingsArray'][$chosenFilling];
    $_SESSION['fillingName'] = $viewFilling->get_name();
    $_SESSION['fillingPrice'] = $viewFilling->get_price();
}


// Payment Page

function directPayment()
{
    $directPay = <<<DELIMITER
    <form method="POST">
        <button type="submit" class="submitStylePay" name="paySubmit"> Next Stop, Payment! </button>
    </form>
    DELIMITER;

    echo $directPay;
}

// Function to calculate the price of donuts
function calcPriceOfDonut($selectedDonutPrice, $totalPrice, $selectedFillingPrice, $chosenQuantity, $price)
{

    $price = ($selectedDonutPrice + $totalPrice + $selectedFillingPrice) * $chosenQuantity;

    $viewPrice = <<<DELIMITER
    <form method="POST">
        <p> Price of Donut Type: R $selectedDonutPrice </p>
        <p> Price of Donut Toppings: R $totalPrice </p>
        <p> Price of Donut Filling: R $selectedFillingPrice </p>
        <p> Number of Donuts: $chosenQuantity </p>
        <h2> Total: R $price </h2>
   </form>
   DELIMITER;

    echo $viewPrice;

}

?>