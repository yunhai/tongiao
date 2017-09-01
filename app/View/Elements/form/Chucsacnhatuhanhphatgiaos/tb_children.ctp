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
                            if ($key == "ntg_thogioi_thuctykheo_hoac_kheoni") {
                                echo "Nơi thọ giới";
                            } elseif ($key == "ntg_tanphong_hoathuong_hoac_nitruong") {
                                echo "Nơi tấn phong";
                            } elseif ($key == "tv_bantrisu_caphuyen_namsuycu" || 
                                $key == "cm_bantrisu_caphuyen_namsuycu" || 
                                $key == "tv_bantrisu_captinh_namsuycu" || 
                                $key == "cm_bantrisu_captinh_namsuycu" || 
                                $key == "tv_hoidong_trisu_namsuycu" || 
                                $key == "tv_hoidong_chungminh_namsuycu"
                                ) {
                                echo "Năm suy cử";
                            } elseif ($key == "trinhdohocvan_bangcap") {
                                echo "Trình độ học vấn";
                            } elseif ($key == "trinhdochuyenmonvetongiao_bangcap") {
                                echo "Trình độ chuyên môn về tôn giáo";
                            } elseif ($key == "trinhdongoaingu_bangcap") {
                                echo "Trình độ ngoại ngữ";
                            } elseif ($key == "trinhdotinhoc_bangcap") {
                                echo "Trình độ tin học";
                            } elseif ($key == "bonsu_phamsachiennay_gioipham" || $key == "ychisu_phamsachiennay_gioipham") {
                                echo "Giới phẩm";
                            } elseif ($key == "bonsu_phamsachiennay_giaopham" || $key == "ychisu_phamsachiennay_giaopham") {
                                echo "Giáo phẩm";
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
                            $key == "Giới phẩm" || 
                            $key == "Giáo phẩm" || 
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
                            echo $this->element("form/Chucsacnhatuhanhphatgiaos/tb_children", array("data" => $val, "is_call" => 1));
                        } else if ($key == "Trình độ học vấn") {
                            echo $this->element("layout/table/tb_vertical_auto", array("data" => $val, "id" => "trinhdohocvan"));
                        } else if ($key == "Trình độ chuyên môn về tôn giáo") {
                            echo $this->element("layout/table/tb_vertical_auto", array("data" => $val, "id" => "trinhdochuyenmonvetongiao"));
                        } else if ($key == "Trình độ ngoại ngữ") {
                            echo $this->element("layout/table/tb_vertical_auto", array("data" => $val, "id" => "trinhdongoaingu"));
                        } else if ($key == "Trình độ tin học") {
                            echo $this->element("layout/table/tb_vertical_auto", array("data" => $val, "id" => "trinhdotinhoc"));
                        } else if ($key == "Bố, mẹ đẻ") {
                            echo $this->element("form/Chucsacnhatuhanhphatgiaos/tb_children_quanhe", array("data" => $val, "is_call" => 1));
                        } else if ($key == "Bố, mẹ vợ (chồng)") {
                            echo $this->element("form/Chucsacnhatuhanhphatgiaos/tb_children_quanhe", array("data" => $val, "is_call" => 1));
                        } else if ($key == "Anh chị em ruột") {
                            echo $this->element("layout/table/tb_vertical_auto", array("data" => $val, "id" => "anhchiemruot"));
                        } else if ($key == "Anh chị em vợ (chồng)") {
                            echo $this->element("layout/table/tb_vertical_auto", array("data" => $val, "id" => "anhchiemvochong"));
                        } else if ($key == "Vợ (chồng) và con") {
                            echo $this->element("layout/table/tb_vertical_auto", array("data" => $val, "id" => "vochongvacon"));
                        } else if ($key == "Đã qua các lớp đào tạo, bồi dưỡng về tôn giáo trong nước") {
                            echo $this->element("layout/table/tb_vertical_auto", array("data" => $val, "id" => "daquacaclopdaotaoboiduongvetongiaotrongnuoc"));
                        } else if ($key == "Đã qua các lớp đào tạo, bồi dưỡng về tôn giáo ở ngoài nước") {
                            echo $this->element("layout/table/tb_vertical_auto", array("data" => $val, "id" => "daquacaclopdaotaoboiduongvetongiaoongoainuoc"));
                        } else if ($key == "Quá trình hoạt động tôn giáo ở trong nước") {
                            echo $this->element("layout/table/tb_vertical_auto", array("data" => $val, "id" => "quatrinhhoatdongtongiaootrongnuoc"));
                        } else if ($key == "Quá trình hoạt động tôn giáo ở nước ngoài") {
                            echo $this->element("layout/table/tb_vertical_auto", array("data" => $val, "id" => "quatrinhhoatdongtongiaoonuocngoai"));
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