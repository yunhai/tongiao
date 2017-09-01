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
                            if ($key == "mucsu_congnhan") {
                                echo "Đã được Nhà nước công nhận";
                            } elseif ($key == "mucsu_chuacongnhan") {
                                echo "Chưa được Nhà nước công nhận";
                            } elseif ($key == "mucsunhiemchuc_congnhan") {
                                echo "Đã được Nhà nước công nhận";
                            } elseif ($key == "mucsunhiemchuc_chuacongnhan") {
                                echo "Chưa được Nhà nước công nhận";
                            } elseif ($key == "truyendao_congnhan") {
                                echo "Đã được Nhà nước công nhận";
                            } elseif ($key == "truyendao_chuacongnhan") {
                                echo "Chưa được Nhà nước công nhận";
                            } elseif ($key == "soho_dantoc_soho_sonhankhau") {
                                echo "Số hộ";
                            } elseif ($key == "trinhdohocvan_bangcap") {
                                echo "Trình độ học vấn";
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
                            $key == "Đảng cộng sản Việt Nam" || 
                            $key == "Hội đồng nhân dân" || 
                            $key == "Ủy Ban MTTQVN" || 
                            $key == "Công đoàn" || 
                            $key == "Hội cựu Chiến binh" || 
                            $key == "Hội Nông dân" || 
                            $key == "Hội Chữ thập đỏ" || 
                            $key == "Đoàn thanh niên" || 
                            $key == "Hội Liên hiệp Thanh niên" || 
                            $key == "Hội Liên hiệp Phụ nữ" || 
                            $key == "Các tổ chức khác"
                            ) {
                            echo $this->element("form/Nguoihoatdongtinnguongchuyennghieps/tb_children", array("data" => $val, "is_call" => 1));
                        } else if ($key == "Trình độ học vấn") {
                            echo $this->element("layout/table/tb_vertical_auto", array("data" => $val, "id" => "trinhdohocvan"));
                        } else if ($key == "Trình độ ngoại ngữ") {
                            echo $this->element("layout/table/tb_vertical_auto", array("data" => $val, "id" => "trinhdongoaingu"));
                        } else if ($key == "Trình độ tin học") {
                            echo $this->element("layout/table/tb_vertical_auto", array("data" => $val, "id" => "trinhdotinhoc"));
                        }  else if ($key == "Bố, mẹ đẻ") {
                            echo $this->element("form/Nguoihoatdongtinnguongchuyennghieps/tb_children_quanhe", array("data" => $val, "is_call" => 1));
                        } else if ($key == "Bố, mẹ vợ (chồng)") {
                            echo $this->element("form/Nguoihoatdongtinnguongchuyennghieps/tb_children_quanhe", array("data" => $val, "is_call" => 1));
                        } else if ($key == "Anh chị em ruột") {
                            echo $this->element("layout/table/tb_vertical_auto", array("data" => $val, "id" => "anhchiemruot"));
                        } else if ($key == "Anh chị em vợ (chồng)") {
                            echo $this->element("layout/table/tb_vertical_auto", array("data" => $val, "id" => "anhchiemvochong"));
                        } else if ($key == "Vợ (chồng) và con") {
                            echo $this->element("layout/table/tb_vertical_auto", array("data" => $val, "id" => "vochongvacon"));
                        } else if ($key == "Các chức danh tín ngưỡng đã kinh qua") {
                            echo $this->element("layout/table/tb_vertical_auto", array("data" => $val, "id" => "cacchucdanhtinnguongdakinhqua"));
                        } else if ($key == "Quá trình hoạt động tín ngưỡng ở trong nước") {
                            echo $this->element("layout/table/tb_vertical_auto", array("data" => $val, "id" => "quatrinhhoatdongtinnguongotrongnuoc"));
                        } else if ($key == "Quá trình hoạt động tín ngưỡng ở nước ngoài (nếu có)") {
                            echo $this->element("layout/table/tb_vertical_auto", array("data" => $val, "id" => "quatrinhhoatdongtinnguongonuocngoaineuco"));
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