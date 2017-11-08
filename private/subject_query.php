<?php

/**
 * Subject query functions
 */

/**
 * Validate data for subject insert or update
 *
 * @return void
 */
function validateSubject($position, $visible, $menu_name)
{
    $errors = [];

    // position
    if ( ($position_int = convertToInteger($position)) !== false) {
        if ($position_int <= 0) {
            $errors[] = "Position must be greater than zero.";
        }
        else if ($position_int > 999) {
            $errors[] = "Position must be less than 999.";
        }
    }
    else {
        $errors[] = "Position is not a valid integer value.";
    }

    // visible
    if (isNotInSet((string)$visible, ['0', '1'])) {
        $errors[] = "Visible must be either 1 or 0";
    }

    // menu_name
    if (isBlank($menu_name)) {
        $errors[] = "Name can not be blank.";
    }
    elseif (!hasLength($menu_name, ['min' => 2, 'max' => 255])) {
        $errors[] = "Name must be between 2 and 255 characters.";
    }

    return $errors;
}

/**
 * Returns all subjects sorted by position
 *
 * @return Result set with all subjects
 */
function getAllSubjects($visible_only = false)
{
    global $db;

	$sql = "SELECT id, position, visible, menu_name FROM subject";
	if ($visible_only) {
		$sql .= " WHERE visible = '1'";
	}
    $sql .= " ORDER BY position ASC";
    return dbQuery($db, $sql);
}

/**
 * Returns count of subjects
 *
 * @return count
 */
function getSubjectCount()
{
    global $db;

    $sql = "SELECT COUNT(*) AS count FROM subject";
    return dbSelectSingle($db, $sql)['count'];
}

/**
 * Returns subject data by id
 *
 * @param [type] $subject_id
 * @return Array with data
 */
function getSubjectById($subject_id)
{
    global $db;

    $sql = "SELECT id, position, visible, menu_name FROM subject WHERE id = '" . dbEscape($db, $subject_id) . "'";
    return dbSelectSingle($db, $sql);
}

function increaseSubjectPositions($position)
{
	global $db;
	
    $sql = "UPDATE subject SET";
    $sql .= " position = position + 1";
	$sql .= " WHERE position >= '" . dbEscape($db, $position) . "'";

    return dbQuery($db, $sql);
}

function decreaseSubjectPositions($position)
{
	global $db;
	
    $sql = "UPDATE subject SET";
    $sql .= " position = position - 1";
	$sql .= " WHERE position >= '" . dbEscape($db, $position) . "'";

    return dbQuery($db, $sql);
}

/**
 * Create subject
 *
 * @param [int] $position
 * @param [int] $visible
 * @param [string] $menu_name
 * @return Subject id
 */
function createSubject($position, $visible, $menu_name)
{
    global $db;

    $errors = validateSubject($position, $visible, $menu_name);
    if (!empty($errors)) {
        // Errors happened
        return $errors;
	}
	increaseSubjectPositions($position);

    $sql = "INSERT INTO subject (position, visible, menu_name) VALUES(";
    $sql .= "'" . dbEscape($db, $position) . "'";
    $sql .= ", '" . dbEscape($db, $visible) . "'";
    $sql .= ", '" . dbEscape($db, $menu_name) . "'";
    $sql .= ")";
    return dbInsert($db, $sql);
}

/**
 * Deletes subject from database
 *
 * @param [int] $subject_id
 * @return void
 */
function deleteSubject($subject_id)
{
    global $db;

    $result_set = getPagesBySubjectId($subject_id);
    if (mysqli_num_rows($result_set) > 0) {
        $errors[] = "This subject still has associated pages. Remove the pages before deleting this subject.";
        mysqli_free_result($result_set);
        return $errors;
    }
	mysqli_free_result($result_set);
	
	$subject = getSubjectById($subject_id);
	decreaseSubjectPositions($subject['position']);

    $sql = "DELETE FROM subject WHERE id = ";
    $sql .= "'" . dbEscape($db, $subject_id) . "'";
    $sql .= " LIMIT 1";
    dbQuery($db, $sql);
}

/**
 * Updates subject entry
 *
 * @param [int] $id
 * @param [int] $position
 * @param [int] $visible
 * @param [string] $menu_name
 * @return void
 */
function updateSubjectValues($subject_id, $position, $visible, $menu_name)
{
    global $db;

    $errors = validateSubject($position, $visible, $menu_name);
    if (!empty($errors)) {
        // Errors happened
        return $errors;
	}
	
	$subject = getSubjectById($subject_id);
	if ($subject['position'] != $position) {
		decreaseSubjectPositions($subject['position']);
		increaseSubjectPositions($position);
	}

    $sql = "UPDATE subject SET";
    $sql .= " position = '" . dbEscape($db, $position) . "'";
    $sql .= ", visible = '" . dbEscape($db, $visible) . "'";
    $sql .= ", menu_name = '" . dbEscape($db, $menu_name) . "'";
    $sql .= " WHERE id = '$subject_id' LIMIT 1";
    return dbQuery($db, $sql);
}

function updateSubject($subject)
{
    global $db;

    return updateSubjectValues($subject['id'], $subject['position'], $subject['visible'], $subject['menu_name']);
}