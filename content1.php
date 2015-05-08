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
		<legend>Human, enter a video you wish to add: </legend>
	    Video Name:  <input type="text" maxlength = 255 name="videoName" /> <br />
	    Category: <input type ="text" maxlength = 255 name = "category"  /> <br />
	    Length: <input type = "number" min = "0" step = "1" name = "length" /> <br />
    	<input type="submit" name = "Add Video"/>
	</form>
</section>

<section id = "resultsTable">


	<?php

		//Checks to make sure that that all values have been entered
		if (isset($_GET['videoName']) && $_GET['videoName'] == NULL 
			&& isset($_GET['category']) && $_GET['category'] == null 
			&& isset($_GET['length']) && $_GET['length'] == null)

		{
			?>

			<script language = "JavaScript">
			// 	alert('Human, you must enter a video name. ')
			</script>

				<br>
		    	<a href="Interface.php">go back</a>
				<br>
			<?php
		}	

		//If there were values entered then the values will be added to the database.
		else if (isset($_GET['videoName']) && $_GET['videoName'] != NULL 
		&& isset($_GET['category']) && $_GET['category'] != null 
		&& isset($_GET['length']) && $_GET['length'] != null)
		{
			$mysqli2 = new mysqli("oniddb.cws.oregonstate.edu", "dinhd-db", $myPassword, "dinhd-db");
			if ($mysqli2->connect_errno) {
			    echo "Failed to connect to MySQL: (" . $mysqli->connect_errno . ") " . $mysqli->connect_error;
			}
			else
			{
				echo "Successfully connected to database <br>";
			}

			if (!($stmt2 = $mysqli2->prepare("INSERT INTO videoStore(name, category, length) VALUES (?,?,?)"))) 
				//500,"  $_GET['videoName'] "," $_GET['category'] ", " $_GET['length'] "," 0 ")"))) 
			{
			    echo "Prepare failed: (" . $mysqli2->errno . ") " . $mysqli2->error;
			}
			$nameInsert = $_GET['videoName'];
			$categoryInsert = $_GET['category'];
			$lengthInsert = $_GET['length'];
		
	

			$checkOutStatus = 22;

			if (!$stmt2->bind_param("ssi", $nameInsert, $categoryInsert, $lengthInsert)) {
			    echo "Binding parameters failed: (" . $stmt2->errno . ") " . $stmt2->error;
			}

			if (!$stmt2->execute()) {
			    echo "Execute failed: (" . $stmt2->errno . ") " . $stmt2->error;
			}
		}
	


	//these prepared statements were copied from http://us2.php.net/manual/en/mysqli.quickstart.prepared-statements.php
	// Login to database
	$mysqli = new mysqli("oniddb.cws.oregonstate.edu", "dinhd-db", $myPassword, "dinhd-db");
	if ($mysqli->connect_errno) {
	    echo "Failed to connect to MySQL: (" . $mysqli->connect_errno . ") " . $mysqli->connect_error;
	}
	else
	{
		//echo "Successfully connected to database <br>";
	}


	if (!($stmt = $mysqli->prepare("SELECT id, name, category, length, rented FROM videoStore"))) {
	    echo "Prepare failed: (" . $mysqli->errno . ") " . $mysqli->error;
	}
	else
	{
		//echo "Assigned mysqli object to stmt object <br>";
	}


	if (!$stmt->execute()) {
	    echo "Execute failed: (" . $mysqli->errno . ") " . $mysqli->error;
	}

	
	$out_id    = NULL;
	$out_name = NULL;
	$out_category = NULL;
	$out_length = NULL;
	$out_rented = NULL;

	$numberOfCategories = NULL;
	$categories[] = NULL;

	if (!$stmt->bind_result($out_id, $out_name, $out_category, $out_length, $out_rented)) {
	    echo "Binding output parameters failed: (" . $stmt->errno . ") " . $stmt->error;
	}

	// only adds categories to list if they are unique
	while ($stmt->fetch()) {

		if (in_array ($out_category, $categories))
		{
			
		}
		else
		{
			$categories[] = $out_category;	
		}




}
	// This section asks the user to select a category to display
	echo "<h1> Filter by category </h1>";
	echo "<form action='content1.php' method='get'>";
	echo "<select name = 'filterCategory'>";
		foreach($categories as $categoryName)
		{
			echo "<option value =" . $categoryName . ">" . $categoryName . "</option>";
		}
	echo " <option value='All Categories'>All Categories</option>";
	echo "</select>";
	echo "<INPUT TYPE ='submit' name='submit' />";
	echo "</form>";

	$mysqli = new mysqli("oniddb.cws.oregonstate.edu", "dinhd-db", $myPassword, "dinhd-db");
	if ($mysqli->connect_errno) {
	    echo "Failed to connect to MySQL: (" . $mysqli->connect_errno . ") " . $mysqli->connect_error;
	}
	else
	{
		//echo "Successfully connected to database <br>";
	}


	if (!($stmt = $mysqli->prepare("SELECT id, name, category, length, rented FROM videoStore"))) {
	    echo "Prepare failed: (" . $mysqli->errno . ") " . $mysqli->error;
	}
	else
	{
		//echo "Assigned mysqli object to stmt object <br>";
	}


	if (!$stmt->execute()) {
	    echo "Execute failed: (" . $mysqli->errno . ") " . $mysqli->error;
	}


	if (!$stmt->bind_result($out_id, $out_name, $out_category, $out_length, $out_rented)) {
	    echo "Binding output parameters failed: (" . $stmt->errno . ") " . $stmt->error;
	}

	if (isset($_GET['filterCategory']))
	{
		$filterCategory = $_GET['filterCategory'];
	}
	else
	{
		$filterCategory = "All Categories";
	}

	//$filterCategory = $_GET['filterCategory'];

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

		if ($out_category == $filterCategory)
		{
			// prints out the results
			echo "<tr> <td>" . $out_id . "<td> " . $out_name . "<td>" . $out_category
			. "<td>" . $out_length . "<td>" . $out_rented
			//the delete button
			. " <td> <a href=content2.php?delete=" . $out_id . ">Delete</a>"
			//the checkin/checkout button
			. "<td> <a href=content3.php?check=" . $out_id . ">Check in/out</a>" ;
	    	//printf("id = %s (%s), label = %s (%s)\n", $out_id, gettype($out_id), $out_label, gettype($out_label));
		}
		else if ( $filterCategory == "All Categories")
		{
			// prints out the results
			echo "<tr> <td>" . $out_id . "<td> " . $out_name . "<td>" . $out_category
			. "<td>" . $out_length . "<td>" . $out_rented
			//the delete button
			. " <td> <a href=content2.php?delete=" . $out_id . ">Delete</a>"
			//the checkin/checkout button
			. "<td> <a href=content3.php?check=" . $out_id . ">Check in/out</a>" ;
	    	//printf("id = %s (%s), label = %s (%s)\n", $out_id, gettype($out_id), $out_label, gettype($out_label))
		}
	}	

	echo "</table> <p>";


	mysqli_close($mysqli);

?>



		
</section>

<section >

</section>

</body>
</html>
