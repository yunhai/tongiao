<?php


$field = array(
    'div' => false,
    'id' => false,
    'label' => false,
    "class" => "radio",
    'type' => 'select',
    'required' => false,
    'legend' => false,
    'hiddenField' => false,
    'options' => array("0" => 'Chưa được cấp', "1" => 'Đã được cấp')
);
if (isset($value)) {
    $field["value"] = $value;
}
echo $this->Form->input(
        $name, $field
);
?>

