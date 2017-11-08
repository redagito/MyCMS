<?php
/**
 * Query functions for admin table
 */

function validateAdmin($id, $first_name, $last_name, $email, $username, $password)
{
	$errors = array();
	
    // first_name
    if (isBlank($first_name)) {
        $errors[] = 'First name can not be blank.';
    }
    elseif (!hasLength($first_name, ['min' => 2, 'max' => 255])) {
        $errors[] = 'First name must be between 2 and 255 characters.';
	}
	
    // last_name
    if (isBlank($first_name)) {
        $errors[] = 'Last name can not be blank.';
    }
    elseif (!hasLength($first_name, ['min' => 2, 'max' => 255])) {
        $errors[] = 'Last name must be between 2 and 255 characters.';
	}
	
	// email
    if (isBlank($email)) {
        $errors[] = 'E-Mail can not be blank.';
    }
    elseif (!hasLength($email, ['max' => 255])) {
        $errors[] = 'E-Mail must have less than 255 characters.';
	}
	elseif (!isValidEMailFormat($email)) {
		$errors[] = 'E-Mail does not have a valid format.';
	}

    // username
    if (isBlank($username)) {
        $errors[] = "Username can not be blank.";
    }
    elseif (!hasLength($username, ['min' => 4, 'max' => 255])) {
        $errors[] = "Username must be between 4 and 255 characters.";
	}
	elseif (($admin = getAdminByUsername($username)) !== false
		&& (!isset($id) || ($admin['id'] !== $id))) {
		$errors[] = "Username already exists.";
	}

    // password
    if (isset($password)) {
		if (isBlank($password)) {
			$errors[] = "Password can not be blank.";
		} elseif (!hasLength($password, ['min' => 8, 'max' => 255])) {
			$errors[] = "Password must be between 8 and 255 characters.";
		} else {
			if (!preg_match("#[a-z]+#", $password)) {
				$errors[] = "Password must contain at least one lowercase character.";
			}
		
			if (!preg_match("#[A-Z]+#", $password)) {
				$errors[] = "Password must contain at least one uppercase character.";
			} 
			
			if (!preg_match("#[0-9]+#", $password)) {
				$errors[] = "Password must contain at least one number.";
			}
	
			if (!preg_match('/[\'\/~`\!@#\$%\^&\*\(\)_\-\+=\{\}\[\]\|;:"\<\>,\.\?\\\]/', $password)) {
				$errors[] = "Password must contain at least one special character.";
			}
		}
	}
	
	return $errors;
}

function selectAllFromAdmin()
{
	return "SELECT id, first_name, last_name, email, username, hashed_password FROM admin";
}

function getAllAdmins()
{
	global $db;
	
	$sql = selectAllFromAdmin();
	$sql .= " ORDER BY last_name ASC, first_name ASC";
	return dbQuery($db, $sql);
}

function getAdminById($id)
{
	global $db;

	if (isBlank($id)) return false;

	$sql = selectAllFromAdmin();
	$sql .= " WHERE id = '" . dbEscape($db, $id) . "'";
	$sql .= " LIMIT 1";
	return dbSelectSingle($db, $sql);
}

function getAdminByUsername($username)
{
	global $db;

	if (isBlank($username)) return false;
	
	$sql = selectAllFromAdmin();
	$sql .= " WHERE username = '" . dbEscape($db, $username) . "'";
	$sql .= " LIMIT 1";
	return dbSelectSingle($db, $sql);
}

function createAdmin($first_name, $last_name, $email, $username, $password)
{
	global $db;

    $errors = validateAdmin(NULL, $first_name, $last_name, $email, $username, $password);
    if (!empty($errors)) {
        return $errors;
	}
	
	// Hash password
	$hashed_password = password_hash($password, PASSWORD_DEFAULT);

	$sql = "INSERT INTO admin(first_name, last_name, email, username, hashed_password) VALUES(";
    $sql .= "'" . dbEscape($db, $first_name) . "'";
    $sql .= ", '" . dbEscape($db, $last_name) . "'";
    $sql .= ", '" . dbEscape($db, $email) . "'";
    $sql .= ", '" . dbEscape($db, $username) . "'";
    $sql .= ", '" . dbEscape($db, $hashed_password) . "'";
	$sql .= ")";
	return dbInsert($db, $sql);
}

function deleteAdmin($id)
{
	global $db;

	if (isBlank($id)) return false;

	// Prevent deletion of logged in user
	if (getActiveAdminId() == $id) {
		return [ 'Active Admin user cannot be deleted.' ];
	}

	$sql = "DELETE FROM admin WHERE id = ";
	$sql .= "'" . dbEscape($db, $id) . "'";
	$sql .= " LIMIT 1";
	return dbQuery($db, $sql);
}

function updateAdmin($id, $first_name, $last_name, $email, $username, $password = NULL)
{
	global $db;

    $errors = validateAdmin($id, $first_name, $last_name, $email, $username, $password);
    if (!empty($errors)) {
        return $errors;
	}

	$sql = "UPDATE admin SET";
	$sql .= " first_name = '" . dbEscape($db, $first_name) . "'";
	$sql .= ", last_name = '" . dbEscape($db, $last_name) . "'";
	$sql .= ", email = '" . dbEscape($db, $email) . "'";
	$sql .= ", username = '" . dbEscape($db, $username) . "'";
	if (isset($password)) {
		$sql .= ", password = '" . dbEscape($db, password_hash($password, PASSWORD_DEFAULT)) . "'";
	}
	$sql .= " WHERE id = '" . dbEscape($db, $id) . "'";
	$sql .= " LIMIT 1";

	return dbQuery($db, $sql);
}