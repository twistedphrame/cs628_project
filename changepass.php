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


			//retrieve session data
			$username = $_COOKIE['username']; // retrieves the session variables, the username and first name of the user
			$fname = $_COOKIE['fname'];
			
			
		
			include("dbc.php");
			
			
			
			if ($_SERVER['REQUEST_METHOD'] == 'POST'){
				
				$password = $_POST['password']; // retrieves the variables from their corresponding text boxes that they were entered into 
				$pass1 = $_POST['pass1'];
				$pass2 = $_POST['pass2'];
				$q = "SELECT * FROM users WHERE username = '$username'"; //creates a query that returns the information corresponding to the user that is accessing the page
				$r = mysqli_query($dbc, $q); //runs the query	
					
				$num = mysqli_num_rows($r);
				$row = mysqli_fetch_array($r); //creates a variable that stores the information returned from the query
				
				if ((SHA1($password)) == $row['psword']){ //checks to see if the password entered as their current password matches what is stored in the database
					if($pass1 == $pass2){ //if the current password matches what's stored in the data base, this checks to see if the new passwords that are entered match
						if((SHA1($pass1)) != $row['psword']){
							$pass1 = SHA1($pass1); //hexes the password so it will be in the right form in the database
							$q = "UPDATE users SET psword='$pass1' WHERE username = '$username'"; //creates a query to update the password
							
							$r = mysqli_query($dbc, $q); //runs the query
						
							if($r){ //if it runs successfully it outputs that it was run, and the password has changed
								echo "The password has been changed successfully.";
							}
							else{ //outputs an error message if it has not
								echo"There was an error changing the password";
							}
						}
						else{
							echo "The password that you entered is the old password, please pick a new password";
						}
					}
					else{ //outputs this if the two passwords that the user is trying to do not match
						echo "The passwords that were entered do not match";
					}
				}
				else{ //outputs this if what the user entered as his or her current password does not match what is stored in the database
					echo "The password that you entered is incorrect";
				}
			}
		?>
		<div>
		<form action="" method="POST">
			<center><table>  <!-- creates the table with 3 text input boxes-->
				<tr>
					<td>Current Password:</td>
					<td><input type="password" name="password"></td>					
				</tr>
				<tr>
					<td>New Password:</td>
					<td><input type="password" name="pass1"></td>					
				</tr>
				<tr>
					<td>New Password:</td>
					<td><input type="password" name="pass2"></td>					
				</tr>
				
			</table> </center>
			<div style="padding: 0px 450px" > <!-- creates the update button-->
				<input type="submit" name="button" value="Update Password" >
			</div>
		</form>
		</div>
	
	</div>
	
	<div id="footer">
		<p style="text-align:center; color:white; font-size:12px;"> Copyright Monmouth University 2015</p>
	</div>
	
	</div>
</body>
</html>