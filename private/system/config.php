<?php namespace System;

class Config
{
    private static $config;
    private static $current;
    
    /**
     * get the value of a specific config setting
     * 
     * @param mixed $key
     * @return mixed
     */
    public static function get($keys, $config = 'system')
    {
        if(!empty($keys))
        {
            if(empty(self::$config))
            {
                self::$config = require_once("../private/config/{$config}.cfg");
                self::$current = self::$config['current'];
            }
            
            // check override
            $value = \Util\Arr::get(self::$config, $keys);
            
            if(empty($value))
            {
                // look for server-specific value
                $value = \Util\Arr::get(self::$config[self::$current], $keys);
            }
            
            return $value;
        }
        
        return null;
    }
 
}

