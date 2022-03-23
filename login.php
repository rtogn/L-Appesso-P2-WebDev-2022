<?php
include("save_usr.php");
//start session
session_start();

if (isset($_POST['login']) && strlen($_POST['login']) > 0)   // it checks whether the user clicked login button or not 
{	
	$board = getLeaderboard($scoreFile);
    $user = $_POST['user'];
    $pass = "none"; //$_POST['pass'];
	addUser($user, $pass, $board);
    $_SESSION['use'] = $user;
	//$_SESSION['wincount'] = (int)($board[$user]['win']);
	//$_SESSION['loss'] = (int)($board[$user]['loss']);
	$_SESSION['board'] = $board;
}


if (isset($_SESSION['use'])) {
    header("Location:game.php");
}

?>

<html>

<head>

    <title> Login Page </title>
    <link rel="stylesheet" type="text/css" href="style.css">
    <link rel="stylesheet" type="text/css" href="login.css">
</head>

<body>
    <div class="center">
    	<h1 class="beep">「L'Appesso - The Hanged Man」</h1>
	<h3>Log in with your credentials or create a new user for the score board</h3>
	<form action="" method="post">
        <table width="200" border="0">
            <tr>
                <td> UserName</td>
                <td> <input type="text" name="user"> </td>
 	   </tr>
	    <tr>
        	<td>Password</td>   
		<td><input type="text" name="pass"></td>
            </tr>
            <tr>
                <td> <input type="submit" name="login" value="LOGIN"></td>
            </tr>
        </table>

    	</form>
    </div>
</body>

</html>
