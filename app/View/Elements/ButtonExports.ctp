<ul>
<?php
$index = 0;
$ton_giaos = unserialize(LOAITONGIAO);
foreach ($array as $key => $value) {
    ?>
        <li class='form-group' style="list-style: none;">
            <?php if (in_array($key, array_keys($ton_giaos))):?>
                <div class="form-group">
                    <a class="btn btn-primary btn-sm" data-toggle="collapse" data-parent="#accordion" href="#collapse_<?php echo $key; ?>" aria-expanded="true" aria-controls="collapseOne">
                        <?php echo $value; ?> 
                    </a>
                </div>
                <div id="collapse_<?php echo $key; ?>" class="panel panel-primary panel-collapse collapse in" role="tabpanel" aria-labelledby="headingOne">
                    <div class="panel-body">
                        <div class="input-group col-xs-12 ">
                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <ul class="list-unstyled">
                                          <li><label><input type="checkbox" class="all"> Chọn tất cả</label></li>
                                          <li><hr></li>
                                        </ul>
                                        <?php
                                            $options = array(
                                                '1' => 'BIÊN HÒA',
                                                '2' => 'LONG KHÁNH',
                                                '3' => 'XUÂN LỘC',
                                                '4' => 'CẨM MỸ',
                                                '5' => 'TÂN PHÚ',
                                                '6' => 'ĐỊNH QUÁN',
                                                '7' => 'THỐNG NHẤT',
                                                '8' => 'TRẢNG BOM',
                                                '9' => 'VĨNH CỬU',
                                                '10' => 'NHƠN TRẠCH',
                                                '11' => 'LONG THÀNH'
                                            );
                                            echo $this->Form->input('prefecture_'.$key, array(
                                                'label' => false,
                                                'class' => 'checkbox prefecture',
                                                'type' => 'select',
                                                'multiple' => 'checkbox',
                                                'name' => 'prefecture_'.$key,
                                                'options' => $options,
                                                )
                                            );
                                        ?>
                                    </div>
                                </div>
                                <!-- /.col-lg-6 (nested) -->
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <ul class="list-unstyled">
                                          <li><label><input type="checkbox" class="all"> Chọn tất cả</label></li>
                                          <li><hr></li>
                                        </ul>
                                        <?php
                                            $ton_giao = $ton_giaos[$key];
                                            echo $this->Form->input('ton_giao_'.$key, array(
                                                'label' => false,
                                                'class' => 'checkbox ton_giao',
                                                'type' => 'select',
                                                'multiple' => 'checkbox',
                                                'options' => $ton_giao,
                                                )
                                            );
                                        ?>
                                    </div>
                                </div>
                                <!-- /.col-lg-6 (nested) -->
                            </div>
                        </div>
                        <button type="submit" class="btn btn-primary btn-sm" data-value="<?php echo $key;?>">Xuất BẢNG TỔNG HỢP</button>
                    </div> 
                </div>
            <?php else :?>
            <a onclick="window.location.href = '<?php echo $this->Html->url('/', true) ?>Exports/download/<?php echo $key;?>';" type="button" class="btn btn-primary btn-sm"><?php echo $value;?></a>
            <?php endif;?>
        </li>
    <?php
    $index ++;
}
?>
</ul>