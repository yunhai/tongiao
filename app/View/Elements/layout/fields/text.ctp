<?php
$field = array(
    'div' => false,
    'label' => false,
    'id' => false,
    'placeholder' => !empty($place_holder) ? $place_holder : "",
    'type' => 'text',
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