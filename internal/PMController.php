<?php

class PMController
{
    private $dataset;
    private $error;
    private $msg;
    
    public function __construct($req) {}
    
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
}

?>