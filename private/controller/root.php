<?php namespace Controller;

class Root
{
    /**
     * default route
     * @return \System\View
     */
    public static function base()
    {
        // load master view
        $view = \System\View::load('master');
        
        // set navigation elements
        $view->navigation = \System\View::load('navigation')->set('selected', 'home');
        
        // set default content
        $view->content = \System\View::load('page', 'home');
        
        return $view;
    }
    
    /**
     * route for contact info
     * @return \System\View
     */
    public static function contact()
    {
        // load master view
        $view = \System\View::load('master');
        
        // set navigation elements
        $view->navigation = \System\View::load('navigation')->set('selected', 'contact');
        
        // get contact info from config
        $contactInfo = \System\Config::get('contact');
        
        // set default content
        $view->content = \System\View::load('contact', 'home')->set('contact', $contactInfo);
        
        return $view;
    }
    
    /**
     * my basic feedback form
     * @return \System\View
     */
    public static function feedback()
    {
        // load contact page
        $view = self::contact();
     
        if(!empty($_POST))
        {
            $name = \Util\Arr::get($_POST, 'name');
            $userEmail = \Util\Arr::get($_POST, 'email');
            $message = \Util\Arr::get($_POST, 'message');
            
            if(empty($name) || empty($userEmail) || empty($message))
            {
                $view->content->formError = "please fill in all fields";
            }
            else
            {
                // get contact email info from config
                $email = \System\Config::get(array('contact', 'email'));
                $site = \System\Config::get('site');
                
                // mail feedback data to email defined in config
                mail($email, "feedback from {$name} on {$site}", $message, 
                     "From: {$userEmail}\r\n Reply-To: {$userEmail}\r\n");
                
                $view->content->formMessage = "Thanks for your message, I'll respond to it as soon as possible";
            }
        }
        
        return $view;
    }
    
    /**
     * my entire life history in 30 pages or less
     * @return \System\View
     */
    public static function about()
    {  
        // load master view
        $view = \System\View::load('master');
        
        // set navigation elements
        $view->navigation = \System\View::load('navigation')->set('selected', 'about');
        
        // set default content
        $view->content = \System\View::load('about', 'home');
        
        return $view;
    }  
}

