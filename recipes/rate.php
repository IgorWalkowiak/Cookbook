<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title>Rate</title>
    <link rel="stylesheet" href="../assets/style.css">
  </head>
  <body>
    <?php
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
    $recipesColl = $client->cook->recipes;
    $filter = ['_id' => new MongoDB\BSON\ObjectID($_GET['id'])];
    if ($_GET['vote'] == "pos") {
      $update = ['$addToSet' => ["positiveVoters" => new MongoDB\BSON\ObjectID($_SESSION['loggedId'])]];
      $return = $recipesColl->updateOne($filter, $update);

      $update = ['$pull' => ["negativeVoters" => new MongoDB\BSON\ObjectID($_SESSION['loggedId'])]];
      $return = $recipesColl->updateOne($filter, $update);
    } elseif ($_GET['vote'] == "neg") {
      $update = ['$addToSet' => ["negativeVoters" => new MongoDB\BSON\ObjectID($_SESSION['loggedId'])]];
      $return = $recipesColl->updateOne($filter, $update);

      $update = ['$pull' => ["positiveVoters" => new MongoDB\BSON\ObjectID($_SESSION['loggedId'])]];
      $return = $recipesColl->updateOne($filter, $update);
    } elseif ($_GET['vote'] == "reset") {
      $update = ['$pull' => ["positiveVoters" => new MongoDB\BSON\ObjectID($_SESSION['loggedId'])]];
      $return = $recipesColl->updateOne($filter, $update);

      $update = ['$pull' => ["negativeVoters" => new MongoDB\BSON\ObjectID($_SESSION['loggedId'])]];
      $return = $recipesColl->updateOne($filter, $update);
    }
    header('Location: /recipes/recipe.php?id=' . $_GET['id']);
    ?>
  </body>
</html>