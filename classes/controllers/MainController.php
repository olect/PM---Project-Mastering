<?php

class MainController extends PMController
{
    public function action_edit()
    {
        $this->setDataset(array("name" => "Bruce Bjørkhaug"));
    }
    
    public function action_stepone()
    {
        include_once(MODELS_ROOT."Main.php");
        $form = new Form("Main", "steponeForm", "Registreringsskjema");
        $form->hidden("mainId");
        $form->text(null, "title", "", "Tittel");
        /*$form->hidden("method", "test");
        $form->text(null, "firstName", "", "Fornavn:");
        $form->text(null, "lastName", "", "Etternavn:");
        $form->button(null, "t", "jaja");
        $form->select(null, "topic", array(
            "" => "Velg et emne",
            1 => "Malerier",
            2 => "Tester",
            3 => "Noe godt"
        ), "Emne");
        $form->textarea(null, "msg", "", "Melding");
        $form->checkbox("Farge:", "color", array(
            1 => "R&oslash;d",
            2 => "Orange",
            3 => "Gul",
            4 => "Bl&aring;"
        ));*/
        $form->submit(null, "test", "Submit");
        
        
        $this->setDataset(array(
            "message" => "You just started",
            "link" => "/pm/step-two",
            "title" => "Step two",
            "form" => $form->html()
        ));
    }
    
    public function action_steptwo()
    {
        $this->setDataset(array(
            "message" => "Allmost there",
            "link" => "/pm/step-three",
            "title" => "Step three"
        ));
        include_once(MODELS_ROOT."Main.php");
        $model = new Main();
        $model->setTitle("Step one finished");
        $model->store();
    }
    
    public function action_stepthree()
    {
        include_once(MODELS_ROOT."Main.php");
        $model = new Main();
        $model->setTitle("Step two finished");
        $model->store();
        include_once(CONTAINER_ROOT."MainContainer.php");
        $container = new MainContainer();
        $objects = $container->getAll();
        $this->setDataset(array("message" => "finished"));
    }
}

?>