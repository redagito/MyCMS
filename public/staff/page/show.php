<?php

/**
 * Show page
 */
require_once "../../../private/initialize.php";

$page_title = "Page Info";
require SHARED_PATH . '/staff_header.php';

// Retrieve id
if (!isset($_GET['id'])) {
	redirectToPath('staff/page/index.php', 'Missing ID parameter');
}
$id = $_GET['id'];

// Get page data
$page = getPageById($id);
if (!$page) {
    redirectToPath('staff/page/index.php', 'Page not found');
}
$subject_name = getSubjectById($page['subject_id'])['menu_name'];

?>

<div id="content">
	<a class="back-link" href="<?php echo urlForPath('staff/subject/show.php?id=' . h(u($page['subject_id']))); ?>">
		Back to Subject Page
	</a>
	<div class="page show">
    <h1>Page <?php echo h($page['menu_name']); ?></h1>

	<div class="action">
	<a class="action" target="_blank" href="<?php echo urlForPath('index.php?preview=true&id=' . h(u($id))); ?>">Preview</a>
	</div>

	<div class="attributes">
    <dl>
        <dt>Menu Name<dt>
        <dd><?php echo h($page['menu_name']); ?></dd>
    </dl>
    <dl>
        <dt>Subject<dt>
        <dd><?php echo h($subject_name); ?></dd>
    </dl>
    <dl>
        <dt>Position<dt>
        <dd><?php echo h($page['position']); ?></dd>
    </dl>
    <dl>
        <dt>Visible</dt>
        <dd><?php echo $page['visible'] == 1 ? 'true' : 'false'; ?></dd>
    </dl>
    <dl>
        <dt>Content</dt>
        <dd><textarea cols=80 rows=10 readonly="readonly"><?php echo h($page['content']); ?></textarea></dd>
    </dl>
	</div>
	</div>
</div>

<?php
require SHARED_PATH . '/staff_footer.php';