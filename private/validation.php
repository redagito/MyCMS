<?php

/**
 * Validation functions for user input
 */

/**
 * Checks for blank values
 *
 * @param [type] $val
 * @return boolean
 */
function isBlank($val)
{
    return !isset($val) || trim($val) === '';
}

/**
 * Checks for data present (not blank)
 *
 * @param [type] $val
 * @return boolean
 */
function isNotBlank($val)
{
    return !isBlank($val);
}

function hasMinLength($val, $min)
{
    return strlen($val) >= $min;
}

function hasMaxLength($val, $max)
{
    return strlen($val) <= $max;
}

function hasExactLength($val, $length)
{
    return strlen($val) == $length;
}

function hasLength($val, $option_array)
{
    if (isset($option_array['min'])
        && !hasMinLength($val, $option_array['min'])) {
        return false;
    }

    if (isset($option_array['max'])
        && !hasMaxLength($val, $option_array['max'])) {
        return false;
    }

    if (isset($option_array['exact'])
        && !hasExactLength($val, $option_array['exact'])) {
        return false;
    }
    return true;
}

function isInSet($val, $set)
{
    return in_array($val, $set);
}

function isNotInSet($val, $set)
{
    return !in_array($val, $set);
}

function hasString($val, $required_string)
{
    return strpos($val, $required_string) !== false;
}

function isValidEMailFormat($val)
{
    //$email_regex = '/\A[A-Z0-9._%+-]+@[A-Z0-9.-]+\.[A-Z]{2,}\Z/i';
    return filter_var($val, FILTER_VALIDATE_EMAIL);
}

function convertToInteger($val)
{
    $intval = (int) ($val * 1);
    if (!is_numeric($val) && ($val * 1 == $intval)) {
        return false;
    }
    return $intval;
}

/**
 * Validate database id
 *
 * @param [int] $table_id
 * @return boolean True if valid integer/id
 */
function isValidId($table_id)
{
    return filter_var($table_id, FILTER_VALIDATE_INT);
}