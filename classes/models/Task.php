<?php
        
include_once("Db.php");
include_once("Helper.php");
    
class Task
{
	private $task_id;
	private $project_id;
	private $name;
	private $description;
	private $hours;

	private $error;

	public function __construct($taskData)
    	{
        	foreach($taskData as $variable=>$value)
            		$this->$variable = $value;
    	}

    	public function store()
    	{
        	if($this->validate()) {
            		$db = new Db();
            		$db->query("INSERT INTO task (`task_id`, `project_id`, `name`, `description`, `hours`) VALUES (NULL, $this->project_id, '$this->name', '$this->description', $this->hours);");
            		if($db->getResult() == false) {
                		$this->error = "Problem with storing: ".mysql_error();
                		return false;
            		} else {
                		$this->task_id = $db->getInserId();
                		return true;
            		}
        	} else return false;
    	}

    	public function update()
    	{
        	if($this->validate()) {
            		$db = new Db();
            		$db->query("UPDATE task SET `project_id` = $this->project_id, `name` = '$this->name', `description` = '$this->description', `hours` = $this->hours WHERE `task_id` = $this->task_id;");
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
        	$db->query("DELETE FROM task WHERE task_id = $this->task_id");
    	}

    	private function validate()
    	{
                return true;
    	}

	public function getTask_id()
	{
		return (int) $this->task_id;
	}

	public function setTask_id($task_id)
	{
		$this->task_id = (int) $task_id;
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

	public function getDescription()
	{
		return (string) $this->description;
	}

	public function setDescription($description = "")
	{
		$this->description = (string) $description;
	}

	public function getHours()
	{
		return (float) $this->hours;
	}

	public function setHours($hours)
	{
		$this->hours = (float) $hours;
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