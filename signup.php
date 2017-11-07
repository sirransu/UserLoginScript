<?php 	
	echo '<link rel="stylesheet" type="text/css" href="style.css">'; 
	$error_message = "";
	$username = "";
	$password = "";
	
	if (isset($_POST['signin']))
		header ("Location: login.php");
	
	if ($_SERVER['REQUEST_METHOD'] == 'POST') {
		require '../../sqlConfig.php';
		$username = $_POST['username'];
		$password = $_POST['password'];
		$unameLength = strlen($username);
		$passLength = strlen($password);
		
		if($unameLength < 5 || $unameLength > 25)
			$error_message = "Invalid username length";
		else if ($passLength < 5 || $passLength > 255)
			$error_message = "Invalid password length";
		else {
			$db_found = new mysqli(DB_SERVER, DB_USER, DB_PASS, DB_NAME);

			if($db_found) {
				$SQLquery = $db_found -> prepare('SELECT * FROM login WHERE L1 = ?');
				$SQLquery -> bind_param('s', $username);
				$SQLquery -> execute();
				$result = $SQLquery -> get_result();
				
				if($result -> num_rows > 0) 
					$error_message = "Username already taken";
				else {
					$phash = password_hash($password, PASSWORD_DEFAULT);
					$SQLquery = $db_found -> prepare("INSERT INTO login (L1, L2) 
												VALUES (?, ?)");
					$SQLquery -> bind_param('ss', $username, $phash);
					$SQLquery -> execute(); // Reach this point to add information to database
					
					header ("Location: login.php");
				}
			}
			else
				$error_message = "Database not found";
		}
	}
?>

<html>
  <head>
    <title>Register</title>
  </head>
  <body>
	<H1 align = center>Register Account</H1>
	<form name = "form1" method = "POST" action = "signup.php">
	  <P align = center>Username: <input type = "TEXT" name = "username" value = "<?php print $username; ?>">
	  <P align = center>Password: <input type = "TEXT" name = "password" value = "<?php print $password; ?>">
	  <P align = center><input type = "SUBMIT" name = "register" value = "REGISTER">
		or <input type = "SUBMIT" name = "signin" value = "SIGN IN">
	</form>
	
	<P align = center>
	<?php 	
		print $error_message;
	?>
	
  </body>
</html>