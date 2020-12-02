<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title>Recipe removed</title>
    <link rel="stylesheet" href="../assets/style.css">
  </head>
  <body>
    <?php
    if (!session_id()) {
      @session_start();
    }
    require_once __DIR__ . '\..\phpmongodb\vendor\autoload.php';
    include dirname(__DIR__) . '../credentials.php';

    if (isset($_SESSION["loggedIn"]) && $_SESSION["loggedIn"] == true) {
      $client = new MongoDB\Client('mongodb://' . $chefAccount . '@' . $serverAddress . '/?authSource=cook');
      $usersColl = $client->cook->users;
      $loggedUser = $usersColl->findOne(['_id' => new MongoDB\BSON\ObjectID($_SESSION['loggedId'])]);

      $recipesColl = $client->cook->recipes;
      $recipeOwner = $recipesColl->findOne(['_id' => new MongoDB\BSON\ObjectID($_GET['id'])], ['projection' => ['owner' => 1]]);
      if ((isset($_SESSION["loggedId"]) && $recipeOwner['owner'] == $_SESSION["loggedId"]) || $loggedUser['permissions'] == "admin") {
        $deleteResult = $recipesColl->deleteOne(['_id' => new MongoDB\BSON\ObjectID($_GET['id'])]);
        header('Location: /recipes/browseRecipes.php');
      } else {
        echo "You don't have access to remove that recipe!<br>";
      }
    } else {
      echo "You have to log in!<br>";
    }
    ?>
  <nav>
    <a href="/recipes/browseRecipes.php">Browse recipes</a>
  </nav>
  </body>
</html>