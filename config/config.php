<?php
/**
* define - Defines a named constant at runtime.
* @param string - the name of the constant.
* @param string - the value of the constant.
* @return bool - TRUE on success or FALSE on failure.
*/
define('ROOT_DIR',  sanitizeSlash($rootDirectory));
define('FILES_DIR', sanitizeSlash($rootDirectory . '/publicated/files'));
define('BASE_URL',  $httpRoot . $httpDir);
define('HTTP_PATH', $path);
define('FILE_PATH', sanitizeSlash($path));

