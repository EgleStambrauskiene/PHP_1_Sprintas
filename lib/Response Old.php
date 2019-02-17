<?php
/**
* renderResponse - forms html contents and returns them as string .
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
    extract($variables);//perdirbamas asocijuotas ('key' => 'value') masyvas:
    if (file_exists($template)) {//'key' tampa var (kintamuoju), kuriam priskiriama 'value' reikšmė.
        ob_start();//nuo šio momento visas outputas buferizuojamas, o NE atvaizduojamas naršyklėje.
        include_once $template;//suformuotas html atiduodamas kaip stringas,
        return ob_get_clean();//o buferinė atmintis išvaloma.
    }
    return 'Template not found.';
}

function fileViewResponse($file, $mime)
{
    header('Content-Description: File Transfer');//header — Send a raw HTTP header
    header('Content-Type: ' . $mime);
    header('Content-Transfer-Encoding: Binary');
    header('Expires: 0');
    header('Cache-Control: must-revalidate');
    header('Pragma: public');
    header('Content-Length: ' . filesize($file));
    readfile($file);
    exit();
}

function fileDownloadResponse($file)
{
    header('Content-Description: File Transfer');//header — Send a raw HTTP header
    header('Content-Type: application/octet-stream');
    header('Content-Disposition: attachment; filename="'. basename($file).'"');//basename — 
    header('Content-Transfer-Encoding: Binary');//Returns trailing name component of path (TAI, kas po paskutinio /, DAR g.b. excluded)
    header('Expires: 0');
    header('Cache-Control: must-revalidate');
    header('Pragma: public');
    header('Content-Length: ' . filesize($file));//filesize — Gets file size
    readfile($file);//readfile — Outputs a file
    exit();
}
