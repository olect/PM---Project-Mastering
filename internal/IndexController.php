<?php

class IndexController extends Controller
{    
    public function __construct()
    {
        parent::__construct(func_get_args());
    }
    
    public function action_view()
    {
        $this->setDataset(array("name" => "Ole Chr. Thorsen", "tester"=>"test ole"));
        $this->error = "";
        $this->msg = "";
    }
    
    public function action_edit()
    {
        
    }
    
}

?>