<?php
require_once '../../../private/initialize.php';

$page_title = 'Edit Page';
require SHARED_PATH . '/staff_header.php';

// Page id
if (!isset($_GET['id'])) {
    redirectToPath('staff/page/index.php', 'Missing ID parameter');
}
$id = $_GET['id'];

if (requestIsPost()) {
    // From form submit
    $menu_name = $_POST['menu_name'] ?? die('Missing parameters');
    $subject_id = $_POST['subject_id'] ?? die('Missing parameters');
    $position = $_POST['position'] ?? die('Missing parameters');
    $visible = $_POST['visible'] ?? die('Missing parameters');
    $content = $_POST['content'] ?? die('Missing parameters');

    $ret = updatePage($id, $subject_id, $position, $visible, $menu_name, $content);
    if ($ret === true) {
        redirectToPath('staff/page/show.php?id=' . h(u($id)), 'Page updated successfully');
    }
    elseif (is_array($ret)) {
        $form_errors = $ret;
    }
    else {
        var_dump($ret);
        die("Unhandled return value");
    }
}
else {
    // Read from database
    $page = getPageById($id);
    $menu_name = $page['menu_name'];
    $subject_id = $page['subject_id'];
    $position = $page['position'];
    $visible = $page['visible'];
    $content = $page['content'];
}
?>

<div id="content">
<a class="back-link" href="<?php echo urlForPath('staff/subject/show.php?id=' . h(u($subject_id))); ?>">
	Back to Subject Page
</a>
<div class="page edit">
<h1><?php echo h($page_title); ?></h1>

<?php
$form_action_path = 'staff/page/edit.php?id=' . h(u($id));
$submit_button_text = $page_title;
require SHARED_PATH . '/page_form.php';
?>

</div>
</div>

<?php
require SHARED_PATH . '/staff_footer.php';