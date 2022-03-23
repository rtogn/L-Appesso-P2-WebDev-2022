

<?php
	//ini_set('display_errors', 1);
	//ini_set('display_startup_errors', 1);
	//error_reporting(E_ALL);
	
	
	function getLeaderboard($leaderboardFile) {
		// Returns array containing leaderboard of users from txt repository
		$file = fopen($leaderboardFile, 'r');
		$leaderBoard = array();
		while(!feof($file)) {
			$items = explode(",", fgets($file));
			if ($items[0] != 'usr' and count($items) == 4) {
				$leaderBoard[$items[0]] = array("win" => $items[1], "loss" => $items[2], "password" => $items[3], "name"=> $items[0]);
			}
		}
		fclose($file);
		return $leaderBoard;
	}
	
	function displayLeaderboard($leaderBoard) {
		// Displays table containing leader board scores etc.
		// List will be sorted by highest number of wins. 
		// Pass leaderboard array as argument. 
		
		//$leaderBoard = getLeaderboard($leaderboardFile);
		$scores = array_column($leaderBoard, "win");
		$rank = 1;
		echo "<table class=\"leaderboard\">
			<tr>
				<th>Rank</th>
				<th>Name</th>
				<th>Wins</th>
				<th>Losses</th>
			<tr>";
			
		array_multisort($scores, SORT_DESC, $leaderBoard);
		foreach ($leaderBoard as $user) {
			echo "
			<tr>
				<td>".$rank."</td>
				<td>".$user["name"]."</td>
				<td>".$user["win"]."</td>
				<td>".$user["loss"]."</td>
			<tr>
			";
			//echo "Rank: ".$rank." ".$user["name"]." Wins: ".$user["win"]." Losses: ".$user["loss"]."<br>";
			$rank++;
		}
		
		echo "</table>";	
	}
	
	function addUser($userName, $password, &$leaderboard) {
		// If user is not already on the board add, otherwise no action needed. 
		if (!isset($leaderboard[$userName])) {
			$leaderboard[$userName] = array("win" => 0, "loss" => 0, "password" => $password, "name"=> $userName);
		}
		//var_dump($leaderboard);
	}
	
	function saveUserScores($leaderboard, $leaderboardFile) {
		// Saves current session data to the text file repository.
		// Allows for scores to persist between sessions among users. 
		// Bug: A line break is some times added under items creating empty lines
		// This had to be accounted for when parsing. Rmoving /n causes it to place
		// Everything on one line.
		
		
		//var_dump($leaderboard);
		$info = "usr,win,loss,password";
		foreach ($leaderboard as $user) {
			$userInfo = "\n".$user['name'].",".$user['win'].",".$user['loss'].",".$user['password'];
			$info .= $userInfo;			
		}
		
		$file = fopen($leaderboardFile, 'w');
		fwrite($file, $info);
		fclose($file);
	}		
	
	function updateUserWin($userName, &$leaderboard) {
		// Incremets users win count.
		$value = (int)($leaderboard[$userName]['win']);
		$leaderboard[$userName]['win'] = (string)(++$value);

	}
	
	function updateUserLoss($userName, &$leaderboard) {
		// Incremets users win count. 
		$value = (int)($leaderboard[$userName]['loss']);
		$leaderboard[$userName]['loss'] = (string)(++$value);
	}

	//Global reference to text data repo for convenience. 
	$scoreFile = "usrs.txt";

	/*testing html
	
	<html>

	<head>

		<title> Usr save Page </title>
		<style>
			table, th, td {
				border:1px solid black;
			}
		</style>
	</head>

	<body>
		<h1>User save<h1>
		<?php
		
			addUser("Beep", "sheep", $board);
			updateUserWin("Beep", $board);
			updateUserWin("Beep", $board);
			displayLeaderboard($board);
			saveUserScores($board, $scoreFile);
			
			//
			
			//echo (string)(validateUser("Beep", $board));
			//saveUserScores($board, $ufile);

		?>

	</body>	
	</html>
	*/
?>


