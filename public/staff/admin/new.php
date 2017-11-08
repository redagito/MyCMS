<?php
require_once '../../../private/initialize.php';

$page_title = 'New Admin';
require SHARED_PATH . '/staff_header.php';

// Form values
$first_name = $_POST['first_name'] ?? '';
$last_name = $_POST['last_name'] ?? '';
$email = $_POST['email'] ?? '';
$username = $_POST['username'] ?? '';
$password = $_POST['password'] ?? '';
$confirm_password = $_POST['confirm_password'] ?? '';

// Errors
$form_errors = array();

// On form submit
if (requestIsPost()) {
	if ($password !== $confirm_password) {
		$form_errors[] = "Passwords do not match";
	} else {
		$id = createAdmin($first_name, $last_name, $email, $username, $password);
		if (is_array($id)) {
			$form_errors = $id;
		}
		elseif ($id === false) {
			redirectToPath('/staff/admin/index.php', "Failed to create admin");
		}
		else {
			redirectToPath('/staff/admin/show.php?id=' . h(u($id)), "Admin created successfully");
		}
	}
}
?>

<div id="content">
<a class="back-link" href="<?php echo urlForPath('staff/admin/index.php'); ?>">Back to List</a>
<div class="admin new">

<h1>Create Admin</h1>

<?php
// Page form
$form_action_path = 'staff/admin/new.php';
$submit_button_text = 'Create Admin';
require SHARED_PATH . '/admin_form.php';
?>

</div>
</div>

<?php
require SHARED_PATH . '/staff_footer.php';