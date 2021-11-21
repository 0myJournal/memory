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
  <title>Register</title>
  <meta name="description" content="Memory v2">
  <meta name="author" content="Ewaldo Nieuwenhuis">
  <link rel="stylesheet" href="css/bootstrap.min.css">
  <link type="text/css" rel="stylesheet" href="css/styles.css">
  <script type="text/javascript" src="js/functions_js.js"></script>  
</head>

<body class="back">
  <div class="holder">
    <h1 class="title">Register</h1>
    <p class="undertitle">Made by Ewaldo Nieuwenhuis</p>
    </div>
    <?php
    //query to insert new user into users table
    $query_register = $db->prepare("insert into users set 
    username=?,
    password=?,
    email=?
    ");
    //if the register button is pressed
    //otherwise just post the registration form
    if($_POST)
    {
        //get fields from form
        $username=$_POST["username"];
        $password = $_POST["passwd"];
        $email = $_POST["email"];
        //check if username, password and email are valid
        if(checkValidity($username,$password,$email,$db))
        {
            //md5 hash the code with secret key, (hackers won't be able to un-md5hash this ;) )
            $hashedpassword = md5($password.'josthanos'.$username[0]);
            $result_register = $query_register->execute(array($username,$hashedpassword,$email));
            //check if registration was succesfull
            if($result_register){        
                echo"<p class='centeroo'>Account was succesfully created</p>";
            ?> <button><a class="centeroo" href="index.php"> Go to log in page</a> </button><?php
            }
            else{
                echo"<p class='centeroo'>An error has occured</p>";
                header("Refresh:2;");
            }
        }
        
    
    }
    else{
    ?> 
        <div>
            <form method="post" action="">
                <table class="table table-light">
                    <tr>
                        <td> Username: </td> <td> <input type="text" name="username"> </td>
                    </tr>
                    <tr>
                        <td> Password: </td> <td> <input type="password" name="passwd"> </td>
                    </tr>
                    <tr>
                        <td> Email: </td> <td> <input type="text" name="email"> </td>
                    </tr>    
                    <tr>
                        <td> <input type="submit" value="Register"> </td>
                    </tr>
                </table><br>
            </form>
        </div>
    <?php
    }
    ?>
</body>
</html>