<?php

/**
 * New subject
 */
require_once '../../../private/initialize.php';

$page_title = 'New Subject';
require SHARED_PATH . '/staff_header.php';

?>

<div id="content">
<a class="back-link" href="<?php echo urlForPath('staff/subject/index.php'); ?>">
    Back to List
</a>

<?php
// On form submit
if (requestIsPost()) {
    $position = $_POST['position'] ?? die('Invalid form data');
    $visible = $_POST['visible'] ?? die('Invalid form data');
    $menu_name = $_POST['menu_name'] ?? die('Invalid form data');
	$form_errors = array();
	
    $id = createSubject($position, $visible, $menu_name);
    if (is_array($id)) {
        $form_errors = $id;
    }
    else {
        redirectToPath('/staff/subject/show.php?id=' . h(u($id)), 'Subject created successfully');
    }
}
?>
<div class="subject new">
<h1>Create Subject</h1>

<?php
$form_action_path = 'staff/subject/new.php';
$submit_button_text = 'Create Subject';
require SHARED_PATH . '/subject_form.php';
?>

</div>
</div>

<?php
require SHARED_PATH . '/staff_footer.php';