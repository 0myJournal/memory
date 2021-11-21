<?php
 //post each game in a div with the date, turns, winner and players
function postGames($db){
  
    //query to get each game order by the most recent one
    $query_games= $db->prepare("SELECT 
    * from games ORDER BY `games`.`datetime` DESC");
    $query_games->execute();
    //post <div> with game details
    foreach($query_games as $game){
        //get names of player one and two
        $gbP1= getNameByID($game["player_one_id"],$db);
        $gbP2 = getNameByID($game["player_two_id"], $db)
        //post the data
    ?>
      <div class = "gameboard"> 
      <h1 class="gbp1">
      <?php
          echo $gbP1;
      ?>
      </h1>
          <h1 class="centeroo"> VS </h1>
      <h1 class="gbp2">
        <?php
          echo $gbP2;
        ?>
      </h1>
      <h1 style="color:yellow; text-align: center;">Winner: </h1>
      <h1 class="gbwinner">
      <?php
          echo getNameByID($game["winner_id"], $db);
      ?>
      </h1>
      <h1> Turns <?php echo $gbP1.": ".$game["turns_player_one"];?></h1>
      <h1> Turns <?php echo $gbP2.": ".$game["turns_player_two"];?></h1>
      <h1> Date: <?php echo $game["datetime"]; ?>
      </div>
    <?php
    }
    
}

//gets username by id
function getNameByID($id,$db){
  //query to get the name 
  //check if id isnt empty
  if($id!=NULL){
    $get_name_query = $db->prepare("select username from users where user_id='".$id."'");
    $get_name_query->execute();
    //get the fetched result, this result will return a string instead of an array
    $fetched_name= $get_name_query->fetch(PDO::FETCH_ASSOC);
    return $fetched_name["username"];
}
else{
    return "No winner";
}

}

//posts a form where you can select 2 players to pla memory against each other
function HostAGame($db){
  //check if user has submitted players
  if(isset($_POST["submit"]))
    {
          //check if a player one is selected
            if($_POST["p1txt"]!="")
            {
              //check if a player two is selecred
                if($_POST["p2txt"]!="")
                {
                  //set sessions which are used in memory and redirect to memory
                  //the users automatically log in this way
                    $_SESSION["player_one"] = $_POST["p1txt"];
                    $_SESSION["player_two"] = $_POST["p2txt"];
                    header("Location: index.php");
                }
                else{
                    echo "Please select player two";
                }
            }
            else{
                if($_POST["p2txt"]!=""){
                    echo "Please select player one";
                }
                else{
                    echo "Please select player one and two";
                }
            }
            
    }
    //post the selection boxes
    ?>
    <!-- boxes to select player one -->
  <div style="margin-left:100px;">
  <h1 style=" margin-left:500px;" id="player_one"> Player one</h1>
  <?php 
          //get username of each user
          $query_get_users = $db->prepare("select * from users");
          $query_get_users->execute();
          foreach($query_get_users as $user){
          ?>
          <!-- when the div is clicked on player one is clicked item -->
          <div class = "divred" onclick="selectItemRed(this.id)" id="<?php echo $user["username"]; ?>">
          <h1 class = "centerooRed" style="color:white;"> <?php echo $user["username"]; ?>
          </div>
          <?php
          }
      ?>
  </div>
  <!-- same box but blue to select player two -->
  <br><br><br><br>
  <div style="margin-left:100px; margin-top:100px;">
  <h1 style=" margin-left:500px;" id="player_two"> Player two</h1>
      <?php
          $query_get_users = $db->prepare("select * from users");
          $query_get_users->execute();
          foreach($query_get_users as $user){
            //make the ids of these divs unique by adding "blue"
            //otherwise I select two divs at once when you really want to select the one you clicked on
          ?>
          <div class = "divblue" onclick="selectItemBlue(this.id)" id="<?php echo $user["username"]."blue"; ?>">
          <h1 class = "centerooRed"> <?php echo $user["username"]; ?></h1></td>
          </div>
          <?php
          }
      ?>
  </div>
  <?php
}


//create a form to make the images unplayable (memory_use colomn)
function deleteImages($db){
  //query to select all playable images
  $query_images = $db->prepare("SELECT * FROM images where memory_use = 1");
  $query_images->execute(array());
  //post every image in a div with a checkbox to select wheter you want to
  //delete it or not
  foreach($query_images as $image){
    ?>
    <form method="post" action="">
    <div class = "imageboard"> 
      <div style="border-radius: 50%;">
      <?php echo "<img style='border-radius: 20%;' src= '".$image["link"]."' width='270' height='150'>";?>
      </div>
      <div style="left:50%; position: relative;">
      <!-- delete[] is so you have more values in the checkbox -->
      <input type="checkbox" name="delete[]" value="<?php echo $image["image_id"]; ?>" id=""/>
      </div>
      
    </div>

<?php
  }
  //place a button to submit selection of deleted images
  ?>
  <input type="submit" name="submit" value="Delete selected items">
  </form><?php
  
  if(isset($_POST["submit"])){
    //get array with selected boxes
    $selected_image_ids = $_POST["delete"];
    //bool to check if the updates went well
    $allwentwell = 1;
    //update each id to memory_use = 0
    foreach($selected_image_ids as $sel_img_id)
    {
      //make a query to update memory_use
      $query_update_image = $db->prepare("UPDATE `images` SET `memory_use` = '0' 
      WHERE `image_id` =?");
      $result_query_img = $query_update_image->execute(array($sel_img_id));
      //check if there are any errors
      if(!$result_query_img)
      {
        $allwentwell = 0;
      }
    }
    if($allwentwell==1){
      echo "Succesfully deleted ".count($selected_image_ids)." Images";
    }
    else{
      echo "Error";
    }
  }

}


//create form to upload image in a link format or a file format
function uploadImage($db){
  ?>
    <div class = "centeroo">
        <form action="" method="post" enctype="multipart/form-data">
            <h3>Select image to upload:</h3>
            <input type="file" name="image">
            <br>
            <input type="text" name="link" value="Or post link">
            <br>
            <input type="submit" value="Upload Image" name="submit">
        </form>

        </div>
    <?php
    if(isset($_POST["submit"]))
    {
        //the directory the image has to be uploaded to with the name of the file
        //with basename you get the last trailing name of a path
        $image = "images/" . basename($_FILES["image"]["name"]);
        $link = basename($_POST["link"]);
        $linkFileType = strtolower(pathinfo($link,PATHINFO_EXTENSION));
        //bool to check if file can be uploaded
        $uploaded = 1;
        $uploadedLink = 1;
        //get the part last extention of a file so .jpg or .png
        $imageFileType = strtolower(pathinfo($image,PATHINFO_EXTENSION));

        //--------------CHECK IF FILE AND LINK ARE VALID IMAGES-------------
        // Check if file already exists in /images
        if (file_exists($image)&& isset($_FILES["image"])) {
          echo "<br>Sorry, file already exists.";
          $uploaded = 0;
        }

        if($_POST["link"] != "Or post link" && $_POST["link"]){
          //check if images has a colomn with posted link
          if(TableHas('images',$_POST["link"], 'link',$db))
          {
              echo "<br>Sorry, link already exists.";
              $uploadedLink = 0;
          }
        }
        

        // Check file size of image is not too large
        if ($_FILES["image"]["size"] > 5000000) {
          echo "<br>Sorry, your file is too large.";
          $uploaded = 0;
        }

        // check if the extensions of file are image extensions
        if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
        && $imageFileType != "gif" ) {
          echo "<br>Only image files are allowed";
          $uploaded = 0;
        }
        // check if the extensions of file are image extensions
        // if($linkFileType != "jpg" && $linkFileType != "png" && $linkFileType != "jpeg"
        // && $linkFileType != "gif" ) {
        //   echo "<br>Only image links are allowed";
        //   $uploadedLink = 0;
        // }
        
        //---------------------------------------------------------------
        // Check if the file is valid
        if ($uploaded == 1) {
          //move file from temporary location (["tmp_name")
          //to a new location (/images)
          //(somehow i cant just get it from the old location you need to store it in the temporary location)
          //upload image path to database
          if (move_uploaded_file($_FILES["image"]["tmp_name"], $image)&&uploadToImages($image, $db))
          {
                echo "<br>Image ".$image." has been uploaded";
          } 
          else 
          {
            echo "<br>Error uploading image";
          }
        }
        //check if link is valid
        if($uploadedLink== 1)
        {
            if(uploadToImages($_POST["link"], $db)){
                echo "<br>Image ".$_POST["link"]." has been uploaded";
            }
            else{
                echo "<br>Error uploading link";
            }
        }
    }
}
//uploads $path to 'images' table in database
//if all goes well return true
function uploadToImages($path, $db){
  //query to upload image
  $query_images = $db->prepare("INSERT INTO `images` (`link`) VALUES ('".$path."')");
  $result_image_upload = $query_images->execute(array());
  //check if query was succcesful
  if($result_image_upload){
    return true;
  }else{
    return false;
  }

}

//returns ID from user with given username
function getIDbyUsername($name, $db){
  //query to get the id 
  $get_id_query = $db->prepare("select user_id from users where username='".$name."'");
  $get_id_query->execute();
  //get the fetched result, this result will return a string instead of an array
  $fetched_id= $get_id_query->fetch(PDO::FETCH_ASSOC);
  return $fetched_id["user_id"];
}

//post a div with task priviledges of admin
function addAdminTasks()
{
  //post html div box with links and a log out button
  ?>
  <div class="containeradmin">
    <h5>Administrator tasks</h5>
    <button><a href="addImage.php" >Add Image to Memory</a></button>
    <br>
    <br>
    <button><a href="deleteimage.php" >Delete Image from Memory</a></button>
    <br>
    <br>
    <button><a href="hostgame.php">Host a game</a></button>
    <br>
    <form method="post" action="">
    <input  type="submit" value="Log out" name="logout">
    </form>
  </div>
  <?php
  //if the log out button is pressed destroy the session so $_SESSION["admin"] is destroyed
  if(isset($_POST["logout"]))
  {
      session_destroy();
      header("Refresh:0");
  }

}

//same as addLoginForm but just 1 user and check if admin === 1
function addLoginFormAdmin($db)
{
  //post a log in form
  ?>
  <div>
    <form method="post" action="">
      <table class="table table-dark table-striped">
        <tr>
          <!-- Give every field a 'name=' so you can access them via ($POST('name field')) -->
          <td> Username admin: </td> <td> <input type="text" name="player1_username"> </td>
        </tr>
        <tr>
          <td> Password admin: </td> <td> <input type="password" name="password_player1"> </td>
        </tr>
        <tr>
          <td> <input type="submit" value="Login" name="login"> </td>
        </tr>
        
      </table><br>
    </form>
  </div>
    <?php
    //if the login button is clicked get username and password
    //check if table users contains given parameters
    if(isset($_POST["login"])){
      
      //get username and password for admin stored in 
      //username box
      $user1= $_POST['player1_username'];
      //passwd box
      $pass1 = $_POST['password_player1'];
      //encrypt the password with md5 and a secret key
      $hashedpass1 = md5($pass1.'josthanos'.$user1[0]);
      //try to get rows from table users with user1 and pass1 
      $user1_query = $db->prepare("select* from users where username=? and password=? and admin=1");
      $user1_query->execute(array($user1, $hashedpass1));
        //get the fetched result, this result will return a string instead of an array
      $user1_fetched= $user1_query->fetch(PDO::FETCH_ASSOC);
      //count how many rows in table contain 
      //the given username and passwd and if admin variable is true
      //if there are none, credentials are invalid or admin is false
      $rows_user1 = $user1_query->rowCount();

      if($rows_user1)
      {
        $_SESSION["admin"] = $user1_fetched["username"];
        header('Location: admin.php');
      }
      else
      {
          echo "Wrong credentials";
          header('Location: admin.php');
      } 
    }

}
//checks if $colomn in $table database contains $needle
function TableHas($table, $needle, $colomn, $db)
{
  //query to select given needle from given colomn in user table
  $query_select = $db->prepare("select * from $table where $colomn = ?");
  $query_select->execute(array($needle));
  //number of results from the query
  $rows = $query_select->rowCount();
  //if there are results that means  there is a $colomn with value $needle
  if($rows>0) {
    return true;
  }
  else{
    return false;
  }

}

//check if username, password and email are valid variables
//---------------------------------------------------------
//check if the fields are filled
//check if the lengths are valid
//check if the email is valid
//check if the username and email are unique
//---------------------------------------------------------
function checkValidity($username, $password, $email, $db){

  //check if the fields are all filled out. If a $_POST["blank"] is empty this will
  //result in a variable with nothing thus if a variable does not exists it will return a boolean value
  if(!$username||!$password||!$email)
  {
      echo "<p class='centeroo'>Not all fields are filled!</p>";
      header("Refresh:2;");
  }
  else{
      //check if the lengths of the given fields are not too long or too short
      //if the variables are too long it will mess with the database
      if(strlen($username)<=20||strlen($password)<=20
      ||strlen($email)<=50||strlen($username)<5||strlen($password)<5)
      {
          //validate email by filter_var FILTER_VALIDATE_EMAIL
          if(filter_var($email, FILTER_VALIDATE_EMAIL)) {
              //check if the colomn 'username' in users doesn't already contain the given username
              if(!TableHas('users',$username, 'username', $db))
              {
                  //same for email
                  if(!TableHas('users',$email, 'email', $db)){
                      return true;
                  }
                  else{
                      echo"<p class='centeroo'>email already taken</p>";
                      header("Refresh:2;");
                  }   

              }
              else{
                  echo"<p class='centeroo'>username already taken</p>";
                  header("Refresh:2;");
                  
              }
              
          }
          else{
              echo"<p class='centeroo'>Invalid email</p>";
              header("Refresh:2;");
          }
      }
      else{
          echo "<p class='centeroo'>Username and password must be between 5 - 20 chars, email can only be 50 chars</p>";
          header("Refresh:2;");
      }
      
  }
}

//posts a log in form on the page
//will return 2 session variables iif the credentials are right
//$_SESSION["player_one"] and $_SESSION["player_two"]
function addLoginForm($db)
{
    //post a log in form
    ?>
      <div>
        <form method="post" action="">
          <table class="table table-dark table-striped">
            <tr>
              <!-- Give every field a 'name=' so you can access them via ($POST('name field')) -->
              <td> Username player 1: </td> <td> <input type="text" name="player1_username"> </td>
              <td> Username player 2: </td> <td> <input type="text" name="player2_username"> </td>
            </tr>
            <tr>
              <td> Password player 1: </td> <td> <input type="password" name="password_player1"> </td>
              <td> Password player 2: </td> <td> <input type="password" name="password_player2"> </td>
            </tr>
            <tr>
              <td> <input type="submit" value="Login Players" name="login"> </td>
            </tr>
            <tr>
              <td> <a href="admin.php"> Administration Log In </a></td>
              <td> <a href="register.php"> Make New Account </a> </td>
            </tr>
          </table><br>
        </form>
      </div>
      
       
        <?php
        //if the login button is clicked get username and password
        //check if table users contains given parameters
        if(isset($_POST["login"])){
          
          //get username and password for user 1 stored in 
          //username box
          $user1= $_POST['player1_username'];
          //passwd box
          $pass1 = $_POST['password_player1'];
          //encrypt the password with md5 and a secret key
          $hashedpass1 = md5($pass1.'josthanos'.$user1[0]);
          //try to get rows from table users with user1 and pass1 
          $user1_query = $db->prepare("select* from users where username=? and password=?");
          $user1_query->execute(array($user1, $hashedpass1));
            //get the fetched result, this result will return a string instead of an array
          $user1_fetched= $user1_query->fetch(PDO::FETCH_ASSOC);
          //count how many rows in table contain the given username and passwd
          //if there are none, credentials are invalid
          $rows_user1 = $user1_query->rowCount();

          //same for user 2
          $user2= $_POST['player2_username'];
          $pass2 = $_POST['password_player2'];
          //encrypt the password with md5 and a secret key
          $hashedpass2 = md5($pass2.'josthanos'.$user2[0]);
          $user2_query = $db->prepare("select* from users where username=? and password=?");
          $user2_query->execute(array($user2, $hashedpass2));
          $user2_fetched= $user2_query->fetch(PDO::FETCH_ASSOC);
          $rows_user2 = $user2_query->rowCount();

            
          $total_rows = $rows_user1 + $rows_user2;
          //check if there are a total of 2 users who have the given credentials
          //also check if the user didn't use the same account twice because you don't
          //want a player playing against himself
          if($total_rows==2&& $user1!=$user2)
          {
            $_SESSION["player_two"] = $user2_fetched["username"];
            $_SESSION["player_one"] = $user1_fetched["username"];
            header('Location: index.php');
          }
          else
          {
              echo "Wrong credentials";
              header('Location: index.php');
          } 
        }
}
//create memory on page
function createMemory($amount, $db, $user1, $user2)
{
   
    //amount of rows for memory
    $rows = $amount/2;
    //the index of the image on the memory page itself
    $imgindex=0;
    //image array filled with $amount of images * 2
    $imageArray = getImgArr($db, $amount);
    //shuffle array so it gets random
    shuffle($imageArray);

    ?>

    <!-- idk but my imgA and imgB classes don't seem to work if I place them in styles.css -->
    <style>
    .imgA{
        position: relative;  
    }
    .imgB{
       position: absolute;            
     }
    </style>
    
    <table class="table table-dark">
        <?php
            for($i=0;$i<$rows;$i++)
            {?>
        <tr>
                <?php 
                //I use 6 for columns because it's fits on the screen well
                for($a=0;$a<6;$a++)
                {
                    //check if index is not out of bounds of array
                    if($imgindex<count($imageArray))
                    {
                    ?>
                    <td class="centeroo">
                        <!-- post image with the link out of the imagearray's image -->
                        <img class="imgB" src="<?php echo $imageArray[$imgindex]["link"]; ?>" height="150" width="200"> 
                        <!-- then add the cover on top of the image to hide it, this is where the magic happens -->
                        <?php addCover($imgindex,$imageArray[$imgindex]["image_id"],$amount, $user1, $user2);?> 
                    </td>
                <?php
                    }
                    //set new index
                    $imgindex++;
                }
                ?>
        </tr>
        <?php
            }
        ?>
    </table>
<?php

}
//returns an image array with size $amount of images 
function getImgArr($db, $amount)
{
    $image_array = array();
    //get images through query
    //the position of the images in the database is random so you don't always get the first 2,4,6,8 etc. images 
    $query = $db->prepare("SELECT * FROM images where memory_use = 1 ORDER BY RAND() LIMIT ".$amount);
    $query->execute();
    //put each image in the imagearray but double because in memory you have to pick 2 cards
    foreach($query as $image)
    {
        array_push($image_array, $image);
        array_push($image_array, $image);
    }
    return $image_array;
}

//adds cover on top of an image
//gets 'removed' when clicked on
function addCover($imgindex, $id_image, $amount, $player_one, $player_two)
{
    
    //put usernames in string format. Javascript doesn't accept simply '$player_one'
    $username_1brackets = "'".$player_one."'";
    $username_2brackets = "'".$player_two."'";
    ?>
    <img src="images/emblem.jpg" id="<?php echo $imgindex;?>" 
    onclick="removeCover(this.id,<?php echo $id_image;?>,<?php echo $amount;?>, <?php echo $username_1brackets;?>, <?php echo $username_2brackets;?>);" 
    class="imgA" width="200" height="150">
    <?php
}


?>
