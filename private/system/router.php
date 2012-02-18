<?php namespace System;

class Router
{
    /**
     * Determine the request and route as necessary
     * 
     * @return \System\View 
     */
    public static function route()
    {
        // determine the request
        $request = $_SERVER['REQUEST_URI'];

        if(empty($request))
        {
            // load default root
            return \Controller\Root::base();
        }

        // parse the request
        $request = preg_split('/\//', $request, -1, PREG_SPLIT_NO_EMPTY);

        if(empty($request))
        {
            // load default root
            return \Controller\Root::base();
        }

        // check for parameters in the URL
        $parameters = null;

        if(count($request) > 2)
        {
            // has parameters
            $parameters = array_slice($request, 2);
        }
        
        // attempt to load the request
        $class = "\\Controller\\" . ucfirst($request[0]);

        if(!class_exists($class))
        {
            // check if it exists as a method in root
            $class = "\\Controller\\Root";
            
            if(method_exists($class, $request[0]))
            {
                return call_user_func(array($class, $request[0]), $parameters);
            }
            
            // load default root
            return \Controller\Root::base();
        }

        // check if there's a function defined 
        if(empty($request[1]) || // no function specified
           !method_exists($class, $request[1]) || // class does not contain function
           \Util\String::startsWith('_', $request[1])) // function begins with an underscore - 
                                                       // such functions are considered"private"
        {
            if(!method_exists($class, 'base'))
            {
                return \Controller\Root::base();
            }

            // load default route in controller
            return call_user_func(array($class, 'base'), $parameters);
        }

        // load function in class
        return call_user_func(array($class, $request[1]), $parameters);
    }
    
}
