<?php namespace Util;

class Email
{
    public static function javascriptEncode($email)
    {
        if(empty($email))
        {
            return;
        }
        
        $script = "<script type='text/javascript'>";
        
        // split email randomly
        $output = \Util\String::splitRandomly($email);

        $valueScript = '';
        
        foreach($output as $key=>$string)
        {
            $script .=  "var s{$key} = '{$string}'; ";
            
            $valueScript .= "+s{$key}";
        }

        $script .= "document.write(\"<a href='mailto:\"{$valueScript}+\"'>\"{$valueScript}+\"</a>\");</script>";
        
        return $script;
    }
}
