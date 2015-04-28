<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>Online Shopping System</title>
<meta http-equiv="content-type" content="text/html; charset=utf-8" />
</head>
<body>

	<div id = "container">
  <?php include("includes/sql_queries.php"); ?> 
	<?php include("includes/header.php");?>
	
	<div id="content" align='center'>	
		<h1>Products Page</h1>

    <script>
      function displayProducts() {
				var categorySelect = document.getElementById("category");
				var categoryText = categorySelect.options[categorySelect.selectedIndex].text;
				window.location.replace('products.php?category='+categoryText, '_SELF');
			}
    </script>

		<form action="" method="POST"> 
			<center>
        <table style="padding: 10px 0px">
				<tr>
        <td>
				<?php   // the actual pull down menu created with the classes in it
          $category = NULL;
          if($_SERVER['REQUEST_METHOD'] == 'GET' && isset($_GET[PRODUCT_TABLE::$CATEGORY])) {
            $category = $_GET[PRODUCT_TABLE::$CATEGORY];
          }
          include("dbc.php");
          categoryDropDown($dbc, 'category', $category);
				?>
				</td>
        <td>
          <!-- the display button that when clicked pulls items from the database based on the subject that was selected-->
					<input type="button" onclick="displayProducts()" name="display" value="Display" />
				</td>
			</table>
      </center>
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
      if($category != NULL) {
        include("dbc.php");
        foreach(selectApprovedProductsByCategory($dbc, $category) as $product) {
          echo "<tr>";
            echo '<td><a href="view_product.php?'.PRODUCT_TABLE::$PROD_ID.'='.$product[PRODUCT_TABLE::$PROD_ID].'">'.
			'<img src="images/'.$product[PRODUCT_TABLE::$IMAGE].'" height="60" width="100"/></a></td>';
            echo "<td>".$product[PRODUCT_TABLE::$CATEGORY]."</td>";
            echo "<td>".$product[PRODUCT_TABLE::$VEND_ID]."</td>";
            echo "<td>".$product[PRODUCT_TABLE::$DESCRIPTION]."</td>";
            echo "<td>".$product[PRODUCT_TABLE::$PRICE]."</td>";
            echo "</tr>";
        }
			}
		?>					
		</table><center> 
	
	</div> <!--content -->

	<div id="footer">

	</div>
	</div> <!--container -->
</body>
</html>