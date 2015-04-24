<html>
<?php
    include("includes/sql_queries.php");
    session_start();
    if (!isset($_COOKIE[USER_TABLE::$USER_NAME])) {
      header('LOCATION: shopping_cart.php');
    }
?>
<head>
    <title>Check Out</title>    
</head>

<body>
  <?php include("includes/header.php"); ?>
  <script src="ajaxFuncs.js"></script>
  <div>
    
  </div>
</body>


</html>