<?php 	
	session_start();
	session_destroy();
?>

<html>
  <head>
    <title>Log out</title>
	<?php echo '<link rel="stylesheet" type="text/css" href="css/style.css">'; ?>
  </head>
  <body>
	User logged out
	<p>
    <a HREF = login.php>Return to login</a>
  </body>
</html>
