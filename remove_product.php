<?php 

	session_start();
	if(isset($_COOKIE['uname']))
		$uname = $_COOKIE['uname'];
	else
		header('LOCATION: signin.php');

 	$productid = $_GET['productid']; 
 	
 	include("dbc.php");

		$remove = "UPDATE product SET approved ='r' WHERE productid = '$productid'";
			$r= mysqli_query($dbc, $remove);
			if ($r)
				header('LOCATION: vendor_products.php');
			else 
				echo "something went wrong while trying to remove this product";
		
	
?>