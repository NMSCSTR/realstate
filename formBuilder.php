<?php 

class FormBuilder {
    private $formAction;
    private $method;
    private $elements = [];

    public function __construct($action, $method = 'POST') {
        $this->formAction = $action;
        $this->method = $method;
    }

    public function addElement($type, $name, $label, $attributes = []) {

        $attributesString = $this->attributesToString($attributes);
        

        $this->elements[] = "<div class='mb-3'><label for='$name' class='form-label'>$label</label>";
        $this->elements[] = "<input type='$type' name='$name' id='$name' class='form-control' $attributesString></div>";
    }
    public function addTextarea($name, $label, $attributes = []) {
        $attributesString = $this->attributesToString($attributes);
        
        $this->elements[] = "<div class='mb-3'><label for='$name' class='form-label'>$label</label>";
        $this->elements[] = "<textarea name='$name' id='$name' class='form-control' $attributesString></textarea></div>";
    }

    public function addSelect($name, $label, $options, $attributes = []) {
        $attributesString = $this->attributesToString($attributes);
        

        $this->elements[] = "<div class='mb-3'><label for='$name' class='form-label'>$label</label>";
        $select = "<select name='$name' id='$name' class='form-select' $attributesString>";

        foreach ($options as $value => $text) {
            $select .= "<option value='$value'>$text</option>";
        }
        $select .= "</select></div>";
        $this->elements[] = $select;
    }


    public function getForm() {

        $form = "<form action='$this->formAction' method='$this->method'>";
        
        $form .= implode("", $this->elements);
        
        $form .= "<button type='submit' class='btn btn-success'>Submit</button>";
        $form .= "</form>";  
        return $form;
    }

    private function attributesToString($attributes) {
        $attrString = '';
        
        foreach ($attributes as $key => $value) {
            $attrString .= "$key='$value' ";
        }
        return $attrString;
    }
}



// Example usage:


// $formBuilder = new FormBuilder('(link unavailable)', 'POST');
// $formBuilder->addElement('text', 'name', 'Your Name');
// $formBuilder->addTextarea('description', 'Description');
// $formBuilder->addSelect('color', 'Color', ['red' => 'Red', 'green' => 'Green', 'blue' => 'Blue']);
// echo $formBuilder->getForm();