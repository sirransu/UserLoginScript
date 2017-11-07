<html>
  <head>
    <title>Register</title>
	<?php 	
		echo '<link rel="stylesheet" type="text/css" href="style.css">'; 
		$error_message = "";
		
		if ($_SERVER['REQUEST_METHOD'] == 'POST') {
			require '../../sqlConfig.php';
			$username = $_POST['username'];
			$password = $_POST['password'];
			$email = $_POST['email'];
			
			$database = "login";
			$db_found = new mysqli(DB_SERVER, DB_USER, DB_PASS, $database);
			
			if($db_found) {
				$SQL = $db_found -> prepare('SELECT * FROM login WHERE L1 = ?');
				$SQL -> bind_param('s', $username);
				$SQL -> execute();
				$result = $SQL -> get_result();
				
				if($result -> num_rows > 0) 
					$error_message = "Username already taken";
				else {
					$phash = password_hash($password, PASSWORD_DEFAULT);
					$SQL = $db_found -> prepare("INSERT INTO login (L1, L2, L3) 
												VALUES (?, ?, ?)");
					$SQL -> bind_param('sss', $username, $phash, $email);
					$SQL -> execute(); // Reach this point to add information to database
					
					header ("Location: login.php");
				}
			}
			else
				$error_message = "Database not found";
		}
		else {
			$username = "";
			$password = "";
			$email = "";
		}
		
		if (isset($_POST['signin']))
			header ("Location: login.php");
	?>
  </head>
  <body>
	<form name = "form1" method = "POST" action = "signup.php">
	  Username: <input type = "TEXT" name = "username" value = "<?php print $username; ?>">
	  Password: <input type = "TEXT" name = "password" value = "<?php print $password; ?>">
	  Email: <input type = "TEXT" name = "email" value = "<?php print $email; ?>">
	  <P align = center>
	    <input type = "SUBMIT" name = "register" value = "REGISTER">
	  </P>
	  <P align = center>
	    <input type = "SUBMIT" name = "signin" value = "SIGN IN">
	  </P>
	</form>
	<P>
	<?php 	
		print $error_message;
	?>
  </body>
</html>