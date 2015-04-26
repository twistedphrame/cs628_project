<html>
<?php
    include("includes/sql_queries.php");
    session_start();    
    if (!isset($_COOKIE[USER_TABLE::$USER_NAME])
        || $_COOKIE[USER_TABLE::$ROLE] != USER_TABLE::$ROLE_ADMIN) {
      header('LOCATION: products.php');
    }
?>
<head>
    <title>Pending Vendors</title>    
</head>
<body>
    <div id = "container">
    <?php include("includes/header.php"); ?>
    <script src="ajaxFuncs.js"></script>
    <div id="content" align="center">
    <br>
    <h2>Pending Vendors</h2>
    <br>
    <table>
      <tr>
        <td>Vendor Name</td>
        <td>First Name</td>
        <td>Last Name</td>
        <td>Address</td>
        <td>City</td>
        <td>State</td>
        <td>Zip Code</td>
        <td>Email</td>
        <td>Phone</td>
      </tr>
      
      <?php
        include('dbc.php');
        $vendors = selectPendingVendors($dbc);
        if(empty($vendors)) {
          echo "<tr><td colspan=9 align=center>There are no pending Vendors</td></tr>";
        } else {
          foreach($vendors as $vendor) {
            echo "<tr>";
            echo '<td>'.$vendor[USER_TABLE::$USER_NAME].'</td>';
            echo '<td>'.$vendor[USER_TABLE::$FIRST_NAME].'</td>';
            echo '<td>'.$vendor[USER_TABLE::$LAST_NAME].'</td>';
            echo '<td>'.$vendor[USER_TABLE::$ADDRESS].'</td>';
            echo '<td>'.$vendor[USER_TABLE::$CITY].'</td>';
            echo '<td>'.$vendor[USER_TABLE::$STATE].'</td>';
            echo '<td>'.$vendor[USER_TABLE::$ZIP_CODE].'</td>';
            echo '<td>'.$vendor[USER_TABLE::$EMAIL].'</td>';
            echo '<td>'.$vendor[USER_TABLE::$PHONE].'</td>';
            echo '<td><input type="button" value="APPROVE" onclick="approveVendor(\''
                            .$vendor[USER_TABLE::$USER_NAME].'\',\'pending_vendors.php\')" /></td>';
            echo "</tr>";
          }
        }
      ?>
    </table>
    </div>
    <?php include("includes/footer.php"); ?>
    </div>
</body>
</html>
