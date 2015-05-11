<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8" />

<title>Video Store</title>
</head>
<body>
<h1></h1>
<section>

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

	$queryObject = NULL;

	//delete sequence copied from http://www.w3schools.com/php/php_mysql_delete.asp
	//If the $_get command tells the user to delete a file, then the file will be deleted
	if (isset($_GET['delete']) && $_GET['delete'] != null)
	{
		echo "deleting ID: " . $_GET['delete'] . "<br>";
		$queryObject = "DELETE FROM videoStore WHERE id=1";

		if (mysqli_query($mysqli, "DELETE FROM videoStore WHERE id=". $_GET['delete']) === TRUE) {
	    echo "Record deleted successfully";
		} else {
	    echo "Error deleting record: " . $mysqli->error;
		}

	}

	if (isset($_GET['deleteAll']) && $_GET['deleteAll'] != null)
	{
		echo "Deleting all records <br>";
		$queryObject = "DELETE FROM videoStore";

	

		if (mysqli_query($mysqli, "DELETE FROM videoStore") === TRUE) {
	    echo "All records deleted";
		} else {
	    echo "Error deleting all records: " . $mysqli->error;
		}
	}





	mysqli_close($mysqli);
?>
	<a href="content1.php"> Go back to main page </a>
</section>

</body>
</html>