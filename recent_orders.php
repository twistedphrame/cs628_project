<html>
<?php
    session_start();
    include("includes/sql_queries.php");
    if (!isset($_COOKIE[USER_TABLE::$USER_NAME])) {
      header('LOCATION: shopping_cart.php');
    }
    
    function transactionRow($dbc, $order) {
      echo "<tr><td></td>";
      $product = selectSingleProduct($dbc, $order[TRANSACTION_TABLE::$PROD_ID]);
      echo "<td>".$product[PRODUCT_TABLE::$PROD_NAME].'-'.$order[TRANSACTION_TABLE::$PROD_ID]."</td>";
      echo "<td>".$order[TRANSACTION_TABLE::$QUANTITY]."</td>";
      echo "<td>$".number_format($order[TRANSACTION_TABLE::$PRICE],2)."</td>";
      echo "<td>".statusString($order)."</td>";
      if($order[TRANSACTION_TABLE::$STATUS] == TRANSACTION_TABLE::$ORDER_PENDING) {
        echo '<td><input type="button" value="CANCEL" onclick="updateOrderStatus(\''.$order[TRANSACTION_TABLE::$PROD_ID].'\',\''
                                                                                  .$order[TRANSACTION_TABLE::$TRANS_ID].'\',\''
                                                                                  .$order[TRANSACTION_TABLE::$USER_NAME].'\',\''
                                                                                  .TRANSACTION_TABLE::$ORDER_CANCELLED.'\')" /></td>';
      }
      echo "</tr>";
      if($order[TRANSACTION_TABLE::$STATUS] == TRANSACTION_TABLE::$ORDER_CANCELLED) {
        return 0;
      }
      return $order[TRANSACTION_TABLE::$QUANTITY] * $order[TRANSACTION_TABLE::$PRICE];
    }
?>
<head>
    <title>Recent Purchases</title>    
</head>

<body>
  <div id = "container">
  <?php include("includes/header.php"); ?>
  <script src="ajaxFuncs.js"></script>
  <div id="content" align="center">
    <form>
      <table>
        <?php
          include("dbc.php");
          $orders = selectTransactionsForUserDescTime($dbc, $_COOKIE[USER_TABLE::$USER_NAME]);
          if(empty($orders)) {
            echo "There are no orders";
          } else {
            $orderDate = NULL;
            $sum = 0;
            foreach($orders as $order) {              
              if($order[TRANSACTION_TABLE::$TRANS_ID] != $orderDate) {
                if($orderDate != NULL) {
                  echo "<tr><td colSpan=4 align=right>Total</td><td>$".number_format($sum,2)."</td></tr>";
                }
                $sum = 0;
                $orderDate = $order[TRANSACTION_TABLE::$TRANS_ID];
                echo "<tr><td align=left>".$orderDate."</td></tr>";
                echo "<tr><td></td><td>Product</td><td>Quantity</td><td>Unit Price</td><td>Status</td></tr>";
                $sum = $sum + transactionRow($dbc, $order);
              } else {
                $sum = $sum + transactionRow($dbc, $order);
              }
            }
            if($orderDate != NULL) { //Need to print out the last total
              echo "<tr><td colSpan=4 align=right>Total:</td><td>".$sum."</td></tr>";
            }
          }
        ?>
      </table>
    </form>
  </div>
    <?php include("includes/footer.php"); ?>   
  </div>
</body>
</html>