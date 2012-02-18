<?php namespace Controller;

class Category
{
    /**
     * manage categories
     * @return \System\View
     */
    public static function manage()
    {
        \Controller\User::_checkLogin("/category/manage");
        
        // load master view
        $view = \System\View::load('master', 'root');
        
        // set navigation elements
        $view->navigation = \System\View::load('navigation', 'root')->set('selected', 'user console');
        
        // set default content
        $view->content = \System\View::load('manage');
        
        // get current categories
        $view->content->categories = \Model\Category::getAll();
        
        return $view;
    }
    
    /**
     * add a new category
     * @return \System\View
     */
    public static function add()
    {
        \Controller\User::_checkLogin("/category/manage");
        
        $name = \Util\Arr::get($_POST, 'name');
        
        if(empty($name))
        {
            $view = self::manage();
            $view->content->formError = 'invalid category name';
            return $view;
        }
        
        // create category
        $category = \Model\Category::create($name);
        
        if(empty($category))
        {
            $view = self::manage();
            $view->content->formError = 'could not create category';
            return $view;
        }
        
        // go back to manage page
        header("Location: /category/manage");
        die();
    }
    
    /**
     * update categories
     * @return \System\View
     */
    public static function update()
    {
        \Controller\User::_checkLogin("/category/manage");
        
        if(empty($_POST))
        {
            return self::manage();
        }
        
        $categories = \Util\Arr::get($_POST, 'category');
        $delete = \Util\Arr::get($_POST, 'categorydel');
        
        if(!empty($delete))
        {
            // delete items marked for deletion
            foreach($delete as $id=>$value)
            {
                if($value == "on")
                {
                    // delete category
                    \Model\Category::delete($id);
                    
                    // remove it from category so we don't update it
                    if(array_key_exists($id, $categories))
                    {
                        unset($categories[$id]);
                    }
                }
            }
        }
        
        if(!empty($categories))
        {
            // update categories
            foreach($categories as $id=>$value)
            {
                $category = \Model\Category::get($id);
                
                if(!empty($category))
                {
                    if($category->getName() != $value)
                    {
                        $category->setName($value)->commit();
                    }
                }
            }
        }
        
        // go back to manage page
        header("Location: /category/manage");
        die();
    }
    
}


