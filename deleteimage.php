<?php
//Bonte says "thou shall never delete data"
//so I will not
//i will only set memory_use to false
?>

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
  <title>Delete Image</title>
  <meta name="description" content="Memory v2">
  <meta name="author" content="Ewaldo Nieuwenhuis">
  <link rel="stylesheet" href="css/bootstrap.min.css">
  <link type="text/css" rel="stylesheet" href="css/styles.css">
  <script type="text/javascript" src="js/functions_js.js"></script>  
</head>

<body class="back">
  <div class="holder">
    <h1 class="title">Delete Image</h1>
    <h3 class="centeroo"><a href="admin.php" >Back to Admin Tasks</a></h3>
    <p class="undertitle">Made by Ewaldo Nieuwenhuis</p>
</div>
    <?php
    //check if admin is logged in
    session_start();
    if(isset($_SESSION["admin"])){
        //post form to delete images
        deleteImages($db);
    }
    else{
        echo "Donder op";
        header("Refresh:index.php");
    }
    ?>
</body>
</html>