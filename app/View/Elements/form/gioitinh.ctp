<?php

$gender = array(
    'Nam', 'Nữ'
);
echo $this->Form->input("gioitinh", array(
    'type' => 'radio',
    'options' => $gender,
    'class' => 'radio-inline',
    'legend' => false,
    'default' => 1,
    'before' => '',
    'after' => '</div>',
    'separator' => '',
        )
);
?>