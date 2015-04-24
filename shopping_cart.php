<html>
<?php
    include("includes/sql_queries.php");
    session_start();
    if (!isset($_COOKIE[USER_TABLE::$USER_NAME])) {
      header('LOCATION: products.php');
    }
?>
<head>
    <title>Shopping Cart</title>    
</head>

<body>
  <?php include("includes/header.php"); ?>
  <script src="ajaxFuncs.js"></script>
  <script>
    function checkout() {
      window.location.replace('checkout.php', '_SELF');
    }    
  </script>
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
              echo '<td><a href="view_product.php?'.PRODUCT_TABLE::$PROD_ID.'='.$product[PRODUCT_TABLE::$PROD_ID].'">';
              echo $product[PRODUCT_TABLE::$PROD_NAME].'-'.$product[PRODUCT_TABLE::$PROD_NUMBER].'</a></td>';
              echo '<td>$'.number_format($product[PRODUCT_TABLE::$PRICE],2).'</td>';
              echo '<td>'.$product[PRODUCT_TABLE::$DISCOUNT].'%</td>';
              $price = actualCost($product);
              echo '<td>$'.number_format($price,2).'</td>';
              $count = $product['selected_quantity'];
              echo '<td>';
              echo quantityDropDown('cart_'.$product[PRODUCT_TABLE::$PROD_ID], $product['selected_quantity'], $product[PRODUCT_TABLE::$QUANTITY]);
              echo '</td>';
              $total =$price*$count;
              $sum = $sum + $total;
              echo '<td>$'.number_format($total, 2).'</td>';              
              echo '<td><input type="button" onclick="addToCart(\'';
              echo $product[PRODUCT_TABLE::$PROD_ID];
              echo '\',\'';
              echo 'cart_'.$product[PRODUCT_TABLE::$PROD_ID];
              echo '\')" value="UPDATE" /></td>';
              echo '<td><input type="button" onclick="removeItemFromCart(\'';
              echo $product[PRODUCT_TABLE::$PROD_ID];
              echo '\')" value="REMOVE" /></td>';
              echo '</tr>';
            }
            echo '<tr><td colspan="5" align="right">Order Total:</td><td align="left">$'.number_format($sum,2).'</td>';
            echo '<td colspan="2"><input type="button" onclick="checkout()" value="CHECK OUT" /></td></tr>';
          }
        ?>
      </table>
    </form>
  </div>  
  <?php include("includes/footer.php"); ?>   
</body>

</html>