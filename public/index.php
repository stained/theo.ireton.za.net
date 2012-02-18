<?php
/*
 * index.php
 * 
 * Entry point from the web
 * 
 */

// let the router handle the routing
\System\Router::route()->display();

/**
 * Auto-loading of files based on class
 * @param string $class 
 */
function __autoload($class) {
    
    // determine script path 
    $scriptPath = $_SERVER['SCRIPT_FILENAME'];
  
    $info = pathinfo($scriptPath);
    
    $path = strtolower('../private/' . 
                       str_replace("\\", "/", $class) . '.php');
    
    if(!file_exists($path))
    {
        return;
    }
    
    // load file
    require_once($path);
}