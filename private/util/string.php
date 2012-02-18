<?php namespace Util;

class String
{
    /**
     * Split a string randomly
     * 
     * @param string $string
     * @return array
     */
    public static function splitRandomly($string)
    {
        $length = strlen($string);
        
        $count = 0;
        
        $output = array();
        
        while($count < $length)
        {
            // get random value between 1 and 4
            $random = rand(1, 4);
            
            if($count + $random < $length)
            {
                $output[] = substr($string, $count, $random);
            }
            else
            {
                $output[] = substr($string, $count);
            }
                    
            $count += $random;
        }
        
        return $output;
    }
    
    /**
     * check if haystack begins with needle
     * 
     * @param string $needle
     * @param string $haystack
     * @return bool
     */
    public static function startsWith($needle, $haystack)
    {
        // do some sanity checking
        if(empty($needle) || empty($haystack))
        {
            return false;
        }
        
        $needleLen = strlen($needle);
        
        if($needleLen > strlen($haystack))
        {
            return false;
        }
        
        if(substr($haystack, 0, $needleLen) == $needle)
        {
            return true;
        }
        
        return false;
    }
    
    /**
     * Overload for the standard strpos to accept arrays
     * @param mixed $needle
     * @param string $haystack
     * @param int $offset
     * @return mixed
     */
    public static function strpos($needle, $haystack, $offset = 0)
    {
        if(!is_array($needle))
        {
            return strpos($haystack, $needle, $offset);
        }
        
        foreach($needle as $search)
        {
            $position = strpos($haystack, $search, $offset);
            
            if($position !== false)
            {
                return $position;
            }
        }
        
       return false;
    }
    
    /**
     * Truncate a string
     * @param string $string
     * @param int $length
     * @param string $replace
     * @return string
     */
    public static function truncate($string, $length = 240, $replace = '...') 
    { 
        if(strlen($string) < $length) 
        { 
            return $string; 
        } 

        // don't start right at the beginning, give it a sentence or two
        $offset = 50;
        
        if($length < $offset)
        {
            $offset = 0;
        }
        
        $string = substr($string, 0, $length);

        $endCharacters = array('<br />', ' <', '.', '!', '?', ')');
        $endPosition = self::strpos($endCharacters, $string, $offset);

        if($endPosition !== false)
        { 
            return substr($string, 0, $endPosition) . $replace; 
        } 
        
        // up to first comma
        $endPosition = strpos($string, ",", $offset); 

        if($endPosition !== false)
        { 
           return substr($string, 0, $endPosition) . $replace; 
        } 
        
        // get last word
        $endPosition = strrpos($string, ' ', $length - 20); 

        if($endPosition !== false)
        { 
            return substr($string, 0, $endPosition) . $replace; 
        } 

        return $string . $replace; 
    }
    
}

