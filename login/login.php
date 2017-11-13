<?php 	
	session_start();
						
	if (isset($_POST['register']))
		header ("Location: signup.php");
	
	if ($_SERVER['REQUEST_METHOD'] == 'POST') {
		
		require '../../sqlConfigH.php';
		
		$username = $_POST['username'];
		$password = $_POST['password'];
		
		$db_found = new mysqli(DB_SERVER, DB_USER, DB_PASS, DB_NAME);

		if($db_found) {
			
			$SQLquery = $db_found -> prepare('SELECT * FROM login WHERE L1 = ?');
			$SQLquery -> bind_param('s', $username);
			$SQLquery -> execute();
			$result = $SQLquery -> get_result();
			
			if($result -> num_rows == 1) {
				
				$db_field = $result -> fetch_assoc();
				
				if(password_verify($password, $db_field['L2'])) {
					
					$_SESSION['login'] = "1";
					
					header("Location: page1.php");
				}
				else {
					$error_message = "Invalid login";
					$_SESSION['login'] = '';
				}
			}	
			else 
				$error_message = "Username not found";
		}
		else
			$error_message = "Error: Database not found";
	}
	else {
		$error_message = "";
		$username = "";
		$password = "";
	}
?>

<html>
  <head>
    <title>Sign in</title>
	<?php echo '<link rel="stylesheet" type="text/css" href="css/style.css">'; ?>
  </head>
  <body>
  	<h1 ALIGN = CENTER>Sign in</h1>
	<form name = "form1" METHOD = "POST" ACTION = "login.php">
	  <p ALIGN = CENTER> Username: 
	  <input TYPE = "text" NAME = "username" VALUE = "<?php print $username; ?>">
	  <p ALIGN = CENTER> Password: 
	  <input TYPE = "password" NAME = "password" VALUE = "<?php print $password; ?>">
	  <p ALIGN = CENTER> 
	  <input TYPE = "submit" NAME = "signin" VALUE = "SIGN IN"> or
	  <input TYPE = "submit" NAME = "register" VALUE = "REGISTER">
	</form>
	<p ALIGN = CENTER>
	<?php print $error_message; ?>
  </body>
</html>
