<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8" />
<title>Interface.php</title>
</head>
<body>
<h1>Add a video</h1>
<section>		
	<form action="content1.php" method="post">
		<legend>Human, enter your slave name</legend>
	    Video Name:  <input type="text" maxlength = 255 name="videoName" /> <br />
	    Category: <input type ="text" maxlength = 255 name = "category"  /> <br />
	    Length: <input type = "number" min = "0" step = "1" name = "length" /> <br />
    	<input type="submit" name = "Add Video"/>
	</form>
</section>

<h1>View videos </h1>


<?php

?>

</body>
</html>
