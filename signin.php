<html>
<head>
	<title>CS628</title>
	<link rel = "stylesheet" href = "includes/style.css" type = "text/css" media = "screen" />
	

</head>

<body>
	
<div id="container">
	<div id="header">
		<?php include("includes/header.html"); ?>
	</div>
	
	<div id="content">
		<div style="color: red;">
		<?php
		if ($_SERVER['REQUEST_METHOD'] == 'POST'){
			if($_POST['button']=='Login'){
				$username = $_POST['username'];
				$psword = $_POST['psword'];
			
				$error = array();
		
				if(empty($username)) $error[]= "You forgot to enter user name.";
				if(empty($psword)) $error[]= "You forgot to enter password.";
			
				if(empty($error)) {
					include("dbc.php");
					
					$q = "SELECT * FROM users WHERE username = '$username'";
					
					$r = mysqli_query($dbc, $q);
					
					$num = mysqli_num_rows($r);
					
					if ($num == 1){
						$row = mysqli_fetch_array($r);
						$fname = $row['fname'];
						$pwd = SHA1($psword);
						$role = $row['role'];
						
						echo $pwd;
						
						if ($pwd == $row['psword']){
							session_start();
							
							
							setcookie('username',$username,time()+36000);
							setcookie('fname',$fname,time()+36000);
							setcookie('role',$role,time()+36000);
							 
							
							
							header('LOCATION: index.php');
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
				$role = $_POST['role'];
				if (empty($role)) 
					echo "You forgot to select a role.";
				else
					header('LOCATION: register.php?role='.$role);
					
			}
		}
		?>
		</div>
	
		<div style = "padding: 50px 0px">
		<form action="" method="POST">
			<center><table>
				<tr>
					<td>Username:</td>
					<td><input type="text" name="username"></td>					
				</tr>
				<tr>
					<td>Password:</td>
					<td><input type="password" name="psword"></td>	
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
					<td><input type="radio" name="role" value="Customer">Customer
						<input type="radio" name="role" value="Admin">Admin
						<input type="radio" name="role" value="Vendor">Vendor
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






