<?php

/**
 * Functions
 */

/**
 * Gets url for path
 * 
 * @param [string] $script_path Path to script
 * 
 * @return url
 */
function urlForPath($script_path)
{
    // Add the leading '/' if not present
    if ($script_path[0] != '/') {
        $script_path = '/' . $script_path;
    }
    return WWW_ROOT . $script_path;
}

/**
 * Shorthand urlencode
 *
 * @param [string] $url_string String for encoding
 * 
 * @return Encoded string
 */
function u($url_string)
{
    return urlencode($url_string);
}

/**
 * Shorthand htmlspecialchars
 *
 * @param [string] $html_string HTML string for encoding
 * 
 * @return Encoded string
 */
function h($html_string)
{
    return htmlspecialchars($html_string);
}

/**
 * Sets 404 status and exits
 *
 * @return void
 */
function error404($html = "")
{
    header($_SERVER['SERVER_PROTOCOL'] . ' 404 Not Found');
    echo $html;
    exit();
}

/**
 * Sets 500 status and exits
 *
 * @return void
 */
function error500($html = "")
{
    header($_SERVER['SERVER_PROTOCOL'] . ' 500 Internal Server Error');
    exit();
}

/**
 * Sends 404 code and displays default error page
 *
 * @return void
 */
function notFound()
{
    error404('<h1>404 Not Found</h1>The page that you have requested could not be found.');
}

/**
 * Sends 500 code and displays default error page
 *
 * @return void
 */
function internalServerError()
{
    error500('<h1>500 Internal Server Error</h1>An internal server error has occured.');
}

/**
 * Sends redirection header
 *
 * @param [string] $redirect_url Redirection target
 * @return void
 */
function redirectTo($redirect_url)
{
    header('Location: ' . $redirect_url);
    exit();
}

/**
 * Redirect to path utility function
 *
 * @param [string] $redirect_path Redirection path from WWW_ROOT
 * @return void
 */
function redirectToPath($redirect_path, $message=NULL)
{
	if (isset($message)) {
		$_SESSION['redirect_message'] = $message;
	}
    redirectTo(urlForPath($redirect_path));
}

/**
 * Returns last redirect message from session and clears the value.
 *
 * @return Redirect message
 */
function retrieveRedirectMessage()
{
	if (isset($_SESSION['redirect_message'])) {
		$message = $_SESSION['redirect_message'];
		unset($_SESSION['redirect_message']);
		return $message;
	}
}

/**
 * Checks if the current request is a POST request.
 *
 * @return boolean True if request method is POST, false otherwise
 */
function requestIsPost()
{
    return $_SERVER['REQUEST_METHOD'] == 'POST';
}

/**
 * Checks if the current request is a GET request.
 *
 * @return boolean True if request is GET, false otherwise
 */
function requestIsGet()
{
    return $_SERVER['REQUEST_METHOD'] == 'GET';
}

function displayErrors($errors = array())
{
    if (empty($errors)) {
        return "";
    }

    $out = '<div class="errors">';
    $out .= 'Please fix the following errors:';
    $out .= "<ul>\n";
    foreach ($errors as $error) {
        $out .= '<li>' . h($error) . '</li>' . "\n";
    }
    $out .= "</ul>\n";
    $out .= "</div>\n";
    return $out;
}