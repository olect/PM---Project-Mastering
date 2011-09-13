<?php
        
include_once("Db.php");
include_once("Helper.php");
    
class Customer
{
	private $customer_id;
	private $name;
	private $address;
	private $zip;
	private $city;
	private $phone;
	private $email;

	private $error;

	public function __construct($customerData)
    	{
        	foreach($customerData as $variable=>$value)
            		$this->$variable = $value;
    	}

    	public function store()
    	{
        	if($this->validate()) {
            		$db = new Db();
            		$db->query("INSERT INTO customer (`customer_id`, `name`, `address`, `zip`, `city`, `phone`, `email`) VALUES (NULL, '$this->name', '$this->address', $this->zip, '$this->city', $this->phone, '$this->email');");
            		if($db->getResult() == false) {
                		$this->error = "Problem with storing: ".mysql_error();
                		return false;
            		} else {
                		$this->customer_id = $db->getInserId();
                		return true;
            		}
        	} else return false;
    	}

    	public function update()
    	{
        	if($this->validate()) {
            		$db = new Db();
            		$db->query("UPDATE customer SET `name` = '$this->name', `address` = '$this->address', `zip` = $this->zip, `city` = '$this->city', `phone` = $this->phone, `email` = '$this->email' WHERE `customer_id` = $this->customer_id;");
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
        	$db->query("DELETE FROM customer WHERE customer_id = $this->customer_id");
    	}

    	private function validate()
    	{
                if(is_string($this->name)) {
			if(is_string($this->address)) {
				if(is_int($this->zip)) {
					if(is_string($this->city)) {
						if(is_int($this->phone)) {
							if(is_string($this->email)) {
								if(Helper::validEmail($this->email)) {
									return true;
								} else $this->error = "Variable email is not a valid email";
							} else $this->error = "Variable email is not of type: String";
						} else $this->error = "Variable phone is not of type: Int";
					} else $this->error = "Variable city is not of type: String";
				} else $this->error = "Variable zip is not of type: Int";
			} else $this->error = "Variable address is not of type: String";
		} else $this->error = "Variable name is not of type: String";
    	}

	public function getCustomer_id()
	{
		return (int) $this->customer_id;
	}

	public function setCustomer_id($customer_id)
	{
		$this->customer_id = (int) $customer_id;
	}

	public function getName()
	{
		return (string) $this->name;
	}

	public function setName($name = "")
	{
		$this->name = (string) $name;
	}

	public function getAddress()
	{
		return (string) $this->address;
	}

	public function setAddress($address = "")
	{
		$this->address = (string) $address;
	}

	public function getZip()
	{
		return (int) $this->zip;
	}

	public function setZip($zip)
	{
		$this->zip = (int) $zip;
	}

	public function getCity()
	{
		return (string) $this->city;
	}

	public function setCity($city = "")
	{
		$this->city = (string) $city;
	}

	public function getPhone()
	{
		return (int) $this->phone;
	}

	public function setPhone($phone)
	{
		$this->phone = (int) $phone;
	}

	public function getEmail()
	{
		return (string) $this->email;
	}

	public function setEmail($email = "")
	{
		$this->email = (string) $email;
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