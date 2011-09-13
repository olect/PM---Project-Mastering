<?php

class Main extends PMModel
{
    protected $mainId;
    protected $title;

    protected function validate()
    {
        return true;
    }

    public function getMainid()
    {
        return (int) $this->mainId;
    }

    public function setMainid($mainId)
    {
        $this->mainId = (int) $mainId;
    }

    public function getTitle()
    {
        return (string) $this->title;
    }

    public function setTitle($title = "")
    {
        $this->title = (string) $title;
    }
}
    
?>