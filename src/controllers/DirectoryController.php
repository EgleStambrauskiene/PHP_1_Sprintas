<?php
/** indexAction - defines how the contents of the structured directories/files view 
* will be organized when responding. Uses sub-functions, defined in other files.
* @return string (finally) returned by function renderResponse($template, $variables = []) with parameters set: 
* string $template, associated array $variables.
* or string returned by functions fileViewResponse() or fileDownloadResponse(), 
* all returned functions are defined in in Response.php.
*/
function indexAction()
{
    /** The require_once statement includes and evaluates the specified file.
    * Also PHP will check if the file has already been included, and if so, not include (require) it again.
    * Upon failure it will also produce a fatal E_COMPILE_ERROR level error, - it will halt the script.
    * ROOT_DIR is constant defined in Config.php.
    * Function sanitizeSlash() is described in Helpers.php.
    */
    require_once ROOT_DIR . sanitizeSlash('/src/models/DirectoryModel.php');

    /**
    * is_dir - Tells whether the filename is a directory.
    * @param string (FILES_DIR . FILE_PATH), FILES_DIR and FILE_PATH are constants defined in Config.php.
    * @return string (finally) returned by function renderResponse($template, $variables = []) with set parameters: string $template, associated array $variables.
    * Function renderResponse is described in Response.php.
    */
    if (is_dir(FILES_DIR . FILE_PATH)) {
        
        $template = sanitizeSlash(ROOT_DIR . '/src/views/templates/dir_list.html.php');
        // Function getDirList() is described in DirectoryModel.php.
        $dirs     = getDirList();
        // Function createCrumbs() is described in View.php.
        $crumbs   = createCrumbs(HTTP_PATH);
        // Function renderResponse() is described in Response.php.
        return renderResponse($template, ['directoryContents' => $dirs, 'crumbs' => $crumbs]);
        
    } else {
        /**
        * mime_content_type - Detect MIME Content-type for a file.
        * @param string (FILES_DIR . FILE_PATH), path to the tested file.
        * FILES_DIR and FILE_PATH are constants defined in Config.php.
        * @return string the content type in MIME format, or FALSE on failure.
        * @throws string Upon failure, an E_WARNING is emitted.
        */
        $mime = mime_content_type(FILES_DIR . FILE_PATH);
        switch ($mime) {
            case 'text/plain':
            case 'image/png':
            case 'image/jpeg':
            case 'application/pdf':
            {
                // Function fileViewResponse() is described in Response.php.
                return fileViewResponse(FILES_DIR . FILE_PATH, $mime);
                break;
            }
            default:
            {
                // Function fileDownloadResponse() is described in Response.php.
                return fileDownloadResponse(FILES_DIR . FILE_PATH);
                break;
            }

        }
    }
}

/**
 * uploadAction - uploads selected file to a new location.
 * @return string (finally), returned by function indexAction, described above.
 */
function uploadAction()
{
    //checks, if any file is selected to upload and gets the values from array.
    if (isset($_FILES['file_upload'])) {
        $file_tmp = $_FILES['file_upload']['tmp_name'];
        $file_name = $_FILES['file_upload']['name'];
        if (!$_FILES['file_upload']['error']) {
            /**
            * move_uploaded_file - Moves an uploaded file to a new location.
            * @param string $file_tmp (the filename of the uploaded file);
            * @param string 'FILES_DIR . FILE_PATH . DIRECTORY_SEPARATOR . $file_name' (The destination of the moved file.);
            * @return bool TRUE on success, if filename is not a valid upload file, will return FALSE.
            */
            $move = move_uploaded_file($file_tmp, FILES_DIR . FILE_PATH . DIRECTORY_SEPARATOR . $file_name);
            if (!$move) {
                $_SESSION['messages'][] = 'Error on file moving.';
            }
        } else {
            $_SESSION['messages'][] = 'File transfer error.';
        }
    }
    return indexAction();
}

/**
 * mkdirAction - creates a new directory.
 * @return string (finally), returned by function indexAction, described above.
 */
function mkdirAction()
{
    //checks if there is set name for a new directory.
    if ($_POST['mkdir']) {
        /**
        * file_exists - Checks if directory exists.
        * @param string 'FILES_DIR . FILE_PATH . DIRECTORY_SEPARATOR . $_POST['mkdir']' - path to the directory.
        * @return bool TRUE if the directory specified by filename exists; FALSE otherwise.
        */
        if (file_exists(FILES_DIR . FILE_PATH . DIRECTORY_SEPARATOR . $_POST['mkdir'])){
            $_SESSION['messages'][] = 'Directory ' . $_POST['mkdir'] . ' already exists.';
        } else {
            /**
            * mkdir - Attempts to create the directory specified by pathname.
            * @param string 'FILES_DIR . FILE_PATH . DIRECTORY_SEPARATOR . $_POST['mkdir']' - path to the directory.
            * @return bool TRUE on success or FALSE on failure.
            */
            mkdir(FILES_DIR . FILE_PATH . DIRECTORY_SEPARATOR . $_POST['mkdir']);
        }
    } else {
        //if the name of a new directory is not set, only the button 'CREATE DIRECTORY' has click.
        $_SESSION['messages'][] = 'Please provide valid directory name.';
    }
    return indexAction();
}

/**
 * batchAction - deletes selected files and directories.
 * @return string (finally), returned by function indexAction, described above.
 */
function batchAction()
{
    //if directories or files selected, $_POST['batch'] is an array of strings, 'foreach' is an iterator.
    foreach ($_POST['batch'] as $deleteItem) {
        //check, if the filename is a directory.
        if (is_dir(FILES_DIR . $deleteItem)) {
            /**
            * glob - Find pathnames matching a pattern.
            * @param string "FILES_DIR . $deleteItem . DIRECTORY_SEPARATOR . '*'" - the pattern.
            * @return array containing the matched directories, an empty array if no file matched or FALSE on error.
            */
            $isEmpty = glob(FILES_DIR . $deleteItem . DIRECTORY_SEPARATOR . '*');
            /**
            * empty - Determine whether a variable is empty.
            * @param array $isEmpty - to be checked.
            * @return bool FALSE if array exists and has a non-empty, non-zero value. Otherwise returns TRUE.
            */
            if (empty($isEmpty)) {
                /**
                * rmdir - Attempts to remove the directory defined by path to it.
                * @param string 'FILES_DIR . $deleteItem' - it is path to the directory.
                * @return bool TRUE on success or FALSE on failure.
                */
                rmdir(FILES_DIR . $deleteItem);
            } else {
                $_SESSION['messages'][] = 'Please empty directory contents first.';
            }
        } else {
            /**
            * unlink - Deletes a file.
            * @param string 'FILES_DIR . $deleteItem' - it is path to the file.
            * @return bool TRUE on success or FALSE on failure.
            */
            unlink(FILES_DIR . $deleteItem);
        }
    }
    return indexAction();
}
