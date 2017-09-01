<a class="btn btn-default add_row_vertical pull-left" ref="tb_vertical_<?php echo $id; ?>"><i class="glyphicon glyphicon-plus"></i> Thêm</a>
<div id="tb_vertical_<?php echo $id; ?>">
    <div class="tb0">
        <table class="table table-bordered  tb-auto" >
            <tbody>
                <tr>
                    <td colspan="3">
                        <i class="glyphicon glyphicon-remove ic_delete_vertical"></i>
                    </td>
                </tr>
                <?php foreach ($data as $key => $val) { ?>
                    <tr>
                        <th class="col-xs-2 text-left">
                            <?php echo $key; ?>
                            </td>
                        <td>
                            <?php
                            $name = "$id][" . $val["value"] . ".";

                            switch ($val["key"]) {
                                case "text":
                                    echo $this->element("layout/fields/textarea", array("name" => $name, "value" => "",));
                                    break;
                                case "datetime":
                                    echo $this->element("layout/fields/date", array("name" => $name, "value" => "",));
                                    break;
                                case "checkbox":
                                    ?>  
                                <!--                                               <input type="checkbox" name="data[<?php echo $model; ?>][<?php echo $id; ?>][<?php echo $val["value"]; ?>][]" value="1">-->
                                    <?php
                                    echo $this->element("layout/fields/checkbox", array("name" => $name, "value" => ""));
                                    break;
                                case "date":
                                    echo $this->element("layout/fields/date", array("name" => $name, "value" => "",));
                                    break;
                                case "year":
                                    echo $this->element("layout/fields/date", array("name" => $name, "modeDate" => "modeYear"));
                                    break;
                                case "select":
                                    echo $this->element("layout/fields/select", array('id' => $id, "name" => $name, "val" => $val, "value" => ""));
                                    break;
                                default:
                                    echo $this->element("layout/fields/text", array("name" => $name, "value" => "",));
                                    break;
                            }
                            ?>
                        </td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>

    <?php
//                pr($this->request->data["Chucsactinlanh"][$id]);
//                pr($id);
//                foreach ($this->request->data["Chucsactinlanh"][$id] as $val) {
//                    
//                }
    $key_tb = 1;
    if (!empty($this->request->data[$model][$id])) {
        foreach ($this->request->data[$model][$id] as $v) {
            ?>
            <div class="tb<?php echo $key_tb; ?>">
                <table class="table table-bordered  tb-auto" >
                    <tbody>
                        <tr>
                            <td colspan="3">
                                <i class="glyphicon glyphicon-remove ic_delete_vertical"></i>
                            </td>
                        </tr>
                        <?php foreach ($data as $key => $val) { ?>
                            <tr>
                                <th class="col-xs-2 text-left">
                                    <?php echo $key; ?>
                                    </td>
                                <td>
                                    <?php
//                                    pr($v);
//                                    pr($val["value"]);

                                    $name = "$id][" . $val["value"] . ".";
                                    $str = !empty($v[$val["value"]]) ? $v[$val["value"]] : "";
                                    switch ($val["key"]) {
                                        case "text":
                                            echo $this->element("layout/fields/textarea", array("name" => $name, "value" => $str));
                                            break;
                                        case "datetime":
                                            echo $this->element("layout/fields/date", array("name" => $name, "value" => $str));
                                            break;
                                        case "checkbox":
                                            ?>  
                                                                        <!--                                               <input type="checkbox" name="data[<?php echo $model; ?>][<?php echo $id; ?>][<?php echo $val["value"]; ?>][]" value="1">-->
                                            <?php
                                            echo $this->element("layout/fields/checkbox", array("name" => $name, "value" => $str));
                                            break;
                                        case "date":
                                            echo $this->element("layout/fields/date", array("name" => $name, "value" => $str));
                                            break;
                                        case "year":
                                            echo $this->element("layout/fields/date", array("name" => $name, "modeDate" => "modeYear", "value" => $str));
                                            break;
                                        case "select":
                                            echo $this->element("layout/fields/select", array('id' => $id, "name" => $name,  "val" => $val, "value" => $str, "key_tb" => $key_tb));
                                            break;
                                        default:
                                            echo $this->element("layout/fields/text", array("name" => $name, "value" => $str));
                                            break;
                                    }
                                    ?>
                                </td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
            <?php
            $key_tb ++;
        }
    } else {
        ?>

        <div class="tb<?php echo $key_tb; ?>">
            <table class="table table-bordered  tb-auto" >
                <tbody>
                    <tr>
                        <td colspan="3">
                            <i class="glyphicon glyphicon-remove ic_delete_vertical"></i>
                        </td>
                    </tr>
                    <?php foreach ($data as $key => $val) { ?>
                        <tr>
                            <th class="col-xs-2 text-left">
                                <?php echo $key; ?>
                                </td>
                            <td>
                                <?php
                                $name = "$id][" . $val["value"] . ".";
                                switch ($val["key"]) {
                                    case "text":
                                        echo $this->element("layout/fields/textarea", array("name" => $name,));
                                        break;
                                    case "datetime":
                                        echo $this->element("layout/fields/date", array("name" => $name,));
                                        break;
                                    case "checkbox":
                                        ?>  
                                                                        <!--                                               <input type="checkbox" name="data[<?php echo $model; ?>][<?php echo $id; ?>][<?php echo $val["value"]; ?>][]" value="1">-->
                                        <?php
                                        echo $this->element("layout/fields/checkbox", array("name" => $name));
                                        break;
                                    case "date":
                                        echo $this->element("layout/fields/date", array("name" => $name,));
                                        break;
                                    case "year":
                                        echo $this->element("layout/fields/date", array("name" => $name, "modeDate" => "modeYear"));
                                        break;
                                    case "select":
                                        echo $this->element("layout/fields/select", array('id' => $id, "name" => $name,  "val" => $val, "value" => ""));
                                        break;
                                    default:
                                        echo $this->element("layout/fields/text", array("name" => $name));
                                        break;
                                }
                                ?>
                            </td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>

    <?php }
    ?>


</div>
