<?php namespace Model;

class Link
{
    private $id;
    private $url;
    private $description;
    private $timestamp;
    
    /**
     * construct a link model object
     * @param type $data 
     */
    private function __construct($data = null)
    {
        if(!empty($data))
        {
            $this->id = \Util\Arr::get($data, 'id');
            $this->url = \Util\Arr::get($data, 'url');
            $this->description = \Util\Arr::get($data, 'description');
            $this->timestamp = \Util\Arr::get($data, 'timestamp');
        }
    }
    
    /**
     * get link id
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }
    
    /**
     * get link url
     * @return string
     */
    public function getURL()
    {
        return $this->url;
    }
    
    /**
     * set link url
     * @param string $url
     * @return \Model\Link
     */
    public function setURL($url)
    {
        $this->url = $url;
        return $this;
    }

    /**
     * get link description
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }
    
    /**
     * set link description
     * @param string $description
     * @return \Model\Link
     */
    public function setDescription($description)
    {
        $this->description = $description;
        return $this;
    }
    
    /**
     * get link timestamp
     * @return string
     */
    public function getTimestamp()
    {
        return $this->timestamp;
    }
    
    /**
     * Commit link
     * 
     * @return bool
     */
    public function commit()
    {
        $mysql = \System\MySQL::getInstance();
        
        $query = sprintf("UPDATE link SET " .
                         "url='%s', description='%s', timestamp='%s' " .
                         "WHERE id=%d",
                         mysql_escape_string($this->url),
                         mysql_escape_string($this->description),
                         $this->timestamp,
                         $this->id
                        );
        
        return $mysql->query($query);
    }
    
    /**
     * create new link
     * @return \Model\Link
     */
    private function createLink()
    {
        $mysql = \System\MySQL::getInstance();
        
        $query = sprintf("INSERT INTO link SET " .
                         "url='%s', description='%s', timestamp='%s'",
                         mysql_escape_string($this->url),
                         mysql_escape_string($this->description),
                         $this->timestamp
                        );
        
        $success = $mysql->query($query);
        
        if($success)
        {
            $this->id = $mysql->getInsertId();
            return $this;
        }
    }
    
    /**
     * create new link
     * @param string $url
     * @param string $description
     * @return \Model\Link
     */
    public static function create($url, $description)
    {
        // check if link already exists
        $link = self::getByURL($url);
        
        if(!empty($link))
        {
            return false;
        }
        
        // create new link
        $link = new self();
        $link->url = $url;
        $link->description = $description;
        $link->timestamp = date("Y-m-d H:i:s");
        
        return $link->createLink();
    }
    
    /**
     * Get link by id
     * @param int $id
     * @return \Model\Link 
     */
    public static function get($id)
    {
        $mysql = \System\MySQL::getInstance();
        
        $query = sprintf("SELECT * FROM link WHERE id=%d", $id);
        
        $result = $mysql->getSingleRow($query);
        
        if(!empty($result))
        {
            return new self($result);
        }
    }

    /**
     * Get link by url
     * @param string $url
     * @return \Model\Link 
     */
    public static function getByURL($url)
    {
        $mysql = \System\MySQL::getInstance();
        
        $query = sprintf("SELECT * FROM link WHERE url='%s'", 
                         mysql_escape_string($url)
                        );
        
        $result = $mysql->getSingleRow($query);
        
        if(!empty($result))
        {
            return new self($result);
        }
    }
    
    /**
     * Get all link
     * @return array(\Model\Link)
     */
    public static function getAll()
    {
        $mysql = \System\MySQL::getInstance();
        
        $query = sprintf("SELECT * FROM link ORDER BY timestamp DESC");
        
        $result = $mysql->getMultipleRows($query);
        
        if(!empty($result))
        {
            $links = array();
            
            foreach($result as $item)
            {
                $links[] = new self($item);
            }
            
            return $links;
        }
    }
    
    /**
     * Delete link
     * @param int $id
     * @return bool
     */
    public static function delete($id)
    {
        $mysql = \System\MySQL::getInstance();
        
        $query = sprintf("DELETE FROM link WHERE id=%d", $id);
        
        return $mysql->query($query);
    }    
}



