<?php
/**
* session_start - Starts new session and initializes the $_SESSION superglobal.
* @return bool TRUE if a session was successfully started, otherwise FALSE.
*/
session_start();

/** The require_once statement includes and evaluates the specified file.
* Also PHP will check if the file has already been included, and if so, not include (require) it again.
* Upon failure it will also produce a fatal E_COMPILE_ERROR level error, - it will halt the script.
*/
require_once __DIR__ . DIRECTORY_SEPARATOR . 'lib' . DIRECTORY_SEPARATOR . 'Helpers.php';

// Setting protocol.
$httpProtocol = 'http://';

/**
* isset - Determines if a variable is set and is not NULL.
* @param string $_SERVER['HTTPS'] The entries in the superglobal $_SERVER are created by the web server.
* @return bool TRUE if $_SERVER['HTTPS'] is set to a non-empty value. FALSE otherwise.
*/

/**
* strtolower - Makes a string lowercase.
* @param string $_SERVER['HTTPS'] The entries in the superglobal $_SERVER are created by the web server.
* @return string 'on' or 'off', all alphabetic characters are converted to lowercase.
*/
if (isset($_SERVER['HTTPS']) && strtolower($_SERVER['HTTPS']) == 'on') {
    $httpProtocol = 'https://';
}

// Setting http root.
// $_SERVER['HTTP_HOST'] - content of 'HTTP_HOST' is taken from the current request header (type: string).
$httpRoot = $httpProtocol . $_SERVER['HTTP_HOST'];

// Setting http directory.
/**
* dirname - Returns a parent directory's path.
* @param string $_SERVER['SCRIPT_NAME'] - contains the current script's path (is '/dirs/index.php').
* @return string - contains the parent directory's path that is (default=1) level up from the current directory (is '/dirs').
*/
$httpDir  = dirname($_SERVER['SCRIPT_NAME']);

if ($httpDir == '/') {
    $httpDir = '';
}

// Setting path.
$path = '';

/**
* isset - Determines if a variable is set and is not NULL.
* @param string $_SERVER['REQUEST_URI'] - the URI which was given in order to access this (index.php) page (is '/dirs/').
* @return bool TRUE if $_SERVER['REQUEST_URI'] is set to a non-empty value. FALSE otherwise.
*/

/**
* strlen - Gets string length.
* @param string $httpDir (is '/dirs').
* @return int - the length of the given string, 0 if the string is empty (is 5).
*/

/**
* substr - Returns the portion of string specified by the start parameter.
* Could be third parameter - int $length.   
* @param string $_SERVER['REQUEST_URI'] - the URI which was given in order to access this (index.php) page (is '/dirs/').
* @param int ($start = strlen($httpDir), is 5) Start is non-negative, the returned string will start at the 5 position in the given string, counting from zero.
* @return string - the extracted part of string (is '/'); or FALSE on failure, or an empty string.
*/

/**
* urldecode - Decodes URL-encoded string.
* @param string - (substr($_SERVER['REQUEST_URI'], strlen($httpDir))) the string to be decoded (is '/').
* @return string - the decoded string (is '/').
*/
if (isset($_SERVER['REQUEST_URI'])) {
    $path = urldecode(substr($_SERVER['REQUEST_URI'], strlen($httpDir)));
}

if ($path == '/') {
    $path = '';
}

// Setting root directory.
// __DIR__ is PHP constant: the directory of the file (is 'C:\www\dirs').
$rootDirectory = __DIR__;

//function sanitizeSlash() is described in Helpers.php.
require_once sanitizeSlash(__DIR__ . '/config/config.php');
require_once sanitizeSlash(__DIR__ . '/lib/Response.php');
require_once sanitizeSlash(__DIR__ . '/src/views/View.php');
require_once sanitizeSlash(__DIR__ . '/src/controllers/DirectoryController.php');

// Function name is a concatenated string: $function = $action . 'Action'. 
// $action gets values depending on what request have been made in the browser.
$action = 'index';

/**
* file_exists - Checks whether a file or directory exists.
* @param string 'FILES_DIR . FILE_PATH' - path to the file or directory.
* @return bool TRUE if the file or directory specified by filename exists; FALSE otherwise.
*/

/**
* isset - Determines if a variable is set and is not NULL.
* @param array $_FILES['file_upload'].
* @return bool TRUE if $_FILES['file_upload'] is set to a non-empty value. FALSE otherwise.
*/

// FILES_DIR, FILE_PATH are constants defined in Config.php. 
if (file_exists(FILES_DIR . FILE_PATH)) {
    if (isset($_FILES['file_upload'])) {
        $action = 'upload';
    }
    
    /**
    * isset - Determines if a variable is set and is not NULL.
    * @param string $_POST['mkdir'], only one directory could be created at a time.
    * @return bool TRUE if $_POST['mkdir'] is set to a non-empty value. FALSE otherwise.
    */
    if (isset($_POST['mkdir'])) {
        $action = 'mkdir';
    }

    /**
    * isset - Determines if a variable is set and is not NULL.
    * @param array $_POST['batch'], more than one directory or file could be intended to delete.
    * @return bool TRUE if $_POST['batch'] is set to a non-empty value. FALSE otherwise.
    */
    if (isset($_POST['batch'])) {
        $action = 'batch';
    }
    
    $function = $action . 'Action';

    // Every function (uploadAction(), mkdirAction(), batchAction()) returns function indexAction(), 
    // which is described in DirectoryController.php (the view of the browser window will be changed in response).
    $response = $function();

    echo $response;
} else {
    require_once sanitizeSlash(__DIR__ . '/src/controllers/HttpStatusController.php');
    // Function httpStatusAction() is described in HttpStatusController.php.
    echo httpStatusAction(404);
    exit();
}
