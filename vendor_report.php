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
    
    function tableHeader() {
      echo '<tr>';
      echo '<td>Product</td>';
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
    <title>Vendor Report</title>    
</head>
<body>
    <div id = "container">
    <?php include("includes/header.php"); ?>
    <script src="ajaxFuncs.js"></script>
    <script>
    	function search() {
				var userSearch = document.getElementById("username");
				var user = userSearch.value;
				window.location.replace('vendor_report.php?username='+user, '_SELF');
			}
    </script>
    <div id="content" align="center">
      <?php
        $userName = '';
        if($_SERVER['REQUEST_METHOD'] == 'GET' && isset($_GET[USER_TABLE::$USER_NAME])) {
          $userName = $_GET[USER_TABLE::$USER_NAME];
          include("dbc.php");
          $userInfo = selectSingleVendor($dbc, $userName);
        }
      ?>
      <form>
        <table>
          <tr>
            <td>Vendor Search:</td>
            <td>
              <?php
                echo '<input type="text" id="'.USER_TABLE::$USER_NAME.'" name="'.USER_TABLE::$USER_NAME.'" value="'.$userName.'"/>'
              ?>
            </td>
            <td>
              <input type="button" onclick="search()" value="Search" />
            </td>
          </tr>
          <tr>
            <td colspan='3'><div style="color: red">
              <?php
                if($userName != '' && empty($userInfo)) {
                  echo "Could not find vendor.";
                }
              ?>
            </div></td>
          </tr>
        </table>
      </form>
      <br>
      <?php
        if(!empty($userInfo)) {
          echo '<h2>User Information</h2>';
          echo '<table>';
          echo '<tr><td>First Name:</td><td>'.$userInfo[USER_TABLE::$FIRST_NAME].'</td></tr>';
          echo '<tr><td>Last Name:</td><td>'.$userInfo[USER_TABLE::$LAST_NAME].'</td></tr>';
          echo '<tr><td>Approved:</td><td>';
          if($userInfo[USER_TABLE::$APPROVED]) {
            echo 'Yes</td></tr>';
          } else {
            echo 'No</td><td><input type="button" value="APPROVE" onclick="approveVendor(\''
                            .$userInfo[USER_TABLE::$USER_NAME].'\',\'vendor_report.php?username='.$userInfo[USER_TABLE::$USER_NAME].'\')" /></td></tr>';
          }
          echo '<tr><td>Address:</td><td>'.$userInfo[USER_TABLE::$ADDRESS].'</td></tr>';
          echo '<tr><td>City:</td><td>'.$userInfo[USER_TABLE::$CITY].'</td></tr>';
          echo '<tr><td>State:</td><td>'.$userInfo[USER_TABLE::$STATE].'</td></tr>';
          echo '<tr><td>Zip Code:</td><td>'.$userInfo[USER_TABLE::$ZIP_CODE].'</td></tr>';
          echo '<tr><td>Email:</td><td>'.$userInfo[USER_TABLE::$EMAIL].'</td></tr>';
          echo '<tr><td>Phone:</td><td>'.$userInfo[USER_TABLE::$PHONE].'</td></tr>';
          echo '</table>';
          
          echo '<br><h2>Offered Products</h2>';
          $products = selectAllProductsByVendorSortedByApproval($dbc, $userName);
          if(empty($products)) {
            echo "This vendor has no products";
          }else {
            $approved = false;
            $pending = false;
						$removed = false;
            echo "<table align=center>";
            foreach($products as $product) {
              if($product[PRODUCT_TABLE::$APPROVED] == "a") {
                if(!$approved) {
                  $approved = true;
                  echo "<tr><td align='center' colspan=10><br><h4>Approved Products</h4></td></tr>";
                  tableHeader();
                }
                approvedProductRow($product, false);
              } elseif($product[PRODUCT_TABLE::$APPROVED] == "p") {
                if(!$pending) {
                  $pending = true;
                  echo "<tr><td align='center' colspan=10><br><h4>Pending Products</h4></td></tr>";
                  tableHeader();
                }
                pendingProductRow($product, false, 'vendor_report.php?'.USER_TABLE::$USER_NAME.'='.$userName);
              }  elseif($product[PRODUCT_TABLE::$APPROVED] == "r") {
								if(!$removed) {
                  $removed = true;
                  echo "<tr><td align='center' colspan=10><br><h4>Removed Products</h4></td></tr>";
                  tableHeader();
                }
								removedProductRow($product, false, 'vendor_report.php?'.USER_TABLE::$USER_NAME.'='.$userName);
							}
            }
            echo "</table>";
          }
          echo '<br><h2>Order History</h2>';
          $orders = selectTransactionsForUserDescTime($dbc, $userName);
          if(empty($orders)) {
            echo "This user has not ordered anything";
          } else {
            echo '<table>';
            $orderDate = NULL;
            $sum = 0;
            foreach($orders as $order) {              
              if($order[TRANSACTION_TABLE::$TRANS_ID] != $orderDate) {
                if($orderDate != NULL) {
                  orderTotal($sum);
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
              orderTotal($sum);
            }
            echo '</table>';
          }
        }
      ?>
    </div>
    <?php include("includes/footer.php"); ?>
    </div>
</body>
</html>
