<?php
//get functions, ../ because it has to travel back to /memory/
require "../functions.php";
//make connection with database
try{
    $db = new PDO("mysql:host=localhost;dbname=memory;", "root","");
}
catch(PDOException $exception)
{
//echo any error with connection
  echo $exception->getmessage();
}
//get the variables given in the link
//for example 
//api/upload_game.php?w=jos&&p1=jos&&p2=greg&&t1=2&&t2=4
//$_REQUEST["w"] is the 'w=' in the link
//so $_REQUEST["w"] = "jos"
$winner = $_REQUEST["w"];
$player1 = $_REQUEST["p1"];
$player2 = $_REQUEST["p2"];
$turns1 = $_REQUEST["t1"];
$turns2 = $_REQUEST["t2"];
//set winner_id to null as default
$winner_id=NULL;
//now check if there is a winner because you can't get the ID of a NULL username
if($winner!="")
{
    $winner_id = getIDbyUsername($winner, $db);
}
//check if the rest of the values are filles
if($player1!=""&&$player2!=""&&$turns1!=""&&$turns2!="")
{
    //get id from first and second player
    $player1_id = getIDbyUsername($player1, $db);
    $player2_id = getIDbyUsername($player2, $db);  
    //query to insert game into database 
    $query_game = $db->prepare("insert into games set 
        player_one_id=?,
        player_two_id=?,
        turns_player_one=?,
        turns_player_two=?,
        winner_id=?
    ");
    //execute query with id's and turns
    $query_game->execute(array(
            $player1_id,
            $player2_id,
            $turns1,
            $turns2,
            $winner_id
    ));
    var_dump($query_game);
}

  
?>