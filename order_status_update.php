<?php
  session_start();
  require_once("transaction.php");
  if (!isset($_COOKIE[USER_TABLE::$USER_NAME])) {
    header('LOCATION: products.php');
  }
  if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (!isset($_POST[TRANSACTION_TABLE::$PROD_ID])) {
      header('LOCATION: products.php');
    }
    if (!isset($_POST[TRANSACTION_TABLE::$USER_NAME])) {
      header('LOCATION: products.php');
    }
    if (!isset($_POST[TRANSACTION_TABLE::$TRANS_ID])) {
      header('LOCATION: products.php');
    }
    if(!isset($_POST[TRANSACTION_TABLE::$STATUS])) {
      header('LOCATION: products.php');
    }
    include("dbc.php");
    $status = $_POST[TRANSACTION_TABLE::$STATUS];
    $transaction = new Transaction();
    $transaction->setTransactionID($_POST[TRANSACTION_TABLE::$TRANS_ID])
                ->setUserName($_POST[TRANSACTION_TABLE::$USER_NAME])
                ->setProductID($_POST[TRANSACTION_TABLE::$PROD_ID]);
    if($status == TRANSACTION_TABLE::$ORDER_PENDING) {
      echo $transaction->pending()->updateStatus($dbc);
    } elseif($status == TRANSACTION_TABLE::$ORDER_SHIPPED) {
      echo $transaction->shipped()->updateStatus($dbc);
    } elseif($status == TRANSACTION_TABLE::$ORDER_CANCELLED) {
      echo $transaction->cancelled()->updateStatus($dbc);
    }
  } else {
    header('LOCATION: products.php');
  }
?>