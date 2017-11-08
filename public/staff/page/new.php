<?php
require_once '../../../private/initialize.php';

$page_title = 'New Page';
require SHARED_PATH . '/staff_header.php';

// On form submit
if (requestIsPost()) {
	// Form values
	$menu_name = $_POST['menu_name'] ?? '';
	$subject_id = $_POST['subject_id'] ?? '';
	$position = $_POST['position'] ?? '';
	$visible = $_POST['visible'] ?? '';
	$content = $_POST['content'] ?? '';

    $id = createPage($subject_id, $position, $visible, $menu_name, $content);
    if (is_array($id)) {
        $form_errors = $id;
    }
    elseif ($id === false) {
        redirectToPath('staff/subject/show.php?id=' . h(u($subject_id)), "Failed to create page");
    }
    else {
        redirectToPath('staff/page/show.php?id=' . h(u($id)), "Page created successfully");
    }
} else {
	$subject_id = $_GET['subject_id'] ?? redirectToPath('staff/index.php', 'Missing ID parameter');
}
?>

<div id="content">
<a class="back-link" href="<?php echo urlForPath('staff/subject/show.php?id=' . h(u($subject_id))); ?>">
	Back to Subject Page
</a>
<div class="page new">

<h1>Create Page</h1>

<?php

// Page form parameters
$form_action_path = 'staff/page/new.php';
$submit_button_text = 'Create Page';
$selected_subject_id = $_GET['subject_id'] ?? NULL;

require SHARED_PATH . '/page_form.php';
?>

</div>
</div>

<?php
require SHARED_PATH . '/staff_footer.php';