<html>
  <head>
    <title>Log out</title>
	<?php 	
		echo '<link rel="stylesheet" type="text/css" href="style.css">'; 
		session_start();
		session_destroy();
	?>
  </head>
  <body>
	User logged out
	<P>
    <A HREF = login.php>Return to login</A>
  </body>
</html>