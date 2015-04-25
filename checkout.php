<html>
<?php
    include("includes/sql_queries.php");
    session_start();
    if (!isset($_COOKIE[USER_TABLE::$USER_NAME])) {
      header('LOCATION: shopping_cart.php');
    }
?>
<head>
    <title>Check Out</title>    
</head>

<body>
  <div id = "container">
  <?php include("includes/header.php"); ?>
  <script src="ajaxFuncs.js"></script>
  <div id="content" align="center">
      <h2>Selected Products</h2>
      <table>
        <?php
          include("dbc.php");
          $products = productsInCart($dbc);
          if(empty($products)) {
            header('LOCATION: shopping_cart.php');
          }
          echo "<tr>";
          echo "<td>Product</td>";
          echo "<td>Cost</td>";
          echo "<td>Quantity</td>";
          echo "</tr>";
          $sum = 0;
          foreach($products as $product) {
            echo '<tr>';
            echo '<td>'.$product[PRODUCT_TABLE::$PROD_NAME].'-'.$product[PRODUCT_TABLE::$PROD_NUMBER].'</td>';
            $price = actualCost($product);
            echo '<td>$'.number_format($price,2).'</td>';
            $count = $product['selected_quantity'];
            echo '<td>';
            echo $count;
            echo '</td>';
            $sum = $sum + ($price*$count);
            echo '</tr>';
          }
          echo '<tr><td colspan="5" align="right">Order Total:</td><td align="left">$'.number_format($sum,2).'</td>';
        ?>
      </table>
      <br>
      <h2>Shipping Information</h2>
      <form>
      <table>
      <?php
          $q = "SELECT * FROM users WHERE username = '{$_COOKIE[USER_TABLE::$USER_NAME]}'";
					$r = mysqli_query($dbc, $q);
          if(!$r || mysqli_num_rows($r) != 1) {
            header('LOCATION: shopping_cart.php');
          }
          $user = mysqli_fetch_array($r);
          echo '<tr><td>'.$user[USER_TABLE::$FIRST_NAME].' '.$user[USER_TABLE::$LAST_NAME].'</td><td></td></tr>';
          echo '<tr><td>'.$user[USER_TABLE::$ADDRESS].'</td><td></td></tr>';
          echo '<tr><td>'.$user[USER_TABLE::$CITY].', '.$user[USER_TABLE::$STATE].'</td><td></td></tr>';
          echo '<tr><td >'.$user[USER_TABLE::$ZIP_CODE].'</td><td></td></tr>';
          echo '<tr><td colspan="2"><input type="button" onclick="window.location.replace(\'edit_profile.php\', \'_SELF\');" value="CHANGE ADDRESS"/></td></tr>';
      ?>
      </table>
      <br>
        <table>
            <?php            
              echo '<td colspan="2"><input type="button" onclick="order(\''.$user[USER_TABLE::$USER_NAME].'\')" value="PLACE ORDER" /></td></tr>';
            ?>
        </table>
      </form>
  <?php include("includes/footer.php"); ?>
  </div>
  </div>
</body>

</html>