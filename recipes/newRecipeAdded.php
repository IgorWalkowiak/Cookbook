<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title>New Recipes</title>
    <link rel="stylesheet" href="../assets/style.css">
  </head>
  <body>

	
<?php
class Quantity
{
  public $unit;
  public $amount;
}
class Ingredient
{
  public $name;
  public $quanity;
}

if (!session_id()) {
  @session_start();
}
require_once __DIR__ . '\..\phpmongodb\vendor\autoload.php';
include dirname(__DIR__) . '../credentials.php';
$client;
if (isset($_SESSION["loggedIn"]) && $_SESSION["loggedIn"] == true) {
  $client = new MongoDB\Client('mongodb://' . $chefAccount . '@' . $serverAddress . '/?authSource=cook');
} else {
  $client = new MongoDB\Client('mongodb://' . $guestAccount . '@' . $serverAddress . '/?authSource=cook');
}
$companydb = $client->cook;
$recipesColl = $companydb->recipes;

$dbInput = [];

if (isset($_SESSION["loggedId"])) {
  $dbInput['owner'] = $_SESSION["loggedId"];
}
if (isset($_POST["title"])) {
  $dbInput['title'] = $_POST["title"];
}

if (isset($_POST["description"])) {
  $dbInput['description'] = $_POST["description"];
}

if (isset($_POST["calories"])) {
  $dbInput['calories'] = $_POST["calories"];
}

if (isset($_POST["tags"])) {
  $dbInput['tags'] = explode(' ', $_POST["tags"]);
}
$steps = [];
for ($i = 1; isset($_POST["stepInput" . strval($i)]); $i++) {
  array_push($steps, $_POST["stepInput" . strval($i)]);
}

$ingredients = [];
for ($i = 1; isset($_POST["ingredientName" . strval($i)]); $i++) {
  $ingredient = new Ingredient();
  $quanity = new Quantity();
  $ingredient->name = $_POST["ingredientName" . strval($i)];
  $quanity->unit = $_POST["ingredientUnit" . strval($i)];
  $quanity->amount = $_POST["ingredientAmount" . strval($i)];
  $ingredient->quanity = $quanity;
  array_push($ingredients, $ingredient);
}
$dbInput['ingredients'] = $ingredients;

$dbInput['steps'] = $steps;
$dbInput['positiveVoters'] = [];
$dbInput['negativeVoters'] = [];

$insertOneResult = $recipesColl->insertOne($dbInput);
header('Location: /recipes/recipe.php?id=' . $insertOneResult->getInsertedId());

echo "<br>";
echo "<br>";
?>
   
  </body>
</html>