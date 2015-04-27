<html xmlns = "http://www.w3.org/1999/xhtml">
<head>
	<title>Online Shopping System</title>
	<link rel = "stylesheet" href = "includes/style.css" type = "text/css" media = "screen" />
	<meta http-equiv = "content-type" content = "text/html; charset = utf-8" />
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
			}
			if($role == "Admin"){
				include("includes/header_admin.html");
			}
			if($role == "Vendor"){
				include("includes/header_vendor.html");
			}
			
			function menu($arr,$name,$value){
				echo '<select name='.name.'>';
				
				foreach($arr as $ar){
					echo '<option value = "'.$ar.'"';
					if($ar ==$value) echo 'selected="selected"';
						echo '>'.$ar.'</option>';
						
				}
				echo '</select>';
				}
				
				include("dbc.php");

				$productid = $_GET[PRODUCT_TABLE::$PROD_ID];//grabs the class id and sets in a variable.  The class id was pushed from the previous page
	
					
	

			
			
			if ($_SERVER['REQUEST_METHOD'] == 'POST'){
				$category = $_POST['category'];
				$productname = $_POST['productname'];
				$description = $_POST['description'];
				$price = $_POST['price'];
				$productnumber = $_POST['productnumber'];
				$features = $_POST['features'];
				$image = $_POST['image'];
				$constraints = $_POST['constraints'];
				$discount = $_POST['discount'];
				$quantity = $_POST['quantity'];
				$q = "UPDATE users SET category='$category', productname='$productname', description='$description', price='$price', productnumber='$productnumber', features='$features', image='$image', constraints='$constraints',
					discount='$discount',quantity='$quantity', WHERE username = '$username'";
					
				$r = mysqli_query($dbc, $q);
					
					if($r){
						echo "The information has been updated.";
					}
					else{
						echo"There was an error updating the information";
					}
				
				
			}
			else {
				$q = "SELECT * FROM users WHERE username = '$username'";
					
				$r = mysqli_query($dbc, $q);
					
				$num = mysqli_num_rows($r);
				
				if ($num == 1){
						$row = mysqli_fetch_array($r);
						$fname = $row['fname'];
						$lname = $row['lname'];
						$address = $row['address'];
						$city = $row['city'];
						$state = $row['state'];
						$zipcode = $row['zipcode'];
						$email = $row['email'];
						$phone = $row['phone'];
						
				}
				else{
					echo "There was an error loading user information";
				}
			}
				
		?>
		<div>
		<form action="" method="POST">
						<table>
				<tr>
					<td>Category:</td>
					<td>
					
						<?php 
							$catarray = array();
							include("dbc.php");
							$q = "SELECT * FROM categories"; //creates a query that pulls all the information for classes that match the subject that was selected from the drop down menu
							$r = mysqli_query($dbc, $q);
							while ($row = mysqli_fetch_array($r)){
								array_push($catarray,"$row[catname]");
							}
							echo '<select name ="category">'; //echo'd so the web browser can pick it up
								foreach($catarray as $cat){
									echo '<option value = "'.$cat.'"';
									if (isset($_POST['category'])) {
										if ($cat == $_POST['category'])  echo 'selected ="selected"';
									}
									echo '>'.$cat.'</option>';
								}
							echo '</select>';
					
							
						?>
					</td> 
				</tr>
				<tr>
					<td>Product Name:</td>
					<td><input type="text" name="name"
					value = <?php if(isset($_POST['name'])) echo $_POST['name'] ?> ></td>
				</tr>
				<tr>
					<td>Description:</td>
					<td><input type="text" name="description"
					value = <?php if(isset($_POST['description'])) echo $_POST['description'] ?> ></td>
				</tr>
				<tr>
					<td>Price:</td>
					<td><input type="text" name="price"
					value = <?php if(isset($_POST['price'])) echo $_POST['price'] ?> ></td>
				</tr>
				<tr>
					<td>Product Number:</td>
					<td><input type="text" name="productnum"
					value = <?php if(isset($_POST['productnum'])) echo $_POST['productnum'] ?> ></td>
				</tr>
				<tr>
					<td>Product Features:</td>
					<td><input type="text" name="features"
					value = <?php if(isset($_POST['features'])) echo $_POST['features'] ?> ></td>
				</tr>
				<tr>
					<td>Product Image:</td>
					<td><img src="images/<?php echo $row[PRODUCT_TABLE::$IMAGE];?>" height="133" width="200"/></td>
				</tr>
				<tr>
					<td>Product Constraints:</td>
					<td><input type="text" name="constraints"
					value = <?php if(isset($_POST['constraints'])) echo $_POST['constraints'] ?> ></td>
				</tr>
				<tr>
					<td>Product Discount:</td>
					<td><input type="text" name="discount"
					value = <?php if(isset($_POST['discount'])) echo $_POST['discount'] ?> ></td>
				</tr>
				<tr>
					<td>Product Quantity:</td>
					<td><input type="text" name="quantity"
					value = <?php if(isset($_POST['quantity'])) echo $_POST['quantity'] ?> ></td>
				</tr>
				
			</table>
			<div style="padding: 0px 450px" >
				<input type="submit" name="button" value="Update" >
			</div>
		</form>
		</div>
	
	</div>
	
	<div id = "footer">
		<p>Copyright 2015 Monmouth University</p>
	</div>
	
	</div>
</body>
</html>