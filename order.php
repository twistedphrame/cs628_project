<?php
  session_start();
  require_once("transaction.php");
  if (!isset($_COOKIE[USER_TABLE::$USER_NAME])) {
    header('LOCATION: products.php');
  }
  if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    include("dbc.php");
    $products = productsInCart($dbc);
    if(empty($products)) {
      header('LOCATION: shopping_cart.php');
    }
    $user = selectSingleCustomer($dbc, $_COOKIE[USER_TABLE::$USER_NAME]);
    if(empty($user)) {
      header('LOCATION: shopping_cart.php');
    }
    date_default_timezone_set('America/New_York');
    $trans_id = date('Y-m-d H:i:s', time());    
    $transaction = new Transaction();
    $transaction->pending()
                ->setUserName($user[USER_TABLE::$USER_NAME])
                ->setFirstName($user[USER_TABLE::$FIRST_NAME])
                ->setLastName($user[USER_TABLE::$LAST_NAME])
                ->setAddress($user[USER_TABLE::$ADDRESS])
                ->setCity($user[USER_TABLE::$CITY])
                ->setState($user[USER_TABLE::$STATE])
                ->setZipCode($user[USER_TABLE::$ZIP_CODE])
                ->setTransactionID($trans_id);
    require_once("includes/sql_queries.php");
    foreach($products as $product) {
      setcookie('prod_'.$product[PRODUCT_TABLE::$PROD_ID], '', time()-1000);
      $transaction->setQuantity($product['selected_quantity'])
                  ->setPricePerUnit(actualCost($product))
                  ->setProductID($product[PRODUCT_TABLE::$PROD_ID])
                  ->setVendorID($product[PRODUCT_TABLE::$VEND_ID])
                  ->insert($dbc);
      $vendor =  selectSingleCustomer($dbc, $product[PRODUCT_TABLE::$VEND_ID]);
      $subject = 'You made a sale!';
      $message = "Hi ". $vendor[USER_TABLE::$FIRST_NAME] . ' A user has purchased one of your products!';
      $headers = 'From: Online Shopping System' . "\r\n" .
      'Reply-To: ' . "\r\n" .	'X-Mailer: PHP/' . phpversion();
      mail($vendor[USER_TABLE::$EMAIL], $subject, $message, $headers);
    }    
    $subject = 'Thank you for your order!';
    $message = "Hi ". $user[USER_TABLE::$FIRST_NAME] . ' Thank you for your order!';
    $headers = 'From: Online Shopping System' . "\r\n" .
    'Reply-To: ' . "\r\n" .	'X-Mailer: PHP/' . phpversion();
    mail($user[USER_TABLE::$EMAIL], $subject, $message, $headers);
  } else {
    header('LOCATION: products.php');
  }
?>