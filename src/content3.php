

<?php
	error_reporting(E_ALL);
	ini_set('display_errors', 'On');
	include 'storedInfo.php';

	$mysqli = new mysqli("oniddb.cws.oregonstate.edu", "dinhd-db", $myPassword, "dinhd-db");
	if ($mysqli->connect_errno) {
	    echo "Failed to connect to MySQL: (" . $mysqli->connect_errno . ") " . $mysqli->connect_error;
	}
	else
	{
		echo "Successfully connected to database <br>";
	}


	if (!($stmt = $mysqli->prepare("SELECT id, name, category, length, rented FROM videoStore"))) {
	    echo "Prepare failed: (" . $mysqli->errno . ") " . $mysqli->error;
	}
	else
	{
		echo "Assigned mysqli object to stmt object <br>";
	}



	$mysqli2 = new mysqli("oniddb.cws.oregonstate.edu", "dinhd-db", $myPassword, "dinhd-db");
	if ($mysqli->connect_errno) {
	    echo "Failed to connect to MySQL: (" . $mysqli->connect_errno . ") " . $mysqli->connect_error;
	}
	else
	{
		echo "Successfully connected to database <br>";
	}



	if (!$stmt->execute()) {
	    echo "Execute failed: (" . $mysqli->errno . ") " . $mysqli->error;
	}

	
	$out_id    = NULL;
	$out_name = NULL;
	$out_category = NULL;
	$out_length = NULL;
	$out_rented = NULL;


	if (!$stmt->bind_result($out_id, $out_name, $out_category, $out_length, $out_rented)) {
	    echo "Binding output parameters failed: (" . $stmt->errno . ") " . $stmt->error;
	}



	while ($stmt->fetch())
	{
		if ($out_id == $_GET['check'])
		{
			// reverse the status
			if ($out_rented == 0)
			{
				$out_rented = 1;
			}
			else
			{
				$out_rented = 0;
			}

			echo "Found record to be checked out or or in";
			$objectQuery = "UPDATE videoStore SET rented=" . $out_rented . " WHERE id=" . $_GET['check'];
			if (mysqli_query($mysqli2, $objectQuery)) 
			{
			    echo "Record updated successfully";
			} 
			else 
			{
			    echo "Error updating record: " . mysqli_error($mysqli2);
			}	
		}
	}

	// $queryObject = NULL;
	// if (mysqli_query($mysqli, "DELETE FROM videoStore WHERE id=". $_GET['delete']) === TRUE) {
 //    echo "Record deleted successfully";
	// } else {
 //    echo "Error deleting record: " . $mysqli->error;
	// }

	// if (isset($_GET['check']) && $_GET['check'] != null)
	// {
	// 	echo "Toggling status of" . $_GET['delete'] . "<br>";
	// 	$queryObject = "UPDATE videoStore SET ";

	// }

 ?>
 <br>
 <a href="content1.php"> Go back to main page </a>