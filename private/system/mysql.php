<?php namespace System;

class MySQL
{
    private $config;
    private $resource;
    private $isPersistent;
    
    private static $instance;
    
    /**
     * create a new instance of the db connector
     * 
     * @param array $config
     * @param bool $isPersistent 
     */
    private function __construct($config, $isPersistent = false)
    {
        $this->config = $config;
        $this->isPersistent = $isPersistent;

        // connect to db
        $this->connect();
    }

    /**
     * get the db resource
     * @return resource
     */
    public function getResource()
    {
        return $this->resource;
    }

    /**
     * insert or update query
     * @param string $query
     * @return bool
     */
    public function query($query)
    {
        $this->checkConnection();

        $result = \mysql_query($query, $this->resource);

        if (!$result)
        {
            return false;
        }
        
        return true;
    }

    /**
     * Get a single field
     * @param string $query
     * @return mixed 
     */
    public function getSingleField($query)
    {
        $this->checkConnection();

        $result = \mysql_query($query, $this->resource);
        
        if (!$result)
        {
            return false;
        }
        
        $row = \mysql_fetch_row($result);
        mysql_free_result($result);
        
        return $row[0];
    }

    /**
     * get a single row
     * @param string $query
     * @return array
     */
    public function getSingleRow($query)
    {
        $this->checkConnection();

        $result = \mysql_query($query, $this->resource);
        
        if (!$result)
        {
            return false;
        }
        
        $row = \mysql_fetch_assoc($result);
        mysql_free_result($result);
        
        return $row;
    }
    
    /**
     * get multiple rows
     * @param string $query
     * @return array
     */
    public function getMultipleRows($query)
    {
        $this->checkConnection();

        $result = \mysql_query($query, $this->resource);
        
        if (!$result)
        {
            return false;
        }
        
        $rows = array();
        while ($row = \mysql_fetch_assoc($result))
        {
            $rows[] = $row;
        }
        
        mysql_free_result($result);
        return $rows;
    }

    /**
     * get the id of the last insert
     * @return int
     */
    public function getInsertId()
    {
        return mysql_insert_id($this->resource);
    }

    /**
     * connect to the db
     * @return bool
     */
    private function connect()
    {
        if ($this->isPersistent)
        {
            // persistant connection
            $this->resource = @\mysql_pconnect($this->config['server'],
                                               $this->config['user'],
                                               $this->config['password']);
        }
        else
        {
            // non-persistant connection
            $this->resource = @\mysql_connect($this->config['server'],
                                              $this->config['user'],
                                              $this->config['password'], 
                                              true);
        }
        
        if (!$this->resource)
        {
            return false;
        }
        
        if (!empty($this->config['database']) && !@mysql_select_db($this->config['database'], $this->resource))
        {
            return false;
        }
        
        return true;
    }

    /**
     * disconnect from the db
     */
    public function disconnect()
    {
        \mysql_close($this->resource);
        $this->resource = null;
    }

    /**
     * Get last mysql error
     * @return string 
     */
    public function getError()
    {
        return mysql_error();
    }

    /**
    * check if connection exists, if not connect
    */
    private function checkConnection()
    {
        if (!$this->resource)
        {
            $this->connect();
        }
    }

    /**
    * Get or initiate MySQL instance
    * 
    * @return \System\MySQL
    */
    public static function getInstance()
    {
        if (empty(self::$instance))
        {
            // get db settings
            $config = \System\Config::get('mysql');
            self::$instance = new self($config);
        }

        return self::$instance;
    }    
}
