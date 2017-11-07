<?php 	
	echo '<link rel="stylesheet" type="text/css" href="style.css">'; 
	$error_message = "";
	$username = "";
	$password = "";
	
	if (isset($_POST['register']))
		header ("Location: signup.php");
	
	if ($_SERVER['REQUEST_METHOD'] == 'POST') {
		require '../../sqlConfig.php';
		$username = $_POST['username'];
		$password = $_POST['password'];
		
		$db_found = new mysqli(DB_SERVER, DB_USER, DB_PASS, DB_NAME);

		if($db_found) {
			$SQLquery = $db_found -> prepare('SELECT * FROM login WHERE L1 = ?');
			$SQLquery -> bind_param('s', $username);
			$SQLquery -> execute();
			$result = $SQLquery  -> get_result();
			
			if($result -> num_rows == 1) {
				$db_field = $result -> fetch_assoc();
				
				if(password_verify($password, $db_field['L2'])) {
					session_start();
					$_SESSION['login'] = "1";
					header("Location: page1.php");
				}
				else {
					$error_message = "Invalid login";
					session_start();
					$_SESSION['login'] = '';
				}
			}	
			else 
				$error_message = "Username not found";
		}
		else
			$error_message = "Error: Database not found";
		
	}
?>
<html>
  <head>
    <title>Sign in</title>
  </head>
  <body>
  	<H1 align = center>Sign in</H1>
	<form name = "form1" method = "POST" action = "login.php">
	  <P align = center>Username: <input type = "TEXT" name = "username" value = "<?php print $username; ?>">
	  <P align = center>Password: <input type = "TEXT" name = "password" value = "<?php print $password; ?>">
	  <P align = center> <input type = "SUBMIT" name = "signin" value = "SIGN IN">
	  or <input type = "SUBMIT" name = "register" value = "REGISTER">
	</form>
	
	<P align = center>
	<?php 	
		print $error_message;
	?>
  </body>
</html>
