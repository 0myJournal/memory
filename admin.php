<?php
  //I do this so I can use functions from functions.php
  require "functions.php";

  //SET VARIABLES--------------------------------------
  session_start();
  
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
  <title>Admin Login</title>
  <meta name="description" content="Memory v2">
  <meta name="author" content="Ewaldo Nieuwenhuis">
  <link rel="stylesheet" href="css/bootstrap.min.css">
  <link type="text/css" rel="stylesheet" href="css/styles.css">
  <script type="text/javascript" src="js/functions_js.js"></script>  
</head>

<body class="back">
  <div class="holder">
    <h1 class="title">Administration Tasks</h1>
    <p class="undertitle">Made by Ewaldo Nieuwenhuis</p>
    </div>
    <?php
    //checks if admin is logged in, if negative post a log in form so admin can login
    if($_SESSION){
      if(isset($_SESSION["admin"]))
      {
        //add <div> with admin tasks
        addAdminTasks();
      }
      else{
        addLoginFormAdmin($db);
      }
    }
    else{
      addLoginFormAdmin($db);
    }
    
    ?>
</body>
