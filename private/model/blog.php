<?php namespace Model;

class Blog
{
    private $id;
    private $title;
    private $timestamp;
    private $categoryId;
    private $post;
    
    /**
     * construct a blog model object
     * @param type $data 
     */
    private function __construct($data = null)
    {
        if(!empty($data))
        {
            $this->id = \Util\Arr::get($data, 'id');
            $this->title = \Util\Arr::get($data, 'title');
            $this->timestamp = \Util\Arr::get($data, 'timestamp');
            $this->categoryId = \Util\Arr::get($data, 'categoryid');
            $this->post = \Util\Arr::get($data, 'post');
        }
    }
    
    /**
     * get blog entry id
     * @return int 
     */
    public function getId()
    {
        return $this->id;
    }
    
    /**
     * get blog title
     * @return string 
     */
    public function getTitle()
    {
        return $this->title;
    }
    
    /**
     * set blog title
     * @param string $title
     * @return \Model\Blog 
     */
    public function setTitle($title)
    {
        $this->title = $title;
        return $this;
    }
    
    /**
     * get blog timestamp
     * @return string
     */
    public function getTimestamp()
    {
        return $this->timestamp;
    }
    
    /**
     * get category id
     * @return int
     */
    public function getCategoryId()
    {
        return $this->categoryId;
    }
    
    /**
     * get category
     * @return string
     */
    public function getCategory()
    {
        $category = \Model\Category::get($this->categoryId);
        
        return $category->getName();
    }
    
    /**
     * set category
     * @param int $categoryId
     * @return \Model\Blog 
     */
    public function setCategoryId($categoryId)
    {
        $this->categoryId = $categoryId;
        return $this;
    }
     
    /**
     * get actual post
     * @return string
     */
    public function getPost()
    {
        return $this->post;
    }
    
    /**
     * set post
     * @param string $post
     * @return \Model\Blog 
     */
    public function setPost($post)
    {
        $this->post = $post;
        return $this;
    }    

    /**
     * commit blog entry
     * @return bool 
     */
    public function commit()
    {
        $mysql = \System\MySQL::getInstance();
        
        $query = sprintf("UPDATE blog SET ".
                         "title='%s', timestamp='%s', ".
                         "categoryid=%d, post='%s' ".
                         "WHERE id=%d",
                         mysql_escape_string($this->title),
                         $this->timestamp,
                         $this->categoryId,
                         mysql_escape_string($this->post),
                         $this->id
                        );
        
        return $mysql->query($query);
    }
    
    /**
     * Create new blog entry
     * @return \Model\Blog 
     */
    private function createEntry()
    {
        $mysql = \System\MySQL::getInstance();
        
        $query = sprintf("INSERT INTO blog SET ".
                         "title='%s', timestamp='%s', ".
                         "categoryid=%d, post='%s'",
                         mysql_escape_string($this->title),
                         $this->timestamp,
                         $this->categoryId,
                         mysql_escape_string($this->post)
                        );
        
        $success = $mysql->query($query);
        
        if($success)
        {
            $this->id = $mysql->getInsertId();
            return $this;
        }
    }
    
    /**
     * Create a new blog entry
     * 
     * @param string $title
     * @param int $categoryId
     * @param string $post
     * @return \Model\Blog
     */
    public static function create($title, $categoryId, $post)
    {
        // create a new blog object
        $blog = new self();
        
        $blog->title = $title;
        $blog->categoryId = $categoryId;
        $blog->post = $post;
        $blog->timestamp = date("Y-m-d H:i:s");
        
        // insert into db
        return $blog->createEntry();
    }

    /**
     * Get blog entry by id
     * @param int $id
     * @return \Model\Blog
     */
    public static function get($id)
    {
        $mysql = \System\MySQL::getInstance();
        
        $query = sprintf("SELECT * FROM blog WHERE id=%d", $id);
        
        $result = $mysql->getSingleRow($query);
        
        if(!empty($result))
        {
            return new self($result);
        }
    }    
    
    /**
     * Get all blog posts
     * @return array(\Model\Blog)
     */
    public static function getAll()
    {
        $mysql = \System\MySQL::getInstance();
        
        $query = sprintf("SELECT * FROM blog ORDER BY timestamp DESC");
        
        $result = $mysql->getMultipleRows($query);
        
        return self::getMultiple($result);
    }    
    
    /**
     * Get all blog posts for a specific month
     * @return array(\Model\Blog)
     */
    public static function getForMonth($month)
    {
        $mysql = \System\MySQL::getInstance();
        
        $query = sprintf("SELECT * FROM blog WHERE SUBSTR(`timestamp`, 1, 7) = '%s' " .
                         "ORDER BY timestamp DESC",
                         mysql_escape_string($month)
                        );
        
        $result = $mysql->getMultipleRows($query);
        
        return self::getMultiple($result);
    }        
    
   /**
     * Get all blog posts for a specific category
     * @return array(\Model\Blog)
     */
    public static function getForCategory($category)
    {
        $mysql = \System\MySQL::getInstance();
        
        $query = sprintf("SELECT b.* FROM blog b, category c " .
                         "WHERE c.name='%s' AND c.id = b.categoryid " .
                         "ORDER BY timestamp DESC",
                         mysql_escape_string($category)
                        );
        
        $result = $mysql->getMultipleRows($query);
        
        return self::getMultiple($result);
    }         
    
    /**
     * get a grouping of dates for blog entries
     * @return array
     */
    public static function getDateGroups()
    {
        $mysql = \System\MySQL::getInstance();
        
        $query = sprintf("SELECT SUBSTR(`timestamp`, 1, 7) AS `date`, " .
                         "COUNT(*) AS `count` FROM blog GROUP BY `date` " . 
                         "ORDER BY `date` DESC;");
        
        return $mysql->getMultipleRows($query);
    }
    
    /**
     * get a grouping of categories for blog entries
     * @return array
     */
    public static function getCategoryGroups()
    {
        $mysql = \System\MySQL::getInstance();
        
        $query = sprintf("SELECT c.name AS `name`, COUNT(*) AS `count` " .
                         "FROM blog b, category c ".
                         "WHERE c.id = b.categoryid ".
                         "GROUP BY `name` ORDER BY `name` ASC;");
        
        return $mysql->getMultipleRows($query);
    }
    
    /**
     * Delete blog post
     * @param int $id
     * @return bool
     */
    public static function delete($id)
    {
        $mysql = \System\MySQL::getInstance();
        
        $query = sprintf("DELETE FROM blog WHERE id=%d", $id);
        
        return $mysql->query($query);
    }
    
    /**
     * get multiple objects from a mysql result
     * @param array $result
     * @return array(\Model\Blog) 
     */
    private static function getMultiple($result)
    {
        if(!empty($result))
        {
            $posts = array();
            
            foreach($result as $item)
            {
                $posts[] = new self($item);
            }
            
            return $posts;
        }
    }
    
}
