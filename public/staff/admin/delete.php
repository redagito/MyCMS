<?php

/**
 * Delete form for admin
 */

require_once '../../../private/initialize.php';

// ID parameter always required
if (!isset($_GET['id'])) {
    redirectToPath('staff/admin/index.php', 'Missing ID parameter.');
}
$id = $_GET['id'];

// On form submit
if (requestIsPost()) {
	$result = deleteAdmin($id);
	if (is_array($result)) {
		$form_errors = §result;
	} else {
		redirectToPath('staff/admin/index.php', 'Admin deleted successfully.');
	}
}

$entry = getAdminById($id);

$page_title = 'Delete Admin';
require SHARED_PATH . '/staff_header.php';

?>

<div id="content">
<a class="back-link" href="<?php echo urlForPath('staff/admin/index.php'); ?>">Back to list</a>

<div class="admin delete">
<h1><?php echo h($page_title); ?></h1>
<?php echo displayErrors($form_errors); ?>

<p>Are you sure you want to delete this Admin?</p>
<p class="item"><?php echo h($entry['username']); ?></p>

<form action="<?php echo urlForPath('staff/admin/delete.php?id=' . h(u($entry['id']))); ?>" method="post">

<div id="operations">
<input type="submit" name="commit" value="Delete Admin" />
</div>
</div>
</div>

<?php
require SHARED_PATH . '/staff_footer.php';