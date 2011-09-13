<?php
        
include_once("Db.php");
include_once("Helper.php");
    
class Project
{
	private $project_id;
	private $name;
	private $customer_id;

	private $error;

	public function __construct($projectData)
    	{
        	foreach($projectData as $variable=>$value)
            		$this->$variable = $value;
    	}

    	public function store()
    	{
        	if($this->validate()) {
            		$db = new Db();
            		$db->query("INSERT INTO project (`project_id`, `name`, `customer_id`) VALUES (NULL, '$this->name', $this->customer_id);");
            		if($db->getResult() == false) {
                		$this->error = "Problem with storing: ".mysql_error();
                		return false;
            		} else {
                		$this->project_id = $db->getInserId();
                		return true;
            		}
        	} else return false;
    	}

    	public function update()
    	{
        	if($this->validate()) {
            		$db = new Db();
            		$db->query("UPDATE project SET `name` = '$this->name', `customer_id` = $this->customer_id WHERE `project_id` = $this->project_id;");
            		if($db->getResult() == false) {
                		$this->error = "Problem with updating: ".mysql_error();
                		return false;
            		} else {
                		return true;
            		}
        	} else return false;
    	}

    	public function delete()
    	{
        	$db = new Db();
        	$db->query("DELETE FROM project WHERE project_id = $this->project_id");
    	}

    	private function validate()
    	{
                if(is_string($this->name)) {
			return true;
		} else $this->error = "Variable name is not of type: String";
    	}

	public function getProject_id()
	{
		return (int) $this->project_id;
	}

	public function setProject_id($project_id)
	{
		$this->project_id = (int) $project_id;
	}

	public function getName()
	{
		return (string) $this->name;
	}

	public function setName($name = "")
	{
		$this->name = (string) $name;
	}

	public function getCustomer_id()
	{
		return (int) $this->customer_id;
	}

	public function setCustomer_id($customer_id)
	{
		$this->customer_id = (int) $customer_id;
	}


    	public function getError()
    	{
        	return $this->error;
    	}
    
    	public function toArray()
    	{
    		$arr = array();
    		foreach($this as $key=>$val)
        		$arr[$key] = $val;
    		return $arr;
    	}
}
    
?>