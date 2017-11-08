<?php

/**
 * Database utility functions
 */
require_once 'dbconfig.php';

/**
 * Creates database connection
 *
 * @return Connection handle
 */
function dbConnect()
{
    $connection = mysqli_connect(DB_SERVER, DB_USER, DB_PASS, DB_NAME)
        or die('Database connection error ' . mysqli_connect_errno() . ': ' . mysqli_connect_error());
    return $connection;
}

/**
 * Disconnects from database
 *
 * @param [handle] $connection Connection handle
 * @return void
 */
function dbDisconnect($connection)
{
    if (isset($connection)) {
        mysqli_close($connection);
    }
}

/**
 * Sends query to db with error checking
 *
 * @param [type] $query
 * @return result set
 */
function dbQuery($db, $sql)
{
    $result_set = mysqli_query($db, $sql)
        or die("Database query failed: $sql; Error:" . mysqli_error($db));
    return $result_set;
}

/**
 * Sends select query to db while expecting only one result
 *
 * @param [type] $db
 * @param [type] $sql
 * @return void
 */
function dbSelectSingle($db, $sql)
{
    $result_set = dbQuery($db, $sql);
    $num_rows = mysqli_num_rows($result_set);
    // Not found
    if ($num_rows == 0) {
        return false;
    }
    
    // Select statement invalid, returns more than one result
    if ($num_rows > 1) {
        die('More than one result from query');
    }

    $result = mysqli_fetch_assoc($result_set);
    mysqli_free_result($result_set);
    return $result;
}

/**
 * Sends insert command to database
 *
 * @param [type] $db
 * @param [type] $sql
 * @return id of the inserted data
 */
function dbInsert($db, $sql)
{
    if (dbQuery($db, $sql) !== true) {
        die('Insert failed or not an insert statement');
    }
    return mysqli_insert_id($db);
}

/**
 * Calls the callback function on each entry of the result
 * of the query function.
 *
 * @param [function] $query_func Returns result set
 * @param [function] $callback_func Called for each entry of result set
 * @return void
 */
function dbForEach($query_func, $callback_func)
{
    $result_set = $query_func();
    while ($result = mysqli_fetch_assoc($result_set)) {
        $callback_func($result);
    }
    mysqli_free_result($result_set);
}

function dbForEachResult($result_set, $callback_func)
{
    while ($result = mysqli_fetch_assoc($result_set)) {
        $callback_func($result);
    }
    mysqli_free_result($result_set);
}

function dbEscape($db, $string)
{
    return mysqli_real_escape_string($db, $string);
}