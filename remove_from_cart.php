<?php
  session_start();
  include("includes/sql_queries.php");
  if (!isset($_COOKIE[USER_TABLE::$USER_NAME])) {
    header('LOCATION: products.php');
  }
  if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    setcookie("prod_".$_POST[PRODUCT_TABLE::$PROD_ID],
              '',
              time()-1000);
  } else {
    header('LOCATION: products.php');
  }
?>