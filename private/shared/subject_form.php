<?php

/**
 * Subject form for new and edit
 */

if (!isset($form_action_path)) die('Missing form action path');
if (!isset($submit_button_text)) die('Missing submit button text');;

$menu_name = $menu_name ?? '';
$visible = $visible ?? 0;

// If position is not set, add an additional position
// and set it as default selection
$count = getSubjectCount();
if (!isset($position)) {
	$count++;
	$position = $count;
}

$form_errors = $form_errors ?? array();
echo displayErrors($form_errors);
?>

<form action="<?php echo h(urlForPath($form_action_path)); ?>" method="post">
<dl>
    <dt>Menu Name</dt>
    <dd><input type="text" name="menu_name" value="<?php echo h($menu_name); ?>" /></dd>
</dl>
<dl>
    <dt>Position</dt>
    <dd>
        <select name="position">
<?php
for ($i = 1; $i <= $count; $i++) {
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
<div id="operations">
    <input type="submit" value="<?php echo h($submit_button_text); ?>" />
</div>
</form>