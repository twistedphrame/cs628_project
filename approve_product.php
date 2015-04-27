<?php
  session_start();
  require_once("product.php");
  if (!isset($_COOKIE[USER_TABLE::$USER_NAME])) {
    header('LOCATION: products.php');
  }
  if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (!isset($_POST[PRODUCT_TABLE::$PROD_ID])) {
      header('LOCATION: products.php');
    }
    include("dbc.php");
    $product = new Product();
    $product->setProductID($_POST[PRODUCT_TABLE::$PROD_ID])
            ->setApproved(true)
            ->update($dbc);
    require_once("include/sql_queries.php");
    $product = selectSingleProduct($dbc, $_POST[PRODUCT_TABLE::$PROD_ID]);
    $userInfo = selectSingleCustomer($dbc, $product[PRODUCT_TABLE::$VEND_ID]);
    $subject = 'You Product is ready for sale!';
    $message = "Hi ". $userInfo[USER_TABLE::$FIRST_NAME . ' Your product'.$product[PRODUCT_TABLE::$PROD_NAME].' can now be sold!';
    $headers = 'From: Online Shopping System' . "\r\n" .
    'Reply-To: ' . "\r\n" .	'X-Mailer: PHP/' . phpversion();
    mail($userInfo[USER_TABLE::$EMAIL], $subject, $message, $headers);
  } else {
    header('LOCATION: products.php');
  }
?>