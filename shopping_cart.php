<html>
<?php
    include("includes/sql_queries.php");
    session_start();
    if (!isset($_COOKIE[USER_TABLE::$USER_NAME])) {
      header('LOCATION: index.php');
    }
?>
<head>
    <title>Shopping Cart</title>    
</head>

<body>
  <?php include("includes/header.php"); ?>
  <script src="ajaxFuncs.js"></script>
  <div>
    <form>
      <table>
        <?php
          include("dbc.php");
          $products = productsInCart($dbc);
          echo "<tr>";
          echo "<td>Product</td>";
          echo "<td>Unit Cost</td>";
          echo "<td>Discount</td>";
          echo "<td>Actual Cost</td>";
          echo "<td>Quantity</td>";
          echo "<td>Total</td>";
          echo "<td></td><td></td>";
          echo "</tr>\n";
          
          if(empty($products)) {
            echo "<tr><td colspan='6'>No products in cart</td></tr>";
            echo "<tr><td colspan='5' align='center'>Order Total:</td><td>$0.00</td></tr>";
          } else {
            $sum = 0;
            foreach($products as $product) {
              echo '<tr>';
              echo '<td>'.$product[PRODUCT_TABLE::$PROD_NAME].'-'.$product[PRODUCT_TABLE::$PROD_NUMBER].'</td>';
              echo '<td>$'.number_format($product[PRODUCT_TABLE::$PRICE],2).'</td>';
              echo '<td>'.$product[PRODUCT_TABLE::$DISCOUNT].'%</td>';
              $price = actualCost($product);
              echo '<td>$'.number_format($price,2).'</td>';
              $count = $product['selected_quantity'];
              echo '<td>';
              echo quantityDropDown($product[PRODUCT_TABLE::$PROD_ID], $product['selected_quantity'], $product[PRODUCT_TABLE::$QUANTITY]);
              echo '</td>';
              $total =$price*$count;
              $sum = $sum + $total;
              echo '<td>$'.number_format($total, 2).'</td>';
              
              echo '<td>UPDATE</td>';
              echo '<td>REMOVE</td>';
              echo '</tr>';
            }
            echo '<tr><td colspan="5" align="right">Order Total:</td><td align="left">$'.number_format($sum,2).'</td></tr>';
            echo "<tr><td colspan='6' align='right'>PLACE ORDER</td></tr>";
          }
        ?>
      </table>
    </form>
  </div>  
  <?php include("includes/footer.php"); ?>   
</body>

</html>