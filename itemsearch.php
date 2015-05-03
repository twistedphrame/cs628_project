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
			include("includes/sql_queries.php");
			include("includes/header.php");
		?>
		<div>
		<form action="" method="POST">
				<table>
				<tr>
					<td>Product Name:</td>
					<td><input type="text" name="productname" value="<?php if(isset($_POST['productname'])) echo $_POST['productname']; ?>"></td>	
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
			<th> Product</th>
			<th> Description </th>
			<th> Price </th>
		</tr>

		<?php
					if ($_SERVER['REQUEST_METHOD'] == 'POST'){
				$productname = $_POST['productname'];
				$q = 'SELECT * from '.PRODUCT_TABLE::$NAME.' WHERE '.PRODUCT_TABLE::$PROD_NAME.' LIKE \'%'.$productname.'%\''
                                                    .' AND '.PRODUCT_TABLE::$APPROVED.' = \'a\';';
				include("dbc.php");
				$r = mysqli_query($dbc, $q);
				if($r) {
				  //a loop that keeps pulling records with the same subject that was selected until there are no more records	
				while ($row = mysqli_fetch_array($r)){
					echo "<tr>";
					echo "<td>".$row['category']."</td>";
            echo '<td><a href="view_product.php?'.PRODUCT_TABLE::$PROD_ID.'='.$row[PRODUCT_TABLE::$PROD_ID].'">'.
			'<img src="images/'.$row[PRODUCT_TABLE::$IMAGE].'" height="60" width="100"/></a>'.$row[PRODUCT_TABLE::$PROD_NAME].'</td>';
            echo "<td>".$row[PRODUCT_TABLE::$DESCRIPTION]."</td>";
            echo "<td>".$row[PRODUCT_TABLE::$PRICE]."</td>";					
					echo "</tr>";
				}
				} else {
					echo "<tr><td colspan=10>No Product found for: '$productname'</td></tr>";
				}
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