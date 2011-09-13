<?php

class Controller
{
    private $controller;
    private $container;
    private $smarty;
    
    private $action;
    private $actions = array();
    private $template;
    
    private $dataset;
    private $error;
    private $msg;
    
    public function __construct()
    {
        $args = func_get_args();
        $smarty = $args[0][0];
        $req = $args[0][1];
        if($smarty != null && $smarty instanceof Smarty)
            $this->smarty = $smarty;
        else throw new Exception("Failed to launch Smarty in IndexController", 0);
        
        if(!isset($req['url']) || $req['url'] == SYSTEM_BASE) {
            $objectName = "Index";
            $this->action = "view";
            $this->controller = $this;
        } else {
            
            $urlMapping = $this->dispatch_url($req['url']);
            $objectName = $urlMapping->controller;
            $this->action = $urlMapping->action;

            if(!include_once($this->autoload($objectName)))
                throw new Exception("Problem including file from autoloader", 0);
            
            $this->controller = new $objectName($req);
        }
        
        
        $this->getActions($this->controller);
        
        if(in_array("action_".$this->action, $this->actions))
            call_user_func_array(array($this->controller, "action_".$this->action), $req);
        
        $this->printTemplate($objectName, str_replace("controller","",strtolower($objectName))."/".$this->action.".tpl");
    }
    
    private function getActions($controller)
    {
        foreach(get_class_methods($controller) as $method)
            if(strstr($method, "action_"))
                $this->actions[] = $method;
    }
    
    public function getDataset()
    {
        return $this->dataset;
    }
    
    public function setDataset($dataset)
    {
        $this->dataset = $dataset;
    }
    
    public function getError()
    {
        return $this->error;
    }
    
    public function getMsg()
    {
        return $this->msg;
    }
    
    private function dispatch_url($url)
    {
        $url = str_replace(SYSTEM_BASE, "", $url);
        $db = new Db();
        $db->query("SELECT * FROM `urlmapping` WHERE `url` = '$url'");
        if($urlmapping = $db->getObject())
            return $urlmapping;
        else throw new Exception("Failed to retrieve controller from urlmapper", 200);
    }
    
    private function autoload($objectName = "")
    {
        $loadFile = "";
        if($objectName != "") {
            if ($handle = opendir(CONTROLLERS_ROOT)) {
                while (false !== ($file = readdir($handle))) {
                    if ($file != "." && $file != "..") {
                        if($file == $objectName.".php")
                            $loadFile = CONTROLLERS_ROOT.$file;
                    }
                }
                closedir($handle);
            }
            if($loadFile == "")
            if($handle = opendir(INTERNAL_ROOT)) {
                while (false !== ($file = readdir($handle))) {
                    if ($file != "." && $file != "..") {
                        if($file == $objectName.".php")
                            $loadFile = INTERNAL_ROOT.$file;
                    }
                }
                closedir($handle);
            }
            return $loadFile;
        } else throw new Exception("Failed to retrieve object in autoloader", 100);
    }
    
    private function printTemplate($objectName, $templatePath)
    {
        $this->smarty->assign($this->controller->getDataset());
        $this->smarty->assign("Error", $this->controller->getError());
        $this->smarty->assign("Msg", $this->controller->getMsg());
        $this->smarty->display($templatePath);
    }
}

?>