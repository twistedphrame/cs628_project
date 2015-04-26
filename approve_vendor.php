<?php
  session_start();
  require_once("product.php");
  if (!isset($_COOKIE[USER_TABLE::$USER_NAME])) {
    header('LOCATION: products.php');
  }
  if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (!isset($_POST[USER_TABLE::$USER_NAME])) {
      header('LOCATION: products.php');
    }
    include("dbc.php");
    
    
    $q = 'UPDATE ' . USER_TABLE::$NAME . ' SET '
          .USER_TABLE::$APPROVED.'=\'1\' WHERE '.USER_TABLE::$USER_NAME.' = \''.$_POST[USER_TABLE::$USER_NAME].'\'';
    $r = mysqli_query($dbc, $q);
    if($r) {
      return true;
    }
    return false;
  } else {
    header('LOCATION: products.php');
  }
?>