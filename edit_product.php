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

			
			if ($_SERVER['REQUEST_METHOD'] == 'POST'){
				$productid = $_POST['productid'];
				$category = $_POST['category'];
				$productname = $_POST['productname'];
				$description = $_POST['description'];
				$price = $_POST['price'];
				$productnumber = $_POST['productnumber'];
				$features = $_POST['features'];
				$image ='';
        if(isset($_FILES["image"]) && !empty($_FILES["image"]["tmp_name"])) {
          $image = basename($_FILES["image"]["name"]);
        }
				$constraints = $_POST['constraints'];
				$discount = $_POST['discount'];
				$quantity = $_POST['quantity'];
				include("product.php");
				$prod = new Product();
				$r = $prod->setProductID($productid)
				     ->setCategory($category)
				     ->setName($productname)
						 ->setDescription($description)
						 ->setPrice($price)
						 ->setSerialNum($productnumber)
						 ->setFeatures($features)
						 ->setImages($image)
						 ->setConstraints($constraints)
						 ->setDiscount($discount)
						 ->setQuantity($quantity)
						 ->update($dbc);
				if($r){
					echo "The information has been updated.";
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
				else{
					echo"There was an error updating the information";
				}
			}
			elseif ($_SERVER['REQUEST_METHOD'] == 'GET'){
			  $productid = $_GET[PRODUCT_TABLE::$PROD_ID];//grabs the class id and sets in a variable.  The class id was pushed from the previous page

				$q = "SELECT * FROM product WHERE productid = '$productid'";
					
				$r = mysqli_query($dbc, $q);
					
				$row = mysqli_fetch_array($r);
						
				$category = $row['category'];
				$productname = $row['productname'];
				$description = $row['description'];
				$price = $row['price'];
				$productnumber = $row['productnumber'];
				$features = $row['features'];
				$image = $row['image'];
				$constraints = $row['constraints'];
				$discount = $row['discount'];
				$quantity = $row['quantity'];
						
			} else {
				header('LOCATION: products.php');
			}
				
		?>
		<div>
		<form action="edit_product.php" method="post" enctype="multipart/form-data">
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
					<td><input type="text" name="productname" value="<?php echo $productname ?>"></td>	
				</tr>
				<tr>
					<td>Description:</td>
					<td><input type="text" name="description" value="<?php echo $description ?>"></td>	
				</tr>
				<tr>
					<td>Price:</td>
					<td><input type="text" name="price" value="<?php echo $price ?>"></td>	
				</tr>
				<tr>
					<td>Product Number:</td>
					<td><input type="text" name="productnumber" value="<?php echo $productnumber ?>"></td>	
				</tr>
				<tr>
					<td>Product Features:</td>
					<td><input type="text" name="features" value="<?php echo $features ?>"></td>	
				</tr>
				<tr>
					<td>Product Image:</td>
					<td><input type="file" name="image" id="image"></td>
				  </tr>
				<tr>
					<td>Product Constraints:</td>
					<td><input type="text" name="constraints" value="<?php echo $constraints ?>"></td>	
				</tr>
				<tr>
					<td>Product Discount:</td>
					<td><input type="text" name="discount" value="<?php echo $discount ?>"></td>	</td>
				</tr>
				<tr>
					<td>Product Quantity:</td>
					<td><input type="text" name="quantity" value="<?php echo $quantity ?>"></td>	
				</tr>
				<tr>
					<td><input type="hidden" name="productid" value="<?php echo $productid ?>"></td>
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