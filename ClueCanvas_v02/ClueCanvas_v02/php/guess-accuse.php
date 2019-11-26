<?php

//include the basic database connection and function pages
	include_once('dbConnect.php');
	include_once('functions.php');

//if there is no current turn and no current player id, it is a new game and the setup phase must run. for now, this is dummy data until the startup script works
	if(!isset($_SESSION['game']['turn']) || !isset($_SESSION['game']['turn'])) {
        echo "Start goes here";

    }
    else
    {
        $gameId = $_SESSION['game']['gameId'];
        $numPlayers = $_SESSION['game']['numPlayers'];
        $turn = $_SESSION['game']['turn'];
        $nextPlayer = $_SESSION['game']['turn'] + 1;
        $_SESSION['game']['nextPlayer'] = $nextPlayer;
        $currentPlayer = $_SESSION['game']['turn'];

        $currentTurn = $_SESSION['game']['turn'];
        $playerName = $_SESSION['players'][$currentPlayer]['name'];
        $playerCharacter = $_SESSION['players'][$currentPlayer]['character'];
        // $playerLocation = $_SESSION['players'][$currentPlayer]['location'];
        $playerRoom = $_SESSION['players'][$currentPlayer]['room'];
    }


    if(!isset($room))
    {
        $roomName = $_SESSION['players'][$currentPlayer]['room'];
        //    $roomName = convertRoom($room);
    }

    //depending on what button is pressed, launch that function
//if guess is clicked
	if (!empty($_POST['btn-guess'])) {
	    //run the guess function
	    guess();
	    //and reset the post variable for the button
        $_POST['btn-guess'] = null;
        //if the accuse button is clicked
    } else if (!empty($_POST['btn-accuse'])) {
        //run the accuse function
	    accuse();
        //and reset the post variable for the button
        $_POST['btn-accuse'] = null;
        //finally, if the choose button on the modal window is pressed
    } else if (!empty($_POST['btn-chooseSubmit'])) {       
            $chosenCard = $_POST['txt-chosenCard'];
        if($_POST['btn-chooseSubmit']) {           
        }
        else if (!empty($_SESSION['chosenCard'])) {
            echo "chosen: " . $chosenCard;
            showCard();
        }

        //launch the finish update function as this is a continuation of the player's last guess

        finishUpdate($chosenCard);

    }
    else if(!empty($_POST['btn-nextTurn']))
    {
        nextTurn();
    }


