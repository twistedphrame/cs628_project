<html>
<?php
    include("includes/sql_queries.php");
    session_start();    
    if (!isset($_COOKIE[USER_TABLE::$USER_NAME])
        || $_COOKIE[USER_TABLE::$ROLE] != USER_TABLE::$ROLE_ADMIN) {
      header('LOCATION: products.php');
    }
    
    function tableHeader() {
      echo '<tr>';
      echo '<td>Product</td>';
      echo '<td>Vendor</td>';
      echo '<td>Category</td>';
      echo '<td>Image</td>';
      echo '<td>Description</td>';
      echo '<td>Features</td>';
      echo '<td>Constraintes</td>';
      echo '<td>Price</td>';
      echo '<td>Discount</td>';
      echo '<td>Quantity</td>';
      echo '</tr>';
    }
?>
<head>
    <title>Pending Products</title>    
</head>
<body>
    <div id = "container">
    <?php include("includes/header.php"); ?>
    <script src="ajaxFuncs.js"></script>
    <div id="content" align="center">
    <br>
    <h2>Pending Products</h2>
    <br>
      <?php
        include("dbc.php");
        $products = selectPendingProducts($dbc);
        if(empty($products)) {
          echo "There are no pending products";
        }else {
          echo "<table align=center>";
          tableHeader();
          foreach($products as $product) {
            pendingProductRow($product, true, 'pending_product_report.php');
          }
          echo "</table>";
        }
      ?>
    </div>
    <?php include("includes/footer.php"); ?>
    </div>
</body>
</html>
