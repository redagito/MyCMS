<?php

/**
 * New subject
 */
require_once '../../../private/initialize.php';

$page_title = 'Edit Subject';
require SHARED_PATH . '/staff_header.php';

// Page id
if (!isset($_GET['id'])) {
    redirectToPath('staff/subject/index.php', 'Missing ID parameter');
}
$id = $_GET['id'];

if (requestIsPost()) {
    $menu_name = $_POST['menu_name'] ?? die('Missing parameters');
    $position = $_POST['position'] ?? die('Missing parameters');
    $visible = $_POST['visible'] ?? die('Missing parameters');
    $form_errors = array();
    $ret = updateSubjectValues($id, $position, $visible, $menu_name);
    if ($ret === true) {
        redirectToPath('staff/subject/show.php?id=' . h(u($id)), 'Updated subject successfully');
    }
    elseif (is_array($ret)) {
        $form_errors = $ret;
    }
    else {
        redirectToPath('staff/subject/index.php', 'Failed to update subject');
    }
}
else {
    $subject = getSubjectById($id);
    $menu_name = $subject['menu_name'];
    $position = $subject['position'];
    $visible = $subject['visible'];
}
?>

<div id="content">
<a class="back-link" href="<?php echo urlForPath('staff/subject/index.php'); ?>">
    Back to List
</a>

<div class="subject edit">
<h1><?php echo h($page_title); ?></h1>

<?php
$form_action_path = 'staff/subject/edit.php?id=' . h(u($id));
$submit_button_text = $page_title;
require SHARED_PATH . '/subject_form.php';
?>

</div>
</div>

<?php
require SHARED_PATH . '/staff_footer.php';