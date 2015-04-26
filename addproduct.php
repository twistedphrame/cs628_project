<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>Online Shopping System</title>
<link rel="stylesheet" href="includes/style.css" type="text/css" media="screen" />
<meta http-equiv="content-type" content="text/html; charset=utf-8" />
</head>
<body>


<div id="container">
	<div id="header">
	<h1 style ="padding:20px 100px">Add a Product</h1>
	</div>
	
		<div id="content" align='center'>	
		<h1>Class Registration</h1>		
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
			include("sql_queries.php");
      include("includes/header.php");
		?>
		<?php 
			if($_SERVER['REQUEST_METHOD'] == 'POST'){
			
				$category = $_POST['category']; //form data username,
				$name = $_POST['name'];
				$vendorid = $username;
				$approved = 0;
				$description = $_POST['description'];
				$price = $_POST['price'];
				$productnum = $_POST['productnum'];
				$features = $_POST['features'];
				$image = $_POST['image'];
				$constraints = $_POST['constraints'];
				$discount = $_POST['discount'];
				$quantity = $_POST['quantity'];
				


				$error = array(); //define an array
			
				if(empty($category)) $error[]= "You forgot to enter a category.";
				if(empty($name)) $error[]= "You forgot to enter a product name.";
				if(empty($description)) $error[]= "You forgot to enter a product description.";
				if(empty($price)) $error[]= "You forgot to enter a product price.";
				if(empty($productnum)) $error[]= "You forgot to enter a product number.";
				if(empty($features)) $error[]= "You forgot to enter product features.";
				if(empty($image)) $error[]= "You forgot to enter a product image.";
				if(empty($constraints)) $error[]= "You forgot to enter product constraints.";
				if(empty($discount)) $error[]= "You forgot to enter a product discount.";
				if(empty($quantity)) $error[]= "You forgot to enter a product quantity.";
				
			
				if(empty($error)){
				
					//1. connect to database
					include("dbc.php");
					//2. define a query(insert a record to users table)
					$q = "INSERT INTO product (category,
											productname,
											vendorid,
											description,
											price,
											productnumber,
											features,
											image,
											constraints,
											discount,
											approved,
											quantity) VALUES 
											('$category',
											'$name',
											'$vendorid',
											'$description',
											'$price',
											'$productnum',
											'$features',
											'$image',
											'$constraints',
											'$discount',
											'$approved',
											'$quantity')";
					//3. execute the query
					$r = mysqli_query($dbc, $q);
					//4. Sanity check 
					if($r) echo "Record is inserted into database.";
					else echo "Something is wrong.";
				echo $category;
				echo "</br>";
				echo $name;
				echo "</br>";
				echo $vendorid;
				echo "</br>";
				echo $approved;
				echo "</br>";
				echo $description;
				echo "</br>";
				echo $price;
				echo "</br>";
				echo $productnum;
				echo "</br>";
				echo $features;
				echo "</br>";
				echo $image;
				echo "</br>";
				echo $constraints;
				echo "</br>";
				echo $discount;
				echo "</br>";
				echo $quantity;
				echo "</br>";
				}
				
				else{
					foreach($error as $err){
						echo $err;
						echo"<br>";
					}
				}
			}
			
			
		?>
		</div>
		<form action="" method="POST">
			<table>
				<tr>
					<td>Category:</td>
					<td>
					
						<?php 
							include("dbc.php");
              categoryDropDown($dbc, "category", $_POST['category']);
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
					<td><input type="text" name="image"
					value = <?php if(isset($_POST['image'])) echo $_POST['image'] ?> ></td>
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
			<div style="padding:0px 410px">
				<input type="submit" value="Add Class">  <!-- the input type submit means its a button, the value is what you see on the button-->
			</div>
		</form>
		<input type="button" onClick="parent.location='products.php'" value="Back">
	</div>

	
	<div id="footer">
		<p style="text-align:center; color:white; font-size:12px;"> Copyright Monmouth University 2015</p>
	</div>
</div>

</body>



</html>