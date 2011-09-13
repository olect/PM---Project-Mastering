<?php

define("FORM_METHOD_POST", "post");
define("FORM_METHOD_GET", "get");
define("FORM_METHOD_PUT", "put");
define("FORM_METHOD_FILE", "file");

class Form
{
    private $html;
    private $elements;
    private $action;
    
    private $model;
    private $update = false;
    private $response;
    
    public function __construct($model = null, $id = null, $legend = null, $action = "", $method = FORM_METHOD_POST)
    {
        
        if(is_object($model)) {
            $this->model = $model;
            if($model->identifier() != null)
                $this->update = true;
        } elseif(is_string($model)) {
            $this->model = new $model(Request::params());
            
            if($this->model->identifier() != null)
                $this->update = true;
        }

        $_id = ($id != null)?" id='$id'":"";
        $_legend = ($legend != null)?"<legend>$legend</legend>":"";
        $this->html = "<form method='$method' action='$action'$_id>";
        $this->html .= "<fieldset>";
        $this->html .= $_legend;
    }
    
    public function hidden($name = "", $value = "")
    {
        if(is_object($this->model))
            if($this->model->get($name) != null)
                $value = $this->model->get($name);
        //var_dump($this->model);
                    
        $this->elements["hidden"][] = array("html" => "<input type='hidden' name='$name' value='$value' />", "name" => $name, "value" => $value);
    }
    
    public function text($id = null, $name = "", $value = "", $label = null, $class = null)
    {
        if(Request::paramExist($name))
            $value = Request::param($name);
            
        $_id = ($id != null)?" id='$id'":"";
        $field = "";
        $field .= ($label != null)?"<label>$label":"";
        $field .= "<input type='text' name='$name' value='$value'$_id/>";;
        $field .= ($label != null)?"</label>":"";
        $this->elements["other"][] = array("className" => "text", "html" => $field);
    }
    
    public function password($id = null, $name = "", $value = "", $label = null, $class = null)
    {
        if(Request::paramExist($name))
            $value = Request::param($name);
            
        $_id = ($id != null)?" id='$id'":"";
        $field = "";
        $field .= ($label != null)?"<label>$label":"";
        $field .= "<input type='password' name='$name' value='$value'$_id/>";;
        $field .= ($label != null)?"</label>":"";
        $this->elements["other"][] = array("className" => "password", "html" => $field);
    }
    
    public function textarea($id = null, $name = "", $value = "", $label = null, $rows = 3, $cols = 5, $class = null)
    {
        if(Request::paramExist($name))
            $value = Request::param($name);
            
        $_id = ($id != null)?" id='$id'":"";
        $className = ($class != null)?$class:"";
        $field = "";
        $field .= ($label != null)?"<label>$label":"";
        $field .= "<textarea$className rows='$rows' cols='$cols' name='$name'$_id>$value</textarea>";;
        $field .= ($label != null)?"</label>":"";
        $this->elements["other"][] = array("className" => "textarea", "html" => $field);
    }
    
    public function select($id = null, $name = "", $values = array(), $label = null, $selected = 0)
    {
        if(Request::paramExist($name))
            $selected = Request::param($name);
        $_id = ($id != null)?" id='$id'":"";
        $field = "";
        $field .= ($label != null)?"<label>$label":"";
        $field .= "<select name='$name'$_id>";
        foreach($values as $key=>$value) {
            if($selected == $key)
                $field .= "<option value='$key' selected='selected'>$value</option>";
            else
                $field .= "<option value='$key'>$value</option>";
        }
        $field .= "</select>";
        $field .= ($label != null)?"</label>":"";
        $this->elements["other"][] = array("className" => "select", "html" => $field);
    }
    
    public function radio($title = null, $name = null, $values = array(), $selected = 0)
    {
        if(Request::paramExist($name))
            $selected = Request::param($name);
        
        $field = "";
        $field .= ($title != null)?"<h3>$title</h3>":"";
        
        foreach($values as $key=>$value) {
            if($selected == $key)
                $field .= "<label><input type='radio' name='$name' value='$key' checked='checked' />$value</label>";
            else
                $field .= "<label><input type='radio' name='$name' value='$key' />$value</label>";
        }
        
        $this->elements["other"][] = array("className" => "radio", "html" => $field);
    }
    
    public function checkbox($title = null, $name = null, $values = array(), $selected = 0)
    {
        if(Request::paramExist($name))
            $selected = Request::param($name, REQUEST_MODE_RAW);
        
        $field = "";
        $field .= ($title != null)?"<h3>$title</h3>":"";

        foreach($values as $key=>$value) {
            if(in_array($key, $selected))
                $field .= "<label><input type='checkbox' name='".$name."[]' value='$key' checked='checked' />$value</label>";
            else
                $field .= "<label><input type='checkbox' name='".$name."[]' value='$key' />$value</label>";
        }
        
        $this->elements["other"][] = array("className" => "checkbox", "html" => $field);
    }
    
    public function button($id = null, $name = null, $value = "Send")
    {
        $field = "<button name='$name'>$value</button>";
        $this->elements['other'][] = array("className" => "button", "html" => $field);
    }
    
    public function submit($id = null, $name = null, $value = "Send")
    {
        $field = "<input type='submit' name='$name' value='$value' />";
        $this->elements['submit'][] = array("className" => "submit", "html" => $field, "name" => $name, "value" => $value);
    }
    
    public function html($show = true)
    {
        $this->processModel();
        
        foreach($this->elements['hidden'] as $element) {
            if(is_object($this->model))
                if($this->model->get($element['name']) != null)
                    $this->html .= "<input type='hidden' name='".$element['name']."' value='".$this->model->get($element['name'])."' />";
                else
                    $this->html .= $element['html'];
        }
        
        $this->html .= "<ul>";
        foreach($this->elements['other'] as $element) {
            $className = $element['className'];
            $html = $element['html'];
            $this->html .= "
                <li class='$className'>
                    $html
                </li>
            ";
        }
        foreach($this->elements['submit'] as $element) {
            $className = $element['className'];
            $html = $element['html'];
            $this->html .= "
                <li class='submit'>
                    $html
                </li>
            ";
        }
        if($this->response != null)
            $this->html .= $this->response;
        $this->html .= "</ul>";
        $this->html .= "</fieldset>";
        $this->html .= "</form>";
        return $this->html;
    }
    
    private function processModel()
    {
        $val = null;
        if($this->formSubmitted()) {
            if($this->update != true && method_exists($this->model, "store")) {
                if($this->model->store())
                   $val = "Lagret";
                else $val = $this->model->getError();
            } elseif($this->update == true && method_exists($this->model, "update")) {
                if($this->model->update())
                   $val = "Oppdatert";
                else $val = $this->model->getError();
            }
        }
        if($val != null)
            $this->response = "<li class='formResponse'><p>$val</p></li>";

    }
    
    private function formSubmitted()
    {
        foreach($this->elements['submit'] as $submit)
            if(Request::paramExist($submit['name']))
                return true;
    }
}

?>