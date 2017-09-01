
<div id="accordion" role="tablist" aria-multiselectable="true">
    <?php
        echo $this->Form->create('Chucviectinhdocusiphathoivietnam', array('inputDefaults' => array(
                'label' => false,
                'div' => false,
                'error' => false,
            ),
            'type' => 'file',
            "class" => "form-horizontal frm "
        ));
    ?>

    <?php
    foreach ($header as $key => $value) {
        $is_col = ($key == 0) ? "in" : "";
        ?>
        <div class="row">
            <div class="col-xs-12 text-left ">
                <div class="panel panel-default">
                    <div class="panel-heading" role="tab" id="headingOne">
                        <h4 class="panel-title">
                            <a data-toggle="collapse" data-parent="#accordion" href="#collapse_<?php echo $key; ?>" aria-expanded="true" aria-controls="collapseOne">
                                <?php echo $value; ?> 
                            </a>
                        </h4>
                    </div>
                    <div id="collapse_<?php echo $key; ?>" class="panel-collapse collapse <?php echo $is_col; ?>" role="tabpanel" aria-labelledby="headingOne">
                        <div class="panel-body">
                            <div class="input-group col-xs-12 ">
                                <?php
                                    switch ($key) {
                                        case 0:
                                            echo $this->element("form/Chucviectinhdocusiphathoivietnams/content_1", array("key" => $key));
                                            break;
                                        case 1:
                                            echo $this->element("form/Chucviectinhdocusiphathoivietnams/content_2", array("key" => $key));
                                            break;
                                        case 2:
                                            echo $this->element("cacthongtinkhac", array("key" => $key));
                                            break;
                                        case 3:
                                            echo $this->element("kiennghi", array("key" => $key));
                                            break;
                                        default:
                                            break;
                                    }
                                ?>
                            </div>
                        </div> 
                    </div>
                </div>
            </div>
        </div>
    <?php } ?>

    <div class=" well center-block text-center panner" > 
        <?php
        echo $this->Form->submit(
                !empty($this->request->data["ShopTagDetail"]["id"]) ? "Sửa" : "Thêm", array(
            'type' => 'submit',
            'class' => 'btn  btn-info',
            'div' => false,
            'label' => false
                )
        );
        ?>    
    </div>
    <div class="row">

    </div>



</div>

<?php echo $this->Form->end(); ?>
