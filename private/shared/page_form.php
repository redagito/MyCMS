<?php

/**
 * Page form for new and edit
 */

if (!isset($form_action_path)) die('Missing form action path');
if (!isset($submit_button_text)) die('Missing submit button text');;

$menu_name = $menu_name ?? '';
$subject_id = $subject_id ?? '';
$visible = $visible ?? 0;
$content = $content ?? '';

// If position is not set, add an additional position
// and set it as default selection
$page_count = getPageCountBySubjectId($subject_id);
if (!isset($position)) {
	$page_count++;
	$position = $page_count;
}

// Show any form errors from earlier submissions
$form_errors = $form_errors ?? array();
echo displayErrors($form_errors);
?>

<form action="<?php echo h(urlForPath($form_action_path)); ?>" method="post">
<dl>
    <dt>Menu Name</dt>
    <dd><input type="text" name="menu_name" value="<?php echo h($menu_name ?? ''); ?>" /></dd>
</dl>
<dl>
    <dt>Subject</dt>
    <dd>
        <select name="subject_id">
<?php
dbForEach('getAllSubjects', function ($result) {
    global $subject_id;
    echo '<option value="' . h($result['id']) . '"';
    echo $result['id'] == $subject_id ? ' selected="selected"' : '';
    echo '>' . h($result['menu_name']) . "</option>\n";
});
?>
        </select>
    </dd>
</dl>
<dl>
    <dt>Position</dt>
    <dd>
        <select name="position">
<?php
for ($i = 1; $i <= $page_count; $i++) {
    echo '<option value="' . $i . '"';
    echo $i == $position ? ' selected="selected"' : '';
    echo ">$i</option>\n";
}
?>
        </select>
    </dd>
</dl>
<dl>
    <dt>Visible</dt>
    <dd>
        <input type="hidden" name="visible" value="0" />
        <input type="checkbox" name="visible" value="1" <?php echo $visible == 1 ? ' checked="checked"' : ''; ?>/>
    </dd>
</dl>
<dl>
    <dt>Content</dt>
    <dd><textarea cols="80" rows="10" name="content"><?php echo h($content); ?></textarea></dd>
</dl>
<div id="operations">
    <input type="submit" value="<?php echo h($submit_button_text); ?>" />
</div>
</form>