<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>Class Registration</title>
<link rel="stylesheet" href="includes/style.css" type="text/css" media="screen" />
<meta http-equiv="content-type" content="text/html; charset=utf-8" />
</head>
<body>
	<div id = "container">
	<?php include("includes/header.html");?>

<div id="container">
	<div id="header">
	<h1 style ="padding:20px 100px">Online Shopping System Registration</h1>
	</div>
	
	<div id="main" align="center">
		<div style="color:red">
		<?php 
			if(isset($_GET['role'])){
				$role = $_GET['role'];
			}
			if($_SERVER['REQUEST_METHOD'] == 'POST'){
			
				$username = $_POST['username']; //form data username,
				$psword = $_POST['psword'];
				$psword2 = $_POST['psword2'];
				$fname = $_POST['fname'];
				$lname = $_POST['lname'];
				$address = $_POST['address'];
				$city = $_POST['city'];
				$state = $_POST['state'];
				$zipcode = $_POST['zipcode'];
				$email = $_POST['email'];
				$phone = $_POST['phone'];
				$role = $_POST['role'];
				
			
			
			
				$error = array(); //define an array
			
				if(empty($username)) $error[]= "You forgot to enter a user name.";
				if(empty($psword)) $error[]= "You forgot to enter a password.";
				if($psword != ($psword2)) $error[] ="The passwords do not match.";
				if(empty($fname)) $error[]= "You forgot to enter a first name.";
				if(empty($lname)) $error[]= "You forgot to enter a last name.";
				if(empty($address)) $error[]= "You forgot to enter an address.";
				if(empty($city)) $error[]= "You forgot to enter a city.";
				if(empty($state)) $error[]= "You forgot to enter a state.";
				if(empty($zipcode)) $error[]= "You forgot to enter a zipcode.";
				if(empty($email)) $error[]= "You forgot to enter an email.";
				if(empty($phone)) $error[]= "You forgot to enter a phone number.";
				
			
				if(empty($error)){
				
					//1. connect to database
					include("dbc.php");
					//2. define a query(insert a record to users table)
					$q = "INSERT INTO users (username,
											fname,
											lname,
											psword,
											address,
											city,
											state,
											zipcode,
											email,
											phone,
											role) VALUES 
											('$username',
											'$fname',
											'$lname',
											SHA1('$psword'),
											'$address',
											'$city',
											'$state',
											'$zipcode',
											'$email',
											'$phone',
											'$role')";
					//3. execute the query
					$r = mysqli_query($dbc, $q);
					//4. Sanity check 
					if($r) echo "Record is inserted into database.";
					else echo "Something is wrong.";
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
					<td><input type="text" name="username" 
					value = <?php if(isset($_POST['username'])) echo $_POST['username'] ?> ></td>
				</tr>
				<tr>
					<td>Password:</td>
					<td><input type="password" name="psword" ></td> <!--input type "password" makes asteriks appear instead of the letters when typing-->
				</tr>
				<tr>
					<td>Confirm Password:</td>
					<td><input type="password" name="psword2"></td> <!--input type "password" makes asteriks appear instead of the letters when typing-->
				</tr>
				<tr>
					<td>First Name:</td>
					<td><input type="text" name="fname"
					value = <?php if(isset($_POST['fname'])) echo $_POST['fname'] ?>> </td>
				</tr>
				<tr>
					<td>Last Name:</td>
					<td><input type="text" name="lname"
					value = <?php if(isset($_POST['lname'])) echo $_POST['lname'] ?> ></td>
				</tr>
				<tr>
					<td>Address:</td>
					<td><input type="text" name="address"></td>
				</tr>
				<tr>
					<td>City:</td>
					<td><input type="text" name="city"></td>
				</tr>
				<tr>
					<td>State:</td>
					<td>
					
						<?php 
							$state = array("NJ","PA","FL","MN","MO","NY");
							echo '<select name ="state">'; //echo'd so the web browser can pick it up
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
					<td><input type="text" name="zipcode"></td>
				</tr>
				<tr>
					<td>Email:</td>
					<td><input type="text" name="email"></td>
				</tr>
				<tr>
					<td>Phone Number:</td>
					<td><input type="text" name="phone"></td>
				</tr>
				<tr>
				<td></td>
				<td><input type="hidden" name="role" value="<?php echo $role ?>"></td>
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