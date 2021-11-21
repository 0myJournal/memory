
//global variables

//previous image and cover that were clicked
var last_id = 0;
var last_clicked_index = 0;

var firstclicked = true;
//array with images the user had guessed
var guessedImages = new Array();

//player variables
var clicks = 0;
var player_one = true;
var turns_p1 = 0;
var turns_p2 = 0;
var first = true;

//removes cover of clicked_index and checks if you guessed right or wrong image
function removeCover(clicked_index, img_id, amount, playerone_name, playertwo_name)
{
        //add clicks and set turns for player
        clicks++;
        if(clicks==2){
            player_one=false;
        }
        if(clicks==4){
            player_one=true;
            clicks=0;
        }

        //get cover from given index
        var cover = document.getElementById(clicked_index);
        //makes cover translucent
        cover.style.opacity = 0;
        //check if the image is already guessed
        if(!guessedImages.includes(img_id))
        {
            //checks if the id of the image you clicked on is the same as the last image
            //also checks if the index of image isn't the same, you shouldn't have a guess if you
            //just click on the same image twice
            if(img_id==last_id && clicked_index!= last_clicked_index)
            {
                //put id of image in guessedImages
                guessedImages.push(img_id);
                
                //check if the amount of guessed images is equal to the amount of images played with
                //true -> won game
                //false -> keep on playing
                if(guessedImages.length==amount)
                {
                    //check who won determined by who has the least turns
                    //when player one is winner
                    if(turns_p1<turns_p2){
                        alert(playerone_name + " WINS!");
                        //put data into game table using ajax
                        insertIntoDatabase(playerone_name,playerone_name,playertwo_name,turns_p1,turns_p2); 
                        //go to leaderboard.php to see the score
                        //set a time out because php is slow and needs a second to insert data
                        setTimeout(function(){window.location.href = "leaderboard.php";} ,1000);
                    }
                    //when player two is winner
                    if(turns_p2<turns_p1){
                        alert(playertwo_name + " WINS!");
                        insertIntoDatabase(playertwo_name,playerone_name,playertwo_name,turns_p1,turns_p2);
                        setTimeout(function(){window.location.href = "leaderboard.php";} ,1000);
                    }
                    //no winner
                    if(turns_p1==turns_p2)
                    {
                        alert("nobody wins :("); 
                        //put colomn 'winner' in database to null
                        insertIntoDatabase("",playerone_name,playertwo_name,turns_p1,turns_p2);
                        setTimeout(function(){window.location.href = "leaderboard.php";} ,1000);
                    }
                    
                }
            }
            else{
                //you don't have to turn the first image clicked to normal opacity yet
                if(firstclicked)
                {
                    firstclicked=false;
                }
                //but the second one you do, but only if you guessed wrong
                else{

                    //check if the clicked images aren't guessed and them turn the covers back to normal
                    if(!guessedImages.includes(img_id) &&!guessedImages.includes(last_id)&& clicked_index!= last_clicked_index)
                    {
                        //add turns for player one or player two
                        if(player_one){
                            turns_p1++;
                            document.getElementById("turns_player_one").innerHTML = playerone_name +" "+turns_p1.toString();
                        }
                        else{
                            turns_p2++;
                            document.getElementById("turns_player_two").innerHTML = playertwo_name +" "+turns_p2.toString();
                        }
                        //after a second (because the user needs to memorize what they clicked on) 
                        //set opacity back to normal 
                        setTimeout(function(){cover.style.opacity=1;} ,1000);
                        //same with the last cover you clicked on
                        var last_cover = document.getElementById(last_clicked_index);
                        setTimeout(function(){last_cover.style.opacity=1;} ,1000);
                        //reset firstclicked variable because you start a new turn
                        firstclicked=true;
                    }
                }
            }
            //set last id and last index as current so you can compare the images again next click
            //but only images that are not guessed yet because otherwise the system will reset the opacity of cover of a guessed image 
            if(!guessedImages.includes(img_id))
            {
               last_id=img_id;
               last_clicked_index = clicked_index;
            }
        }
}

