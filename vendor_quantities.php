<html>
<head>
<title>Stock Report</title>
<meta http-equiv="content-type" content="text/html; charset=utf-8" />
</head>
<body>
	<div id = "container">
  <script src='ajaxFuncs.js'></script>
  <script>
    	function displayReport() {
				var categorySelect = document.getElementById("category");
				var catName = categorySelect.options[categorySelect.selectedIndex].text;
				window.location.replace('vendor_quantities.php?catname='+catName, '_SELF');
			}
      function updateProduct(prodID) {
        window.location.replace('edit_product.php?productid='+prodID, '_SELF');
      }
	  function removeProduct(prodID) {
        window.location.replace('remove_product.php?productid='+prodID, '_SELF');
      }
  </script>
  
  <?php
    session_start();
    include("includes/sql_queries.php");
    if (!isset($_COOKIE[USER_TABLE::$USER_NAME])
        || $_COOKIE[USER_TABLE::$ROLE] != USER_TABLE::$ROLE_VENDOR) {
      header('LOCATION: products.php');
    }
    include("includes/header.php");
    
    function singleRow($product) {
      echo "<tr>";
      echo "<td>".$product[PRODUCT_TABLE::$PROD_NAME].'-'.$product[PRODUCT_TABLE::$PROD_NUMBER]."</td>";
      echo "<td>".$product[PRODUCT_TABLE::$QUANTITY]."</td>";
      echo "<td>".$product[PRODUCT_TABLE::$PRICE]."</td>";
      echo "<td>".$product[PRODUCT_TABLE::$DISCOUNT]."%</td>";
      $approved = '';
      if($product[PRODUCT_TABLE::$APPROVED] == 'p') {
        $approved = 'Pending';
      } elseif($product[PRODUCT_TABLE::$APPROVED] == 'a') {
        $approved = 'Approved';
      } else {
				$approved = 'Removed';
			}
      echo "<td>".$approved.'</td>';
			if($product[PRODUCT_TABLE::$APPROVED] != 'r') {
				echo '<td><input type="button" onclick="updateProduct(\''.$product[PRODUCT_TABLE::$PROD_ID].'\')" value="UPDATE" /></td>'; 
				echo '<td><input type="button" onclick="removeProduct(\''.$product[PRODUCT_TABLE::$PROD_ID].'\')" value="REMOVE" /></td>';
			}
      echo "</tr>";
    }
  ?>
	<div id="content" align='center'>
    <form>
    <?php
      $selectedCategory = NULL;
      if ($_SERVER['REQUEST_METHOD'] == 'GET') {
        $selectedCategory = (isset($_GET[CATEGORY_TABLE::$CAT_NAME]) ? $_GET[CATEGORY_TABLE::$CAT_NAME] : NULL);
      }
      echo "<br><table><tr><td>";
      include("dbc.php");
      categoryDropDown($dbc, 'category', $selectedCategory);
      echo '</td><td><input type="button" onclick="displayReport()" value="VIEW" /></td></tr></table>';
    ?>
    </form>
    <br>
    <?php
      if($_SERVER['REQUEST_METHOD'] = 'GET' && $selectedCategory != null) {
        include("dbc.php");
        $products = selectAllProductsByVendorInCategory($dbc, $_COOKIE[USER_TABLE::$USER_NAME], $selectedCategory);
        if(empty($products)) {
          echo "No products to display.";
        } else {
          echo "<table>";
          echo "<tr><td>Product</td><td>Quantity</td><td>Unit Price</td><td>Discount</td><td>Approval</td></tr>";
          foreach($products as $product) {              
            singleRow($product);
          }
          echo "</table>";
        }
      }
    ?>
  </div>
  <?php include("includes/footer.php") ?>
  </div>
</body>
</html>