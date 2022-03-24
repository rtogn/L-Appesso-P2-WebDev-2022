<?php
	session_start();
	include("save_usr.php")
?>
<!DOCTYPE html>
    <html>

    <head>
        <title>Leaderboard</title>
        <link type="text/css" rel="stylesheet" href="css/style.css" />
        <link type="text/css" rel="stylesheet" href="css/leaderboard.css" />
    </head>

    <body>
        <?php
		displayLeaderboard($_SESSION['board']);
		// save user scores to the persistant text file!
		saveUserScores($_SESSION['board'], $scoreFile);
		

		?>		
            <br>

            <div class="buttons">
                <form action="" method="post">
                    <table>
                        <tr>
                            <td><input type="submit" name="newGame" value="Play Another Game"></td>
                            <td><input type="submit" name="login" value="Back To Start"></td>
                        </tr>
                    </table>
                </form>
            </div>
			
		<div class="tarot">

			<h3>Your Fortune: </h3>
			<?php
			if ($_SESSION['won']) {
				$choice = $_SESSION["fortune"];
				echo " <img src=\"./imgs/".$choice.".jpg\" alt=\"".$choice."\" class=\"fortune\"> ";
			}
			else {
				
				echo " <img src=\"./imgs/death.jpg\" alt=\"DEATH\" class=\"fortune\"> ";
			}
			?>
		</div>			
            <?php
			if (isset($_POST['login'])) {
				session_destroy();
				header("Location:login.php");
			}

			if (isset($_POST['newGame'])) {
			session_destroy();
			header("Location:game.php");
			}
			
			?>

    </body>

    </html>
