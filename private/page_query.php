<?php

/**
 * Page query functions
 */

function existsPageWithMenuName($menu_name, $page_id = false)
{
    global $db;

    $sql = "SELECT 1 FROM page WHERE menu_name = ";
    $sql .= "'" . dbEscape($db, $menu_name) . "'";
    if ($page_id !== false) {
        $sql .= " AND id != ";
        $sql .= "'" . dbEscape($db, $page_id) . "'";
    }
    $sql .= " LIMIT 1";
    return dbSelectSingle($db, $sql) !== false;
}

/**
 * Validate data for page insert or update
 *
 * @return void
 */
function validatePage($subject_id, $position, $visible, $menu_name, $content, $page_id = false)
{
    $errors = [];

    // subject id
    if (!isValidId($subject_id)) {
        $errors[] = "Subject ID is not a valid database ID";
    }

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
    elseif (existsPageWithMenuName($menu_name, $page_id)) {
        $errors[] = "A page with this name already exists.";
    }

    // content
    // max content size, 1 MB
    $max_content_size = 1024 * 1024;
    if (!hasMaxLength($content, 1024 * 1024)) {
        $errors[] = "Content size must be below $max_content_size characters.";
    }

    return $errors;
}

/**
 * Returns all pages sorted by position
 *
 * @return Result set with all subjects
 */
function getAllPages($options = array())
{
    global $db;

    $sql = "SELECT id, subject_id, menu_name, position, visible, content";
	$sql .= " FROM page WHERE 1";
	// Additional options
	if (isset($options['visible'])) {
		if ($options['visible'] === true) {
			$sql .= " AND visible = 1";
		} else if ($options['visible'] === false) {
			$sql .= " AND visible = 0";
		} else {
			die("Invalid value for visible");
		}
	}
	$sql .= " ORDER BY subject_id ASC, position ASC ";
    return dbQuery($db, $sql);
}

/**
 * Returns count of pages
 *
 * @return count
 */
function getPageCount()
{
    global $db;

    $sql = "SELECT COUNT(*) AS count FROM page";
    return dbSelectSingle($db, $sql)['count'];
}

function getPageCountBySubjectId($subject_id)
{
    global $db;

	$sql = "SELECT COUNT(*) AS count FROM page";
	$sql .= " WHERE subject_id = '" . dbEscape($db, $subject_id) . "'";
    return dbSelectSingle($db, $sql)['count'];
}

/**
 * Returns single page by id
 *
 * @param [type] $page_id Page ID
 * @return Array with data
 */
function getPageById($page_id)
{
    global $db;

    $sql = "SELECT id, subject_id, menu_name, position, visible, content FROM page WHERE id = ";
    $sql .= "'" . dbEscape($db, $page_id) . "'";
    return dbSelectSingle($db, $sql);
}

function getVisiblePageById($page_id)
{
    global $db;

    $sql = "SELECT id, subject_id, menu_name, position, visible, content FROM page WHERE id = ";
	$sql .= "'" . dbEscape($db, $page_id) . "'";
	$sql .= " AND visible = 1";
    return dbSelectSingle($db, $sql);
}

function getPagesBySubjectId($subject_id, $visible_only=false)
{
    global $db;

    $sql = "SELECT id, subject_id, menu_name, position, visible, content FROM page WHERE subject_id = ";
	$sql .= "'" . dbEscape($db, $subject_id) . "'";
	if ($visible_only) {
		$sql .= " AND visible = '1'";
	}
    $sql .= " ORDER BY position ASC";
    return dbQuery($db, $sql);
}

function getFirstPageBySubjectId($subject_id, $visible_only=false)
{
    global $db;

    $sql = "SELECT id, subject_id, menu_name, position, visible, content FROM page WHERE subject_id = ";
	$sql .= "'" . dbEscape($db, $subject_id) . "'";
	if ($visible_only) {
		$sql .= " AND visible = '1'";
	}
    $sql .= " ORDER BY position ASC LIMIT 1";
    return dbSelectSingle($db, $sql);
}

/**
 * Increase the page positions by one for all pages
 * by subject id with a position of greater or equal to position
 *
 * @param [type] $subject_id
 * @param [type] $position
 * @return void
 */
function increasePagePositions($subject_id, $position)
{
	global $db;
	
    $sql = "UPDATE page SET";
    $sql .= " position = position + 1";
	$sql .= " WHERE subject_id = '" . dbEscape($db, $subject_id) . "'";
	$sql .= " AND position >= '" . dbEscape($db, $position) . "'";

    return dbQuery($db, $sql);
}

function decreasePagePositions($subject_id, $position)
{
	global $db;
	
    $sql = "UPDATE page SET";
    $sql .= " position = position - 1";
	$sql .= " WHERE subject_id = '" . dbEscape($db, $subject_id) . "'";
	$sql .= " AND position >= '" . dbEscape($db, $position) . "'";

    return dbQuery($db, $sql);
}

/**
 * Create page
 *
 * @param [type] $position
 * @param [type] $visible
 * @param [type] $menu_name
 * @return Page id
 */
function createPage($subject_id, $position, $visible, $menu_name, $content)
{
    global $db;

    $errors = validatePage($subject_id, $position, $visible, $menu_name, $content);
    if (!empty($errors)) {
        return $errors;
	}
	// Move all pages one up
	increasePagePositions($subject_id, $position);

    $sql = "INSERT INTO page(subject_id, menu_name, position, visible, content) VALUES(";
    $sql .= "'" . dbEscape($db, $subject_id) . "'";
    $sql .= ", '" . dbEscape($db, $menu_name) . "'";
    $sql .= ", '" . dbEscape($db, $position) . "'";
    $sql .= ", '" . dbEscape($db, $visible) . "'";
    $sql .= ", '" . dbEscape($db, $content) . "'";
    $sql .= ")";
    return dbInsert($db, $sql);
}

/**
 * Deletes page from database
 *
 * @param [int] $page_id
 * @return void
 */
function deletePage($page_id)
{
    global $db;

	$page = getPageById($page_id);
	decreasePagePositions($page['subject_id'], $page['position']);

    $sql = "DELETE FROM page WHERE id = ";
    $sql .= "'" . dbEscape($db, $page_id) . "'";
    $sql .= " LIMIT 1";
    return dbQuery($db, $sql);
}

/**
 * Update a page
 *
 * @param [int] $page_id
 * @param [int] $subject_id
 * @param [int] $position
 * @param [int] $visible
 * @param [string] $menu_name
 * @param string $content
 * @return void
 */
function updatePage($page_id, $subject_id, $position, $visible, $menu_name, $content)
{
    global $db;

    $errors = validatePage($subject_id, $position, $visible, $menu_name, $content, $page_id);
    if (!empty($errors)) {
        return $errors;
    }

	$page = getPageById($page_id);
	if ($page['position'] != $position) {
		decreasePagePositions($subject_id, $page['position']);
		increasePagePositions($subject_id, $position);
	}

    $sql = "UPDATE page SET";
    $sql .= " subject_id = '" . dbEscape($db, $subject_id) . "'";
    $sql .= ", position = '" . dbEscape($db, $position) . "'";
    $sql .= ", visible = '" . dbEscape($db, $visible) . "'";
    $sql .= ", menu_name = '" . dbEscape($db, $menu_name) . "'";
    $sql .= ", content = '" . dbEscape($db, $content) . "'";
    $sql .= " WHERE id = '" . dbEscape($db, $page_id) . "' LIMIT 1";

    return dbQuery($db, $sql);
}