<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title>Admin</title>
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
    $usersColl = $client->cook->users;
    if (isset($_SESSION["loggedIn"]) && $_SESSION["loggedIn"] == true) {
      $loggedUser = $usersColl->findOne(['_id' => new MongoDB\BSON\ObjectID($_SESSION['loggedId'])]);
      if (isset($loggedUser['permissions']) && $loggedUser['permissions'] == 'admin') {
        echo "<div class='recipes'>";
        echo "<h3>users:</h3>";
        $client = new MongoDB\Client('mongodb://' . $adminAccount . '@' . $serverAddress . '/?authSource=cook');
        $usersColl = $client->cook->users;
        if (isset($_GET["remove"])) {
          $usersColl->deleteOne(['login' => $_GET["remove"]]);
        }
        if (isset($_GET["priv"]) && isset($_GET["login"])) {
          $usersColl->updateOne(['login' => $_GET["login"]], ['$set' => ['permissions' => $_GET["priv"]]]);
        }
        $loggedUsers = $usersColl->find();
        foreach ($loggedUsers as $user) {
          echo "<div class = 'user'>";
          echo "<p class = 'nickname'> User account: " . $user['login'] . "</p>";
          echo "<p class = 'permissions'> Permissions: " . $user['permissions'] . "</p>";
          echo "<a href='/loginSystem/adminPanel.php?remove=" . $user['login'] . "'>Remove user</a><br>";
          echo "<a href='/loginSystem/adminPanel.php?priv=admin&login=" . $user['login'] . "'>Give admin permission</a><br>";
          echo "<a href='/loginSystem/adminPanel.php?priv=chef&login=" . $user['login'] . "'>Give user permission</a>";
          echo "</div>";
        }
        echo "</div>";
      } else {
        echo " <div class = 'errors'>";
        echo "<h2 class = 'error'>You are not administrator!</h2>";
        echo "</div>";
      }
    } else {
      echo " <div class = 'errors'>";
      echo "<h2 class = 'error'>You are not administrator!</h2>";
      echo "</div>";
    }
    ?>
    <nav>
      <a href="/index.php">Home</a>
      <a href="/recipes/browseRecipes.php">Browse recipes</a>
      <?php
      if (!session_id()) {
        @session_start();
      }
      if (isset($_SESSION["loggedIn"]) && $_SESSION["loggedIn"] == true) {
        echo "<a href='/recipes/newRecipe.php'>Add new recipe</a>";
        echo "<a href='/loginSystem/logout.php'>Logout</a>";
      } else {
        echo "<a href='/loginSystem/login.php'>Log in</a>";
        echo "<a href='/loginSystem/register.php'>Register</a>";
      }
      ?>
    </nav>
  </body>
</html>