//this is the second half of the guess function IF there were more than 1 cards matching with another player and the current player chose one of them
    function finishUpdate($chosenCard)
    {
        //include the turn page to get access to the turn order function (although probably not needed here)
        include_once('turn.php');

        //get the database connection information
        $db = getDatabase();
        //set the chosen card to equal what was clicked
        $chosenCard = $_SESSION['chosenCard'];
        //$_SESSION['chosenCard'] = $chosenCard;

        //set game id to what was in the session variable
        $gameID = $_SESSION['game']['gameId'];
        //set the current player id to what was in the session variable
        $currentPlayer = $_SESSION['game']['turn'];
        //set current turn based on whats in the session variable
        $currentTurn = $_SESSION['game']['turn'];
        //set the card from player to what was in the session variable (which in turn was set in the first half of the guess function)
        $cardFromPlayer = $_SESSION['cardFromPlayer'];

        //prepare the sql statement to update the correct category on the correct game and in the correct notebook
        $sqlState = $db->prepare("UPDATE cluecards SET $chosenCard = $cardFromPlayer WHERE gameID LIKE $gameID AND playerID LIKE $currentPlayer AND notebookID LIKE $cardFromPlayer");

        //execute the sql statement
        $sqlState->execute();

        //if there were rows returned, it was successful. if not, there was a problem
        if ($sqlState->execute() && $sqlState->rowCount() > 0) {
            $results1 = $sqlState->fetchAll(PDO::FETCH_ASSOC);
            }

        //populate a turnOrder variable with the turn order based on the number of players and the current turn
        $turnOrder = getCurrentPlayerOrder($_SESSION['game']['numPlayers'], $_SESSION['game']['turn']);

        //set the next player variable to equal the first spot in the turnOrder array (which is the next player)
        showCard();


        //update session variables

        //$_SESSION['game']['currentPlayer'] = $currentPlayer;
        //$_SESSION['game']['nextPlayer'] = $nextPlayer;

    }

    //function to check if the card is owned by another player
    function checkIfOwned($db, $card, $gameID, $currentPlayer, $cardFromPlayer)
    {
        //prepare the sql statement
        $sqlState = $db->prepare("SELECT * FROM clueCards WHERE GameID LIKE $gameID AND playerID LIKE $currentPlayer AND notebookID LIKE $cardFromPlayer AND $card LIKE $cardFromPlayer");
        //print_r($sqlState);

        //if there were rows returned, it was successful. if not, there was a problem
        if ($sqlState->execute() && $sqlState->rowCount() > 0) {
            $results = $sqlState->fetchAll(PDO::FETCH_ASSOC);
            //set the card variable to 1 indicating that the card is already owned
            $card = 1;
        }
        else
        {
            //set the card variable to 0 indicating that no match is found and that card is not owned by that player
            $card = 0;
        }

        //return the result
        return $card;
    }

    function showCard()
    {
        echo "<br/>";
        echo "<div class='col-12'>Click the button to view your card</div>";
        echo "<div class='row'><div class='col-6'><button type='button' id='btnShowCard' class='btn btn-info btn-lg' data-toggle='modal' data-target='#showCard'>Show Card</button></div></div>";
        //echo "<div class='col-6'><button type='button' id='btnNextTurn' class='btn btn-info btn-lg' data-toggle='modal' data-target='#'>Next Turn</button></div>";
        echo "<form method='post' action='index.php'><div class='col-6'><input type='submit' id='btn-nextTurn' name='btn-nextTurn' class='btn btn-info btn-lg' value='Next Turn'></div></form>";
        echo "<div class='row'><br /><br /><br /></div>";
    }

    //function that triggers once a player clicks on suggest
	function guess()
    {

        //if there is post data in each of these fields...
        if ((!empty($_POST['txt-game-id'])) && !empty($_POST['sel-weapons']) && !empty($_POST['sel-players']) && !empty($_POST['txt-room'])) {
            //get database info
            $db = getDatabase();
            //set the following variables based on their post data
            $gameID = $_POST['txt-game-id'];
            $selWeapons = $_POST['sel-weapons'];
            $selPerson = $_POST['sel-players'];
            $txtRoom = $_POST['txt-room'];
            $currentTurn = $_POST['txt-current-turn'];
            $numPlayers = $_POST['txt-num-players'];
            //$currentPlayer = $_POST['txt-player-id'];
            $currentPlayer = $_SESSION['game']['turn'];
        }
        //if there is no post data in those fields
        else//ask the user to enter some
        {
            echo "Please choose a valid weapon, person and room";
        }

        $txtRoom = convertRoom($txtRoom);

        //prepare the sql statement to check the master record to figure out who owns the cards selected
        $sqlState = $db->prepare("SELECT * FROM clueCards WHERE GameID LIKE $gameID AND playerID LIKE 0");

        //if the sql executes successfully, populate the $results array with the master record
        if ($sqlState->execute() && $sqlState->rowCount() > 0) {
            $results = $sqlState->fetchAll(PDO::FETCH_ASSOC);
        }

        //var_dump($results);
//print_r($results[0][$selWeapons]);
        //print_r($results);

        //if all categories selected come back as 0, they are all part of the solution
        if (($results[0][$selWeapons] == 0) && ($results[0][$selPerson] == 0) && ($results[0][$txtRoom] == 0))
        {
            echo "Winnah - no cards found";
        } else {
            //use order function to determine who's cards to look at to see if they have any of the selected cards
            include_once('turn.php');

            //populate the turn order variable with the getCurrentPlayerOrder function
            $turnOrder = getCurrentPlayerOrder($numPlayers, $currentTurn);

            //set the next player to be the next player in the turn order variable
            $nextPlayer = $turnOrder[0];

            //start the sql statement
            $partialSql = "UPDATE cluecards SET ";

            //as long as it hasnt looped around and come back to the current player, keep checking records
            while ($nextPlayer != $currentPlayer) {
                //print_r($results);
                //find out which match and set their update variables for hte sql statement
                //weapons and person

                //if categories being checked BOTH match the next player being checked...
                if (($results[0][$selWeapons] == $nextPlayer) && $results[0][$selPerson] == $nextPlayer) {
                    //$_SESSION['game']['nextPlayer'] = $nextPlayer;

                    $_POST['card1'] = $selWeapons;
                    $_POST['card2'] = $selPerson;

                    $card1 = $results[0][$selWeapons];
                    $_SESSION['card1'] = $results[0][$selWeapons];
                    $card2 = $results[0][$selPerson];
                    $_SESSION['card2'] = $results[0][$selPerson];

                    //set the cardFromPlayer variable to equal the next player
                    $cardFromPlayer = $nextPlayer;
                    //set the session variable for that. (PROBABLY NOT NEEDED)
                    $_SESSION['cardFromPlayer'] = $cardFromPlayer;

                    //check the first card to see if its owned using the checkIfOwned function
                    $cardCheck1 = checkIfOwned($db, $selWeapons, $gameID, $currentPlayer, $cardFromPlayer);

                    //check the second card to see if its owned using the checkIfOwned function
                    $cardCheck2 = checkIfOwned($db, $selPerson, $gameID, $currentPlayer, $nextPlayer);

                    //if they both come back as 0, both are valid
                    if($cardCheck1 == 0 && $cardCheck2 == 0) {
                        //so run the choice function to choose between them
                        $chosenCard = choice($card1, $card2);
                        $_SESSION['chosenCard'] = $chosenCard;

                        //break out of the loop
                        $nextPlayer = $currentPlayer;
                    }
                    //otherwise if only card 1 is valid
                    else if ($cardCheck1 == 0 && $cardCheck2 == 1)
                    {
                        //set the chosen card to card 1
                        $chosenCard = $card1;
                        //use card 1 - weapon
                        $_SESSION['chosenCard'] = $chosenCard;

                        //finish the sql statement
                        $partialSql .= "$chosenCard = $cardFromPlayer, WHERE gameID LIKE $gameID AND playerID LIKE $currentPlayer AND notebookID LIKE $cardFromPlayer";
                        //break out of the loop
                        $nextPlayer = $currentPlayer;
                    }
                    //otherwise if only card 2 is valid
                    else if ($cardCheck1 == 1 && $cardCheck2 == 0)
                    {
                        //set the chosen card to card 2
                        $chosenCard = $card2;
                        //use card 2 - person
                        $_SESSION['chosenCard'] = $chosenCard;

                        //finish the sql statement
                        $partialSql .= "$chosenCard = $cardFromPlayer, WHERE gameID LIKE $gameID AND playerID LIKE $currentPlayer AND notebookID LIKE $cardFromPlayer";
                        //break out of the loop
                        $nextPlayer = $currentPlayer;
                    }
                    //otherwise, if neither are valid, check the next player
                    else if ($cardCheck1 == 1 && $cardCheck2 == 1)
                    {
                        //neither is valid, go to next player
                        $nextPlayer++;
                    }

                    //showCard();
                    //echo "Weapon or Person Updated";

                    //update weapons or room
                } else if (($results[0][$selWeapons] == $nextPlayer) && ($results[0][$txtRoom] == $nextPlayer)) {
                    $_POST['card1'] = $selWeapons;
                    $_POST['card2'] = $txtRoom;

                    $card1 = $results[0][$selWeapons];
                    $_SESSION['card1'] = $results[0][$selWeapons];
                    $card2 = $results[0][$txtRoom];
                    $_SESSION['card2'] = $results[0][$txtRoom];

                    //set the cardFromPlayer variable to equal the next player
                    $cardFromPlayer = $nextPlayer;
                    //set the session variable for that. (PROBABLY NOT NEEDED)
                    $_SESSION['cardFromPlayer'] = $cardFromPlayer;

                    //check the first card to see if its owned using the checkIfOwned function
                    $cardCheck1 = checkIfOwned($db, $selWeapons, $gameID, $currentPlayer, $cardFromPlayer);
                    //if it comes back as 0, it was not found and is a valid card to use

                    //check the second card to see if its owned using the checkIfOwned function
                    $cardCheck2 = checkIfOwned($db, $txtRoom, $gameID, $currentPlayer, $nextPlayer);

                    //if they both come back as 0, both are valid
                    if($cardCheck1 == 0 && $cardCheck2 == 0) {
                        //so run the choice function to choose between them
                        $chosenCard = choice($card1, $card2);
                        $_SESSION['chosenCard'] = $chosenCard;

                        //break out of the loop
                        $nextPlayer = $currentPlayer;
                    }
                    //otherwise if only card 1 is valid
                    else if ($cardCheck1 == 0 && $cardCheck2 == 1)
                    {
                        //set the chosen card to card 1
                        $chosenCard = $card1;
                        //use card 1 - weapon
                        $_SESSION['chosenCard'] = $chosenCard;

                        //finish the sql statement
                        $partialSql .= "$chosenCard = $cardFromPlayer, WHERE gameID LIKE $gameID AND playerID LIKE $currentPlayer AND notebookID LIKE $cardFromPlayer";
                        //break out of the loop
                        $nextPlayer = $currentPlayer;
                    }
                    //otherwise if only card 2 is valid
                    else if ($cardCheck1 == 1 && $cardCheck2 == 0)
                    {
                        //set the chosen card to card 2
                        $chosenCard = $card2;
                        //use card 2 - person
                        $_SESSION['chosenCard'] = $chosenCard;

                        //finish the sql statement
                        $partialSql .= "$chosenCard = $cardFromPlayer, WHERE gameID LIKE $gameID AND playerID LIKE $currentPlayer AND notebookID LIKE $cardFromPlayer";
                        //break out of the loop
                        $nextPlayer = $currentPlayer;
                    }
                    //otherwise, if neither are valid, check the next player
                    else if ($cardCheck1 == 1 && $cardCheck2 == 1)
                    {
                        //neither is valid, go to next player
                        $nextPlayer++;
                    }
                    //showCard();
                    //$_SESSION['chosenCard'] = $chosenCard;
                    //echo "Room or Weapon Updated";

                    //update person or room
                } else if (($results[0][$selPerson] == $nextPlayer) && ($results[0][$txtRoom] == $nextPlayer)) {

                    $card1 = $results[0][$selPerson];
                    $card2 = $results[0][$txtRoom];

                    //set the cardFromPlayer variable to equal the next player
                    $cardFromPlayer = $nextPlayer;
                    //set the session variable for that. (PROBABLY NOT NEEDED)
                    $_SESSION['cardFromPlayer'] = $cardFromPlayer;

                    //check the first card to see if its owned using the checkIfOwned function
                    $cardCheck1 = checkIfOwned($db, $selPerson, $gameID, $currentPlayer, $cardFromPlayer);

                    //check the second card to see if its owned using the checkIfOwned function
                    $cardCheck2 = checkIfOwned($db, $txtRoom, $gameID, $currentPlayer, $nextPlayer);
                    //if it comes back as 0, it was not found and is a valid card to use

                    //if they both come back as 0, both are valid
                    if($cardCheck1 == 0 && $cardCheck2 == 0) {
                        //so run the choice function to choose between them
                        $chosenCard = choice($card1, $card2);
                        $_SESSION['chosenCard'] = $chosenCard;

                        //break out of the loop
                        $nextPlayer = $currentPlayer;
                    }
                    //otherwise if only card 1 is valid
                    else if ($cardCheck1 == 0 && $cardCheck2 == 1)
                    {
                        //set the chosen card to card 1
                        $chosenCard = $card1;
                        //use card 1 - weapon
                        $_SESSION['chosenCard'] = $chosenCard;

                        //finish the sql statement
                        $partialSql .= "$chosenCard = $cardFromPlayer, WHERE gameID LIKE $gameID AND playerID LIKE $currentPlayer AND notebookID LIKE $cardFromPlayer";
                        //break out of the loop
                        $nextPlayer = $currentPlayer;
                    }
                    //otherwise if only card 2 is valid
                    else if ($cardCheck1 == 1 && $cardCheck2 == 0)
                    {
                        //set the chosen card to card 2
                        $chosenCard = $card2;
                        //use card 2 - person
                        $_SESSION['chosenCard'] = $chosenCard;

                        //finish the sql statement
                        $partialSql .= "$chosenCard = $cardFromPlayer, WHERE gameID LIKE $gameID AND playerID LIKE $currentPlayer AND notebookID LIKE $cardFromPlayer";
                        //break out of the loop
                        $nextPlayer = $currentPlayer;
                    }
                    //otherwise, if neither are valid, check the next player
                    else if ($cardCheck1 == 1 && $cardCheck2 == 1)
                    {
                        //neither is valid, go to next player
                        $nextPlayer++;
                    }

//                    showCard();
//                    $_SESSION['chosenCard'] = $chosenCard;
                    //echo "Person or Room Updated";

                    //update person
                } else if ($results[0][$selPerson] == $nextPlayer) {
                    //set the cardFromPlayer variable to equal the next player
                    $cardFromPlayer = $nextPlayer;
                    //construct rest of sql statement
                    $partialSql .= "$selPerson = $cardFromPlayer WHERE gameID LIKE $gameID AND playerID LIKE $currentPlayer AND notebookID LIKE $cardFromPlayer";

                    //$_SESSION['game']['nextPlayer'] = $nextPlayer;
                    $nextPlayer = $currentPlayer;

                    $_SESSION['chosenCard'] = $selPerson;

                    showCard();
                    //nextTurn();
                    //echo "Person Updated";

                    //update weapons
                } else if ($results[0][$selWeapons] == $nextPlayer) {
                    //set the cardFromPlayer variable to equal the next player
                    $cardFromPlayer = $nextPlayer;
                    //construct rest of sql statement
                    $partialSql .= "$selWeapons = $cardFromPlayer WHERE gameID LIKE $gameID AND playerID LIKE $currentPlayer AND notebookID LIKE $cardFromPlayer";

                    //$_SESSION['game']['nextPlayer'] = $nextPlayer;
                    $nextPlayer = $currentPlayer;


                    $_SESSION['chosenCard'] = $selWeapons;
                    showCard();
                    //nextTurn();
                    //echo "Weapon Updated";

                    //update room
                } else if ($results[0][$txtRoom] == $nextPlayer) {
                    //set the cardFromPlayer variable to equal the next player
                    $cardFromPlayer = $nextPlayer;
                    //construct rest of sql statement

                    $partialSql .= "$txtRoom = $cardFromPlayer WHERE gameID LIKE $gameID AND playerID LIKE $currentPlayer AND notebookID LIKE $cardFromPlayer";

                    //$_SESSION['game']['nextPlayer'] = $nextPlayer;
                    $nextPlayer = $currentPlayer;
                    $_SESSION['chosenCard'] = $txtRoom;
                    showCard();
//                    nextTurn();
                    //echo "Room Updated";

                } else {
                    //as long as the next player does not equal the current player (it hasnt looped back around yet)
                    if($nextPlayer != $currentPlayer)
                    {
                        //add one to the next player
                        $nextPlayer++;
                        //if the next player is higher than the number of players
                        if($nextPlayer > $numPlayers)
                        {
                            //reset the player to player 1
                            $nextPlayer = 1;
                        }
                    }
                }
            }

            $sqlState = $db->prepare($partialSql);

            if ($sqlState->execute() && $sqlState->rowCount() > 0) {
                $results1 = $sqlState->fetchAll(PDO::FETCH_ASSOC);
                //print_r($results1);
            }

        }
    }

	function choice($card1, $card2){

	    echo "<br/>";
        echo "<div class='row'><div class='col-2'></div><div class='col-10'>Multiple matches found. Click the button to choose a card.</div></div></div>";
	    echo "<div class='row'><div class='col-4'></div><div class='col-4'><button type='button' id='btnChoose' class='btn btn-info btn-lg' data-toggle='modal' data-target='#chooseCards'>Choose Card</button></div></div>";
	    echo "<div class='row'><br /></div>";
    }

    function nextTurn()
    {
        include_once('turn.php');

        $turnOrder = getCurrentPlayerOrder($_SESSION['game']['numPlayers'], $_SESSION['game']['turn']);

        $_SESSION['game']['turn'] = $turnOrder[0];
        $_SESSION['game']['nextPlayer'] = $turnOrder[1];

    }


	function accuse() {
        echo 'Accuse Function Executed Successfully';
    }

    function convertRoom($room)
    {

        if($room == "Billiard Room")
        {
            $roomName = "billiard_room";
        }
        else if($room == "Dining Room")
        {
            $roomName = "dining_room";
        }
        else if($room == "Ballroom")
        {
            $roomName = "ballroom";
        }
        else if($room == "Hall")
        {
            $roomName = "hall";
        }
        else if($room == "Kitchen")
        {
            $roomName = "kitchen";
        }
        else if($room == "Library")
        {
            $roomName = "library";
        }
        else if($room == "Lounge")
        {
            $roomName = "lounge";
        }
        else if($room == "Study")
        {
            $roomName = "study";
        }

        return $roomName;
    }

