<?php if ($id != "nhatho" && $id != "xaydung") {?>
<a class="btn btn-default add_row_vertical pull-left" ref="tb_vertical_<?php echo $id; ?>"><i class="glyphicon glyphicon-plus"></i> Them</a>
<?php }?>
<div id="tb_vertical_<?php echo $id; ?>">
    <div class="tb0">
        <table class="table table-bordered  tb-auto" >
            <tbody>
                <tr>
                    <td colspan="3">
                        <i class="glyphicon glyphicon-remove ic_delete_vertical"></i>
                    </td>
                </tr>
                <?php foreach ($data as $key => $val) { 
                    ?>
                    <tr>
                        <th class="col-xs-2 text-left">
                            <?php echo $key; ?>
                        </th>
                        <td>
                            <?php
                                if ($key == "Nhà thờ") {
                                    echo $this->element("form/Hodaocaodais/tb_vertical_auto", array("data" => $val, "id" => "nhatho"));
                                } elseif ($key == "Xây dựng") {
                                    echo $this->element("form/Hodaocaodais/tb_vertical_auto", array("data" => $val, "id" => "xaydung"));
                                } else {
                                    $name = "$id][" . $val["value"] . ".";
                                    switch ($val["key"]) {
                                        case "text":
                                            echo $this->element("layout/fields/textarea", array("name" => $name,));
                                            break;
                                        case "datetime":
                                            echo $this->element("layout/fields/date", array("name" => $name,));
                                            break;
                                        case "checkbox":
                                            echo $this->element("layout/fields/checkbox", array("name" => $name,));
                                            break;
                                        case "date":
                                            echo $this->element("layout/fields/date", array("name" => $name,));
                                            break;
                                        default:
                                            echo $this->element("layout/fields/text", array("name" => $name));
                                            break;
                                    }
                                }
                            ?>
                        </td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>

    <div class="tb1">
        <table class="table table-bordered  tb-auto" >
            <tbody>
                <tr>
                    <td colspan="3">
                        <i class="glyphicon glyphicon-remove ic_delete_vertical"></i>
                    </td>
                </tr>
                <?php foreach ($data as $key => $val) { 
                    ?>
                    <tr>
                        <th class="col-xs-2 text-left">
                            <?php echo $key; ?>
                        </th>
                        <td>
                            <?php
                                if ($key == "Nhà thờ") {
                                    echo $this->element("form/Giaoxus/tb_vertical_auto", array("data" => $val, "id" => "nhatho"));
                                } elseif ($key == "Xây dựng") {
                                    echo $this->element("form/Giaoxus/tb_vertical_auto", array("data" => $val, "id" => "xaydung"));
                                } else {
                                    $name = "$id][" . $val["value"] . ".";
                                    switch ($val["key"]) {
                                        case "text":
                                            echo $this->element("layout/fields/textarea", array("name" => $name,));
                                            break;
                                        case "datetime":
                                            echo $this->element("layout/fields/date", array("name" => $name,));
                                            break;
                                        case "checkbox":
                                            echo $this->element("layout/fields/checkbox", array("name" => $name,));
                                            break;
                                        case "date":
                                            echo $this->element("layout/fields/date", array("name" => $name,));
                                            break;
                                        default:
                                            echo $this->element("layout/fields/text", array("name" => $name));
                                            break;
                                    }
                                }
                            ?>
                        </td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>
</div>
