<html xmlns = "http://www.w3.org/1999/xhtml">
<head>
	<title>Online Shopping System</title>
	<link rel = "stylesheet" href = "includes/style.css" type = "text/css" media = "screen" />
	<meta http-equiv = "content-type" content = "text/html; charset = utf-8" />
</head>

<body>
<div id="container">

	
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
			include("includes/sql_queries.php");
			include("includes/header.php");
			
				
				include("dbc.php");

	
					
	

			
			
			if ($_SERVER['REQUEST_METHOD'] == 'POST'){
				$productname = $_POST['productname'];

			}
				
		?>
		<div>
		<form action="" method="POST">
				<table>
				<tr>
					<td>Product Name:</td>
					<td><input type="text" name="productname"></td>	
				</tr>
			</table>
			<div style="padding: 0px 450px" >
				<input type="submit" name="button" value="Search" >
			</div>
		</form>
		</div>
		
		<center><table>
		<tr>
			<th> Category </th>
			<th> Product Name </th>
			<th> Vendor</th>
			<th> Description </th>
			<th> Price </th>
			<th> Product Number </th>
			<th> Features </th>
			<th> Image</th>
			<th> Constraints </th>
			<th> Quantity </th>
		</tr>

		<?php 
				$q = "SELECT * from product WHERE productname = '$productname'";

				$r = mysqli_query($dbc, $q);
					
				while ($row = mysqli_fetch_array($r)){  //a loop that keeps pulling records with the same subject that was selected until there are no more records
				echo "<tr>";
					echo "<td>".$row['category']."</td>";
					echo "<td>".$row['productname']."</td>";
					echo "<td>".$row['vendorid']."</td>";
					echo "<td>".$row['description']."</td>";
					echo "<td>".$row['price']."</td>";
					echo "<td>".$row['productnumber']."</td>";
					echo "<td>".$row['features']."</td>";
					echo '<td><img src="images/'.$row['image'].'" height="60" width="100"/></a></td>';
					echo "<td>".$row['constraints']."</td>";
					echo "<td>".$row['quantity']."</td>";
					
				echo "</tr>";
			}
		?>					
		</table><center> 

	
	
	
	</div>
	
	<div id = "footer">
		<p>Copyright 2015 Monmouth University</p>
	</div>
	
	</div>
</body>
</html>