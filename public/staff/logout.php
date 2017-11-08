<?php
/**
 * Logout functionality
 */

require '../../private/initialize.php';

requireAdminLogin();
logoutAdmin();

redirectToPath('staff/login.php', 'Logout successfull');