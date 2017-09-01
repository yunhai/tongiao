<table class="table table-bordered col-xs-12 tb-generator">
    <tbody>
        <?php
        $is_call = !empty($is_call) ? $is_call : 0;
        foreach ($data as $key => $val) {
            ?>
            <tr>
                <th class="col-xs-2 text-left">
                    <label class="control-label pull-right"><?php echo $key; ?></label>
                </th>
                <td >
                    <?php 
                        echo $this->element("form/Chucsacnhatuhanhconggiaotrieus/tb_children_quanhe_noidung", array("data" => $val, "is_call" => 1));
                    ?>
                </td>
            </tr>
<?php } ?>
    </tbody>
</table>