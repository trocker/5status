<?php
require_once('/../../lib/wrappers/functions.php');
require_once('/../../lib/wrappers/session.php');
require_once('/../../lib/wrappers/db.php');
require_once('/../../lib/wrappers/user.php');

if($session->is_logged_in()) {
  redirect_to("/../../lib/index.html");
}

if (isset($_POST['submit'])) { // Form has been submitted.

  $username = trim($_POST['username']);
  $password = trim($_POST['password']);
  
  // Check database to see if username/password exist.
	$found_user = User::authenticate($username, $password);
	
  if ($found_user) {
    $session->login($found_user);
    redirect_to("/../../lib/index.html");
  } else {
    // username/password combo was not found in the database
    $message = "Username/password combination incorrect.";
  }
  
} else { // Form has not been submitted.
  $username = "";
  $password = "";
}

?>

<html>
  <head>
    <title>5status</title>
  </head>
  <body>
    <div id="header">
      <h1>User Login</h1>
    </div>
    <div id="main">


		<h2>Login</h2>
		<?php echo output_message($message); ?>

		<form action="login.php" method="post">
		  <table>
		    <tr>
		      <td>Username:</td>
		      <td>
		        <input type="text" name="username" maxlength="30" value="<?php echo htmlentities($username); ?>" />
		      </td>
		    </tr>
		    <tr>
		      <td>Password:</td>
		      <td>
		        <input type="password" name="password" maxlength="30" value="<?php echo htmlentities($password); ?>" />
		      </td>
		    </tr>
		    <tr>
		      <td colspan="2">
		        <input type="submit" name="submit" value="Login" />
		      </td>
		    </tr>
		  </table>
		</form>
    </div>
    <div id="footer">Copyright <?php echo date("Y", time()); ?></div>
  </body>
</html>