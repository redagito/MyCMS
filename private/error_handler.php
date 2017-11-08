<?php 

function myExceptionHandler($exception)
{
	ob_clean();
	echo "<h1>Fatal error</h1>\n<p>Uncaught exception '" . get_class($exception) . "'<p>\n";
	echo "<p>" . $exception->getMessage() . "</p>\n";
	echo "<pre>" . $exception->getTraceAsString() . "</pre>\n";
	echo "<p>thrown in <b>" . $exception->getFile() . "</b> on line <b>" . $exception->getLine() . "</b></p>";
	die();
}

function myErrorHandler($code, $message, $file, $line)
{ 
	ob_clean();
	echo "<h1>Error $code</h1>\n<p>$file:$line<p>\n<p>$message</p>\n";
	echo "<pre>\n";
	debug_print_backtrace(DEBUG_BACKTRACE_IGNORE_ARGS);
	echo "</pre>\n";
	die();
}

function myShutdownHandler()
{
	$last_error = error_get_last();
	if ($last_error['type'] === E_ERROR) {
	// fatal error
		myErrorHandler(E_ERROR, $last_error['message'], $last_error['file'], $last_error['line']);
	}
}