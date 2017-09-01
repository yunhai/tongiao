<table class="table table-bordered col-xs-12 tb-generator">
    <tbody>
        <?php
        $is_call = !empty($is_call) ? $is_call : 0;
        foreach ($data as $key => $val) {
            ?>
            <tr>
                <?php if (!in_array($key, array('cacthongtinkhac', 'kiennghi'))) { ?>
                <th class="col-xs-2 text-left">
                    <label class="control-label pull-right">
                        <?php 
                            if ($key == "phutrachnganhthieu_liendoantruong" || $key == "phutrachnganhoanh_liendoantruong" || $key == "phutrachsennon_liendoantruong") {
                                echo "Liên đoàn trưởng";
                            } elseif ($key == "phutrachnganhthieu_liendoanpho" || $key == "phutrachnganhoanh_liendoanpho" || $key == "phutrachsennon_liendoanpho") {
                                echo "Liên đoàn phó";
                            } elseif ($key == "phutrachnganhthieu_thuky" || $key == "phutrachnganhoanh_thuky" || $key == "phutrachsennon_thuky") {
                                echo "Thư ký";
                            } elseif ($key == "dathocap_captap") {
                                echo "Cấp tập";
                            } elseif ($key == "dathocap_captin") {
                                echo "Cấp tín";
                            } elseif ($key == "dathocap_captan") {
                                echo "Cấp tấn";
                            } elseif ($key == "dathocap_capdung") {
                                echo "Cấp dũng";
                            } else {
                                echo $key;
                            }
                        ?>
                    </label>
                </th>
                <?php } ?>
                <td >
                    <?php
                        if ($key == "Chứng minh nhân dân" || 
                            $key == "Nguyên quán" || 
                            $key == "Nơi đăng ký hộ khẩu thường trú" || 
                            $key == "Nơi ở hiện nay" || 
                            $key == "Liên đoàn trưởng" || 
                            $key == "Liên đoàn phó" || 
                            $key == "Thư ký" || 
                            $key == "Đã thọ cấp" || 
                            $key == "dathocap_captap" || 
                            $key == "dathocap_captin" || 
                            $key == "dathocap_captan" ||
                            $key == "dathocap_capdung"
                        ) {
                            echo $this->element("form/Giadinhphattus/tb_children", array("data" => $val, "is_call" => 1));
                        } else if ($key == "a) Thanh nam") {
                            echo $this->element("form/Giadinhphattus/tb_children_phuttrach", array("data" => $val, "is_call" => 1));
                        } else if ($key == "b) Thanh nữ") {
                            echo $this->element("form/Giadinhphattus/tb_children_phuttrach", array("data" => $val, "is_call" => 1));
                        } else if ($key == "Nhân sự đã được thọ cấp tính đến nay") {
                            echo $this->element("layout/table/tb_vertical_auto", array("data" => $val, "id" => "nhansudaduocthocaptinhdennay"));
                        } else if ($key == "Nhân sự đã qua đào tạo, bồi dưỡng tính đến nay") {
                            echo $this->element("layout/table/tb_vertical_auto", array("data" => $val, "id" => "nhansudaquadaotaoboiduongtinhdennay"));
                        } else if ($key == "Nhân sự đã qua các trại huấn luyện tính đến nay") {
                            echo $this->element("layout/table/tb_vertical_auto", array("data" => $val, "id" => "nhansudaquacactraihuanluyentinhdennay"));
                        } else if ($key == "Các hoạt động tổ chức trong khuôn viên tự, viện") {
                            echo $this->element("layout/table/tb_vertical_auto", array("data" => $val, "id" => "cachoatdongtochuctrongkhuonvientuvien"));
                        } else if ($key == "Các hoạt động tổ chức ngoài: khuôn viên tự, viện") {
                            echo $this->element("layout/table/tb_vertical_auto", array("data" => $val, "id" => "cachoatdongtochucngoaikhuonvientuvien"));
                        } else if (in_array($key, array('cacthongtinkhac', 'kiennghi'))) {
                            echo $this->element("layout/fields/textarea", array("name" => $val["value"]));
                        } else {
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
                        }
                    ?>
                </td>
            </tr>
<?php } ?>
    </tbody>
</table>