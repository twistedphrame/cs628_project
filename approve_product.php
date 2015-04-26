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
  } else {
    header('LOCATION: products.php');
  }
?>