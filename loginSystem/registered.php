<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title>Przepiski!</title>
    <link rel="stylesheet" href="../assets/style.css">
  </head>
  <body>
  <?php
  if (!session_id()) {
    @session_start();
  }
  require_once __DIR__ . '\..\phpmongodb\vendor\autoload.php';
  include dirname(__DIR__) . '../credentials.php';

  $client = new MongoDB\Client('mongodb://' . $guestAccount . '@' . $serverAddress . '/?authSource=cook');

  $users = $client->cook->users;
  if (isset($_POST["login"]) && isset($_POST["password"])) {
    $user = $users->findOne(['login' => $_POST["login"]]);
    if (!$user) {
      $dbInput['login'] = $_POST["login"];
      $dbInput['password'] = $_POST["password"];
      $dbInput['permissions'] = 'chef';
      $client = new MongoDB\Client('mongodb://' . $chefAccount . '@' . $serverAddress . '/?authSource=cook');
      $users = $client->cook->users;
      $insertOneResult = $users->insertOne($dbInput);
      $user = $users->findOne(['login' => $_POST["login"]]);

      if ($user) {
        $_SESSION["loggedId"] = $user['_id'];
        $_SESSION["loggedIn"] = true;
        echo "<h3 style='color:green;'>Registered!</h3>";
      } else {
        echo "<h3 style='color:red;'>We had some problem to add you to database :c</h3>";
      }
    } else {
      echo "<h3 style='color:red;'>Users already exist!</h3>";
    }
  } else {
  }
  ?>
    <nav>
  <a href="/index.php">Home</a>
    <?php
    if (!session_id()) {
      @session_start();
    }
    if (isset($_SESSION["loggedIn"]) && $_SESSION["loggedIn"] == true) {
      echo '<a href="/recipes/browseRecipes.php">Browse recipes</a>';
      echo "<a href='/recipes/newRecipe.php'>Add new recipe </a>";
      echo "<a href='/loginSystem/logout.php'>Logout </a>";
    } else {
      echo "<a href='/loginSystem/login.php'>Login</a>";
      echo "<a href='/loginSystem/register.php'>Register</a>";
    }
    ?>
    <nav>
  </body>
</html>