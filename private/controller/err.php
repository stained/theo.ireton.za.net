<?php namespace Controller;

class Err
{
    /**
     * file not found
     * @return \System\View
     */
    public static function filenotfound()
    {
        // load master view
        $view = \System\View::load('master', 'root');
        
        // set navigation elements
        $view->navigation = \System\View::load('navigation', 'root');
        
        // set default content
        $view->content = \System\View::load('404');
        
        return $view;
    }
}

