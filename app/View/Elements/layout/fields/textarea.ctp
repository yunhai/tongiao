<?php
$field = array(
    'div' => false,
    'id' => false,
    'label' => false,
    "rows" => 5,
    'type' => 'textarea',
    'placeholder' => !empty($place_holder) ? $place_holder : "",        
    'required' => false,
    'class' => 'form-control ',
);
if (isset($value)) {
    $field["value"] = $value;
}
if (isset($tooltip)) {
    $field["data-toggle"] = "tooltip";
    $field["data-placement"] = "top";
    $field["title"] = $place_holder;
}
echo $this->Form->input(
        $name, $field
);
?>