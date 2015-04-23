<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>Online Shopping System</title>
<link rel="stylesheet" href="includes/style.css" type="text/css" media="screen" />
<meta http-equiv="content-type" content="text/html; charset=utf-8" />
</head>
<body>
	<div id = "container">

	
	<div id="content" align='center'>	

		<?php 
			session_start();
			if(isset($_COOKIE['username'])){
				$username = $_COOKIE['username'];
				$fname = $_COOKIE['fname'];
				$role = $_COOKIE['role'];
			}
			else{
				header('LOCATION: signin.php');
			}
			
			
			if($role == "Customer"){
				include("includes/header_cust.html");
				header('LOCATION: index.php');
			}
			if($role == "Admin"){
				include("includes/header_admin.html");
			}
			if($role == "Vendor"){
				include("includes/header_vendor.html");
				header('LOCATION: index.php');
			}
		?>
		<?php 
			if($_SERVER['REQUEST_METHOD'] == 'POST'){
			
				$name = $_POST['name']; //form data username,

				

				$error = array(); //define an array
			
				if(empty($name)) $error[]= "You forgot to enter a category name.";

				if(empty($error)){
				
					//1. connect to database
					include("dbc.php");
					$q = "SELECT * from categories WHERE catname = '$name'"; //pulls records from the registration table to try to make sure the user isn't already registered for this class
					$r = mysqli_query($dbc, $q);
					
					$num = mysqli_num_rows($r);
					
					if ($num >= 1){ //if the user already has a registration record for this class, it pushes you back to the previous page and doesn't enter another duplicate record
						echo "This category has already been added";
					}
					else{
					$q = "INSERT INTO categories (catname) VALUES 
											('$name')";
					//3. execute the query
					$r = mysqli_query($dbc, $q);
					//4. Sanity check 
					if($r) echo "Record is inserted into database.";
					else echo "Something is wrong.";
					}
				}
				
				else{
					foreach($error as $err){
						echo $err;
						echo"<br>";
					}
				}
			}
			
			
		?>

		<form action="" method="POST">
			<table>
				<tr>
					<td>Category Name:</td>
					<td><input type="text" name="name"
					value = <?php if(isset($_POST['name'])) echo $_POST['name'] ?> ></td>
					<td><input type="submit" value="Add Category"> </td>
				</tr>

			</table>
		</form>

		</br>
		<input type="button" onClick="parent.location='index.php'" value="Back">
	
</div>

	
	<div id="footer">
		<p style="text-align:center; color:white; font-size:12px;"> Copyright Monmouth University 2015</p>
	</div>
</div>


</body>



</html>