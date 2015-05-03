<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>Shopping Registration</title>
<meta http-equiv="content-type" content="text/html; charset=utf-8" />
</head>
<body>
	<div id = "container">
	<?php
    include("includes/sql_queries.php");
    include("includes/header.php");
  ?>

<div id="container">
	<div id="main" align="center">
		<div style="color:red">
		<?php 
			if(!isset($_GET[USER_TABLE::$ROLE])){
				header('LOCATION: products.php');
			}
      $role = $_GET[USER_TABLE::$ROLE];
      if($role != USER_TABLE::$ROLE_VENDOR
         && $role != USER_TABLE::$ROLE_USER) {
       header('LOCATION: products.php'); 
      }
			if($_SERVER['REQUEST_METHOD'] == 'POST'){			
				$username = $_POST[USER_TABLE::$USER_NAME]; //form data username,
				$psword = $_POST[USER_TABLE::$PASS_WORD];
				$psword2 = $_POST[USER_TABLE::$PASS_WORD2];
				$fname = $_POST[USER_TABLE::$FIRST_NAME];
				$lname = $_POST[USER_TABLE::$LAST_NAME];
				$address = $_POST[USER_TABLE::$ADDRESS];
				$city = $_POST[USER_TABLE::$CITY];
				$state = $_POST[USER_TABLE::$STATE];
				$zipcode = $_POST[USER_TABLE::$ZIP_CODE];
				$email = $_POST[USER_TABLE::$EMAIL];
				$phone = $_POST[USER_TABLE::$PHONE];
				$role = $_POST[USER_TABLE::$ROLE];
				
				$error = array(); //define an array
			
				if(empty($username)) $error[]= "You forgot to enter a user name.";
				if(empty($psword)) $error[]= "You forgot to enter a password.";
				if($psword != ($psword2)) $error[] ="The passwords do not match.";
				if(empty($fname) || is_numeric($fname) == true || $fname != 0) $error[]= "You did not enter a valid first name.";
				if(empty($lname) || is_numeric($lname) == true || $lname != 0) $error[]= "You did not enter a valid last name.";
				if(empty($address)) $error[]= "You forgot to enter an address.";
				if(empty($city) || is_numeric($city) == true || $city != 0) $error[]= "You did not enter a valid city";
				if(empty($state) || is_numeric($state) == true || $state != 0) $error[]= "You did not enter a valid state.";
				if(empty($zipcode)|| $zipcode == "0" || $zipcode < 0 || is_numeric($zipcode)== false ) $error[]= "You did not enter a valid zipcode";
				if(empty($email) || $email != 0) $error[]= "You did not enter a valid email.";
				if(empty($phone)|| $phone == "0") $error[]= "You did not enter a valid phone number.";
				
			
				if(empty($error)){				
					//1. connect to database
					include("dbc.php");
					//2. define a query(insert a record to users table)
					$q = 'INSERT INTO users ('.USER_TABLE::$USER_NAME.','
											.USER_TABLE::$FIRST_NAME.','
											.USER_TABLE::$LAST_NAME.','
											.USER_TABLE::$PASS_WORD.','
											.USER_TABLE::$ADDRESS.','
											.USER_TABLE::$CITY.','
											.USER_TABLE::$STATE.','
											.USER_TABLE::$ZIP_CODE.','
											.USER_TABLE::$EMAIL.','
											.USER_TABLE::$PHONE.','
											.USER_TABLE::$ROLE.') VALUES '
											.'(\''.$username.'\','
											.'\''.$fname.'\','
											.'\''.$lname.'\','
											.'SHA1(\''.$psword.'\'),'
											.'\''.$address.'\','
											.'\''.$city.'\','
											.'\''.$state.'\','
											.'\''.$zipcode.'\','
											.'\''.$email.'\','
											.'\''.$phone.'\','
											.'\''.$role.'\')';
					//3. execute the query
					$r = mysqli_query($dbc, $q);
					//4. Sanity check 
					if($r) {
						$subject = 'You Have Been Regestered!';
						$message = "Hi ". $fname . ' Thank you for registing at the Online Shipping System!';
						$headers = 'From: Online Shopping System' . "\r\n" .
    				'Reply-To: ' . "\r\n" .	'X-Mailer: PHP/' . phpversion();
						mail($email, $subject, $message, $headers);
						echo "Thank you for registering.";
					} else {
						echo "Something is wrong.";
					}
				}				
				else{
					foreach($error as $err){
						echo $err;
						echo"<br>";
					}
				}
			}
			
			
		?>
		</div>
		<form action="" method="POST">
			<table>
				<tr>
					<td>Username:</td>
					<td><input type="text" name="<?php echo USER_TABLE::$USER_NAME; ?>" 
					value = <?php if(isset($_POST['username'])) echo $_POST['username'] ?> ></td>
				</tr>
				<tr>
					<td>Password:</td>
					<td><input type="password" name="<?php echo USER_TABLE::$PASS_WORD; ?>" ></td> <!--input type "password" makes asteriks appear instead of the letters when typing-->
				</tr>
				<tr>
					<td>Confirm Password:</td>
					<td><input type="password" name="<?php echo USER_TABLE::$PASS_WORD2; ?>"></td> <!--input type "password" makes asteriks appear instead of the letters when typing-->
				</tr>
				<tr>
					<td>First Name:</td>
					<td><input type="text" name="<?php echo USER_TABLE::$FIRST_NAME; ?>"
					value = <?php if(isset($_POST['fname'])) echo $_POST['fname'] ?>> </td>
				</tr>
				<tr>
					<td>Last Name:</td>
					<td><input type="text" name="<?php echo USER_TABLE::$LAST_NAME; ?>"
					value = <?php if(isset($_POST['lname'])) echo $_POST['lname'] ?> ></td>
				</tr>
				<tr>
					<td>Address:</td>
					<td><input type="text" name="<?php echo USER_TABLE::$ADDRESS; ?>"
						value = <?php if(isset($_POST['address'])) echo $_POST['address'] ?>></td>
				</tr>
				<tr>
					<td>City:</td>
					<td><input type="text" name="<?php echo USER_TABLE::$CITY; ?>"
						value = <?php if(isset($_POST['city'])) echo $_POST['city'] ?>></td>
				</tr>
				<tr>
					<td>State:</td>
					<td>
					
						<?php 
							$state = array("NJ","PA","FL","MN","MO","NY");
							echo '<select name ="'.USER_TABLE::$STATE.'">'; //echo'd so the web browser can pick it up
								foreach($state as $st){
									echo '<option value = "'.$st.'"';
									if (isset($_POST['state'])) {
									if($st == $_POST['state']) echo 'selected = "selected"';
									}
									echo '>'.$st.'</option>';
								}
							echo '</select>';
					
							
						?>
					</td> 
				</tr>
				<tr>
					<td>Zipcode:</td>
					<td><input type="text" name="<?php echo USER_TABLE::$ZIP_CODE; ?>"
					value = <?php if(isset($_POST['zipcode'])) echo $_POST['zipcode'] ?>></td>
				</tr>
				<tr>
					<td>Email:</td>
					<td><input type="text" name="<?php echo USER_TABLE::$EMAIL; ?>"
					value = <?php if(isset($_POST['email'])) echo $_POST['email'] ?>></td>
				</tr>
				<tr>
					<td>Phone Number:</td>
					<td><input type="text" name="<?php echo USER_TABLE::$PHONE; ?>"
					value = <?php if(isset($_POST['phone'])) echo $_POST['phone'] ?>></td>
				</tr>
				<tr>
				<td></td>
				<td><input type="hidden" name="<?php echo USER_TABLE::$ROLE; ?>" value="<?php echo $role ?>"></td>
				</tr>
			
			</table>
			<div style="padding:0px 410px">
				<input type="submit" value="Register">  <!-- the input type submit means its a button, the value is what you see on the button-->
			</div>
		</form>
		<input type="button" onClick="parent.location='signin.php'" value="Back">
	</div>
	
	<div id="footer">
		<p style="text-align:center; color:white; font-size:12px;"> Copyright Monmouth University 2015</p>
	</div>
</div>

</body>



</html>