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
		
		<center><table> <!-- creates the table headers for the class records that will be displayed-->
		<tr>
			<th> Category </th>
		</tr>

		<?php 
			include("dbc.php");
			$q = "SELECT * FROM categories"; //selects all the records from the registration table that corresponds to the username that is signed in
			$r = mysqli_query($dbc, $q);
			while ($row = mysqli_fetch_array($r)){ //loops through all the classes that the user is registered for
					echo "<tr>";
						echo "<td>".$row['catname']."</td>";
						echo "<td><a href='catdelete.php?categoryid=".$row['categoryid']."'>Delete Category</td>"; //creates a link that opens the classdereg page and pushes it the classid for the class the user wants to deregister from
						
					echo "</tr>";
				}
			
		?>					
		</table><center> 
	
	</div> <!--content -->

	
	<div id="footer">
		<p style="text-align:center; color:white; font-size:12px;"> Copyright Monmouth University 2015</p>
	</div>
</div>


</body>



</html>