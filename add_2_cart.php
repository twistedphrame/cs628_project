<?php
  session_start();
  if (empty($_COOKIE['uname'])) {
    header('LOCATION: index.php');
  }
  include("includes/sql_queries.php");
  if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    setcookie($_POST[PRODUCT_TABLE::$PROD_ID], $_POST['quantity']);
  }
?>