?>



<div class="col-12">
   <form method="post" action="index.php">
	   <div class="row">
		   <div class="col-4">
			   <select id="sel-players" name="sel-players" class="btn btn-info btn-block btn-sm">
				   <option value="">Player:</option>
				   <option value="mr_green">Green</option>
				   <option value="colonel_mustard">Mustard</option>
				   <option value="mrs_peacock">Peacock</option>
				   <option value="professor_plum">Plum</option>
				   <option value="miss_scarlet">Scarlet</option>
				   <option value="mrs_white">White</option>
			   </select>
		   </div>
		   <div class="col-4">
			   <select id="sel-weapons" name="sel-weapons" class="btn btn-info btn-block btn-sm">
				   <option value="">Weapon:</option>
				   <option value="candlestick">Candlestick</option>
				   <option value="dagger">Dagger</option>
				   <option value="lead_pipe">Lead Pipe</option>
				   <option value="pistol">Pistol</option>
				   <option value="rope">Rope</option>
                   <option value="wrench">Wrench</option>
			   </select>
		   </div>
		   <div class="col-4">
			   <input type="text" id="txt-room" name="txt-room"
                      class="btn btn-secondary btn-block btn-sm" value="<?php

               echo $_SESSION['players'][$currentPlayer]['room']; ?>" readonly>
           </div>
	   </div>
	   <div class="row">
		   <div class="col-6">
			   <input type="submit" id="btn-guess" name="btn-guess"
                      class="btn btn-primary btn-block btn-sm" value="Suggest">
		   </div>
		   <div class="col-6">
			   <input type="submit" id="btn-accuse" name="btn-accuse"
                      class="btn btn-danger btn-block btn-sm" value="Accuse">
		   </div>
	   </div>
       <div class="row">
           <div class="col-3">
               <input type="text" hidden="true" id="txt-game-id" Value="<?php echo $_SESSION['game']['gameId'] ?>" name="txt-game-id" />
           </div>
           <div class="col-3">
               <input type="text" hidden="true"  id="txt-num-players" Value="<?php echo $_SESSION['game']['numPlayers'] ?>" name="txt-num-players" />
           </div>
           <div class="col-3">
               <input type="text" hidden="true"  id="txt-player-id" Value="<?php echo $_SESSION['game']['turn'] ?>" name="txt-player-id" />
           </div>
       </div>
       <div class="row">
           <div class="col-3">
               <input type="text" hidden="true" id="txt-current-turn" name="txt-current-turn" Value="<?php echo $_SESSION['game']['turn'] ?>" />
               <input type="text" hidden="true" id="txt-nextPlayer" name="txt-nextPlayer" Value="<?php echo $_SESSION['game']['nextPlayer'] ?>" />
           </div>
       </div>
   </form>
