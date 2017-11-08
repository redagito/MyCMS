<?php

/**
 * Admin form for new and edit
 */

if (!isset($form_action_path)) die('Missing form action path');
if (!isset($submit_button_text)) die('Missing submit button text');;

// Form fields
$first_name = $first_name ?? '';
$last_name = $last_name ?? '';
$email = $email ?? '';
$username = $username ?? '';

// Errors
$form_errors = $form_errors ?? array();

// Show any form errors from earlier submissions
echo displayErrors($form_errors);
?>
<form action="<?php echo h(urlForPath($form_action_path)); ?>" method="post">
<dl>
    <dt>First Name</dt>
    <dd><input type="text" name="first_name" value="<?php echo h($first_name); ?>" /></dd>
</dl>
<dl>
    <dt>Last Name</dt>
    <dd><input type="text" name="last_name" value="<?php echo h($last_name); ?>" /></dd>
</dl>
<dl>
    <dt>E-Mail</dt>
    <dd><input type="text" name="email" value="<?php echo h($email); ?>" /></dd>
</dl>
<dl>
    <dt>Username</dt>
    <dd><input type="text" name="username" value="<?php echo h($username); ?>" /></dd>
</dl>
<p>
Passwords must have a length of at least 8 characters and contain at least one number, 
uppercase letter, lowercase letter and special character.
</p>
<dl>
    <dt>Password</dt>
    <dd><input type="password" name="password" value="" /></dd>
</dl>
<dl>
    <dt>Confirm Password</dt>
    <dd><input type="password" name="confirm_password" value="" /></dd>
</dl>
<div id="operations">
    <input type="submit" value="<?php echo h($submit_button_text); ?>" />
</div>
</form>