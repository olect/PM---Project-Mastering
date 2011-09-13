<?php

/**
 * @author Webutvikler O. Thorsen
 * @copyright 2010
 */
include_once("db_config.php");
class Db
{
	private $handle;
	private $result;
	private $query;
	
	public function __construct($altDbSettings = null)
	{
		if($altDbSettings == null) {
			global $dbSettings;
			$this->handle = mysql_connect($dbSettings['host'],$dbSettings['user'],$dbSettings['pass']);
			mysql_selectdb($dbSettings['db'], $this->handle);
		} else {
			$this->handle = mysql_connect($altDbSettings['host'],$altDbSettings['user'],$altDbSettings['pass']);
			mysql_selectdb($altDbSettings['db'], $this->handle);
		}
	}
	
	public function query($queryString = "")
	{
		$this->query = $queryString;
		$this->result = mysql_query($queryString, $this->handle);
	}
	
	public function getObject()
	{
		return mysql_fetch_object($this->result);
	}
	
	public function getNum()
	{
		return mysql_num_rows($this->result);
	}
	
	public function getResult()
	{
		return $this->result;
	}
	
	public function getError()
	{
		return mysql_error($this->handle);
	}
	
	public function getInserId()
	{
		return mysql_insert_id($this->handle);
	}
}

?>