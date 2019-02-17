<?php
/**
 * sanitizeSlash - Validates directory separator for Windows OS.
 * @param string $string - given path.
 * @return string - with valid directory separator.
 */
function sanitizeSlash($string)
{
    /**
     * strtr - Validates directory separator for Windows OS.
     * @param string $string - the string being translated.
     * @param string '/\\' - the string being translated to DIRECTORY_SEPARATOR.
     * @param string DIRECTORY_SEPARATOR - the string replacing '/\\'.
     * @return string - the translated string: with valid directory separator.
     */
    return strtr($string, '/\\', DIRECTORY_SEPARATOR);
}

/**
 * sanitizeToPlain - removes all HTML and PHP tags and encodes all html characters in given string.
 * @param  string $string
 * @return string
 */
function sanitizeToPlain($string = '')
{
    /**
     * strip_tags - Strip HTML and PHP tags from a string.
     * @param string $string - the input string.
     * @return string - the stripped string.
     */

     /**
     * htmlentities - Convert all applicable characters to HTML entities.
     * @param string  - the input string (HTML and PHP are already stripped).
     * @return string - the encoded string (all html characters, possibly left after function strip_tags(),
     * are translated into standart symbol sequences).
     */
    return htmlentities(strip_tags($string));
}
