
	<?php

	session_start();
	if(isset($_COOKIE['uname'])) //if the username is not set in a cookie it pushes the user back to the log in page
		$uname = $_COOKIE['uname'];
	else
		header('LOCATION: products.php');

 	$categoryid = $_GET['categoryid'];//grabs the class id and sets in a variable.  The class id was pushed from the previous page
 	
 	include("dbc.php");
	
	$delete = "DELETE FROM categories WHERE categoryid= '$categoryid'"; //deletes the record from the registration table where the 
	$r= mysqli_query($dbc, $delete);
	if ($r)
		header('LOCATION: removecategory.php');
	else 
		echo "something went wrong while trying to delete this category";
		
	

	?>