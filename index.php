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

  //makes a query to count total amount of images in database
  $query_cnt = $db->prepare('SELECT count(*) as total from images where memory_use =1');
  $query_cnt->execute();
  $img_count = $query_cnt->fetchColumn();

  //amount of images
  $amount=0;
  
  //-------------------------------------------------------
?>

<!-- set up HTML doctype, language, charsets to define page
 make connection to css/styles.css to use classes
 make connection to js/functions_js.js to use Javascript -->
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <title>Memory</title>
  <meta name="description" content="Memory v2">
  <meta name="author" content="Ewaldo Nieuwenhuis">
  <link rel="stylesheet" href="css/bootstrap.min.css">
  <link type="text/css" rel="stylesheet" href="css/styles.css">
  <script type="text/javascript" src="js/functions_js.js"></script>  
</head>

<body class="back">
  <div class="holder">
    <h1 class="title">Memory</h1>
    <?php 
    
    //show turns and log out button if player one and two are logged in 
    if(isset($_SESSION["player_one"])&&isset($_SESSION["player_two"]))
    {?>
      <div class="turns">
      <h2 class="centeroo"> Turns: </h2>
      <p class="centeroo" id ="turns_player_one"> <?php echo $_SESSION["player_one"];?>: 0</p>
      <p class="centeroo" id ="turns_player_two"> <?php echo $_SESSION["player_two"];?>: 0</p>
      <form method="post" action="" class="centeroo">
      <input  type="submit" value="Log out Players" name="logout">
      </form>
      <br>
      </div>
    <?php
    //if player presses on the logout button destroy 2 session
    //(idk why I have to do it twice, only once did not work, I had to click the button twice)
    //in the session the login variables are stored so the page will reload as if users are not logged in
    if(isset($_POST["logout"]))
    {
      session_destroy();
      session_destroy();
      header("Refresh:0");
    }
   
   ?>
    <!-- make form to set amount of images the user wants to play with-->
    <form action="" method="post" class="centeroo">
      <label for="number">Choose number of images:</label> <br>
      <select name="number" id="number"><?php
        //print 2 till max images in db options
        for($i=2;$i<=$img_count;$i++)
        {
              //print option of number
                echo"<option value=".$i.">".$i."</option>";
        }?>
      </select><br>
      <!-- button to submit the amount of images chosen -->
      <input type="submit" name="choose" value="Choose">
    </form>
        <?php
        
   }
   //get chosen number from dropdownbox
   if(isset($_POST['number'])){
     //set amount of images to the chosen value
    $amount=$_POST['number'];
    ?>
    <p class="centeroo"> Chosen image amount = <?php echo $amount;?></p>
    <?php
  }
  else{
    //standard amount of image numbers is max images in db
    $amount=$img_count;
  }
   ?>
    <p class="undertitle">Made by Ewaldo Nieuwenhuis</p>
  </div>
    <?php
    //checks if users are logged in, if negative post a log in form so users can login
    if($_SESSION){
      if(isset($_SESSION["player_one"])&&isset($_SESSION["player_two"]))
      {
        createMemory($amount, $db, $_SESSION["player_one"],$_SESSION["player_two"]);
        
      }
      else{
        addLoginForm($db);
      }
    }
    else{
      addLoginForm($db);
    }
    
    ?>
    
  </body>
</html>