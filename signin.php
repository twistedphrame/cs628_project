<html>
<head>
  <?php include("includes/sql_queries.php"); ?>
	<title>CS628</title>
	<link rel = "stylesheet" href = "includes/style.css" type = "text/css" media = "screen" />
</head>

<body>
	
<div id="container">
	<div id="header">
		<?php include("includes/header.php"); ?>
	</div>
	
	<div id="content">
		<div style="color: red;">
		<?php
		if ($_SERVER['REQUEST_METHOD'] == 'POST'){
			if($_POST['button']=='Login'){
				$username = $_POST[USER_TABLE::$USER_NAME];
				$psword = $_POST[USER_TABLE::$PASS_WORD];
			
				$error = array();
		
				if(empty($username)) $error[]= "You forgot to enter user name.";
				if(empty($psword)) $error[]= "You forgot to enter password.";
			
				if(empty($error)) {
					include("dbc.php");
					
					$q = "SELECT * FROM " . USER_TABLE::$NAME . " WHERE " . USER_TABLE::$USER_NAME . " = '$username'";
					$r = mysqli_query($dbc, $q);
					if ($r && mysqli_num_rows($r) == 1){
						$row = mysqli_fetch_array($r);
						$fname = $row[USER_TABLE::$FIRST_NAME];
						$pwd = SHA1($psword);
						$role = $row[USER_TABLE::$ROLE];
						
						echo $pwd;
						
						if ($pwd == $row[USER_TABLE::$PASS_WORD]){
							session_start();
							setcookie(USER_TABLE::$USER_NAME,$username,time()+36000);
							setcookie(USER_TABLE::$FIRST_NAME,$fname,time()+36000);
							setcookie(USER_TABLE::$ROLE,$role,time()+36000);

							header('LOCATION: products.php');
						}
						else {
							echo "incorrect password";
						}
					}
					else 
						echo "unknown username.";
						
				}
				else {
					//print error information
					foreach ($error as $err){
						echo $err;
						echo "<br>";
					}
				}
			}
			else {   //register button was hit
				$role = $_POST[USER_TABLE::$ROLE];
				if (empty($role)) 
					echo "You forgot to select a role.";
				else
					header('LOCATION: register.php?'.USER_TABLE::$ROLE.'='.$role);
					
			}
		}
		?>
		</div>
	
		<div style = "padding: 50px 0px">
		<form action="" method="POST">
			<center><table>
				<tr>
					<td>Username:</td>
					<td><input type="text" name="<?php echo USER_TABLE::$USER_NAME; ?>"></td>					
				</tr>
				<tr>
					<td>Password:</td>
					<td><input type="password" name="<?php echo USER_TABLE::$PASS_WORD; ?>"></td>	
				</tr>
	
			</table></center>
			<div style="padding: 0px 450px" >
				<input type="submit" name="button" value="Login" >
			</div>
		</form>
		</div>
		
		<form action="" method="POST">
			<center><table>
		
				<tr>
					<td>Role:</td>
					<td><input type="radio" name="<?php echo USER_TABLE::$ROLE; ?>" value="<?php echo USER_TABLE::$ROLE_USER; ?>">Customer
              <input type="radio" name="<?php echo USER_TABLE::$ROLE; ?>" value="<?php echo USER_TABLE::$ROLE_VENDOR ?>">Vendor
					</td>	
				</tr>
			</table></center>
			<div style="padding: 0px 450px" >
				<input type="submit" name="button" value="Register" >
			</div>
		</form>
	</div>
	
  
	<div id="footer">
		<p style = "padding: 10px 250px; font-size: 12px">Copyright 2015 Monmouth University</p> 
	</div>

</div>

</body>
</html>






