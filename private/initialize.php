<?php

/**
 * Initialization 
 */
// Guard against double init
if (isset($initialized)) {
    die('Double initialization invalid');
}

require_once 'error_handler.php';

set_error_handler('myErrorHandler');
set_exception_handler('myExceptionHandler');
register_shutdown_function('myShutdownHandler');

error_reporting(E_ALL);
ini_set('display_errors', 1);

// Enable output buffering 
ob_start();

// Enable sessions
session_start();

// Assign file path to php constants
// __FILE__ returns the current path to this file
// dirname( returns the path to the parent directory
define('PRIVATE_PATH', dirname(__FILE__));
define('PROJECT_PATH', dirname(PRIVATE_PATH));

$public_folder = '/public';
$shared_folder = '/shared';

define('PUBLIC_PATH', PROJECT_PATH . $public_folder);
define('SHARED_PATH', PRIVATE_PATH . $shared_folder);

// Assign the root url to a php constant
// * Does not need to include the domain
// * Use the same root as webserver
// * Can either be hardcoded or dynamically
// Dynamic solution, based on path to public folder
// Will hold the path from the public folder to the current script file
$public_end = strpos($_SERVER['SCRIPT_NAME'], $public_folder)
    + strlen($public_folder);
$doc_root = substr($_SERVER['SCRIPT_NAME'], 0, $public_end);
define('WWW_ROOT', $doc_root);

// General utility functions
require_once 'utility.php';

// Validation functions
require_once 'validation.php';

// Database utility functions
require_once 'database.php';

// User authentication utility
require_once 'authorization.php';

// Query utility functions
require_once 'subject_query.php';
require_once 'page_query.php';
require_once 'admin_query.php';

// HTML generator utility
require_once 'html.php';

// Creates DB connection
$db = dbConnect();
$initialized = true;