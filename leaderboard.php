<?php
session_start();
include("save_usr.php")
?>

<html>

<head>
    <title>Leaderboard</title>
	<link type="text/css" rel="stylesheet" href="style.css" />
    <link type="text/css" rel="stylesheet" href="leaderboard.css" />
</head>
<body>
    <?php
		displayLeaderboard($_SESSION['board']);
		// save user scores to the persistant text file!
		saveUserScores($_SESSION['board'], $scoreFile);
		//var_dump(getLeaderboard($scoreFile));
	?>

    <br><br>

    <form action="" method="post">
        <input type="submit" name="login" value="Restart">
    </form>

    <?php
    if (isset($_POST['login'])) {
		
        session_destroy();
        header("Location:login.php");
    }

    ?>


</body>

</html>