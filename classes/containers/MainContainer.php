<?php

include_once(MODELS_ROOT."Main.php");

class MainContainer
{
    private $mainObjects;

    public function __construct() {}

    public function getOneBy($mainId)
    {
            $db = new Db();
            $db->query("SELECT * FROM `main` WHERE `mainId` = $mainId");
            if($db->getNum() > 0) {
                    return new Main($db->getObject());
            } else return false;
    }

    public function getAll()
    {
            $mainArr = array();
            $db = new Db();
            $db->query("SELECT * FROM `main`");
            if($db->getNum() > 0)
                    while($mainObject = $db->getObject()) {
                            $mainArr[] = new Main($mainObject);
                    }
            return $mainArr;
    }
}

?>
        