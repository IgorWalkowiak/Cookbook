<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title>logout</title>
    <link rel="stylesheet" href="../assets/style.css">

  </head>
  <body>
  <?php
  session_start();
  if (isset($_SESSION["loggedIn"])) {
    $_SESSION["loggedIn"] = false;
    unset($_SESSION["loggedId"]);
    echo $_SESSION["loggedIn"];
    header('Location: /index.php');
  }
  ?>
  </body>
</html>