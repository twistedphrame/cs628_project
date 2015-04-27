<html>
<?php
    include("includes/sql_queries.php");
    session_start();    
    if (!isset($_COOKIE[USER_TABLE::$USER_NAME])
        || $_COOKIE[USER_TABLE::$ROLE] != USER_TABLE::$ROLE_ADMIN) {
      header('LOCATION: products.php');
    }
    
    function transactionRow($dbc, $order) {
      echo "<tr><td></td>";
      $product = selectSingleProduct($dbc, $order[TRANSACTION_TABLE::$PROD_ID]);
      echo '<td>'.$order[TRANSACTION_TABLE::$USER_NAME].'</td>';
      echo '<td>'.$order[TRANSACTION_TABLE::$VENDOR_ID].'</td>';
      echo "<td>".$product[PRODUCT_TABLE::$PROD_NAME].'-'.$product[PRODUCT_TABLE::$PROD_NUMBER]."</td>";
      echo "<td>".$order[TRANSACTION_TABLE::$QUANTITY]."</td>";
      echo "<td>$".number_format($order[TRANSACTION_TABLE::$PRICE],2)."</td>";
      echo "<td>".statusString($order)."</td>";
      echo "</tr>";
      if($order[TRANSACTION_TABLE::$STATUS] == TRANSACTION_TABLE::$ORDER_CANCELLED) {
        return 0;
      }
      return $order[TRANSACTION_TABLE::$QUANTITY] * $order[TRANSACTION_TABLE::$PRICE];
    }
    
    function orderTotal($sum) {
      echo "<tr><td colSpan=4 align=right>Order Total</td><td>$".number_format($sum,2)."</td></tr>";
    }
?>
<head>
    <title>User Report</title>    
</head>
<body>
    <div id = "container">
    <?php include("includes/header.php"); ?>
    <script src="ajaxFuncs.js"></script>
    <div id="content" align="center">
      <br>
      <h2>Sales</h2>
      <br>
      <?php
        include('dbc.php');
        date_default_timezone_set('America/New_York' );
        $orders = allTransactionsDescendingTime($dbc);
        if(empty($orders)) {
          echo "There are no orders";
        } else {
          echo '<table>';
          $orderDate = NULL;
          $sum = 0;
          foreach($orders as $order) {
            $time = strtotime($order[TRANSACTION_TABLE::$TRANS_ID]);
            $date =  date('Y-m-d',$time);
            if($date != $orderDate) {
              if($orderDate != NULL) {
                orderTotal($sum);
              }
              $sum = 0;
              $orderDate = $date;
              echo "<tr><td align=left>".$orderDate."</td></tr>";
              echo "<tr><td></td><td>User</td><td>Vendor</td><td>Product</td><td>Quantity</td><td>Unit Price</td><td>Status</td></tr>";
              $sum = $sum + transactionRow($dbc, $order);
            } else {
              $sum = $sum + transactionRow($dbc, $order);
            }
          }
          if($orderDate != NULL) { //Need to print out the last total
            orderTotal($sum);
          }
          echo '</table>';
        }
      ?>
    </div>
    <?php include("includes/footer.php"); ?>
    </div>
</body>
</html>
