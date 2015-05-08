<?php
	error_reporting(E_ALL);
	ini_set('display_errors', 'On');
	include 'storedInfo.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8" />
<title>Video Store</title>
<script src='javascript.js'></script>

</head>
<body>
<h1>Add a video</h1>
<section>		
	<form action="content1.php" method="get">
		<legend>Human, a video you wish to add</legend>
	    Video Name:  <input type="text" maxlength = 255 name="videoName" /> <br />
	    Category: <input type ="text" maxlength = 255 name = "category"  /> <br />
	    Length: <input type = "number" min = "0" step = "1" name = "length" /> <br />
    	<input type="submit" name = "Add Video"/>
	</form>
</section>

<section id = "resultsTable">


	<?php

		if (isset($_GET['videoName']) && $_GET['videoName'] == null)
		{
		print_r('Human, you must enter a video name. ');
		?>

		// <script language = "JavaScript">
		// 	alert('Human, you must enter a video name. ')
		 </script>
		 
			<br>
	    	<a href="Interface.php">go back</a>
			<br>
		<?php
		}

		if (isset($_GET['category']) && $_GET['category'] == null)
		{
			print_r('Human, you must enter a category.');
			?>
				<br>
		    	<a href="Interface.php">go back</a>
				<br>
			<?php
		}		
	?>

<?php
	//these prepared statements were copied from http://us2.php.net/manual/en/mysqli.quickstart.prepared-statements.php
	// Login to database
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

	echo "<br>";

	echo '<p> <table border="1">';


	echo '<tr> <td> ID <td> Title <td> Category <td> Length <td> Rental Status <td> Remove <td> Check in/out';
	while ($stmt->fetch()) {
		//changes the output of rented into english
		if ($out_rented == 1)
		{
			$out_rented = "Checked out";
		}
		else
		{
			$out_rented = "Available";
		}


	// prints out the results
	echo "<tr> <td>" . $out_id . "<td> " . $out_name . "<td>" . $out_category
		. "<td>" . $out_length . "<td>" . $out_rented
	//the delete button
		. " <td> <a href=content2.php?delete=" . $out_id . ">Delete</a>"
	//the checkin/checkout button
		. "<td> <a href=content3.php?check=" . $out_id . ">Check in/out</a>";
    //printf("id = %s (%s), label = %s (%s)\n", $out_id, gettype($out_id), $out_label, gettype($out_label));
}

	mysqli_close($mysqli);

?>



		
</section>

<section >

</section>

</body>
</html>
