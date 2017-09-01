<?php

$field = array(
    'div' => false,
    'id' => false,
    'label' => false,
    "class" => "checkbox",
    'type' => 'checkbox',
    'required' => false,
);
if (isset($value)) {
    $field["value"] = $value;
}
echo $this->Form->input(
        $name, $field
);
?>