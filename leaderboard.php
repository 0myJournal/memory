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
  <title>Leaderboard</title>
  <meta name="description" content="Memory v2">
  <meta name="author" content="Ewaldo Nieuwenhuis">
  <link rel="stylesheet" href="css/bootstrap.min.css">
  <link type="text/css" rel="stylesheet" href="css/styles.css">
  <script type="text/javascript" src="js/functions_js.js"></script>  
</head>

<body class="back">
  <div class="holder">
    <h1 class="title"> Leaderboard</h1>
    <h3 class="centeroo"><a href="index.php" >Back to Memory</a></h3>
    <p class="undertitle">Made by Ewaldo Nieuwenhuis</p>
    </div>
    <?php
    //get query to get the times won for each user 
    //count the winner id in the games table
    //inner join the username on the winner id
    //group by username
    //order by the count(winner_id)
    $query_leaderboard = $db->prepare("SELECT 
    COUNT(winner_id) as 'Times won',users.username, users.date_joined FROM games INNER JOIN users ON games.winner_id = users.user_id GROUP BY users.username  
    ORDER BY `Times won`  DESC");
    $query_leaderboard->execute();
    //post table with results
    ?>
    <div>
    
      <table class="table table-dark table-striped">
      <thead>
        <tr>
            <th scope="col">#</th>
            <th scope="col">User</th>
            <th scope="col">Matches Won</th>
            <th scope="col">Date joined</th>
        </tr>
        </thead>
        <tbody>
    <?php
    $cnt = 1;
    foreach($query_leaderboard as $result)
    {
        //cnt is to go from first place till last place
        //post results from query
       ?>
       <tr>
       <td><?php echo $cnt;?></td>
       <td><?php echo $result["username"];?></td>
       <td><?php echo $result["Times won"];?></td>
        <td><?php echo $result["date_joined"];?></td><?php
        $cnt++;
    }
    ?>
    </tbody>
    </table><br>
    <h3 class="centeroo"><a href="games.php">See all games</a></h3>
</body>
