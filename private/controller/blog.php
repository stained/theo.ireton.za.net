<?php namespace Controller;

class Blog
{
    /**
     * Display latest blog entries
     * 
     * @return \System\View 
     */
    public static function base($loadPost = true)
    {
        // load master view
        $view = \System\View::load('master', 'root');
        
        // set navigation elements
        $view->navigation = \System\View::load('navigation', 'root')->set('selected', 'blog');
        
        // set default content
        $view->content = \System\View::load('page');
        
        // check if user is logged in
        $user = \Controller\User::_getLoggedInUser();
        
        $categories = \Model\Category::getAll();
        
        if(!empty($user) && \System\Config::get('show_new_post') == true)
        {
            // show post creation tools
            $view->content->post = \System\View::load('post');
            $view->content->post->categories = $categories;
        }

        $view->content->categories = $categories;
        
        // get existing blog posts
        $view->content->nav = \System\View::load('nav');
        
        $view->content->nav->groupedDates = \Model\Blog::getDateGroups();
        $view->content->nav->groupedCategories = \Model\Blog::getCategoryGroups();
        
        if(!empty($view->content->nav->groupedDates) && $loadPost !== false)
        {
            // get posts for first month
            $month = $view->content->nav->groupedDates[0]['date'];
            
            $view->content->posts = \Model\Blog::getForMonth($month);
            $view->content->nav->selectedDate = $month;
        }        
        
        return $view;
    }
    
    /**
     * get posts from archive
     * 
     * @param array $parameters
     * @return \System\View 
     */
    public static function archive(array $parameters = null)
    {
        if(empty($parameters))
        {
            // load base
            header("Location: /blog");
            die();
        }
        
        // get view
        $view = self::base(false);

        if(count($parameters) > 2)
        {
            // invalid month
            header("Location: /err/filenotfound");
            die();
        }        
        
        $date = implode("-", $parameters);
        
        // parse date to ensure that it's safe
        $month = date("Y-m", strtotime($date));
        
        if(empty($month))
        {
            // page not found
            header("Location: /err/filenotfound");
            die();
        }
        
        // get posts for month
        $view->content->posts = \Model\Blog::getForMonth($month);
        $view->content->nav->selectedDate = $month;
        
        return $view;
    }
    
    /**
     * get posts for category
     * 
     * @param array $parameters
     * @return \System\View 
     */
    public static function category(array $parameters = null)
    {
        if(empty($parameters))
        {
            // load base
            header("Location: /blog");
            die();
        }
        
        // get view
        $view = self::base(false);
    
        if(count($parameters) > 1)
        {
            // invalid category
            header("Location: /err/filenotfound");
            die();
        }
        
        $parameters[0] = urldecode($parameters[0]);
        
        // get posts for month
        $view->content->posts = \Model\Blog::getForCategory($parameters[0]);
        $view->content->nav->selectedCategory = $parameters[0];
        
        return $view;
    }
    
    /**
     * Post a new blog entry
     * @return \System\View
     */
    public static function post()
    {
        \Controller\User::_checkLogin('/blog');
        
        $title = \Util\Arr::get($_POST, 'title');
        $category = \Util\Arr::get($_POST, 'category');
        $post = \Util\Arr::get($_POST, 'post');
        
        if(empty($title) || empty($category) || empty($post) || $category == "-1")
        {
            $view = self::base();
            $view->content->post->formError = "fill in all fields to post a blog entry";
            return $view;
        }
        
        // create new blog post
        $blog = \Model\Blog::create($title, $category, $post);
        
        if(empty($blog))
        {
            $view = self::base();
            $view->content->post->formError = "could not create blog entry";
            return $view;
        }
        
        // reload blog view
        header("Location: /blog/manage");
        die();
    }
    
    /**
     * Manage blog posts
     * @return \System\View
     */
    public static function manage()
    {
        \Controller\User::_checkLogin('/blog/manage');
        
        $view = \System\View::load('master', 'root');
        
        // set navigation elements
        $view->navigation = \System\View::load('navigation', 'root')->set('selected', 'user console');
        
        // set default content
        $view->content = \System\View::load('manage');
        
        // get all posts
        $view->content->posts = \Model\Blog::getAll();
        
        // show post creation tools
        $view->content->post = \System\View::load('post');
        $view->content->post->categories = \Model\Category::getAll();
        
        return $view;
    }
    
    /**
     * Edit blog post
     * @param array $parameters
     * @return \System\View 
     */
    public static function edit(array $parameters = null)
    {
        if(empty($parameters) || count($parameters) > 1)
        {
            header("Location: /err/filenotfound");
            die();
        }
        
        \Controller\User::_checkLogin('/blog/edit/' . $parameters[0]);
        
        $view = \System\View::load('master', 'root');
        
        // set navigation elements
        $view->navigation = \System\View::load('navigation', 'root')->set('selected', 'user console');
        
        // set default content
        $view->content = \System\View::load('edit');
        
        // get post
        $view->content->post = \Model\Blog::get($parameters[0]);

        if(empty($view->content->post))
        {
            // could not find post
            header("Location: /err/filenotfound");
            die();
        }
        
        $view->content->categories = \Model\Category::getAll();
        
        // show post edit
        return $view;
    }
    
    /**
     * Update blog post
     * @param array $parameters
     * @return \System\View 
     */
    public static function update(array $parameters = null)
    {
        $view = self::edit($parameters);

        if(empty($_POST))
        {
            return $view;
        }
        
        if(!empty($_POST['delete']))
        {
            // delete post
            \Model\Blog::Delete($parameters[0]);
            
            // redirect to manage
            header("Location: /blog/manage");
            die();
        }
            
        $title = \Util\Arr::get($_POST, 'title');
        $category = \Util\Arr::get($_POST, 'category');
        $post = \Util\Arr::get($_POST, 'post');
        
        // set data temporarily
        $view->content->post->setTitle($title);
        $view->content->post->setPost($post);
        $view->content->post->setCategoryId($category);
        
        if(empty($title) || empty($category) || empty($post) || $category == "-1")
        {
            $view->content->formError = "fill in all fields to update a blog entry";
            return $view;
        }
        
        // update post
        $success = $view->content->post->commit();

        if(!$success)
        {
            $view->content->formError = "could not update post";
            return $view;
        }
        
        $view->content->formMessage = "post successfully updated";
        
        // show post edit
        return $view;
    }
    
    public static function view($parameters)
    {
        if(empty($parameters) || count($parameters) > 1)
        {
            header("Location: /err/filenotfound");
            die();
        }
        
        $post = \Model\Blog::get($parameters[0]);
        
        if(empty($post))
        {
            header("Location: /err/filenotfound");
            die();
        }
        
        // load master view
        $view = \System\View::load('master', 'root');
        
        // set navigation elements
        $view->navigation = \System\View::load('navigation', 'root');
        
        // set default content
        $view->content = \System\View::load('view');
        
        $view->content->post = $post;
        
        // check if user is logged in
        $user = \Controller\User::_getLoggedInUser();
        
        // get existing blog posts
        $view->content->nav = \System\View::load('nav');
        $view->content->nav->groupedDates = \Model\Blog::getDateGroups();
        $view->content->nav->groupedCategories = \Model\Blog::getCategoryGroups();
        
        return $view;        
    }
}

