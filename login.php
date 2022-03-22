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
	$_SESSION['wincount'] = (int)$board[$user]['win'];
	$_SESSION['loss'] = (int)$board[$user]['loss'];
	$_SESSION['board'] = $board;
}


if (isset($_SESSION['use'])) {
    header("Location:game.php");
}

?>

<html>

<head>

    <title> Login Page </title>

</head>

<body>

    <h1>Sign in!</h1>

    <form action="" method="post">

        <table width="200" border="0">
            <tr>
                <td> UserName</td>
                <td> <input type="text" name="user"> </td>
            </tr>
            <tr>
                <td> <input type="submit" name="login" value="LOGIN"></td>
                <td></td>
            </tr>
        </table>
    </form>

</body>

</html>