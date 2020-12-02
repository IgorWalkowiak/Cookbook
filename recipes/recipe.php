<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title>Recipe</title>
    <link rel="stylesheet" href="../assets/style.css">
  </head>
  <body>
    <div class = "recipes">
      <h3> Recipe! </h3>
      <?php
      if (!session_id()) {
        @session_start();
      }
      require_once __DIR__ . '\..\phpmongodb\vendor\autoload.php';
      include dirname(__DIR__) . '..\credentials.php';

      $client;
      if (isset($_SESSION["loggedIn"]) && $_SESSION["loggedIn"] == true) {
        $client = new MongoDB\Client('mongodb://' . $chefAccount . '@' . $serverAddress . '/?authSource=cook');
      } else {
        $client = new MongoDB\Client('mongodb://' . $guestAccount . '@' . $serverAddress . '/?authSource=cook');
      }
      $recipesColl = $client->cook->recipes;
      $recipe = $recipesColl->findOne(['_id' => new MongoDB\BSON\ObjectID($_GET['id'])]);

      echo "<div class = 'title'>" . $recipe['title'] . "</div>";
      echo "<div class = 'description'> OPIS: " . $recipe['description'] . "</div>";

      foreach ($recipe['steps'] as $step) {
        echo "<div class = 'step'>" . $step . "</div>";
      }
      foreach ($recipe['ingredients'] as $ingredient) {
        echo "<div class = 'ingredient'>";
        echo $ingredient['name'] . '<br>';
        echo $ingredient['quanity']['amount'] . " " . $ingredient['quanity']['unit'];
        echo "</div>";
      }

      if (isset($_SESSION["loggedIn"]) && $_SESSION["loggedIn"] == true) {
        echo "<div class = 'votes'>";
        echo "<a class = 'posVote' href='/recipes/rate.php?id=" . $_GET['id'] . "&vote=pos'>Thumb up!</a><br>";
        echo "<a class = 'negVote' href='/recipes/rate.php?id=" . $_GET['id'] . "&vote=neg'>Thumb down!</a><br>";
        echo "<a class = 'removeVote' href='/recipes/rate.php?id=" . $_GET['id'] . "&vote=reset'>Remove vote!</a><br><br>";
        echo "<a class = 'removeRecipe' href='/recipes/removeRecipe.php?id=" . $_GET['id'] . "'>Remove recipe!</a><br><br>";
        echo "</div>";
      }

      echo "<div class = 'rates'>";
      $posResult = $recipesColl->aggregate([['$project' => ['count' => ['$size' => '$positiveVoters']]], ['$match' => ['_id' => new MongoDB\BSON\ObjectID($_GET['id'])]]]);
      foreach ($posResult as $result) {
        echo "Positives: " . $result['count'] . "  <br>";
      }

      $negResult = $recipesColl->aggregate([['$project' => ['count' => ['$size' => '$negativeVoters']]], ['$match' => ['_id' => new MongoDB\BSON\ObjectID($_GET['id'])]]]);
      foreach ($negResult as $result) {
        echo "Negatives: " . $result['count'] . "  <br>";
      }

      $tags = $recipesColl->aggregate([['$project' => ['tags' => 1]], ['$match' => ['_id' => new MongoDB\BSON\ObjectID($_GET['id'])]]]);
      foreach ($tags as $result) {
        echo "Tags: ";
        foreach ($result['tags'] as $tag) {
          echo "<a class = 'tag' href='/recipes/browseRecipes.php?textSearch=&tag=" . $tag . "'>" . $tag . "</a> ";
        }
      }
      echo "</div>";
      ?>
    </div>
  <nav> 
  <a href="/index.php">Home</a>
  <a href="/recipes/browseRecipes.php">Browse recipes</a>
  <nav>
  </body>
</html>