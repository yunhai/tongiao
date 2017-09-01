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
                            } elseif ($key == "sothanhvientrongbanchapsu_hovaten_namsinh_chucvu") {
                                echo "Số thành viên trong Ban Chấp sự";
                            } elseif ($key == "dattrongkhuonvien_tongiao_dacap_gcn_quyensudungdat" || 
                                $key == "dattrongkhuonvien_nnlnntts_dacap_gcn_quyensudungdat" || 
                                $key == "dattrongkhuonvien_gdyt_dacap_gcn_quyensudungdat" || 
                                $key == "dattrongkhuonvien_nghiadia_dacap_gcn_quyensudungdat" || 
                                $key == "dattrongkhuonvien_dsdmdk_dacap_gcn_quyensudungdat" || 
                                $key == "datngoaikhuonvien_tongiao_dacap_gcn_quyensudungdat_1" || 
                                $key == "datngoaikhuonvien_nnlnntts_dacap_gcn_quyensudungdat_1" || 
                                $key == "datngoaikhuonvien_gdyt_dacap_gcn_quyensudungdat_1" || 
                                $key == "datngoaikhuonvien_nghiadia_dacap_gcn_quyensudungdat_1" || 
                                $key == "datngoaikhuonvien_dsdmdk_dacap_gcn_quyensudungdat_1" || 
                                $key == "datngoaikhuonvien_tongiao_dacap_gcn_quyensudungdat_2" || 
                                $key == "datngoaikhuonvien_nnlnntts_dacap_gcn_quyensudungdat_2" || 
                                $key == "datngoaikhuonvien_gdyt_dacap_gcn_quyensudungdat_2" || 
                                $key == "datngoaikhuonvien_nghiadia_dacap_gcn_quyensudungdat_2" || 
                                $key == "datngoaikhuonvien_dsdmdk_dacap_gcn_quyensudungdat_2" || 
                                $key == "datngoaikhuonvien_tongiao_dacap_gcn_quyensudungdat_3" || 
                                $key == "datngoaikhuonvien_nnlnntts_dacap_gcn_quyensudungdat_3" || 
                                $key == "datngoaikhuonvien_gdyt_dacap_gcn_quyensudungdat_3" || 
                                $key == "datngoaikhuonvien_nghiadia_dacap_gcn_quyensudungdat_3" || 
                                $key == "datngoaikhuonvien_dsdmdk_dacap_gcn_quyensudungdat_3"
                            ) {
                                echo "Đã cấp GCN quyền sử dụng đất";
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
                            $key == "Năm thành lập" || 
                            $key == "Nơi ở hiện nay" || 
                            $key == "(1)" || 
                            $key == "(2)" || 
                            $key == "(3)" || 
                            $key == "Tôn giáo" || 
                            $key == "Nông nghiệp, lâm nghiệp, nuôi trồng thủy sản" ||
                            $key == "Giáo dục, y tế" || 
                            $key == "Nghĩa địa" || 
                            $key == "Đất sử dụng mục đích khác" || 
                            $key == "Cấp công nhận" || 
                            $key == "Theo Quyết định" || 
                            //$key == "Đã cấp GCN quyền sử dụng đất" || 
                            $key == "Chưa cấp GCN quyền sử dụng đất" ||  
                            $key == "Chức sắc" || 
                            $key == "Chức việc" || 
                            $key == "Tín đồ" || 
                            $key == "Hội đồng nhân dân" || 
                            $key == "Ủy Ban MTTQVN" || 
                            $key == "Công đoàn" || 
                            $key == "Hội cựu Chiến binh" || 
                            $key == "Hội Nông dân" || 
                            $key == "Hội Chữ thập đỏ" || 
                            $key == "Đoàn Thanh niên" || 
                            $key == "Hội Liên hiệp Thanh niên" || 
                            $key == "Hội Liên hiệp Phụ nữ" || 
                            $key == "Các tổ chức khác" || 
                            $key == "Các cơ quan Đảng" || 
                            $key == "Các cơ quan hành chính" || 
                            $key == "Đơn vị sự nghiệp công lập"
                        ) {
                            echo $this->element("form/Chihoitinlanhs/tb_children", array("data" => $val, "is_call" => 1));
                        } elseif ($key == "dattrongkhuonvien_tongiao_dacap_gcn_quyensudungdat" || 
                            $key == "dattrongkhuonvien_nnlnntts_dacap_gcn_quyensudungdat" || 
                            $key == "dattrongkhuonvien_gdyt_dacap_gcn_quyensudungdat" || 
                            $key == "dattrongkhuonvien_nghiadia_dacap_gcn_quyensudungdat" || 
                            $key == "dattrongkhuonvien_dsdmdk_dacap_gcn_quyensudungdat" || 
                            $key == "datngoaikhuonvien_tongiao_dacap_gcn_quyensudungdat_1" || 
                            $key == "datngoaikhuonvien_nnlnntts_dacap_gcn_quyensudungdat_1" || 
                            $key == "datngoaikhuonvien_gdyt_dacap_gcn_quyensudungdat_1" || 
                            $key == "datngoaikhuonvien_nghiadia_dacap_gcn_quyensudungdat_1" || 
                            $key == "datngoaikhuonvien_dsdmdk_dacap_gcn_quyensudungdat_1" || 
                            $key == "datngoaikhuonvien_tongiao_dacap_gcn_quyensudungdat_2" || 
                            $key == "datngoaikhuonvien_nnlnntts_dacap_gcn_quyensudungdat_2" || 
                            $key == "datngoaikhuonvien_gdyt_dacap_gcn_quyensudungdat_2" || 
                            $key == "datngoaikhuonvien_nghiadia_dacap_gcn_quyensudungdat_2" || 
                            $key == "datngoaikhuonvien_dsdmdk_dacap_gcn_quyensudungdat_2" || 
                            $key == "datngoaikhuonvien_tongiao_dacap_gcn_quyensudungdat_3" || 
                            $key == "datngoaikhuonvien_nnlnntts_dacap_gcn_quyensudungdat_3" || 
                            $key == "datngoaikhuonvien_gdyt_dacap_gcn_quyensudungdat_3" || 
                            $key == "datngoaikhuonvien_nghiadia_dacap_gcn_quyensudungdat_3" || 
                            $key == "datngoaikhuonvien_dsdmdk_dacap_gcn_quyensudungdat_3"
                        ) {
                            echo $this->element("layout/table/tb_vertical_auto", array("data" => $val, "id" => $key));
                        } else if ($key == "Điểm nhóm") {
                            echo $this->element("layout/table/tb_vertical_auto", array("data" => $val, "id" => "diemnhom"));
                        } else if ($key == "soho_dantoc_soho_sonhankhau") {
                            echo $this->element("layout/table/tb_vertical_auto", array("data" => $val, "id" => "soho_dantoc_soho_sonhankhau"));
                        } else if ($key == "Hội đoàn") {
                            echo $this->element("layout/table/tb_vertical_auto", array("data" => $val, "id" => "hoidoan"));
                        } else if ($key == "Các công trình trong khuôn viên nhà thờ chi hội") {
                            echo $this->element("layout/table/tb_vertical_auto", array("data" => $val, "id" => "caccongtrinhtrongkhuonviennhathochihoi"));
                        } else if ($key == "Các công trình ngoài khuôn viên nhà thờ của chi hội (kể cả nơi sinh hoạt của điểm nhóm)") {
                            echo $this->element("layout/table/tb_vertical_auto", array("data" => $val, "id" => "caccongtrinhngoaikhuonviennhathocuachihoi"));
                        } else if ($key == "sothanhvientrongbanchapsu_hovaten_namsinh_chucvu") {
                            echo $this->element("layout/table/tb_vertical_auto", array("data" => $val, "id" => "sothanhvientrongbanchapsu_hovaten_namsinh_chucvu"));
                        } else if ($key == "Các cơ sở quản nhiệm, phụ tá quản nhiệm, phụ trách từ trước đến nay") {
                            echo $this->element("layout/fields/textarea", array("name" => $val["value"]));
                        } else if ($key == "Các hoạt động bác ái, từ thiện xã hội, y tế, giáo dục do chi hội tổ chức thực hiện (cơ sở bảo trợ xã hội, giáo dục, y tế, từ thiện và ghi rõ người phụ trách)") {
                            echo $this->element("layout/table/tb_vertical_auto", array("data" => $val, "id" => "cachoatdongbacai"));
                        } else if ($key == "Tổ chức tại cơ sở thờ tự") {
                            echo $this->element("layout/table/tb_vertical_auto", array("data" => $val, "id" => "tochuctaicosothotu"));
                        } else if ($key == "Tổ chức ngoài cơ sở thờ tự") {
                            echo $this->element("layout/table/tb_vertical_auto", array("data" => $val, "id" => "tochucngoaicosothotu"));
                        } else if ($key == "Quan hệ với các tổ chức, cá nhân tôn giáo nước ngoài (được tài trợ kinh phí để thực hiện)") {
                            echo $this->element("layout/table/tb_vertical_auto", array("data" => $val, "id" => "quanhevoicactochuccanhantongiaonuocngoai"));
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