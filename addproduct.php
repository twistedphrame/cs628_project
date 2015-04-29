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
		?>
		<?php 
			if($_SERVER['REQUEST_METHOD'] == 'POST'){
			
				$category = $_POST['category']; //form data username,
				$name = $_POST['name'];
				$vendorid = $username;
				$approved = "p";
				$description = $_POST['description'];
				$price = $_POST['price'];
				$productnum = $_POST['productnum'];
				$features = $_POST['features'];
        $image ='';
        if(isset($_FILES["image"]) && !empty($_FILES["image"]["tmp_name"])) {
          $image = basename($_FILES["image"]["name"]);
        }
				$constraints = $_POST['constraints'];
				$discount = $_POST['discount'];
				$quantity = $_POST['quantity'];
				

				$error = array(); //define an array
			
				if(empty($category)) $error[]= "You forgot to enter a category.";
				if(empty($name) || is_numeric($name) == true || $name != 0) $error[]= "You forgot to enter a product name.";
				if(empty($description) || is_numeric($description) == true || $description != 0) $error[]= "You forgot to enter a product description.";
				if(empty($price) || $price == "0" || $price < 0 || is_numeric($price)== false ) $error[]= "You forgot to enter a product price.";
				if(empty($productnum) || $productnum <=1 ) $error[]= "You forgot to enter a product number.";
				if(empty($features) || is_numeric($features) == true || $features != 0) $error[]= "You forgot to enter product features.";
				if(empty($image)) $error[]= "You forgot to enter a product image.";
				if(empty($constraints)|| is_numeric($constraints) == true || $constraints != 0) $error[]= "You forgot to enter product constraints.";
				if(empty($discount) || $discount <= 0) $error[]= "You forgot to enter a product discount.";
				if(empty($quantity) || $quantity == 0 || $quantity <=1) $error[]= "You forgot to enter a product quantity.";
				
			
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
					if($r) {
            echo "Record is inserted into database.";
            
            $target_dir = "images/";
            $target_file = $target_dir . basename($_FILES["image"]["name"]);
            $uploadOk = 1;
            $imageFileType = pathinfo($target_file,PATHINFO_EXTENSION);

            // Check if image file is a actual image or fake image
            $check = getimagesize($_FILES["image"]["tmp_name"]);
            if($check !== false) {
              if(move_uploaded_file($_FILES['image']['tmp_name'], $target_file)) {
                echo " File uploaded";
              }
            } else {
                echo "File is not an image.";
            }
          }
					else {
            echo "Something is wrong.";
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
		</div>
		<form action="addproduct.php" method="post" enctype="multipart/form-data">
			<table>
				<tr>
					<td>Category:</td>
					<td>
					
						<?php 
							require_once("dbc.php");
              if(isset($_POST['category'])) {
                categoryDropDown($dbc, "category", $_POST['category']);
              } else {
              categoryDropDown($dbc, "category", NULL);
              }
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
					<td>
						<input type="file" name="image" id="image">
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