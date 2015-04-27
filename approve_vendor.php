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
    
    
    $userInfo = selectSingleCustomer($dbc, $_POST[USER_TABLE::$USER_NAME]);
    
    $q = 'UPDATE ' . USER_TABLE::$NAME . ' SET '
          .USER_TABLE::$APPROVED.'=\'1\' WHERE '.USER_TABLE::$USER_NAME.' = \''.$_POST[USER_TABLE::$USER_NAME].'\'';
    $r = mysqli_query($dbc, $q);
    if($r) {
      $to = $userInfo[USER_TABLE::$EMAIL];
			$subject = 'You Have Been Approved';
      $message = "Hi ". $userInfo[USER_TABLE::$FIRST_NAME] . ' You can now add products to sell to our system!';
  		$headers = 'From: Online Shopping System' . "\r\n" .
    								'Reply-To: ' . "\r\n" .
    								'X-Mailer: PHP/' . phpversion();
      mail($to, $subject, $message, $headers);
      return true;
    }
    return false;
  } else {
    header('LOCATION: products.php');
  }
?>