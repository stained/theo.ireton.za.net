<?php namespace Controller;

class User
{
    /**
     * user's logged in page
     * @return \System\View
     */
    public static function base($user = null)
    {
        if(empty($user))
        {
            // check if user is already logged in
            $user = \Controller\User::_getLoggedInUser();
            
            if(empty($user))
            {
                // redirect to login page
                header("Location: /user/login");
                die();
            }
        }
        
        // load master view
        $view = \System\View::load('master', 'root');
        
        // set navigation elements
        $view->navigation = \System\View::load('navigation', 'root')->set('selected', 'user console');
        
        // set default content
        $view->content = \System\View::load('page');
        $view->content->user = $user;
        
        return $view;
    }
    
    /**
     * Show login page
     * @return \System\View 
     */
    public static function login()
    {
        // check if user is already logged in
        $user = \Controller\User::_getLoggedInUser();
        
        if(!empty($user))
        {
            // redirect to user page
            header("Location: /user");
            die();
        }
        
        // load master view
        $view = \System\View::load('master', 'root');
        
        // set navigation elements
        $view->navigation = \System\View::load('navigation', 'root');
        
        // set default content
        $view->content = \System\View::load('login')->set('selected', 'owner login');
        
        // check for return url
        $return = \Util\Arr::get($_GET, 'r');
        
        if(!empty($return))
        {
            $view->content->return = $return;
        }
        
        return $view;
    }
    
   /**
     * log user out
     * @return \System\View 
     */
    public static function logout()
    {
        // redirect to home
        header("Location: /");

        // delete cookie by invalidating it
        setcookie(\System\Config::get(array('user', 'cookie')), '', strtotime("-1 year"), '/');
        die();
    }    
    
    /**
     * perform actual login
     * 
     * @return \System\View
     */
    public static function dologin()
    {
        $username = \Util\Arr::get($_POST, 'username');
        $password = \Util\Arr::get($_POST, 'password');
        
        if(empty($username) || empty($password))
        {
            $view = self::login();
            $view->content->formError = "invalid username or password";
            return $view;
        }
        
        // hash input data
        $userHash = md5($username . $password);
        
        // compare to config
        $userInfo = \System\Config::get('user');
        
        if($userInfo['password'] != $userHash || $userInfo['username'] != $username)
        {
            $view = self::login();
            $view->content->formError = "invalid username or password";
            return $view;
        }
        
        $return = \Util\Arr::get($_POST, 'return');
        
        if(!empty($return))
        {
            // redirect to user page
            header("Location: /" . urldecode($return));
        }
        else
        {
            // redirect to user page
            header("Location: /user");
        }
        
        // log user in - cookie must be set after the header call
        self::_logUserIn($userInfo);
        
        die();
    }
    
    /**
     * check if the user is logged in
     * 
     * @return array user's information
     */
    public static function _getLoggedInUser()
    {
        // check if a cookie exists for logged in user
        $cookie = \Util\Arr::get($_COOKIE, \System\Config::get(array('user', 'cookie')));

        if(empty($cookie))
        {
            return;
        }
        
        // check if cookie data matches user data
        $userInfo = \System\Config::get('user');
        
        $userHash = md5($userInfo['username'] . $userInfo['password'] . $userInfo['fullname']);
     
        if($userHash != $cookie)
        {
            return false;
        }
        
        return $userInfo;
    }
    
    /**
     * check if user is logged in and redirect to login if necessary
     * @param string $return the return url
     */
    public static function _checkLogin($return = null)
    {
        $user = self::_getLoggedInUser();
        
        if(empty($user))
        {
            header("Location: /user/login?r=" . urlencode($return));
            die();
        }
    }
    
    /**
     * log the user in
     * @param array user's information
     */
    public static function _logUserIn($userInfo)
    {
        // hash user data
        $userHash = md5($userInfo['username'] . $userInfo['password'] . $userInfo['fullname']);
        
        // set cookie
        setcookie(\System\Config::get(array('user', 'cookie')), $userHash, strtotime("+1 year"), '/');
    }
}
