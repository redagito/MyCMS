<?php

/**
 * MyCMS main page
 */

require_once '../private/initialize.php';

if (isset($_GET['id'])) {
	$page_id = $_GET['id'];

	// Preview requires admin user to be logged in
	$preview = false;
	if (isset($_GET['preview'])) {
		$preview = $_GET['preview'] === 'true' && isAdminLoggedIn() ? true : false;
	}
	
	// Only show visible pages, disabled in preview mode
	$visible_only = !$preview;

	// Preview mode enables viewing of invisible pages
	if ($preview) {
		$page = getPageById($page_id);
	} else {
		$page = getVisiblePageById($page_id);
	}

    if (!$page) {
        redirectToPath('index.php');
    }
    $subject_id = $page['subject_id'];
}

require SHARED_PATH . '/public_header.php';
?>

<div id="main">
<?php 
$current_page_id = $page_id ?? false;
require SHARED_PATH . '/public_navigation.php';
?>

<div id="page">

<?php
if (isset($page)) {
	$allowed_tags = '<br><img><a><p><div><h1><h2><h3><b><em><ul><li><strong>';
    echo strip_tags($page['content'], $allowed_tags);
} else {
    include SHARED_PATH . '/static_homepage.php';
}
?>

</div>
</div>

<?php
require SHARED_PATH . '/public_footer.php';