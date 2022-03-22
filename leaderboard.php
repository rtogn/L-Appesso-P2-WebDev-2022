<?php
session_start();
?>

<html>

<head>
    <title>Leaderboard</title>
    <link type="text/css" rel="stylesheet" href="leaderboard.css" />
</head>

<body>
    <table>
        <tr>
            <th>Rank</th>
            <th>Name</th>
            <th># of Wins</th>
        </tr>

        <tr>
            <td>1</td>
            <td><?php echo $_SESSION["use"]; ?></td>
            <td><?php echo $_SESSION["wincount"]; ?></td>
        </tr>






    </table>

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