<?php
        
include_once("Db.php");
include_once("Helper.php");
    
class Progress
{
	private $progress_id;
	private $task_id;
	private $note;
	private $hours;

	private $error;

	public function __construct($progressData)
    	{
        	foreach($progressData as $variable=>$value)
            		$this->$variable = $value;
    	}

    	public function store()
    	{
        	if($this->validate()) {
            		$db = new Db();
            		$db->query("INSERT INTO progress (`progress_id`, `task_id`, `note`, `hours`) VALUES (NULL, $this->task_id, '$this->note', $this->hours);");
            		if($db->getResult() == false) {
                		$this->error = "Problem with storing: ".mysql_error();
                		return false;
            		} else {
                		$this->progress_id = $db->getInserId();
                		return true;
            		}
        	} else return false;
    	}

    	public function update()
    	{
        	if($this->validate()) {
            		$db = new Db();
            		$db->query("UPDATE progress SET `task_id` = $this->task_id, `note` = '$this->note', `hours` = $this->hours WHERE `progress_id` = $this->progress_id;");
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
        	$db->query("DELETE FROM progress WHERE progress_id = $this->progress_id");
    	}

    	private function validate()
    	{
                if(is_string($this->note)) {
			return true;
		} else $this->error = "Variable note is not of type: String";
    	}

	public function getProgress_id()
	{
		return (int) $this->progress_id;
	}

	public function setProgress_id($progress_id)
	{
		$this->progress_id = (int) $progress_id;
	}

	public function getTask_id()
	{
		return (int) $this->task_id;
	}

	public function setTask_id($task_id)
	{
		$this->task_id = (int) $task_id;
	}

	public function getNote()
	{
		return (string) $this->note;
	}

	public function setNote($note = "")
	{
		$this->note = (string) $note;
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