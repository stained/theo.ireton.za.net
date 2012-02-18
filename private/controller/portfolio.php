<?php namespace Controller;

class Portfolio
{
    /**
     * Display portfolio
     * 
     * @return \System\View 
     */
    public static function base()
    {
        // load master view
        $view = \System\View::load('master', 'root');
        
        // set navigation elements
        $view->navigation = \System\View::load('navigation', 'root')->set('selected', 'portfolio');
        
        // set default content
        $view->content = \System\View::load('page');
        
        // show nav
        $view->content->nav = \System\View::load('nav');
        
        return $view;
    }

    /**
     * professional
     * @param array $parameters
     * @return \System\View
     */
    public static function professional($parameters = null)
    {
        if(empty($parameters) || count($parameters) > 1)
        {
            // go home
            header("Location: /portfolio");
            die();
        }
        
        // load master view
        $view = \System\View::load('master', 'root');
        
        // set navigation elements
        $view->navigation = \System\View::load('navigation', 'root');
        
        // set default content
        $view->content = \System\View::load('professional');
        
        $view->content->nav = \System\View::load('nav');
                
        switch(strtolower($parameters[0]))
        {
            case 'boom':
                $view->content->nav->selected = '/portfolio/professional/boom';
                $view->content->page = \System\View::load('boom');
                break;
            
            case 'sasra':
                $view->content->nav->selected = '/portfolio/professional/sasra';
                $view->content->page = \System\View::load('sasra');
                break;
            
            case '6th':
                $view->content->nav->selected = '/portfolio/professional/6th';
                $view->content->page = \System\View::load('6th');
                break;
            
            case 'coldshift':
                $view->content->nav->selected = '/portfolio/professional/coldshift';
                $view->content->page = \System\View::load('coldshift');
                break;
            
            case 'statssa':
                $view->content->nav->selected = '/portfolio/professional/statssa';
                $view->content->page = \System\View::load('statssa');
                break;            
            
            default:
                header("Location: /portfolio");
                die();
        }
        
        
        return $view;
    }
    
     /**
     * personal
     * @param array $parameters
     * @return \System\View
     */
    public static function personal($parameters = null)
    {
        if(empty($parameters) || count($parameters) > 1)
        {
            // go home
            header("Location: /portfolio");
            die();
        }
        
        // load master view
        $view = \System\View::load('master', 'root');
        
        // set navigation elements
        $view->navigation = \System\View::load('navigation', 'root');
        
        // set default content
        $view->content = \System\View::load('personal');
        
        $view->content->nav = \System\View::load('nav');
                
        switch(strtolower($parameters[0]))
        {
            case 'hackershack':
                $view->content->nav->selected = '/portfolio/personal/hackershack';
                $view->content->page = \System\View::load('hackershack');
                break;
            
            case 'site':
                $view->content->nav->selected = '/portfolio/personal/site';
                $view->content->page = \System\View::load('site');
                break;
            
            case 'dots':
                $view->content->nav->selected = '/portfolio/personal/dots';
                $view->content->page = \System\View::load('dots');
                break;
            
            default:
                header("Location: /portfolio");
                die();
        }
        
        
        return $view;
    }
}

