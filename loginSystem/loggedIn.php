<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title>Recipes</title>
    <link rel="stylesheet" href="../assets/style.css">
  </head>
  <body>
  <?php
  require_once __DIR__ . '\..\phpmongodb\vendor\autoload.php';
  include dirname(__DIR__) . '../credentials.php';
  $client;
  if (isset($_SESSION["loggedIn"]) && $_SESSION["loggedIn"] == true) {
    $client = new MongoDB\Client('mongodb://' . $chefAccount . '@' . $serverAddress . '/?authSource=cook');
  } else {
    $client = new MongoDB\Client('mongodb://' . $guestAccount . '@' . $serverAddress . '/?authSource=cook');
  }
  $users = $client->cook->users;
  if (isset($_POST["login"]) && isset($_POST["password"])) {
    $user = $users->findOne(['login' => $_POST["login"]]);
    if ($user['password'] == $_POST["password"]) {
      echo "<h1>You are logged in! </h1>";
      session_start();
      $_SESSION["loggedId"] = $user['_id'];
      $_SESSION["loggedIn"] = true;
    } else {
      header('Location: login.php?status=wrong');
    }
  }
  ?>
  <nav>
  <a href="/index.php">Home</a>
  <a href="/recipes/browseRecipes.php">Browse recipes</a>
  <?php
  if (!session_id()) {
    @session_start();
  }

  if ($_SESSION["loggedIn"] == true) {
    echo "<a href='/recipes/newRecipe.php'>Add new recipe</a>";
    echo "<a href='/loginSystem/logout.php'>Logout </a>";
  } else {
    echo "<a href='/loginSystem/login.php'>Login</a>";
    echo "<a href='/loginSystem/register.php'>Register</a>";
  }
  ?>
  </nav>
  </body>
</html>