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
						$approved = $row[USER_TABLE::$APPROVED];
						$locked = $row['locked'];
						$loginattempts = $row['loginattempts'];

						if ($pwd == $row[USER_TABLE::$PASS_WORD]){
							if($locked == 0){
							session_start();
							setcookie(USER_TABLE::$USER_NAME,$username,time()+36000);
							setcookie(USER_TABLE::$FIRST_NAME,$fname,time()+36000);
							setcookie(USER_TABLE::$ROLE,$role,time()+36000);
							setcookie(USER_TABLE::$APPROVED,$approved,time()+36000);
							header('LOCATION: products.php');
							}
							else{ //if the account has the right password but is locked
								$time = time(); //sets a time variable
								$logintime = $row['lastlogin']; //gets the information from the database about when this user last tried to log in
								$timediff = ($time) - ($logintime); // checks to see how much time there was between their current log in attempt and last log in attempt
								$secondsleft = 60-($timediff); //how many seconds are left until the account is unlocked
								if($timediff <=60){ //if the last log in attempt was less than 60 seconds ago and the account is locked, it will stay locked
									echo "The account is locked for another $secondsleft seconds.";
								}
								else{ //if the account has been locked longer than 60 seconds it lets the user log in properly
									$q = "UPDATE users SET loginattempts='0', lastlogin='$time', locked='0'
										WHERE username = '$username'";
						
									$r = mysqli_query($dbc, $q);
									session_start();
									setcookie(USER_TABLE::$USER_NAME,$username,time()+36000);
									setcookie(USER_TABLE::$FIRST_NAME,$fname,time()+36000);
									setcookie(USER_TABLE::$ROLE,$role,time()+36000);
									setcookie(USER_TABLE::$APPROVED,$approved,time()+36000);
									header('LOCATION: products.php');
								}
							}
						}
						else{ //if the password entered did not match the database
							if($locked == 0){ //if the account is not locked
								$time = time();
								$attempts = ($row['loginattempts'])+ 1; //keeps track of the log in attempts
								if($row['loginattempts'] == 2){ //if the user has already tried unsucessfully to log in twice
									$q1 = "UPDATE users SET loginattempts='0', lastlogin='$time', locked ='1'
									WHERE username = '$username'"; //a query that will reset the number of log in attempts, set the time to the current time for the last log in time and lock the account
								
									$r1 = mysqli_query($dbc, $q1); //runs the query 
								
									echo "The account has been locked";
								}
								else{ //if the user has tried unsucessfully to log in less than 2 times 
									$time = time();
									$q1 = "UPDATE users SET loginattempts='$attempts', lastlogin='$time', locked='0'
									WHERE username = '$username'";  //increments the log in attempts and sets the last log in time to the current time
					
									$r1 = mysqli_query($dbc, $q1);
							
									echo "incorrect password";
								}
							}
							else{ //if the account is locked and the user entered an incorrect password, calculates how much time is left and either says its locked, increments the log in attempts, 
								$time = time();
								$logintime = $row['lastlogin'];
								$timediff = ($time) - ($logintime);
								$secondsleft = 60-($timediff);
								if($timediff <=60){
									echo "The account is locked for another $secondsleft seconds.";
								}
								else{
									$time = time();
									$attempts = ($row['loginattempts'])+ 1;
									if($row['loginattempts'] == 2){
										$q1 = "UPDATE users SET loginattempts='0', lastlogin='$time', locked ='1'
											WHERE username = '$username'";
								
										$r1 = mysqli_query($dbc, $q1);
								
										echo "The account has been locked";
									}
									else{
										$time = time();
										$attempts = ($row['loginattempts'])+ 1;
										$q1 = "UPDATE users SET loginattempts='$attempts', lastlogin='$time', locked='0'
											WHERE uname = '$username'";
					
										$r1 = mysqli_query($dbc, $q1);
								
										echo "incorrect password";
									}
									
								}
							}
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






