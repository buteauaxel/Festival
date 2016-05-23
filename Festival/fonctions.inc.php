<?php

    function __autoload ($className) {

        $fileName = __DIR__ . '/';
        $fileName .= str_replace ('//', DIRECTORY_SEPARATOR, $className) . '.class.php';
    
        if (file_exists ($fileName)) {
            require_once ($fileName);
        }

    }

?>