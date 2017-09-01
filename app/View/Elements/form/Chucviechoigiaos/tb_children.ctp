<table class="table table-bordered col-xs-12 tb-generator">
    <tbody>
        <?php
        $is_call = !empty($is_call) ? $is_call : 0;
        foreach ($data as $key => $val) {
            ?>
            <tr>
                <?php if (!in_array($key, array('cacthongtinkhac', 'kiennghi'))) { 
                ?>
                <th class="col-xs-2 text-left">
                    <label class="control-label pull-right">
                        <?php 
                            if ($key == "soho_dantoc_soho_sonhankhau") {
                                echo "Số hộ";
                            } elseif ($key == "ntndbnhdchakim_noibonhiem" || 
                                $key == "ntndbnhdcnaep_noibonhiem" || 
                                $key == "ntndbnhdckhotip_noibonhiem" || 
                                $key == "ntndbnhdcimam_noibonhiem" || 
                                $key == "ntndbnhdctuon_noibonhiem"
                            ) {
                                echo "Nơi bổ nhiệm";
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
                            $key == "Nơi ở hiện nay" || 
                            $key == "soho_dantoc_soho_sonhankhau" || 
                            $key == "Tôn giáo" || 
                            $key == "Nông nghiệp, lâm nghiệp, nuôi trồng thủy sản" ||
                            $key == "Giáo dục, y tế" || 
                            $key == "Đất sử dụng mục đích khác" ||
                            $key == "Cấp công nhận" || 
                            $key == "Theo Quyết định" || 
                            $key == "Hội đồng nhân dân" || 
                            $key == "Ủy Ban MTTQVN" || 
                            $key == "Hội Chữ thập đỏ" || 
                            $key == "Đoàn thanh niên" || 
                            $key == "Hội Liên hiệp Thanh niên" || 
                            $key == "Hội Liên hiệp Phụ nữ" || 
                            $key == "Các tổ chức khác" || 
                            $key == "Hội đồng nhân dân" || 
                            $key == "Hội Nông dân" || 
                            $key == "Tổ chức khác" || 
                            $key == "Số lượng nhà tu hành tham gia" || 
                            $key == "Số phật tử tham gia" || 
                            $key == "Số lượng chức sắc tham gia" || 
                            $key == "Số lượng chức việc tham gia" || 
                            $key == "Số tín đồ tham gia"
                            
                        ) {
                            echo $this->element("form/Chucviechoigiaos/tb_children", array("data" => $val, "is_call" => 1));
                        }else if ($key == "Trình độ học vấn") {
                            echo $this->element("layout/table/tb_vertical_auto", array("data" => $val, "id" => "trinhdohocvan"));
                        } else if ($key == "Trình độ ngoại ngữ") {
                            echo $this->element("layout/table/tb_vertical_auto", array("data" => $val, "id" => "trinhdongoaingu"));
                        } else if ($key == "Trình độ tin học") {
                            echo $this->element("layout/table/tb_vertical_auto", array("data" => $val, "id" => "trinhdotinhoc"));
                        } else if ($key == "Bố, mẹ đẻ") {
                            echo $this->element("form/Chucsactinlanhs/tb_children_quanhe", array("data" => $val, "is_call" => 1));
                        } else if ($key == "Bố, mẹ vợ (chồng)") {
                            echo $this->element("form/Chucsactinlanhs/tb_children_quanhe", array("data" => $val, "is_call" => 1));
                        } else if ($key == "Anh chị em ruột") {
                            echo $this->element("layout/table/tb_vertical_auto", array("data" => $val, "id" => "anhchiemruot"));
                        } else if ($key == "Anh chị em vợ (chồng)") {
                            echo $this->element("layout/table/tb_vertical_auto", array("data" => $val, "id" => "anhchiemvochong"));
                        } else if ($key == "Vợ (chồng) và con") {
                            echo $this->element("layout/table/tb_vertical_auto", array("data" => $val, "id" => "vochongvacon"));
                        } else if ($key == "Đã cấp GCN quyền sử dụng đất") {
                            echo $this->element("form/Chihoitinhdocusiphatgiaovietnams/tb_children_datdai", array("data" => $val, "is_call" => 1));
                        } else if ($key == "Chưa cấp GCN quyền sử dụng đất") {
                            echo $this->element("form/Chihoitinhdocusiphatgiaovietnams/tb_children_datdai", array("data" => $val, "is_call" => 1));
                        } else if ($key == "Chức vụ khác và thời gian được bổ nhiệm") {
                            echo $this->element("layout/fields/textarea", array("name" => $val["value"]));
                        } else if ($key == "Đã qua các lớp đào tạo, bồi dưỡng về tôn giáo ở trong nước") {
                            echo $this->element("layout/table/tb_vertical_auto", array("data" => $val, "id" => "daquacaclopdaotaoboiduongvetongiaootrongnuoc"));
                        } else if ($key == "Quá trình hoạt động tôn giáo ở trong nước") {
                            echo $this->element("layout/table/tb_vertical_auto", array("data" => $val, "id" => "quatrinhhoatdongtongiaootrongnuoc"));
                        } else if ($key == "Quá trình tu học và hoạt động tôn giáo ở nước ngoài") {
                            echo $this->element("layout/table/tb_vertical_auto", array("data" => $val, "id" => "quatrinhtuhocvahoatdongtongiaoonuocngoai"));
                        } else if ($key == "Chức vụ khác và thời gian được bổ nhiệm") {
                            echo $this->element("layout/fields/textarea", array("name" => $val["value"]));
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