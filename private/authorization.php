<?php
/**
 * Manages login/logout for admin users
 */

 /**
  * Perform login for an admin.
  *
  * @param [type] $id
  * @return void
  */
function loginAdmin($id, $username)
{
	// Regenerate the ID to protect from session fixation
	session_regenerate_id();
	$_SESSION['admin_id'] = $id;
	$_SESSION['last_login'] = time();
	$_SESSION['username'] = $username;
}

function isAdminLoggedIn()
{
	return isset($_SESSION['admin_id']);
}

function requireAdminLogin()
{
	if (!isAdminLoggedIn()) {
		redirectToPath('staff/login.php', 'Authentication required.');
	}
}

function getActiveUsername()
{
	return $_SESSION['username'] ?? '';
}

function getActiveAdminId()
{
	return $_SESSION['admin_id'] ?? '';
}

function logoutAdmin()
{
	// Use unset or instead use
	// $_SESSION['admin_id'] = NULL;
	unset($_SESSION['admin_id']);
	unset($_SESSION['last_login']);
	unset($_SESSION['username']);
	// session_destroy();
}