//inserts data into game table using ajax function
function insertIntoDatabase(winner,player_one,player_two, turns1, turns2)
{
    //XMLHttp variable can get and post data from/to pages
    var xhttp = new XMLHttpRequest();
    //open the API to upload the given data with a POST request
    xhttp.open("POST", "api/upload_game.php?w="+winner+"&&p1="+player_one+"&&p2="+player_two+"&&t1="+turns1+"&&t2="+turns2,true);
    //send the request
    xhttp.send();
    console.log(xhttp);
}

//variables to store the last clicked items
var lastblueselected= 0;
var lastclicked=0;
var first = true;
//set divid to background color darkred
//set divid in playeronetxt, the textbox in form used to post the selected user
//set make same divid in other box unselectable
//set previous selected divid box to old style
//set previous selected divid in other box from grey to old style
function selectItemRed(divid){
    //get the selected div
    var selecteddiv = document.getElementById(divid);
    //check if its not already selected as player two (when it is the background colour is set to grey)
    if(selecteddiv.style.backgroundColor != "grey"){
        //put the name of player one in the textbox in form used to post the player one
        putInBox("playeronetxt",divid);
        //set background to dark red so the user knows this box is selected
        selecteddiv.style.backgroundColor = "darkred";
        //set HTML of the h1 where the user is mentioned to the name of selected user
        document.getElementById("player_one").innerHTML = "Player one: " + (divid);
        //the id of player two is the same as player one but with "blue" added
        //get the id of the same user but in other box
        var selecteddivblue = document.getElementById(divid + "blue");
        //set it to grey to make it unselectable. I don't want 1 player playing against himself
        //that is not fun
        selecteddivblue.style.backgroundColor = "grey";
        //check if its the first click because otherwise there aren't any previous selected items
        if(first){
            first=false;
        }
        else{
            //reset the style of the previous selected element
            var last_selected_id = document.getElementById(lastclicked);
            last_selected_id.className= "divred";
            last_selected_id.style = "";
            //reset the style of the previous unselectable item from box for player two
            var last_selected_id_blue = document.getElementById(lastblueselected);
            last_selected_id_blue.className = "divblue";
            last_selected_id_blue.style = "";
        }
        //set previous items
        lastclicked = divid;
        lastblueselected = divid + "blue";
    }
    
}
//variables to store the last clicked items
var lastclickedBlue=0;
var lastredselected= 0;
//bool to check if first turn
var firstBlue = true;
function selectItemBlue(divid){
    //get the selected div
    var selecteddiv = document.getElementById(divid);
    //check if its not already selected as player one (when it is the background colour is set to grey)
    if(selecteddiv.style.backgroundColor != "grey"){
        //put the name of player two in the textbox in form used to post the player two
        putInBox("playertwotxt",getName(divid));
        //set background to dark blue so the user knows this box is selected
        selecteddiv.style.backgroundColor = "darkblue";
        //set HTML of the h1 where the user is mentioned to the name of selected user
        document.getElementById("player_two").innerHTML = "Player two: " + getName(divid);
        //the id of player one is the same as player two but without "blue" added
        //get the id of the same user but in other box
        var sameidinred = document.getElementById(getName(divid));
        //set it to grey to make it unselectable. I don't want 1 player playing against himself
        //that is not fun
        sameidinred.style.backgroundColor = "grey";
        //check if its the first click because otherwise there aren't any previous selected items
        if(firstBlue){
            firstBlue=false;
        }
        else{
            //reset the style of the previous selected element
            var last_selected_id = document.getElementById(lastclickedBlue);
            last_selected_id.className= "divblue";
            last_selected_id.style = "";
            //reset the style of the previous unselectable item from box for player two
            var last_selected_red = document.getElementById(lastredselected);
            last_selected_red.className= "divred";
            last_selected_red.style = "";
        }
        //set previous items
        lastclickedBlue = divid;
        lastredselected = getName(divid);
    }
    
    
}
//returns same string but without the last 4 letters
//"josblue"->"jos"
function getName(divid){
    var name="";
    var p2 = divid.toString();
    //loop over string and add every character to the new string until
    //i is the given string's length-4. 4 is the length of "blue"
    for(var i=0; i<p2.length-4; i++){
        name+=p2[i];
    }
    return name;

}

//set value of txtbox to given divid
function putInBox(txtbox,divid){
    document.getElementById(txtbox).value=divid;
}