<?php

/**
 * Show subject
 */
require_once '../../../private/initialize.php';

$page_title = "Subject Info";
require SHARED_PATH . '/staff_header.php';

$subject_id = $_GET['id'] ?? '';

$subject = getSubjectbyId($subject_id);
?>

<div id="content">

<div class="subject show">
<a class="back-link" href="<?php echo urlForPath('staff/subject/index.php'); ?>">Back to list</a>

<h1>Subject <?php echo h($subject['menu_name']); ?></h1>
<div class="attributes">   
<dl>
    <dt>Menu Name</dt>
    <dd><?php echo h($subject['menu_name']); ?></dd>
</dl>
<dl>
    <dt>Position</dt>
    <dd><?php echo h($subject['position']); ?></dd>
</dl>
<dl>
    <dt>Visible</dt>
    <dd><?php echo $subject['visible'] == 1 ? 'true' : 'false'; ?></dd>
</dl>
</div>
<hr />

<div class="pages listing">
<h2>Pages</h2>
<div class="actions">
	<a class="actions" href="<?php echo urlForPath('staff/page/new.php?subject_id=' . h(u($subject_id))); ?>">Create New Page</a>
</div>

<table class="list">
<tr>
	<th>ID</th>
	<th>Subject ID</th>
	<th>Position</th>
	<th>Visible</th>
	<th>Name</th>
	<th>&nbsp;</th>
	<th>&nbsp;</th>
	<th>&nbsp;</th>
	<th>&nbsp;</th>
</tr>

<?php
$page_set = getPagesBySubjectId($subject_id);
while ($page = mysqli_fetch_assoc($page_set)) {
    ?>
<tr>
    <td>
        <?php echo h($page['id']); ?>
    </td>
    <td>
        <?php echo h(getSubjectById($page['subject_id'])['menu_name']); ?>
    </td>
    <td>
        <?php echo h($page['position']); ?>
    </td>
    <td>
        <?php echo $page['visible'] == 1 ? 'true' : 'false'; ?>
    </td>
    <td>
        <?php echo h($page['menu_name']); ?>
    </td>
    <td>
        <a class="action" href="<?php echo urlForPath('staff/page/show.php?id=' . h(u($page['id']))); ?>">View</a>
    </td>
    <td>
        <a class="action" target="_blank" href="<?php echo urlForPath('index.php?preview=true&id=' . h(u($page['id']))); ?>">Preview</a>
    </td>
    <td>
        <a class="action" href="<?php echo urlForPath('staff/page/edit.php?id=' . h(u($page['id']))); ?>">Edit</a>
    </td>
    <td>
        <a class="action" href="<?php echo urlForPath('staff/page/delete.php?id=' . h(u($page['id']))); ?>">Delete</a>
    </td>
</tr>
<?php 
}
?>

</table>
</div>
</div>

</div>

<?php
mysqli_free_result($page_set);
require SHARED_PATH . '/staff_footer.php';