<?php

/**
 * Delete form for subject
 */

require_once '../../../private/initialize.php';

// ID parameter always required
if (!isset($_GET['id'])) {
    redirectToPath('staff/subject/index.php', 'Missing ID parameter');
}
$id = $_GET['id'];
$form_errors = array();

// On form submit
if (requestIsPost()) {
    $ret = deleteSubject($id);
    if (is_array($ret)) {
        $form_errors = $ret;
    }
    else {
        redirectToPath('staff/subject/index.php', 'Subject deleted successfully');
    }
}

$subject = getSubjectById($id);

$page_title = 'Delete Subject';
require SHARED_PATH . '/staff_header.php';

?>

<div id="content">
<a class="back-link" href="<?php echo urlForPath('staff/subject/index.php'); ?>">Back to list</a>

<div class="subject delete">
<h1><?php echo h($page_title); ?></h1>
<p>Are you sure you want to delete this subject?</p>
<p class="item"><?php echo h($subject['menu_name']); ?></p>

<?php echo displayErrors($form_errors); ?>
<form action="<?php echo urlForPath('staff/subject/delete.php?id=' . h(u($subject['id']))); ?>" method="post">

<div id="operations">
<input type="submit" name="commit" value="Delete Subject" />
</div>
</div>
</div>

<?php
require SHARED_PATH . '/staff_footer.php';