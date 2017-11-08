<?php

/**
 * Public navigation
 */

$subject_id = $subject_id ?? false;
$page_id = $page_id ?? false;
$preview = $preview ?? false;
$visible_only = $visible_only ?? true;
?>

<nav>
<ul class="subjects">
<?php
dbForEachResult(getAllSubjects($visible_only), function ($subject) {
	global $subject_id;
	global $visible_only;

    if (($subject_id !== false) && ($subject_id == $subject['id'])) {
        echo '<li class="selected">';
    } else {
        echo '<li>';
    }
	echo "\n";
	$first_page = getFirstPageBySubjectId($subject['id'], $visible_only);
    echo htmlLink('index.php?id=' . h(u($first_page['id'])), $subject['menu_name']);

    // Only print pages for selected subject
    if (($subject_id !== false) && ($subject_id == $subject['id'])) {
        // Pages
        echo '<ul class="pages">';
        // Print all pages
        dbForEachResult(getPagesBySubjectId($subject['id'], $visible_only), function($page) {
            global $page_id;
			global $visible_only;

            if (($page_id !== false) && ($page_id == $page['id'])) {
                echo '<li class="selected">';
            } else {
                echo '<li>';
            }
            echo "\n";
            echo htmlLink('index.php?id=' . h(u($page['id'])), $page['menu_name']);
            echo "</li>\n";
        });
        echo "</ul>\n";
    }
    echo "</li>\n";
});
?>
</ul>
</nav>