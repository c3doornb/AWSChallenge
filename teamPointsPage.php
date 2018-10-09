<link rel="stylesheet" href="styles.css">

<?php include "../inc/dbinfo.inc"; ?>
<html>
<body>
<h1>Team Points</h1>
<?php

  /* Connect to MySQL and select the database. */
  $connection = mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD);

  if (mysqli_connect_errno()) echo "Failed to connect to MySQL: " . mysqli_connect_error();

  $database = mysqli_select_db($connection, DB_DATABASE);
  $sqlTeams = "SELECT * FROM teams";
  $sqlPoints = "SELECT * FROM points";
  if($teamsResult = mysqli_query($connection, $sqlTeams)){
    if(mysqli_num_rows($teamsResult) > 0){
     echo "<table>";
            echo "<tr>";
                echo "<th>Team</th>";
                echo "<th>Points</th>";
            echo "</tr>";
        while($tRow = mysqli_fetch_array($teamsResult)){
            echo "<tr>";
              echo "<td>" . $tRow['name'] . "</td>";
		  $pointsResult = mysqli_query($connection, $sqlPoints);
		  $points = 0;
              while($pRow = mysqli_fetch_array($pointsResult)){
            		$sqlUser = "SELECT * FROM users WHERE id = " . $pRow['user_id'];
			$teamIDResult = mysqli_query($connection, $sqlUser);
			$teamIDRow = mysqli_fetch_array($teamIDResult);
			$teamID = $teamIDRow['team_id'];
			if($teamID == $tRow['id']) {
			  $points += $pRow['points'];
			}
              }
		  echo "<td>" . $points . "</td>";
		echo '</tr>';
	  }
      echo "</table>";
      // Free result set
      mysqli_free_result($teamsResult);
      mysqli_free_result($pointsResult);
    } else{
        echo "No records matching your query were found.";
    }
  } else{
    echo "ERROR: Could not able to execute $sql. " . mysqli_error($link);
  }
?>