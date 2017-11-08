<?php
require_once '../../../private/initialize.php';

$page_title = 'Edit Admin';
require SHARED_PATH . '/staff_header.php';

// Admin id
if (!isset($_GET['id'])) {
    redirectToPath('staff/admin/index.php', 'Missing ID parameter');
}
$id = $_GET['id'];
$form_errors = array();

if (requestIsPost()) {
    // Edit admin form submit
    $first_name = $_POST['first_name'] ?? die('Missing parameters');
    $last_name = $_POST['last_name'] ?? die('Missing parameters');
    $email = $_POST['email'] ?? die('Missing parameters');
	$username = $_POST['username'] ?? die('Missing parameters');
	$password = $_POST['password'] ?? die('Missing parameters');
	$confirm_password = $_POST['confirm_password'] ?? die('Missing parameters');
	
	if (!isBlank($password) && $password !== $confirm_password) {
		$form_errors[] = 'Passwords fo not match';
	} else {
		// Prevent blank passwords
		$ret = updateAdmin($id, $first_name, $last_name, $email, $username, isBlank($password) ? NULL : $password);
		if ($ret === true) {
			redirectToPath('staff/admin/show.php?id=' . h(u($id)), 'Admin updated successfully');
		}
		elseif (is_array($ret)) {
			$form_errors = $ret;
		}
		else {
			redirectToPath('staff/admin/show.php?id=' . h(u($id)), 'Failed to update Admin');
		}
	}
}
else {
    // Read from database
	$entry = getAdminById($id);
	if ($entry === false) {
        redirectToPath('staff/admin/index.php', 'Admin not found');
	}

    $first_name = $entry['first_name'];
    $last_name = $entry['last_name'];
    $email = $entry['email'];
	$username = $entry['username'];
}
?>

<div id="content">
<a class="back-link" href="<?php echo urlForPath('staff/admin/index.php'); ?>">Back to List</a>
<div class="admin edit">
<h1><?php echo h($page_title); ?></h1>

<?php
$form_action_path = 'staff/admin/edit.php?id=' . h(u($id));
$submit_button_text = $page_title;
require SHARED_PATH . '/admin_form.php';
?>

</div>
</div>

<?php
require SHARED_PATH . '/staff_footer.php';