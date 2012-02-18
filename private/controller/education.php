<?php namespace Controller;

class Education
{
    /**
     * Display education
     * 
     * @return \System\View 
     */
    public static function base()
    {
        // load master view
        $view = \System\View::load('master', 'root');
        
        // set navigation elements
        $view->navigation = \System\View::load('navigation', 'root')->set('selected', 'education');
        
        // set default content
        $view->content = \System\View::load('page');
        
        // show nav
        $view->content->nav = \System\View::load('nav');
        
        return $view;
    }

    /**
     * show secondary education
     * @return \System\View
     */
    public static function secondary()
    {
        // load master view
        $view = \System\View::load('master', 'root');
        
        // set navigation elements
        $view->navigation = \System\View::load('navigation', 'root');
        
        // set default content
        $view->content = \System\View::load('secondary');
        
        // show nav
        $view->content->nav = \System\View::load('nav');
        $view->content->nav->selected = '/education/secondary';
        
        return $view;
    }
    
    /**
     * show tertiary education
     * @return \System\View
     */
    public static function tertiary($parameters = null)
    {
        if(empty($parameters) || count($parameters) > 1)
        {
            // go home
            header("Location: /education");
            die();
        }
        
        // load master view
        $view = \System\View::load('master', 'root');
        
        // set navigation elements
        $view->navigation = \System\View::load('navigation', 'root');
        
        // set default content
        $view->content = \System\View::load('tertiary');
        
        // show nav
        $view->content->nav = \System\View::load('nav');
        
        switch(strtolower($parameters[0]))
        {
            case 'formal':
                $view->content->nav->selected = '/education/tertiary/formal';
                $view->content->page = \System\View::load('formal');
                break;
            
            case 'opencourseware':
                $view->content->nav->selected = '/education/tertiary/opencourseware';
                $view->content->page = \System\View::load('opencourseware');
                break;
            
            case 'professional':
                $view->content->nav->selected = '/education/tertiary/professional';
                $view->content->page = \System\View::load('professional');
                break;
            
            default:
                header("Location: /education");
                die();
        }
        
        return $view;
    }
        
}

