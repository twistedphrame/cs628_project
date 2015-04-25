<html>
<head>
<title>Sale Reports</title>
<meta http-equiv="content-type" content="text/html; charset=utf-8" />
</head>
<body>
	<div id = "container">
  <?php
    session_start();
    include("includes/sql_queries.php");
    if (!isset($_COOKIE[USER_TABLE::$USER_NAME])
        || $_COOKIE[USER_TABLE::$ROLE] != USER_TABLE::$ROLE_VENDOR) {
      header('LOCATION: products.php');
    }
    include("includes/header.php");
  
  
    function shipping($order) {
      return $order[TRANSACTION_TABLE::$FIRST_NAME].' '.$order[TRANSACTION_TABLE::$LAST_NAME]
             .' '.$order[TRANSACTION_TABLE::$ADDRESS].' '.$order[TRANSACTION_TABLE::$CITY]
             .', '.$order[TRANSACTION_TABLE::$STATE].' '.$order[TRANSACTION_TABLE::$ZIP_CODE];

    }
  
    function transactionRow($dbc, $order) {
      echo "<tr>";
      $product = selectSingleProduct($dbc, $order[TRANSACTION_TABLE::$PROD_ID]);
      //Date</td><td>User</td><td>Product</td><td>Quantity</td><td>Unit Price</td><td><td>Shipping</td></tr>";
      echo '<td>'.$order[TRANSACTION_TABLE::$TRANS_ID].'</td>';
      echo '<td>'.$order[TRANSACTION_TABLE::$USER_NAME].'</td>';
      echo '<td>'.$product[PRODUCT_TABLE::$PROD_NAME].'-'.$product[PRODUCT_TABLE::$PROD_NUMBER]."</td>";
      echo '<td>'.$order[TRANSACTION_TABLE::$QUANTITY].'</td>';
      echo '<td>$'.number_format($order[TRANSACTION_TABLE::$PRICE],2).'</td>';
      $total = ($order[TRANSACTION_TABLE::$PRICE]*$order[TRANSACTION_TABLE::$QUANTITY]);
      echo '<td>$'.number_format($total,2).'</td>';
      echo "<td>".shipping($order)."</td>";
      echo "</tr>";
      return $total;
    }
  
  
  
    function orderTotal($sum) {
      echo "<tr><td colSpan=4 align=right>Order Total</td><td>$".number_format($sum,2)."</td></tr>";
    }
  
  ?>
  <script>
    	function displayReport() {
				var statusSelect = document.getElementById("statusDropDown");
				var statusText = statusSelect.options[statusSelect.selectedIndex].text;
				window.location.replace('vendor_sale_reports.php?status='+statusText, '_SELF');
			}   
  </script>
	<div id="content" align='center'>
    <form>
    <?php
      $selectedStatus = NULL;
      if ($_SERVER['REQUEST_METHOD'] == 'GET') {
        $selectedStatus = (isset($_GET[TRANSACTION_TABLE::$STATUS]) ? $_GET[TRANSACTION_TABLE::$STATUS] : NULL);
      }
      $items = array();
      $items[] = 'Pending';
      $items[] = 'Shipped';
      $items[] = 'Cancelled';
      echo "<br><table><tr><td>";
      createDropDown('statusDropDown', $items,$selectedStatus);
      echo '</td><td><input type="button" onclick="displayReport()" value="VIEW REPORT" /></td></tr></table>';
    ?>
    </form>
    <br>
    <?php
      if($_SERVER['REQUEST_METHOD'] = 'GET' && $selectedStatus != null) {
        include("dbc.php");
        $type = NULL;
        if($selectedStatus == 'Pending') {
          $type = TRANSACTION_TABLE::$ORDER_PENDING;
          echo "<h2 align=center>Pending Orders</h2>";
        } elseif ($selectedStatus == 'Cancelled') {
          $type = TRANSACTION_TABLE::$ORDER_CANCELLED;
          echo "<h2 align=center>Canelled Orders</h2>";
        } else if ($selectedStatus == 'Shipped') {
          $type = TRANSACTION_TABLE::$ORDER_SHIPPED;
          echo "<h2 align=center>Shipped Orders</h2>";
        } else {
          $type = NULL;
        }
        
        if($type != null) {
          $orders = selectTransactionsForVendorDescTime($dbc, $_COOKIE[USER_TABLE::$USER_NAME], $type);
          if(empty($orders)) {
            echo "No orders to display.";
          } else {
            echo "<table>";
            $sum = 0;
            echo "<tr><td>Date</td><td>User</td><td>Product</td><td>Quantity</td><td>Unit Price</td><td>Total</td><td>Shipping</td></tr>";
            foreach($orders as $order) {              
                $sum = $sum + transactionRow($dbc, $order);
            }
            orderTotal($sum);
            echo "</table>";
          }
        }
      }      
    ?>
  </div>
  <?php include("includes/footer.php") ?>
  </div>
</body>
</html>