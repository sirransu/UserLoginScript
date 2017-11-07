<html>
  <head>
    <title>Sign in</title>
	<?php 	
		echo '<link rel="stylesheet" type="text/css" href="style.css">'; 
		$error_message = "";
		
		if ($_SERVER['REQUEST_METHOD'] == 'POST') {
			require '../../sqlConfig.php';
			$username = $_POST['username'];
			$password = $_POST['password'];
			
			$database = "login";
			$db_found = new mysqli(DB_SERVER, DB_USER, DB_PASS, $database);
			
			if($db_found) {
				$SQL = $db_found -> prepare('SELECT * FROM login WHERE L1 = ?');
				$SQL -> bind_param('s', $username);
				$SQL -> execute();
				$result = $SQL -> get_result();
				
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
				$error_message = "Database not found";
		}
		else {
			$username = "";
			$password = "";
		}
	?>
  </head>
  <body>
	<form name = "form1" method = "POST" action = "login.php">
	  Username: <input type = "TEXT" name = "username" value = "<?php print $username; ?>">
	  Password: <input type = "TEXT" name = "password" value = "<?php print $password; ?>">
	  <P align = center>
	    <input type = "SUBMIT" name = "Submit1" value = "SIGN IN">
	  </P>
	</form>
	<P>
	<?php 	
		print $error_message;
	?>
  </body>
</html>