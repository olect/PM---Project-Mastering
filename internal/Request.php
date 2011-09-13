<?php

define("REQUEST_MODE_RAW", 0);
define("REQUEST_MODE_MYSQL", 1);
define("REQUEST_MODE_JSON", 2);

class Request
{
    static public function paramExist($name)
    {
        if(isset($_REQUEST[$name]) && !empty($_REQUEST[$name]) && $_REQUEST[$name] != null)
            return true;
        else return false;
    }
    
    static public function param($name, $mode = REQUEST_MODE_MYSQL)
    {
        switch($mode) {
            case REQUEST_MODE_RAW:
                return (Request::paramExist($name))?$_REQUEST[$name]:null;
                break;
            case REQUEST_MODE_MYSQL:
                return (Request::paramExist($name))?mysql_real_escape_string($_REQUEST[$name]):null;
                break;
            case REQUEST_MODE_JSON:
                return (Request::paramExist($name))?json_decode($_REQUEST[$name]):null;
                break;
        }
    }
    
    static public function all()
    {
        return $_REQUEST;
    }
    
    static public function params()
    {
        if(isset($_REQUEST)) {
            $req = Request::all();

            if(Request::paramExist("url"))
                unset($req['url']);
            return $req;
        } else return array();
    }
}

?>