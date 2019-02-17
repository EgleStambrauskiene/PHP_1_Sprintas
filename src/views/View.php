<?php
/**
 * createCrumbs - Analyzes URL path and creates "breadcrumbs" array.
 * @param  string $path
 * @return array
 */
//ši funkcija sukuria navigacinio kelio 'atvaizdavimą' naršyklėje.
function createCrumbs($path)
{
    $crumbsLinks = [];
    $crumbPath = '';

    /**
    * explode - Returns an array of strings, each of which is a substring of string
    * formed by splitting it on boundaries formed by the string delimiter.
    * @param string '/' - it is delimiter.
    * @param string $path - it is the input string.
    * @return array of strings.
    */

    /**
    * array_filter - Filters elements of an array using a callback function.
    * @param array of strings to iterate over.
    * @return array the filtered array, all entries of given array equal to FALSE were removed.
    */

    /**
    * array_values - returns all the values from the array and indexes the array numerically.
    * @param array.
    * @return array an indexed array of values.
    */
    $crumbs = array_values(array_filter(explode('/', $path)));
    foreach ($crumbs as $key => $crumb) {
        $crumbPath .= $crumb . '/';
        $crumbsLinks[$key]['path'] = $crumbPath;
        $crumbsLinks[$key]['title'] = $crumb;
    }
    return $crumbsLinks;
}
