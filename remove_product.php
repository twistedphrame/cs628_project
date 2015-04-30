<?php 

	session_start();
	if(isset($_COOKIE['uname']))
		$uname = $_COOKIE['uname'];
	else
		header('LOCATION: signin.php');

 	$productid = $_GET['productid']; 
 	include("includes/sql_queries.php");
 	include("dbc.php");
		$product = selectSingleProduct($dbc, $productid);
		$remove = "UPDATE product SET approved ='r' WHERE productid = '$productid'";
			$r= mysqli_query($dbc, $remove);
			if ($r)
				header('LOCATION: vendor_quantities.php?catname='.$product[PRODUCT_TABLE::$CATEGORY]);
			else 
				echo "something went wrong while trying to remove this product";
		
	
?>