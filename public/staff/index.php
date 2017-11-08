<?php

/**
 * Index
 */
require_once '../../private/initialize.php';
?>

<?php 
$page_title = "Staff Menu";
require SHARED_PATH . '/staff_header.php';
?>

<div id="content">
<div id="main-menu">
    <h2>Main Menu</h2>
    <ul>
    <li>
        <a href="<?php echo urlForPath('staff/subject/index.php'); ?> ">
            Subjects
        </a>
    </li>
    <li>
        <a href="<?php echo urlForPath('staff/admin/index.php'); ?> ">
            Admins
        </a>
    </li>
    </ul>
</div>
</div>

<?php require SHARED_PATH . '/staff_footer.php'; ?>