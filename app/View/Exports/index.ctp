<?php
    foreach ($header as $key => $value) {
        ?>
<div class="row">
    <div class="col-xs-12 text-left ">
        <div class="panel panel-default">
            <div class="panel-heading" role="tab" id="headingOne">
                <h4 class="panel-title fa fa-file-excel-o">
                    <a data-toggle="collapse" data-parent="#accordion" href="#collapse_<?php echo $key; ?>" aria-expanded="true" aria-controls="collapseOne">
                        <?php echo $value; ?> 
                    </a>
                </h4>
            </div>
            <div id="collapse_<?php echo $key; ?>" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="headingOne">
                <div class="panel-body">
                    <div class="input-group col-xs-12 ">
                        <?php
                            switch ($key) {
                                case 0:
                                    echo $this->element("ButtonExports", array("array" => $arrayButtonLable1));
                                    break;
                                case 1:
                                    echo $this->element("ButtonExports", array("array" => $arrayButtonLable2));
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