<?php

/**
 * Staff header
 */

 // Default require admin user to be logged in
$require_login = $require_login ?? true;
$page_title = $page_title ?? 'Staff Area';

// Validate authorzed user
if ($require_login) {
	requireAdminLogin();
}

?>
<!doctype html>
<html lang="en">

<head>
<title>MyCMS - <?php echo h($page_title); ?></title>
<meta charset="utf-8">
<link rel="stylesheet" media="all" 
	href="<?php echo urlForPath('stylesheet/staff.css'); ?>"
/>
</head>

<body>
<header>
	<h1>Staff Area</h1>
</header>

<?php
if (isAdminLoggedIn()) { 
?>
<nav>
	<ul>
	<li>User: <?php echo h(getActiveUsername()); ?></li>
	<li><a href="<?php echo urlForPath('staff/index.php'); ?>">Menu</a></li>
	<li><a href="<?php echo urlForPath('staff/logout.php'); ?>">Logout</a></li>
	</ul>
</nav>
<?php 
}
?>

<?php
$message = retrieveRedirectMessage();
if (!isBlank($message)) {
	echo '<div id="message">' . h($message) . '</div>';
}
?>