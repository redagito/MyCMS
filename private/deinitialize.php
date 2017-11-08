<?php

/**
 * Deinitilaization
 * Include at the end of the script
 */
if ( ($initialized ?? false) === false) {
    die('Not initialized');
}

dbDisconnect($db);