<?php
/**
 * HTML generator utility functions
 */

function htmlLink($link_path, $text)
{
    $html = '<a href="' . urlForPath($link_path) . '">';
    $html .= h($text);
    $html .= "</a>\n";
    return $html;
}