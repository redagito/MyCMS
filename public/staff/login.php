<?php
require '../../private/initialize.php';

$username = '';
$password = '';
$form_errors = array();

if (requestIsPost()) {
	$username = $_POST['username'] ?? '';
	$password = $_POST['password'] ?? '';
	
	// Validation
	if (isBlank($username)) {
		$form_errors[] = 'Username cannot be blank.';
	}
	if (isBlank($password)) {
		$form_errors[] = 'Password cannot be blank.';
	}

	if (empty($form_errors)) {
		// Retrieve admin data
		$admin = getAdminByUsername($username);
	
		// Same message for all error conditions to prevent leaking information
		$login_failure_message = 'Log in was unsuccessfull.';
		// Check admin data and password
		if ($admin) {
			if (password_verify($password, $admin['hashed_password'])) {
				// Login successful
				loginAdmin($admin['id'], $admin['username']);
				redirectToPath('staff/index.php');
			} else {
				// User name found but password does not match
				$form_errors[] = $login_failure_message;
			}
		} else {
			// User name does not exist
			$form_errors[] = $login_failure_message;
		}
	}
}

$page_title = 'Login';
$require_login = false;
require SHARED_PATH . '/staff_header.php';
?>

<div id="content">
<h1>Login</h1>
<?php echo displayErrors($form_errors); ?>

<form action="login.php" method="post">

<dl>
	<dt>Username</dt>
	<dd>
	<input type="text" name="username" value="<?php echo h($username); ?>" />
	</dd>
</dl>
<dl>
	<dt>Password</dt>
	<dd>
	<input type="password" name="password" value="" />
	</dd>
</dl>
<dl>
	<dd>
	<input type="submit" name="submit" value="Submit" />
	</dd>
</dl>

</form>
</div>

<?php
require SHARED_PATH . '/staff_footer.php';