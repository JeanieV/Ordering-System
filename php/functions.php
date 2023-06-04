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

// This is where the ingredients gets pushed into the IngredientsArray
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

// 'Storing' the ingredientsArray
$_SESSION['donutsArray'] = populateDonutsArray($jsonFile1);


// Showing the available ingredients by name
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
        <a href="functions.php?view=$index" class="btn btn-primary">
                <h3>{$donut->get_name()}</h3>    
                <img src="$imagePath.$imageExtension" alt="Donut Image" class="donuts">
                <h3>R {$donut->get_price()}</h3> 
        </a>
        </div>
        DELIMITER;

        echo $donutDisplay;
    }
}

class Topping {
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

// This is where the ingredients gets pushed into the IngredientsArray
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

// 'Storing' the ingredientsArray
$_SESSION['toppingsArray'] = populateToppingsArray($jsonFile2);


// Showing the available ingredients by name
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

        $donutDisplay = <<<DELIMITER
        <div class="ing">
        <a href="functions.php?view=$index" class="btn btn-primary">
                <h3>{$topping->get_name()}</h3>    
                <img src="$imagePath.$imageExtension" alt="Donut Image" class="donuts">
                <h3>R {$topping->get_price()}</h3> 
        </a>
        </div>
        DELIMITER;

        echo $donutDisplay;
    }
}


// If the user clicks on the name, what will show?
// if (isset($_GET['view'])) {
//     $chosenIngredientIndex = $_GET['view'];
//     $_SESSION['chosenIngredientIndex'] = $chosenIngredientIndex;
//     $viewIngredient = $_SESSION['ingredientsArray'][$chosenIngredientIndex];
//     $_SESSION['viewIngredientName'] = $viewIngredient->get_name();
//     $_SESSION['viewIngredientPrice'] = $viewIngredient->get_price();
//     header("Location: " . $_SESSION['viewIngredientName'] . ".php");
//     exit;
// }
?>