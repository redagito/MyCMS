<?php

/**
 * Show admin
 */
require_once "../../../private/initialize.php";

$page_title = "Admin Info";
require SHARED_PATH . '/staff_header.php';

// Retrieve id
if (!isset($_GET['id'])) {
	redirectToPath('staff/admin/index.php', 'Missing ID parameter');
}
$id = $_GET['id'];

// Retrieve entry
$entry = getAdminById($id);
if (!$entry) {
    redirectToPath('staff/admin/index.php', 'Admin does not exist');
}
?>

<div id="content">
    <a class="back-link" href="<?php echo urlForPath('staff/admin/index.php'); ?>">Back to list</a>
	<div class="admin show">
    <h1>Admin <?php echo h($entry['username']); ?></h1>

	<div class="attributes">
    <dl>
        <dt>First Name<dt>
        <dd><?php echo h($entry['first_name']); ?></dd>
    </dl>
    <dl>
        <dt>Last Name<dt>
        <dd><?php echo h($entry['last_name']); ?></dd>
    </dl>
    <dl>
        <dt>E-Mail<dt>
        <dd><?php echo h($entry['email']); ?></dd>
    </dl>
    <dl>
        <dt>Username<dt>
        <dd><?php echo h($entry['username']); ?></dd>
    </dl>
    <dl>
        <dt>Password Hash<dt>
        <dd><?php echo h($entry['hashed_password']); ?></dd>
    </dl>
	</div>
	</div>
</div>

<?php
require SHARED_PATH . '/staff_footer.php';