<html>
<?php
    include("includes/sql_queries.php");
    session_start();    
    if (!isset($_COOKIE[USER_TABLE::$USER_NAME])
         || $_SERVER['REQUEST_METHOD'] != 'GET'
         || !isset($_GET[PRODUCT_TABLE::$PROD_ID])) {
      header('LOCATION: products.php');
    }
    include("dbc.php");
    $product = selectSingleApprovedProduct($dbc, $_GET[PRODUCT_TABLE::$PROD_ID]);
    if(empty($product)) {
        header('LOCATION: products.php');
    }
?>
<head>
    <title><?php echo $product[PRODUCT_TABLE::$PROD_NAME]; ?></title>    
</head>

<body>
    <?php include("includes/header.php"); ?>
    <script src="ajaxFuncs.js"></script>
    <div>
        <table>
            <tr>
                <td colspan='2'><h2><?php echo $product[PRODUCT_TABLE::$PROD_NAME]; ?></h2></td>
            </tr>
            <tr>
                <td><img src="images/<?php echo $product[PRODUCT_TABLE::$IMAGE];?>" height="133" width="200"/></td>
                <td>
                    <form>
                        <table>
												<?php
														$percOff = $product[PRODUCT_TABLE::$DISCOUNT];
														if($percOff != NULL && $percOff > 0) {
																echo '<tr><td>Normal Cost:</td><td>$';
                                echo number_format($product[PRODUCT_TABLE::$PRICE], 2);
                                echo '</td></tr>';
																echo '<tr><td>Discount:</td><td>'.$percOff.'%</td></tr>';
																echo '<tr><td>Actual Cost:</td><td>$';
                                echo number_format(actualCost($product), 2);
                                echo '</td></tr>';
														} else {
																echo '<tr><td>Cost:</td><td>'.$product[PRODUCT_TABLE::$PRICE].'</td></tr>';
														}
														echo '<tr><td>Quantity:</td><td>';
                            echo quantityDropDown(PRODUCT_TABLE::$QUANTITY, NULL, $product[PRODUCT_TABLE::$QUANTITY]);
                            echo '</td></tr>';
														echo "<tr><td colspan='2'>";
                            echo '<input type="button" onclick="addToCart('.$_GET[PRODUCT_TABLE::$PROD_ID].')" value="ADD TO CART" />';
                            echo "</td></tr>";
												?>
                        </table>
                    </form>
                </td>
            </tr>
            <tr>
               <td colspan='2'><h4 style='display: inline'>Description:</h4><br><?php echo $product[PRODUCT_TABLE::$DESCRIPTION]; ?></td>
            </tr>
            <tr>
                <td colspan='2'><?php echo "<h4 style='display: inline'>Category:</h4> "; echo $product[PRODUCT_TABLE::$CATEGORY]; ?></td>
            </tr>
            <tr>
                <td colspan='2'><?php echo "<h4 style='display: inline'>Serial Number:</h4> "; echo $product[PRODUCT_TABLE::$PROD_NUMBER]; ?></td>
            </tr>
            <tr>
                <td colspan='2'><h4 style='display: inline'>Features:</h4><br><?php echo $product[PRODUCT_TABLE::$FEATURES]; ?></td>
            </tr>
        </table>        
    </div>
    <?php include("includes/footer.php"); ?>    
</body>
</html>
