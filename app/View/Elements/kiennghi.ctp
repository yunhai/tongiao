<?php
$controller = $this->request->params['controller'];
$index = 0;
foreach ($kienNghi as $d_key => $d_value) {
    ?>
    <div class="row">
        <div class="col-xs-12 text-left  col-xs-offset-0">
            <div class="panel panel-default">
                <div id="collapse<?php echo $key; ?><?php echo $index; ?>" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="headingOne">
                    <div class="panel-body">
                        <div class="input-group col-xs-12 ">
                            <?php
                                echo $this->element("form/".$controller."/tb_children", array("data" => $d_value));
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