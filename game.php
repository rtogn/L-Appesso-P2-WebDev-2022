<?php
include("save_usr.php");
session_start();
$letters = "ABCDEFGHIJKLMNOPQRSTUVWXYZ";



$bodyImages = ["0", "1", "2", "3", "4", "5", "6"];
$words = ["JAVASCRIPT", "HTML", "PROGRAMMING", "ARRAY"];
 

if (!isset($_SESSION['wincount'])) {
    $_SESSION['wincount'] = 0;
}

function getCurrentImage($part)
{
    return "./imgs/" . $part . ".png";
}


function restartGame()
{

    header("Location:leaderboard.php");
}

function getParts()
{
    global $bodyImages;
    return isset($_SESSION["parts"]) ? $_SESSION["parts"] : $bodyImages;
}

function addPart()
{
    $parts = getParts();
    array_shift($parts);
    $_SESSION["parts"] = $parts;
}

//get part image
function CurrentPart()
{
    $parts = getParts();
    return $parts[0];
}

function getWord()
{

    global $words;
    if (!isset($_SESSION["word"]) && empty($_SESSION["word"])) {
        $key = array_rand($words);
        $_SESSION["word"] = $words[$key];
    }
    return $_SESSION["word"];
}

function getCurrentResponses()
{
    return isset($_SESSION["responses"]) ? $_SESSION["responses"] : [];
}

function addResponse($letter)
{
    $responses = getCurrentResponses();
    array_push($responses, $letter);
    $_SESSION["responses"] = $responses;
}

function isLetterCorrect($letter)
{
    $word = getWord();
    $max = strlen($word) - 1;
    for ($i = 0; $i <= $max; $i++) {
        if ($letter == $word[$i]) {
            return true;
        }
    }
    return false;
}


function isWordCorrect()
{
    $guess = getWord();
    $responses = getCurrentResponses();
    $max = strlen($guess) - 1;
    for ($i = 0; $i <= $max; $i++) {
        if (!in_array($guess[$i],  $responses)) {
            return false;
        }
    }
    return true;
}

function isBodyComplete()
{
    $parts = getParts();
    if (count($parts) <= 1) {
        return true;
    }
    return false;
}

function gameComplete()
{
    return isset($_SESSION["gamecomplete"]) ? $_SESSION["gamecomplete"] : false;
}

function markGameAsComplete()
{
    $_SESSION["gamecomplete"] = true;
}

function markGameAsNew()
{
    $_SESSION["gamecomplete"] = false;
}


// check if game restarted
if (isset($_GET['start'])) {
	$cards = ["judgement", "magician", "sun", "temperance", "zawarudo", "moon", "tower", "love"];
	$_SESSION["fortune"] = $cards[array_rand($cards)];
    restartGame();
}

//Logic for guessing letters

if (isset($_GET['keypressed'])) {
    $currentPressedKey = isset($_GET['keypressed']) ? $_GET['keypressed'] : null;

    //if the letter pressed is correct and the body is not complete and the game is not complete
    if ($currentPressedKey && isLetterCorrect($currentPressedKey) && !isBodyComplete() && !gameComplete()) {

        //if the word ends up being correct after adding letter change game state to complete, and set won to true
        addResponse($currentPressedKey);
        if (isWordCorrect()) {
            $WON = true;
            $_SESSION['won'] = $WON;
			updateUserWin($_SESSION['use'], $_SESSION['board']);
            markGameAsComplete();
        }
    } else {

        //if body is not complete and guess is wrong add a part to the body
        if (!isBodyComplete()) {
            addPart();
			
            if (isBodyComplete()) {
				//++$_SESSION['loss'];
				$_SESSION['won'] = $WON;
				updateUserLoss($_SESSION['use'], $_SESSION['board']);
                markGameAsComplete();
            }
			
        } 
		
		/*
		else {
			//++$_SESSION['loss'];
			updateUserLoss($_SESSION['use'], $_SESSION['board']);
            markGameAsComplete();
        }
		*/
    }
}

?>

<html>

<head>
    <meta charset="UTF-8">
    <title>Hangman</title>
    <link rel="stylesheet" href="css/style.css">
	<link rel="stylesheet" href="css/game.css">
</head>

<body>

    <div class="mainDiv">

        <div class="imageDiv">
            <img src="<?php echo getCurrentImage(CurrentPart()); ?>" class="daman" />

            <?php if (gameComplete()) : ?>
                <h1>Game Complete!</h1>
            <?php endif; ?>

            <?php if ($WON  && gameComplete()) : ?>
                <p class="won">You Won!</p>
            <?php elseif (!$WON  && gameComplete()) : ?>
                <p class="lost">You Lost!</p>
            <?php endif; ?>
        </div>

        <div class="titleDiv">
            <h1>PHP Hangman</h1>
            <h2>User: <?php echo $_SESSION['use']; ?></h2>
            <div class="testDiv">
                <form method="get">
                    <?php
                    $max = strlen($letters) - 1;
                    for ($i = 0; $i <= $max; $i++) {
                        echo "<button type='submit' name='keypressed' value='" .
                            $letters[$i] . "'>" . $letters[$i] . "</button>";

                        if ($i % 7 == 0 && $i > 0) {
                            echo '<br>';
                        }
                    }
                    ?>

                    <br><br>

                    <button type="Submit" name="start">End Game</button>
                </form>
            </div>
        </div>
		<br>
        <div class="maxLetters">
            <?php
            $guess = getWord();
            $maxLetters = strlen($guess) - 1;

            for ($j = 0; $j <= $maxLetters; $j++) : $l = getWord()[$j]; ?>

                <?php if (in_array($l, getCurrentResponses())) : ?>
                    <span style="font-size: 35px; border-bottom: 3px solid #000; margin-right: 5px;"><?php echo $l; ?></span>
                <?php else : ?>
                    <span style="font-size: 35px; border-bottom: 3px solid #000; margin-right: 5px;">&nbsp;&nbsp;&nbsp;</span>
                <?php endif; ?>

            <?php endfor; ?>
        </div>

    </div>


</body>

</html>