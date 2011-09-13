<?php

include_once(INTERNAL_ROOT."Db.php");
include_once(INTERNAL_ROOT."Helper.php");

/**
 * A abstract Model class that gives access to helper methods when dealing with a database
 * entity object. Should be extended when creating model-classes.
 * 
 * @author     Ole Chr. Thorsen <webutvikler@olethorsen.no>
 * @version    1.0 2011-07-30 
 */
abstract class PMModel
{
    /**
     * Contains error message
     * @var string
     */
    private $error;
    
    /**
     * When initialized contains an instanse of Db class
     * @var object
     */
    private $db;
    
    /**
     * Stores the entity to the database
     * @return boolean, true if stored correctly
     */
    public function store()
    {
        if($this->validate()) {
            $db = new Db();
            $vars = get_object_vars($this);
            unset($vars['error'], $vars['db']);
            $className = strtolower(get_class($this));
            $identifier = $className."Id";
            $variables = "";
            $values = "";
            $end = end(array_keys($vars));
            foreach($vars as $key=>$value) {
                if($key != $end) {
                    $variables .= "`".$key."`, ";
                    if($key == $identifier)
                        $values .= "NULL, ";
                    else
                        $values .= $this->prepareType($value).", ";
                } else {
                    $variables .= "`".$key."`";;
                    if($key == $identifier)
                        $values .= "NULL";
                    else
                        $values .= $this->prepareType($value);
                }
            }
            $this->beforeStore();
            $db->query("INSERT INTO ".$className." (".$variables.") VALUES (".$values.");");
            if($db->getResult() == false) {
                $this->error = "Failed storing $className - ".mysql_error();
                return false;
            } else {
                $this->$identifier = (int) $db->getInserId();
                $this->afterStore();
                return true;
            }
        }
    }
    
    /**
     * Updates the entity's values in database
     * @return boolean, true if updated correctly
     */
    public function update()
    {
        if($this->validate()) {
            $db = new Db();
            $vars = get_object_vars($this);
            unset($vars['error'], $vars['db']);
            $className = strtolower(get_class($this));
            $identifier = $className."Id";
            $updateStatement = "";
            $end = end(array_keys($vars));
            foreach($vars as $key=>$value) {
                if($key != $end) {
                    if($key != $identifier)
                        $updateStatement .= "`".$key."` = ".$this->prepareType($value).", ";
                } else {
                    if($key != $identifier)
                        $updateStatement .= "`".$key."` = ".$this->prepareType($value);
                }
            }
            $this->beforeUpdate();
            $db->query("UPDATE $className SET $updateStatement WHERE `$identifier` = ".$this->$identifier.";");
            if($db->getResult() == false) {
                $this->error = "Failed updating $className - ".mysql_error();
                return false;
            } else {
                $this->afterUpdate();
                return true;
            }
        }
    }
    
    /**
     * Deletes the entity from database
     * @return void
     */
    public function delete()
    {
        $db = new Db();
        $className = strtolower(get_class($this));
        $identifier = $className."Id";
        $this->beforeDelete();
        $db->query("DELETE FROM $className WHERE `$identifier` = ".$this->$identifier);
        $this->afterDelete();
    }
    
    /**
     * Is called before storing entity to database. Ment to be overided.
     */
    protected function beforeStore() {}
    
    /**
     * Is called after storing entity to database. Ment to be overided.
     */
    protected function afterStore() {}
    
    /**
     * Is called before updating entity to database. Ment to be overided.
     */
    protected function beforeUpdate() {}
    
    /**
     * Is called after updating entity to database. Ment to be overided.
     */
    protected function afterUpdate() {}
    
    /**
     * Is called before deleting entity from database. Ment to be overided.
     */
    protected function beforeDelete() {}
    
    /**
     * Is called after deleting entity from database. Ment to be overided.
     */
    protected function afterDelete() {}
    
    /**
     * @abstract method for validating member data before storing and updating
     * @return boolean
     */
    abstract protected function validate();
    
    /**
     * Initialize Model object by setting values to member variables.
     * @param mixed $data, can contain json-string|array|object
     */
    public function __construct($data)
    {
        $vars = array_keys((array) get_object_vars($this));
        if(!is_string($data)) {
            if(is_array($data) || is_object($data))
                foreach($data as $key=>$value) {
                    if(in_array($key, $vars))
                        $this->$key = $this->processType($value);
                }
        } else $this->fromJson($data);
    }
    
    /**
     * Method for retrieving value from member variable
     * @param string $name
     * @return mixed, value of variable
     */
    public function get($name)
    {
        return $this->$name;
    }
    
    /**
     * Method for setting value of member variable
     * @param string $name, name of member variable
     * @param mixed $value, value of member variable
     */
    public function set($name, $value)
    {
        $this->$name = $this->processType($value);
    }
    
    /**
     * Private method for preparing value for sql statement 
     * @param mixed $value
     * @return mixed
     */
    private function prepareType($value)
    {
        switch(gettype($value)) {
            case "boolean":
                return ($value == false)?0:1;
            
            case "double":
            case "float":
            case "int":
            case "integer":
                return $value;
            case "string":
                return "'".$value."'";
            case "array":
                return "'".implode(",",$value)."'";
            case "NULL":
            case "unknown type":
            default:
                return "NULL";
        }
    }
    
    /**
     * Private method for preparing value for member variable by
     * returning the correct type.
     * @param mixed $value
     * @return mixed
     */
    private function processType($value)
    {
        switch(gettype($value)) {
            case "boolean":
                return (bool) $value;
            case "int":
            case "integer":
                return (int) $value;
            case "double":
            case "float":
                return (double) $value;
            case "string":
                return (string) $value;
            case "object":
            case "resource":
                return $value;
            case "array":
                return (array) $value;
            case "NULL":
            case "unknown type":
            default:
                return null;
        }
    }
    
    public function identifier()
    {
        $vars = array_keys((array) get_object_vars($this));
        
        $className = strtolower(get_class($this));
        $identifier = $className."Id";
        foreach($vars as $param)
            if($param == $identifier)
                return true;
        return false;
    }
    
    /**
     * Method for converting member variables to proper JSON string
     * @return string, JSON formatted string
     */
    public function toJson()
    {
        return json_encode(get_object_vars($this));
    }
    
    /**
     * Method for serializing Model object
     * @return string, serialized
     */
    public function serialize()
    {
        return serialize($this);
    }
    
    /**
     * @return array, contains member variables
     */
    public function toArray()
    {
        return (array) get_object_vars($this);
    }
    
    /**
     * Method for setting member variables from JSON formatted string
     * @param string $string
     */
    public function fromJson($string)
    {
        foreach(json_decode($string) as $key=>$value)
            $this->$key = $this->processType($value);
    }
    
    /**
     * Method for retrieving error message
     * @return string
     */
    public function getError()
    {
        return $this->error;
    }
}

?>