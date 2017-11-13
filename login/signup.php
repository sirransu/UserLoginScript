<?php 	
	if (isset($_POST['signin']))
		header ("Location: login.php");
	
	if ($_SERVER['REQUEST_METHOD'] == 'POST') {
		
		require '../../sqlConfigH.php';
		
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
					$SQLquery = $db_found -> prepare("INSERT INTO login (L1, L2) VALUES (?, ?)");
					$SQLquery -> bind_param('ss', $username, $phash);
					$SQLquery -> execute(); // Reach this point to add information to database
					
					header ("Location: login.php");
				}
			}
			else
				$error_message = "Database not found";
		}
	}
	else {
		$error_message = "";
		$username = "";
		$password = "";
	}
?>

<html>
  <head>
    <title>Register</title>
	<?php echo '<link rel="stylesheet" type="text/css" href="css/style.css">'; ?>
  </head>
  <body>
	<h1 ALIGN = CENTER>Register Account</h1>
	<form NAME = "form1" METHOD = "POST" ACTION = "signup.php">
	  <p ALIGN = CENTER> Username: 
	  <input TYPE = "text" NAME = "username" VALUE = "<?php print $username; ?>">
	  <p ALIGN = CENTER> Password: 
	  <input TYPE = "password" NAME = "password" VALUE = "<?php print $password; ?>">
	  <p ALIGN = CENTER>
	  <input TYPE = "submit" NAME = "register" VALUE = "REGISTER"> or
	  <input TYPE = "submit" NAME = "signin" VALUE = "SIGN IN">
	</form>
	<p ALIGN = center>
	<?php print $error_message; ?>
  </body>
</html>