</div>


<!-- Modal for choose card-->
<!-- Trigger the modal with a button -->
<button type="button" hidden="true" id="btnChoose" class="btn btn-info btn-lg" data-toggle="modal" data-target="#chooseCards">Open Modal</button>


<div id="chooseCards" class="modal fade" role="dialog">
    <div class="modal-dialog">

        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <div class="col-8">
                    <h4 class="modal-title">Choose a Card!</h4>
                </div>
                <div class="col-2">
                    <button type="button" class="close" id="btn-chooseClose" data-dismiss="modal">&times;</button>
                </div>
            </div>

            <div class="modal-body" id="showChoose">
                <form method="post" action="index.php">
                    <input type="button" id="btn-showChoose" name="btn-showChoose"
                           class="btn btn-info btn-block btn-sm" value="Show Cards">
                </form>
            </div>


            <div class="modal-body" id="showCards">

                <div class="row">
                    <div class="col-6">
                        <img id="imageCard1" class="img-responsive center-block" style="max-height: 100%; max-width: 100%" src="img/Cards/<?php $card1 = $_POST["card1"]; echo $card1 ?>.jpg" alt="Card 1">
                    </div>
                    <div class="col-6">
                        <img id="imageCard2" class="img-responsive center-block" style="max-height: 100%; max-width: 100%"  src="img/Cards/<?php $card2 = $_POST["card2"]; echo $card2 ?>.jpg" alt="Card 2">
                    </div>
                    <div class="col-6" id="card1">
                        <input type="submit" id="btn-card1" name="btn-card1"
                               class="btn btn-info btn-block btn-sm" value="Choose">
                    </div>
                    <div class="col-6" id="card2">
                        <input type="submit" id="btn-card2" name="btn-card2"
                               class="btn btn-info btn-block btn-sm" value="Choose">
                    </div>
                </div>
                <form method="post" action="index.php">
                    <div class="row">
                        <div class="col-6">
                            <input type="text" id="txt-card1" hidden="true" Value="<?php echo $_POST["card1"] ?>" name="txt-card1" />
                            <input type="text" id="txt-card2" hidden="true" Value="<?php echo $_POST["card2"] ?>" name="txt-card2" />
                            <input type="text" id="txt-chosenCard" hidden="true" Value="" name="txt-chosenCard" />

                        </div>
                        <div class="col-2">

                        </div>
                        <div class="col-2"></div>
                    </div>
                    <div class="row">
                        <div class="col-3">
                        </div>
                        <div class="col-6">
                            <br/>
                            <input type="submit" id="btn-chooseSubmit" name="btn-chooseSubmit"
                                   class="btn btn-info btn-block btn-sm" value="Submit">
                        </div>
                    </div>
                </form>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>



        </div>

    </div>
</div>
<!-- end modal -->

<!-- Modal for show card-->
<!-- Trigger the modal with a button -->
<button type="button" hidden="false" id="btnShow" class="btn btn-info btn-lg" data-toggle="modal" data-target="#showCard">Open Modal</button>

<div id="showCard" class="modal fade" role="dialog">
    <div class="modal-dialog">

        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">

                <div class="col-8">
                    <h4 class="modal-title">Card aquired!</h4>
                </div>
                <div class="col-12">
                    <button type="button" class="close" id="btn-showClose" data-dismiss="modal">&times;</button>
                </div>
            </div>

            <div class="modal-body" id="showCards">

                <div class="row">
                    <div class="col-4"></div>
                    <div class="col-8">
                        <img id="imageShowCard" class="img-responsive center-block" style="max-height: 100%; max-width: 100%" src="img/Cards/<?php echo $_SESSION['chosenCard']; ?>.jpg" alt="Card 1">
                    </div>

                </div>

            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>



        </div>

    </div>
</div>
<!-- end modal -->