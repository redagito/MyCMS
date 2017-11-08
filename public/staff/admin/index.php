<?php

/**
 * Shows list of admins
 */

require_once '../../../private/initialize.php';

$page_title = 'Admins';
require SHARED_PATH . '/staff_header.php';

?>

<div id="content">
<div class="admins listing">
<h1><?php echo h($page_title); ?></h1>

<div class="actions">
	<a class="actions" href="<?php echo urlForPath('staff/admin/new.php'); ?>">Create New Admin</a>
</div>

<table class="list">
	<tr>
		<th>ID</th>
		<th>First Name</th>
		<th>Last Name</th>
		<th>E-Mail</th>
		<th>Username</th>
		<th>&nbsp;</th>
		<th>&nbsp;</th>
		<th>&nbsp;</th>
	</tr>

<?php
$result_set = getAllAdmins();
while ($entry = mysqli_fetch_assoc($result_set)) {
    ?>
<tr>
    <td>
        <?php echo h($entry['id']); ?>
    </td>
    <td>
        <?php echo h($entry['first_name']); ?>
    </td>
    <td>
        <?php echo h($entry['last_name']); ?>
    </td>
    <td>
        <?php echo h($entry['email']); ?>
    </td>
    <td>
        <?php echo h($entry['username']); ?>
    </td>
    <td>
        <a class="action" href="<?php echo urlForPath('staff/admin/show.php?id=' . h(u($entry['id']))); ?>">View</a>
    </td>
    <td>
        <a class="action" href="<?php echo urlForPath('staff/admin/edit.php?id=' . h(u($entry['id']))); ?>">Edit</a>
    </td>
    <td>
        <a class="action" href="<?php echo urlForPath('staff/admin/delete.php?id=' . h(u($entry['id']))); ?>">Delete</a>
    </td>
</tr>
<?php 
}
?>

        </table>
    </div>
</div>

<?php 
mysqli_free_result($result_set);

require SHARED_PATH . '/staff_footer.php';