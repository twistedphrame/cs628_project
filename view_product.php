<html>
<?php
    $QUANTITY = 'quantity';
    include("sql_queries.php");
    session_start();
    if (/*empty($_COOKIE['uname'])
         *|| */ $_SERVER['REQUEST_METHOD'] != 'GET'
          || !isset($_GET[PRODUCT_TABLE::$PROD_ID])) {
            header('LOCATION: index.php');
    }

    /*
    //retrieve session data
    $uname = $_COOKIE['uname'];//$_SESSION['uname'];
    */
    include("dbc.php");
    $product = selectSingleProduct($dbc, $_GET[PRODUCT_TABLE::$PROD_ID]);
    if(empty($product)) {
        header('LOCATION: index.php');
    }
?>
<script>
    function addToCart(prodID) {
        var e = document.getElementById("quantity");
        var quantity = e.options[e.selectedIndex].value;
        var xhr;
        if (window.XMLHttpRequest) {
            xhr = new XMLHttpRequest();
        }
        else if (window.ActiveXObject) {
            xhr = new ActiveXObject("Msxml2.XMLHTTP");
        }
        else {
            throw new Error("Ajax is not supported by this browser");
        }
        
        //what do I do when i get a response back
        xhr.onreadystatechange = function () {
						if (xhr.readyState === 4) {
										if (xhr.status == 200 && xhr.status < 300) {
														window.location.replace('shopping_cart.php', '_SELF')
										}
						}
				}
				xhr.open('POST', 'add_2_cart.php');
				xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
				xhr.send("productid=" + classID);
				xhr.send("quantity=" + quantity);
		}

</script>
    
<head>
    <title><?php echo $product[PRODUCT_TABLE::$PROD_NAME]; ?></title>    
</head>

<body>
    <?php include("includes/header.php"); ?>
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
														$percOff = $product[DISCOUNT_TABLE::$DISCOUNT];
														if($percOff != NULL && $percOff > 0) {
																echo '<tr><td>Normal Cost:</td><td>'.$product[PRODUCT_TABLE::$PRICE].'</td></tr>';
																echo '<tr><td>Discount:</td><td>'.$percOff.'%</td></tr>';
																echo '<tr><td>Actual Cost:</td><td>' . ($product[PRODUCT_TABLE::$PRICE] * ($percOff/100.0)) . '</td></tr>';
														} else {
																echo '<tr><td>Cost:</td><td>'.$product[PRODUCT_TABLE::$PRICE].'</td></tr>';
														}
														echo '<tr><td>Quantity:</td><td>'.quantityDropDown($QUANTITY, $selected).'</tr></tr>';
														echo "<tr><tdcolspan='2'><input type=\"button\" \n";
														echo 'onclick="addToCart('.$_GET[PRODUCT_TABLE::$PROD_ID].')" ';
														echo "value=\"ADD TO CART\" /></td></tr>\n";
														echo '<tr><td colspan="2">ADD TO CART</td></tr>';
												?>
                        </table>
                    </form>
                </td>
            </tr>
            <tr>
               <td colspan='2'><h4>Description:</h4></td> 
            </tr>
            <tr>
                <td colspan='2'><?php echo "Category: "; echo $product[PRODUCT_TABLE::$CATEGORY]; ?></td>
            </tr>
            <tr>
                <td colspan='2'><?php echo "Serial Number: "; echo $product[PRODUCT_TABLE::$PROD_NUMBER]; ?></td>
            </tr>
            <tr>
                <td colspan='2'><?php echo $product[PRODUCT_TABLE::$DESCRIPTION]; ?></td>
            </tr>
            <tr>
                <td colspan='2'><h4>Features:</h4></td>
            </tr>
            <tr><td colspan='2'><?php echo $product[PRODUCT_TABLE::$FEATURES]; ?></td></tr>
        </table>        
    </div>
    <?php include("includes/footer.php"); ?>    
</body>
</html>