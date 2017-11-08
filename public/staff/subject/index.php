<?php

/**
 * Subject index
 */
require_once '../../../private/initialize.php';

// Subjects from db
$subject_set = getAllSubjects();

$page_title = "Subjects";
require SHARED_PATH . '/staff_header.php';

?>

<div id="content">
<div class="subjects listing">
<h1>Subjects</h1>
<div class="actions">
	<a class="actions" href="<?php echo urlForPath('staff/subject/new.php'); ?>">Create New Subject</a>
</div>

<table class="list">
	<tr>
		<th>ID</th>
		<th>Position</th>
		<th>Visible</th>
		<th>Name</th>
		<th>Pages</th>
		<th>&nbsp;</th>
		<th>&nbsp;</th>
		<th>&nbsp;</th>
	</tr>

<?php
while ($subject = mysqli_fetch_assoc($subject_set)) {
	$page_count = getPageCountBySubjectId($subject['id']);
?>
<tr>
	<td><?php echo h($subject['id']); ?></td>
	<td><?php echo h($subject['position']); ?></td>
	<td><?php echo $subject['visible'] == 1 ? 'true' : 'false'; ?></td>
	<td><?php echo h($subject['menu_name']); ?></td>
	<td><?php echo h($page_count); ?></td>
	<td>
		<a class="action" href="<?php 
								echo urlForPath('staff/subject/show.php?id=' . h(u($subject['id'])));
								?>">View
		</a>
	</td>
	<td><a class="action" href="<?php echo urlForPath('staff/subject/edit.php?id=' . h(u($subject['id']))); ?>">Edit</a></td>
	<td><a class="action" href="<?php echo urlForPath('staff/subject/delete.php?id=' . h(u($subject['id']))); ?>">Delete</a></td>
</tr>
<?php 
}
?>
</table>

</div>
</div>

<?php 
// Cleanup
mysqli_free_result($subject_set);

// Leave at end
require SHARED_PATH . '/staff_footer.php'; ?>