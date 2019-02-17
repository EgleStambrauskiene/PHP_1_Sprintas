<?php
/**
* renderResponse - forms html contents and returns them as string.
* @param string $template
* @param array $variables - defined an empty array.
* @return string
*/
function renderResponse($template, $variables = [])
{
    /**
    * extract - Import variables from an array into the current symbol table.
    * @param array $variables - an associative array. This function treats keys as variable names and values as variable values.
    * For each key/value pair it will create a variable in the current symbol table.
    * @return int - the number of variables successfully imported into the symbol table..
    */
    extract($variables);
    /**
    * file_exists - Checks whether a file or directory exists.
    * @param string $template - path to the file or directory.
    * @return bool - TRUE if the file or directory specified by $template exists; FALSE otherwise.
    */
    if (file_exists($template)) {
        /**
        * ob_start - This function will turn output buffering on (no output is sent from the script then).
        * @return bool - TRUE on success or FALSE on failure.
        */
        ob_start();
        include_once $template;
        /**
        * ob_get_clean - Gets the current buffer contents and delete current output buffer.
        * @param void
        * @return string Returns the contents of the output buffer and end output buffering.
        * If output buffering isn't active then FALSE is returned.
        */
        return ob_get_clean();
    }
    return 'Template not found.';
}

/**
* fileViewResponse - Reads a file and writes it to the output buffer.
* @param string $file
* @param string $mime
* @return int - the number of bytes read from the file.
*/
function fileViewResponse($file, $mime)
    /**
    * header - is used to send a raw HTTP header.
    * @param string
    * @return void
    */
{
    header('Content-Description: File Transfer');
    header('Content-Type: ' . $mime);
    header('Content-Transfer-Encoding: Binary');
    header('Expires: 0');
    header('Cache-Control: must-revalidate');
    header('Pragma: public');
    header('Content-Length: ' . filesize($file));
    /**
    * readfile - Reads a file and writes it to the output buffer.
    * @param string $file - the filename being read.
    * @return int - the number of bytes read from the file.
    */
    readfile($file);
    exit();
}

/**
* fileDownloadResponse - Reads a file and writes it to the output buffer..
* @param string $file
* @return int - the number of bytes read from the file.
*/
function fileDownloadResponse($file)
{
    /**
    * header - is used to send a raw HTTP header.
    * @param string
    * @return void
    */
    header('Content-Description: File Transfer');
    header('Content-Type: application/octet-stream');
    header('Content-Disposition: attachment; filename="'. basename($file).'"');
    header('Content-Transfer-Encoding: Binary');
    header('Expires: 0');
    header('Cache-Control: must-revalidate');
    header('Pragma: public');
    header('Content-Length: ' . filesize($file));
    /**
    * readfile - Reads a file and writes it to the output buffer.
    * @param string $file - the filename being read.
    * @return int - the number of bytes read from the file.
    */
    readfile($file);
    exit();
}
