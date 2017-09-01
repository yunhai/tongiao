<?php
$index = 0;
foreach ($array_3 as $d_key => $d_value) {
    ?>
    <div class="row">
        <div class="col-xs-12 text-left  col-xs-offset-0">
            <div class="panel panel-default">
                <div class="panel-heading" role="tab" id="headingOne">
                    <h4 class="panel-title">
                        <a data-toggle="collapse" data-parent="#accordion" href="#collapse<?php echo $key; ?><?php echo $index; ?>" aria-expanded="true" aria-controls="collapseOne">
                            <?php echo $d_key; ?>
                        </a>
                    </h4>
                </div>
                <div id="collapse<?php echo $key; ?><?php echo $index; ?>" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="headingOne">
                    <div class="panel-body">
                        <div class="input-group col-xs-12 ">
                            <?php
                                echo $this->element("form/Chihoitinhdocusiphatgiaovietnams/tb_children", array("data" => $d_value));
                            ?>
                        </div>
                    </div> 
                </div>
            </div>
        </div>
    </div>
    <?php
    $index ++;
}
?>