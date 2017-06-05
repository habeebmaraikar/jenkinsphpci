<?php
// Register class autoloading
spl_autoload_register(
    function ($name) {
        $name = str_replace('\\', '/', $name) . '.php';

        // Try to load class from src dir
        $srcPath = __DIR__ . '/../src/' . $name;
        if (file_exists($srcPath)) { 
            require_once $srcPath;
        }

        // Load the class from tests dir otherwise
        //else { require_once __DIR__ . '/' . $name; }
    }
);

?>
