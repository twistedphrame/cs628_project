<html xmlns = "http://www.w3.org/1999/xhtml">
<head>
	<title>CS628</title>
	<link rel = "stylesheet" href = "includes/style.css" type = "text/css" media = "screen" />
	<meta http-equiv = "content-type" content = "text/html; charset = utf-8" />
</head>

<body>
	<div id = "container">
	<?php include("includes/header.php"); ?>
	
	<div id = "content">
		<?php
      session_start();
      $_SESSION = array();
      if (isset($_SERVER['HTTP_COOKIE'])) {
        $cookies = explode(';', $_SERVER['HTTP_COOKIE']);
        foreach($cookies as $cookie) {
            $parts = explode('=', $cookie);
            $name = trim($parts[0]);
            setcookie($name, '', time()-1000);
            setcookie($name, '', time()-1000, '/');
        }
      }
      session_destroy();
      header('LOCATION: products.php');
		?>
	
		<h1>You have signed out successfully!</h1>
		<a href = "singin.php">Click here to sign in.</a>
	</div>
	
	<div id = "footer">
		<p>Copyright 2015 Monmouth University</p>
	</div>
	</div>
</body>
</html>
