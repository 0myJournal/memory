<?php
  //I do this so I can use functions from functions.php
  require "functions.php";

  //SET VARIABLES--------------------------------------
  
  
  //make connection to Database for data :D
  try{
    $db = new PDO("mysql:host=localhost;dbname=memory;", "root","");
  }
  catch(PDOException $exception)
  {
    //echo any error with database
      echo $exception->getmessage();
  }
  
  //-------------------------------------------------------
?>

<!-- set up HTML doctype, language, charsets to define page
 make connection to css/styles.css to use classes
 make connection to js/functions_js.js to use Javascript -->
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <title>Games</title>
  <meta name="description" content="Memory v2">
  <meta name="author" content="Ewaldo Nieuwenhuis">
  <link rel="stylesheet" href="css/bootstrap.min.css">
  <link type="text/css" rel="stylesheet" href="css/styles.css">
  <script type="text/javascript" src="js/functions_js.js"></script>  
</head>

<body class="back">
  <div class="holder">
    <h1 class="title"> Games</h1>
    <h3 class="centeroo"><a href="leaderboard.php" >Back to leaderboard</a></h3>
    <p class="undertitle">Made by Ewaldo Nieuwenhuis</p>
    </div>
    <?php
        //post each game in a div with the date, turns, winner and players
        postGames($db);
    ?>
</body>
