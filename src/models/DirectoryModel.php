<?php
/**
* getDirList - forms an appropriate array of directories and files.
* @return array (finally), returned by function dirsFirst($dirs), described below.
*/
function getDirList()
{
    /**
    * scandir - List files and directories inside the specified path.
    * @param string 'FILES_DIR . FILE_PATH' - path to the directory that will be scanned.
    * @return array of files and directories from the scanned directory.
    */
    $dirs = scandir(FILES_DIR . FILE_PATH);
    /**
    * array_diff - Compares array1 against other array and 
    * returns the values in array1 that are not present in the other array.
    * @param array $dirs - array1 to compare from.
    * @param array ['..', '.'] - an array to compare against.
    * @return array containing all the entries from array1 that are not present in the other array.
    */
    //iš direktorijų ir failų listo "išmeta" . ir .. .
    //taip 'atfiltruojami' tevinio '..' ir sakninio katalogo '.' tsk.,
    //nebebus galimybės nueiti į 'aukštesnius' lygius, nei numatyta.
    $dirs = array_diff($dirs, ['..', '.']);

    /**
    * array_values - returns all the values from the array and indexes the array numerically.
    * @param array $dirs
    * @return array an indexed array of values.
    */
    $dirs = array_values($dirs);
    return dirsFirst($dirs);
}

/**
* dirsFirst - sorts given array to directories and files and lists directories prior to files.
* @param array $dirs - an indexed array of values (strings).
* @return array $directoryContents - sorted array, where directories are listed prior to files.
*/
function dirsFirst($dirs)
{
    //defines empty associated array $directoryContents (for sorting strings).
    //key 'DIR'/ value: array of associated arrays ('title' => 'url') for directories.
    //key 'FILE'/ value: array of strings (file paths).
    $directoryContents = ['DIR' => [], 'FILE' => []];

    /**
    * empty - Determine whether a variable is empty.
    * @param array $dirs - to be checked.
    * @return bool FALSE if array exists and has a non-empty, non-zero value. Otherwise returns TRUE.
    */
    if (!empty($dirs)) {
        $i = 0;
        foreach ($dirs as $content) {
            /**
            * is_dir - Tells whether the given filename is a directory..
            * @param string 'FILES_DIR . DIRECTORY_SEPARATOR . FILE_PATH . DIRECTORY_SEPARATOR . $content' - is a filename to be checked.
            * @return bool TRUE if the filename exists and is a directory, FALSE otherwise.
            */
            if (is_dir(FILES_DIR . DIRECTORY_SEPARATOR . FILE_PATH . DIRECTORY_SEPARATOR . $content)) {
                //directory title 
                $directoryContents['DIR'][$i]['title'] = $content;
                //and defined url for that directory.
                $directoryContents['DIR'][$i]['url']  = BASE_URL . HTTP_PATH . '/' . $content;
            } else {
                //if not a directory, then it is a file, handled analogically.
                $directoryContents['FILE'][$i]['title'] = $content;
                $directoryContents['FILE'][$i]['url']  = BASE_URL . HTTP_PATH . '/' . $content;
            }
            $i ++;
        }
    }
    
    return $directoryContents;
}
