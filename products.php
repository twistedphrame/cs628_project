<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>Online Shopping System</title>
<link rel="stylesheet" href="includes/style.css" type="text/css" media="screen" />
<meta http-equiv="content-type" content="text/html; charset=utf-8" />
</head>
<body>
	<div id = "container">
	<?php include("includes/header.html");?>
	
	<div id="content" align='center'>	
		<h1>Products Page</h1>		

		<?php 
			function menu ($arr, $name, $value) {  //creates the menu for selecting the subject that the classes are sorted by
				echo '<select name='.$name.'>';
				foreach ($arr as $ar) {
					echo '<option value = "'.$ar.'"';
					if ($ar==$value) echo 'selected="selected"';
						echo '>'.$ar.'</option>';
					}	
				echo '</select>';
			}
		?>		
			
		<?php
			$subject = "";
	
			if ($_SERVER['REQUEST_METHOD'] == 'POST') {  //when you click the display classes buttons it takes the subject selected from the menu and sets this as the subject that it will use to pull from the database
				if($_POST['button']=='Display'){
					$subject = $_POST['category'];
				}
			}
				
		?>

		<form action="" method="POST"> 
			<center><table style="padding: 10px 0px">
				<tr><td>
				<?php   // the actual pull down menu created with the classes in it
					$cat = array("Food", "Electronics", "Clothing", "Books", "Movies");
					menu($cat, 'category', $_POST['category']);
				?>
				</td><td>
					<input type="submit" name="button" value="Display">  <!-- the display button that when clicked pulls items from the database based on the subject that was selected-->
				</td>
			</table></center>
		</form>

		<center><table>  <!-- creates the table headers for the class records that will be displayed-->
		<tr>
			<th> Product </th>
			<th> Category </th>
			<th> Vendor </th>
			<th> Description </th>
			<th> Price </th>
		</tr>

		<?php 
			include("dbc.php");
			$q = "SELECT * FROM classes WHERE subject = '$subject'";  //creates a query that pulls all the information for classes that match the subject that was selected from the drop down menu
			$r = mysqli_query($dbc, $q);
			
			while ($row = mysqli_fetch_array($r)){  //a loop that keeps pulling records with the same subject that was selected until there are no more records
				echo "<tr>";
					echo "<td>".$row['productname']."</td>";
					echo "<td>".$row['category']."</td>";
					echo "<td>".$row['vendorid']."</td>";
					echo "<td>".$row['description']."</td>";
					echo "<td>".$row['price']."</td>";
					echo "<td>".$row['room']."</td>";
					$cat = array("Food", "Electronics", "Clothing", "Books", "Movies");
					menu($cat, 'category', $_POST['category']);
					echo "<td>add to cart</td>"; //opens a the classreg page and passes it the class id from the class that register" was selected for
					
				echo "</tr>";
			}
		?>					
		</table><center> 
	
	</div> <!--content -->

	<div id="footer">
		<p>Copyright@ Swethana Gopisetti, Monmouth University</p> <!-- this page was based on code from Swethana's edit classes page we were given in class-->
		<p>Modified by Andrew Spaeth for CS628 HW</p>
	</div>
	</div> <!--container -->
</body>
</html>