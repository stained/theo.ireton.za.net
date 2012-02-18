<?php namespace Model;

class Category
{
    private $id;
    private $name;
    
    /**
     * construct a category model object
     * @param type $data 
     */
    private function __construct($data = null)
    {
        if(!empty($data))
        {
            $this->id = \Util\Arr::get($data, 'id');
            $this->name = \Util\Arr::get($data, 'name');
        }
    }
    
    /**
     * get category id
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }
    
    /**
     * get category name
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }
    
    /**
     * set category name
     * @param string $name
     * @return \Model\Category
     */
    public function setName($name)
    {
        $this->name = $name;
        return $this;
    }
    
    /**
     * Commit category
     * 
     * @return bool
     */
    public function commit()
    {
        $mysql = \System\MySQL::getInstance();
        
        $query = sprintf("UPDATE category SET " .
                         "name='%s' WHERE id=%d",
                         mysql_escape_string($this->name),
                         $this->id
                        );
        
        return $mysql->query($query);
    }
    
    /**
     * create new category
     * @return \Model\Category
     */
    private function createCategory()
    {
        $mysql = \System\MySQL::getInstance();
        
        $query = sprintf("INSERT INTO category SET " .
                         "name='%s'",
                         mysql_escape_string($this->name)
                        );
        
        $success = $mysql->query($query);
        
        if($success)
        {
            $this->id = $mysql->getInsertId();
            return $this;
        }
    }
    
    /**
     * create new category
     * @param string $name
     * @return \Model\Category
     */
    public static function create($name)
    {
        // check if category already exists
        $category = self::getByName($name);
        
        if(!empty($category))
        {
            return false;
        }
        
        // create new category
        $category = new self();
        $category->name = $name;
        return $category->createCategory();
    }
    
    /**
     * Get category by id
     * @param int $id
     * @return \Model\Category 
     */
    public static function get($id)
    {
        $mysql = \System\MySQL::getInstance();
        
        $query = sprintf("SELECT * FROM category WHERE id=%d", $id);
        
        $result = $mysql->getSingleRow($query);
        
        if(!empty($result))
        {
            return new self($result);
        }
    }

    /**
     * Get category by name
     * @param string $name
     * @return \Model\Category 
     */
    public static function getByName($name)
    {
        $mysql = \System\MySQL::getInstance();
        
        $query = sprintf("SELECT * FROM category WHERE name='%s'", 
                         mysql_escape_string($name)
                        );
        
        $result = $mysql->getSingleRow($query);
        
        if(!empty($result))
        {
            return new self($result);
        }
    }
    
    /**
     * Get all categories
     * @return array(\Model\Category)
     */
    public static function getAll()
    {
        $mysql = \System\MySQL::getInstance();
        
        $query = sprintf("SELECT * FROM category ORDER BY name");
        
        $result = $mysql->getMultipleRows($query);
        
        if(!empty($result))
        {
            $categories = array();
            
            foreach($result as $item)
            {
                $categories[] = new self($item);
            }
            
            return $categories;
        }
    }
    
    /**
     * Delete category
     * @param int $id
     * @return bool
     */
    public static function delete($id)
    {
        $mysql = \System\MySQL::getInstance();
        
        $query = sprintf("DELETE FROM category WHERE id=%d", $id);
        
        return $mysql->query($query);
    }    
}



