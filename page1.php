<?php 	
	echo '<link rel="stylesheet" type="text/css" href="style.css">'; 
	session_start();
	
	if(!(isset($_SESSION['login'])) || $_SESSION['login'] == '') 
		header("Location: login.php");
	
	// Code below this point only reachable when a user is logged in
?>
<html>
  <head>
    <title>Page 1</title>
  </head>
  <body>
    User logged in
    <P>
    <A HREF = logout.php>Log out</A>
  </body>
</html>