<div class=" input-group date <?php echo!empty($modeDate) ? $modeDate : "datePicker" ?>">
    <?php
//    echo $this->Form->input(
//            $name, array(
//        'div' => false,
//        'label' => false,
//        'id' => false,
//        'placeholder' => !empty($place_holder) ? $place_holder : "",
//        'type' => 'text',
//        'required' => false,
//        'class' => 'form-control ',
//            )
//    );

    $field = array(
        'div' => false,
        'label' => false,
        //"onkeydown"=> "return false",
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
    <span class="input-group-addon">
        <span class="glyphicon glyphicon-calendar"></span>
       
    </span>
    <span class="input-group-delete">
         <i class="glyphicon glyphicon-refresh "></i>
    </span>
</div>