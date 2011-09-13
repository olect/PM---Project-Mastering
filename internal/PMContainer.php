<?php

abstract class PMContainer
{
    private $className;
    
    private $objects;
    
    private $db;
    
    public function __construct($dbconfig = null)
    {
        $this->className = get_class($this);
        $this->db = ($dbconfig != null)?new Db($dbconfig):new Db();
    }
    
    public function getAll()
    {
        
    }
    
    public function getOne($modelId = null)
    {
        $modelClassName = str_replace("Controller", "", $this->className);
        $identifier = $modelClassName."Id";
        
        $this->db->query("SELECT * FROM $modelClassName WHERE `$identifier` = $modelId");
        if($this->db->getNum() > 0)
            return new 
    }
}

?>