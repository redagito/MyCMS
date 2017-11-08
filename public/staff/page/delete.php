<?php

/**
 * Delete form for page
 */

require_once '../../../private/initialize.php';

// ID parameter always required
if (!isset($_GET['id'])) {
    redirectToPath('staff/index.php', 'Missing ID parameter.');
}

$id = $_GET['id'];
$page = getPageById($id);
if (!$page) {
    redirectToPath('staff/index.php', 'Page does not exist.');
}

// On form submit
if (requestIsPost()) {
    deletePage($id);
    redirectToPath('staff/subject/show.php?id=' . h(u($page['subject_id'])), 'Page deleted successfully.');
}

$page_title = 'Delete Page';
require SHARED_PATH . '/staff_header.php';

?>

<div id="content">
<a class="back-link" href="<?php echo urlForPath('staff/subject/show.php?id=' . h(u($page['subject_id']))); ?>">
	Back to Subject Page
</a>

<div class="page delete">
<h1><?php echo h($page_title); ?></h1>
<p>Are you sure you want to delete this page?</p>
<p class="item"><?php echo h($page['menu_name']); ?></p>

<form action="<?php echo urlForPath('staff/page/delete.php?id=' . h(u($page['id']))); ?>" method="post">

<div id="operations">
<input type="submit" name="commit" value="Delete Page" />
</div>
</div>
</div>

<?php
require SHARED_PATH . '/staff_footer.php';