<?php 	
	session_start();
	
	if(!(isset($_SESSION['login'])) || $_SESSION['login'] == '') 
		header("Location: login.php");
	
	$user = "User"; // Placeholder for username printing
	$welcome = "Welcome, ";
	
	// Code below this point only reachable when a user is logged in
?>

<html>
  <head>
    <title>Page 1</title>
	<?php echo '<link rel="stylesheet" type="text/css" href="css/style.css">'; ?>
  </head>
  <body>
    User logged in
    <p>
	<h2> <?php print($welcome . $user . ".") ?> </h2>
	<p>
    <a HREF = logout.php>Log out</a>
  </body>
</html>
