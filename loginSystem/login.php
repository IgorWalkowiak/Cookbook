<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title>Log in!</title>
    <link rel="stylesheet" href="../assets/style.css">
  </head>
  <body>
<div>
  <h2> Log in! </h2>
    <form id="form1" action="loggedIn.php" method="post">
		<label for="login">Login: </label><br>
		<input type="text" required id="login" name="login"><br>

		<label for="password">Password: </label><br>
		<input type="password" required id="password" name="password"><br>
        
		<input type="submit" value="Log in!"><br>
    </form>
    <br>
</div>

  <?php if (isset($_GET['status'])) {
    echo "<h3 style='color:red;'>Wrong login or password</h3>";
  } ?>
	<nav> 
    <a href="/index.php">Home</a>
    <a href="/recipes/browseRecipes.php">Browse recipses</a>
  <nav>
  </body>
</html>