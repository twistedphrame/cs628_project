<html xmlns = "http://www.w3.org/1999/xhtml">
<head>
	<title>CS628</title>
	<link rel = "stylesheet" href = "includes/style.css" type = "text/css" media = "screen" />
	<meta http-equiv = "content-type" content = "text/html; charset = utf-8" />
</head>

<body>
	<div id = "container">
	
	<div id="content" align='center'>	
		<?php 
			session_start();
			if(isset($_COOKIE['username'])){
				$username = $_COOKIE['username'];
				$fname = $_COOKIE['fname'];
				$role = $_COOKIE['role'];
			}
			else{
				header('LOCATION: signin.php');
			}
			include("includes/sql_queries.php");
      include("includes/header.php");
						
			function menu($arr,$name,$value){
				echo '<select name='.name.'>';
				
				foreach($arr as $ar){
					echo '<option value = "'.$ar.'"';
					if($ar ==$value) echo 'selected="selected"';
						echo '>'.$ar.'</option>';
						
				}
				echo '</select>';
				}
				
				include("dbc.php");
			
			
			
			if ($_SERVER['REQUEST_METHOD'] == 'POST'){
				$fname = $_POST['fname'];
				$lname = $_POST['lname'];
				$address = $_POST['address'];
				$city = $_POST['city'];
				$state = $_POST['state'];
				$zipcode = $_POST['zipcode'];
				$email = $_POST['email'];
				$phone = $_POST['phone'];
				$q = "UPDATE users SET fname='$fname', lname='$lname', address='$address', city='$city', state='$state', zipcode='$zipcode', email='$email', phone='$phone'
					WHERE username = '$username'";
					
				$r = mysqli_query($dbc, $q);
					
					if($r){
						echo "The information has been updated.";
					}
					else{
						echo"There was an error updating the information";
					}
				
				
			}
			else {
				$q = "SELECT * FROM users WHERE username = '$username'";
					
				$r = mysqli_query($dbc, $q);
					
				$num = mysqli_num_rows($r);
				
				if ($num == 1){
						$row = mysqli_fetch_array($r);
						$fname = $row['fname'];
						$lname = $row['lname'];
						$address = $row['address'];
						$city = $row['city'];
						$state = $row['state'];
						$zipcode = $row['zipcode'];
						$email = $row['email'];
						$phone = $row['phone'];
						
				}
				else{
					echo "There was an error loading user information";
				}
			}
				
		?>
		<div>
		<form action="" method="POST">
			<center><table>
				<tr>
					<td>First Name:</td>
					<td><input type="text" name="fname" value="<?php echo $fname ?>"></td>					
				</tr>
				<tr>
					<td>Last Name:</td>
					<td><input type="text" name="lname" value="<?php echo $lname ?>"></td>					
				</tr>
				<tr>
					<td>Address:</td>
					<td><input type="text" name="address" value="<?php echo $address ?>"></td>					
				</tr>
				<tr>
					<td>City:</td>
					<td><input type="text" name="city" value="<?php echo $city ?>"></td>					
				</tr>
				<tr>
					<td>State:</td>
					<td><input type="text" name="state" value="<?php echo $state ?>"></td>					
				</tr>
				<tr>
					<td>Zipcode:</td>
					<td><input type="text" name="zipcode" value="<?php echo $zipcode ?>"></td>					
				</tr>
				<tr>
					<td>Email:</td>
					<td><input type="text" name="email" value="<?php echo $email ?>"></td>					
				</tr>
				<tr>
					<td>Phone Number:</td>
					<td><input type="text" name="phone" value="<?php echo $phone ?>"></td>					
				</tr>
				
			</table> </center>
			<div style="padding: 0px 450px" >
				<input type="submit" name="button" value="Update" >
			</div>
		</form>
		</div>
	
	</div>
	
	<div id = "footer">
		<p>Copyright 2015 Monmouth University</p>
	</div>
	
	</div>
</body>
</html>