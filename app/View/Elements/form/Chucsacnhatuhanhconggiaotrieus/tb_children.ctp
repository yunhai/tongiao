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
                            if ($key == "ntndppt_noiphong" || 
                                $key == "ntndplm_noiphong" || 
                                $key == "ntndpgm_noiphong" || 
                                $key == "ntndpth_noiphong" 
                            ) {
                                echo "Nơi phong";
                            } elseif ($key == "cx_nambonhiem" || 
                                $key == "px_nambonhiem" || 
                                $key == "ptx_nambonhiem" || 
                                $key == "qnx_nambonhiem" || 
                                $key == "ht_nambonhiem" || 
                                $key == "tbcm_nambonhiem" || 
                                $key == "tvbtv_nambonhiem" || 
                                $key == "tvhdlm_nambonhiem" || 
                                $key == "lhchd_nambonhiem" 
                            ) {
                                echo "Năm bổ nhiệm";
                            } elseif ($key == "noiohiennay_diachi") {
                                echo "Địa chỉ";
                            } elseif ($key == "trinhdohocvan_bangcap") {
                                echo "Trình độ học vấn";
                            } elseif ($key == "trinhdochuyenmonvetongiao_bangcap") {
                                echo "Trình độ chuyên môn về tôn giáo";
                            } elseif ($key == "trinhdongoaingu_bangcap") {
                                echo "Trình độ ngoại ngữ";
                            } elseif ($key == "trinhdotinhoc_bangcap") {
                                echo "Trình độ tin học";
                            } else {
                                echo $key;
                            }
                        ?>
                    </label>
                </th>
                <?php } ?>
                <td >
                    <?php
                        if ($key == "Địa chỉ" || 
                            $key == "Nơi đăng ký hộ khẩu thường trú" || 
                            $key == "Nơi ở hiện nay" || 
                            $key == "Hội đồng nhân dân" || 
                            $key == "Ủy Ban MTTQVN" || 
                            $key == "Công đoàn" || 
                            $key == "Hội cựu Chiến binh" || 
                            $key == "Hội Nông dân" || 
                            $key == "Hội Chữ thập đỏ" || 
                            $key == "Đoàn thanh niên" || 
                            $key == "Hội Liên hiệp Thanh niên" || 
                            $key == "Hội Liên hiệp Phụ nữ" || 
                            $key == "Ủy ban, Ban Đoàn kết Công giáo" || 
                            $key == "Các tổ chức khác"
                            ) {
                            echo $this->element("form/Chucsacnhatuhanhconggiaotrieus/tb_children", array("data" => $val, "is_call" => 1));
                        } else if ($key == "Bố, mẹ đẻ") {
                            echo $this->element("form/Chucsacnhatuhanhconggiaotrieus/tb_children_quanhe", array("data" => $val, "is_call" => 1));
                        } else if ($key == "Anh chị em ruột") {
                            echo $this->element("layout/table/tb_vertical_auto", array("data" => $val, "id" => "anhchiemruot"));
                        } else if ($key == "Trình độ học vấn") {
                            echo $this->element("layout/table/tb_vertical_auto", array("data" => $val, "id" => "trinhdohocvan"));
                        } else if ($key == "Trình độ chuyên môn về tôn giáo") {
                            echo $this->element("layout/table/tb_vertical_auto", array("data" => $val, "id" => "trinhdochuyenmonvetongiao"));
                        } else if ($key == "Trình độ ngoại ngữ") {
                            echo $this->element("layout/table/tb_vertical_auto", array("data" => $val, "id" => "trinhdongoaingu"));
                        } else if ($key == "Trình độ tin học") {
                            echo $this->element("layout/table/tb_vertical_auto", array("data" => $val, "id" => "trinhdotinhoc"));
                        } else if ($key == "Chức vụ khác và thời gian được bổ nhiệm") {
                            echo $this->element("layout/fields/textarea", array("name" => $val["value"]));
                        } else if ($key == "Đã qua các lớp đào tạo, bồi dưỡng về tôn giáo trong nước") {
                            echo $this->element("layout/table/tb_vertical_auto", array("data" => $val, "id" => "daquacaclopdaotaoboiduongvetongiaotrongnuoc"));
                        } else if ($key == "Quá trình hoạt động tôn giáo ở trong nước") {
                            echo $this->element("layout/table/tb_vertical_auto", array("data" => $val, "id" => "quatrinhhoatdongtongiaootrongnuoc"));
                        } else if ($key == "Đã qua các lớp đào tạo, bồi dưỡng về tôn giáo ở nước ngoài") {
                            echo $this->element("layout/table/tb_vertical_auto", array("data" => $val, "id" => "daquacaclopdaotaoboiduongvetongiaoonuocngoai"));
                        } else if ($key == "Quá trình hoạt động tôn giáo ở nước ngoài") {
                            echo $this->element("layout/table/tb_vertical_auto", array("data" => $val, "id" => "quatrinhhoatdongtongiaoonuocngoai"));
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