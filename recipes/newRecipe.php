<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title>New recipe</title>
    <link rel="stylesheet" href="../assets/style.css">
  </head>
  <body>  
  <script type="text/javascript" src="/js/newRecipeScripts.js"></script>

  	<form id="form1" action="newRecipeAdded.php" method="post">
		<label for="title">Title: </label><br>
		<input type="text" placeholder="e.g. Burrito" id="title" name="title" width="48" height="48"><br>

		<label for="text">Description: </label><br>
		<input type="text" placeholder="e.g. Chicken with rice" id="description" name="description"><br>

		<label for="text">Calories: </label><br>
		<input type="text" id="calories" name="calories"><br>

		<label for="text">Ingredients: </label><br>
		<input type = "button" onClick="addIngredient()" value="Add next ingredient">
		<input type = "button" onClick="removeIngredient()" value="Remove previous ingredient">
		<div id="ingredients"> </div>

		<label for="text">Steps: </label><br>
		<input type = "button" onClick="addStep()" value="Add next step">
		<input type = "button" onClick="removeStep()" value="Remove previous step">
		<div id="steps"> </div>

		<label for="text">Tags: </label><br>
		<input type="text" id="tags" name="tags"><br>
		<input type="submit" value="Add recipe"><br>
	</form>
	<br><br><br><br><br>
	<div id="errors"></div>
	<nav>
  <a href="/index.php">Home</a>
  <a href="/recipes/browseRecipes.php">Browse recipes</a>

  <?php
  if (!session_id()) {
    @session_start();
  }
  if (isset($_SESSION["loggedIn"]) && $_SESSION["loggedIn"] == true) {
    echo "<a href='/recipes/newRecipe.php'>Add new recipe</a>";
    echo "<a href='/loginSystem/logout.php'>Logout </a>";
  } else {
    echo "<a href='/loginSystem/login.php'>Log in</a>";
    echo "<a href='/loginSystem/register.php'>Register</a>";
  }
  ?>

  </nav>
  </body>
</html>