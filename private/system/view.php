<?php namespace System;

class View
{
    private $path;
    private $httpCode = 200;
    
    private function __construct($path, $httpCode = 200)
    {
        $this->path = $path;
        $this->httpCode = $httpCode;
    }
    
    /**
     * display the view
     */
    public function display()
    {
        include($this->path);
    }
    
    /**
     * Set a variable to be visible in the view scope
     * 
     * @param type $variable
     * @param type $value
     * @return \System\View 
     */
    public function set($variable, $value)
    {
        $this->$variable = $value;
        return $this;
    }
    
    /**
     * Load a view
     * 
     * @param string $path
     * @param string $class
     * @param int $httpCode
     * @return \System\View 
     */
    public static function load($path, $class = null, $httpCode = 200)
    {
        if($class == null)
        {
            // determine calling class
            $trace = debug_backtrace();

            $class = \Util\Arr::get($trace, array(1, 'class'));

            if(empty($class))
            {
                header("Location: /err/filenotfound");
                die();
            }

            // get the actual controller class
            $class = strtolower(substr($class, strpos($class, "\\") + 1));
        }
        
        $path = $class . '/' . $path;
        
        $path = '../private/view/' . $path . '.tpl';
        
        if(!file_exists($path))
        {
            header("Location: /err/filenotfound");
            die();
        }
        
        return new self($path, $httpCode);
    }
    
}


