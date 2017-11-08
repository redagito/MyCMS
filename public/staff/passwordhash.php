<?php

require_once '../../private/initialize.php';

requireAdminLogin();

if (!isset($_GET['pass'])) {
	redirectToPath('staff/index.php');
}
echo "<h1>Password Hash</h1>\n";
echo "<p>" . password_hash($_GET['pass'], PASSWORD_DEFAULT) . "<p>\n";
