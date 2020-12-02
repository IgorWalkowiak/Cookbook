<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title>Register</title>
    <link rel="stylesheet" href="../assets/style.css">
  </head>
  <body>
  <h2> Register! </h2>
    <form id="form1" action="registered.php" method="post">
		<label for="login">Login: </label><br>
		<input type="text" required id="login" name="login"><br>
  
		<label for="password">Password: </label><br>
		<input type="password" required id="password" name="password"><br>
		<input type="submit" value="Register"><br>
    </form>
    <br>
	<nav> 
  <a href="/index.php">Home</a>
  <a href="/recipes/browseRecipes.php">Browse recipes</a>
  <nav>
  </body>
</html>