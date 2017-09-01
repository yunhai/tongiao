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
                        switch ($val["key"]) {
                            case "text":
                                echo $this->element("layout/fields/textarea", array("name" => $val["value"]));
                                break;
                            case "datetime":
                                echo $this->element("layout/fields/date", array("name" => $val["value"]));
                                break;
                            case "checkbox":
                                echo $this->element("layout/fields/checkbox", array("name" => $val["value"]));
                                break;
                            case "date":
                                echo $this->element("layout/fields/date", array("name" => $val["value"]));
                                break;
                            default:
                                echo $this->element("layout/fields/text", array("name" => $val["value"]));
                                break;
                        }
                    ?>
                </td>
            </tr>
<?php } ?>
    </tbody>
</table>