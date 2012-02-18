<?php namespace Controller;

class Link
{
    public static function base()
    {
        // load master view
        $view = \System\View::load('master', 'root');
        
        // set navigation elements
        $view->navigation = \System\View::load('navigation', 'root')->set('selected', 'links');
        
        // set default content
        $view->content = \System\View::load('page');
        
        $view->content->links = \Model\Link::getAll();
        
        return $view;
    }
    
    /**
     * manage links
     * @return \System\View
     */
    public static function manage()
    {
        \Controller\User::_checkLogin("/link/manage");
        
        // load master view
        $view = \System\View::load('master', 'root');
        
        // set navigation elements
        $view->navigation = \System\View::load('navigation', 'root')->set('selected', 'user console');
        
        // set default content
        $view->content = \System\View::load('manage');
        
        // get current links
        $view->content->links = \Model\Link::getAll();
        
        return $view;
    }
    
    /**
     * add a new link
     * @return \System\View
     */
    public static function add()
    {
        \Controller\User::_checkLogin("/link/manage");
        
        $url = \Util\Arr::get($_POST, 'url');
        $description = \Util\Arr::get($_POST, 'description');
        
        if(empty($url) || empty($description))
        {
            $view = self::manage();
            $view->content->formError = 'invalid link url or description';
            return $view;
        }
        
        // create link
        $link = \Model\Link::create($url, $description);
        
        if(empty($link))
        {
            $view = self::manage();
            $view->content->formError = 'could not create link';
            return $view;
        }
        
        // go back to manage page
        header("Location: /link/manage");
        die();
    }
    
    /**
     * update links
     * @return \System\View
     */
    public static function update()
    {
        \Controller\User::_checkLogin("/link/manage");
        
        if(empty($_POST))
        {
            return self::manage();
        }
        
        $links = \Util\Arr::get($_POST, 'link');
        $delete = \Util\Arr::get($_POST, 'linkdel');
        
        if(!empty($delete))
        {
            // delete items marked for deletion
            foreach($delete as $id=>$value)
            {
                if($value == "on")
                {
                    // delete link
                    \Model\Link::delete($id);
                    
                    // remove it from link so we don't update it
                    if(array_key_exists($id, $links))
                    {
                        unset($links[$id]);
                    }
                }
            }
        }
        
        if(!empty($links))
        {
            // update links
            foreach($links as $id=>$value)
            {
                $link = \Model\Link::get($id);
                
                if(!empty($link))
                {
                    if($link->getURL() != $value["url"] ||
                       $link->getDescription() != $value["desc"] 
                       )
                    {
                        $link->setURL($value["url"]);
                        $link->setDescription($value["desc"]);
                        $link->commit();
                    }
                }
            }
        }
        
        // go back to manage page
        header("Location: /link/manage");
        die();
    }
    
}


