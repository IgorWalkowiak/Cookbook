<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title>Recipes!</title>
    <link rel="stylesheet" href="../assets/style.css">
  </head>
  <body>
  <nav>
  <a href="/index.php">Home</a>
  <a href="recipes/browseRecipes.php">Browse recipes</a>
  <?php
  if (!session_id()) {
    @session_start();
  }
  if (isset($_SESSION["loggedIn"]) && $_SESSION["loggedIn"] == true) {
    echo "<a href='recipes/newRecipe.php'>Add new recipe</a>";
    echo "<a href='loginSystem/logout.php'>Logout  </a>";
    echo "<a href='loginSystem/adminPanel.php'>Admin panel </a>";
  } else {
    echo "<a href='loginSystem/login.php'>Login</a>";
    echo "<a href='loginSystem/register.php'>Register</a>";
  }
  ?>
  </nav>
  </body>
</html>