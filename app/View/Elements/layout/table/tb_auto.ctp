<a class="btn btn-default add_row pull-left" ref="tb_<?php echo $id; ?>"><i class="glyphicon glyphicon-plus"></i> Thêm</a>
<table class="table table-bordered  tb-auto" id="tb_<?php echo $id; ?>">
    <tbody>
        <tr class='addr0'>
            <?php foreach ($data as $key => $val) { ?>
                <td> 
                    <?php
                    $name = "$id][" . $val["value"] . ".";
                    switch ($val["key"]) {
                        case "text":
                            echo $this->element("layout/fields/textarea", array("name" => $name, "place_holder" => $key, "value" => "", ));
                            break;
                        case "datetime":
                            echo $this->element("layout/fields/date", array("name" => $name, "place_holder" => $key, "value" => "", ));
                            break;
                        case "checkbox":
                            echo $this->element("layout/fields/checkbox", array("name" => $name, "place_holder" => $key, "value" => "", ));
                            break;
                        case "date":
                            echo $this->element("layout/fields/date", array("name" => $name, "place_holder" => $key, "value" => "", ));
                            break;
                        default:
                            echo $this->element("layout/fields/text", array("name" => $name, "place_holder" => $key, "value" => "", ));
                            break;
                    }
                    ?>
                </td>
            <?php } ?>
            <td class="text-center" valing="center">
                <i class="glyphicon glyphicon-remove ic_delete"></i>
            </td>
        </tr>
        <tr class='addr1'>
            <?php foreach ($data as $key => $val) { ?>
                <td> 
                    <?php
                    $name = "$id][" . $val["value"] . ".";
                    switch ($val["key"]) {
                        case "text":
                            echo $this->element("layout/fields/textarea", array("name" => $name, "place_holder" => $key, ));
                            break;
                        case "datetime":
                            echo $this->element("layout/fields/date", array("name" => $name, "place_holder" => $key, ));
                            break;
                        case "checkbox":
                            echo $this->element("layout/fields/checkbox", array("name" => $name, "place_holder" => $key,  ));
                            break;
                        case "date":
                            echo $this->element("layout/fields/date", array("name" => $name, "place_holder" => $key,  ));
                            break;
                        default:
                              echo $this->element("layout/fields/text", array("name" => $name, "place_holder" => $key, ));
                            break;
                    }
                    ?>
                   
                </td>
            <?php } ?>
            <td class="text-center" valing="center">
                <i class="glyphicon glyphicon-remove ic_delete"></i>
            </td>
        </tr>
    </tbody>
</table>