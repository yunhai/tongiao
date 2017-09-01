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
                            $key == "Nơi ở hiện nay" || 
                            $key == "Nam (tăng)" || 
                            $key == "Nữ (ni)" || 
                            $key == "Dưới 18 tuổi" || 
                            $key == "Trên 18 tuổi" || 
                            $key == "11.2 Loại hình đạo tràng (đạo tràng Niệm phật, Bát Quan trai,...)" || 
                            $key == "Tôn giáo" || 
                            $key == "Nông nghiệp, lâm nghiệp, nuôi trồng thủy sản" ||
                            $key == "Giáo dục, y tế" || 
                            $key == "Đất sử dụng mục đích khác" ||
                            $key == "Cấp công nhận" || 
                            $key == "Theo Quyết định" || 
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
                            $key == "Các tổ chức khác" || 
                            $key == "Các cơ quan Đảng" || 
                            $key == "Hội đồng nhân dân" || 
                            $key == "Các cơ quan hành chính" || 
                            $key == "Ủy Ban MTTQVN" || 
                            $key == "Hội Nông dân" || 
                            $key == "Hội Liên hiệp Thanh niên" || 
                            $key == "Hội Liên hiệp Phụ nữ" || 
                            $key == "Đơn vị sự nghiệp công lập" || 
                            $key == "Các tổ chức khác" || 
                            $key == "Cấp công nhận" || 
                            $key == "Theo Quyết định" || 
                            $key == "Số lượng nhà tu hành tham gia" || 
                            $key == "Số phật tử tham gia" || 
                            //$key == "Đã cấp GCN quyền sử dụng đất" || 
                            $key == "Chưa cấp GCN quyền sử dụng đất" || 
                            $key == "(1)" || 
                            $key == "(2)" ||
                            $key == "(3)"
                        ) {
                            echo $this->element("form/Tuvienphatgiaos/tb_children", array("data" => $val, "is_call" => 1));
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
                        } else if ($key == "soho_dantoc_soho_sonhankhau") {
                            echo $this->element("layout/table/tb_vertical_auto", array("data" => $val, "id" => "soho_dantoc_soho_sonhankhau"));
                        } else if ($key == "Các công trình trong khuôn viên của tự, viện") {
                            echo $this->element("layout/table/tb_vertical_auto", array("data" => $val, "id" => "caccongtrinhtrongkhuonviencuatuvien"));
                        } else if ($key == "Các công trình ngoài khuôn viên của tự, viện") {
                            echo $this->element("layout/table/tb_vertical_auto", array("data" => $val, "id" => "caccongtrinhngoaikhuonviencuatuvien"));
                        } else if ($key == "Tu sĩ đang tu học tại tự, viện") {
                            echo $this->element("layout/table/tb_vertical_auto", array("data" => $val, "id" => "tusidangtuhoctaituvien"));
                        } else if ($key == "Các hoạt động bác ái, từ thiện xã hội, y tế, giáo dục do tự, viện tổ chức thực hiện (cơ sở bảo trợ xã hội, giáo dục, y tế, từ thiện và ghi rõ người phụ trách)") {
                            echo $this->element("layout/table/tb_vertical_auto", array("data" => $val, "id" => "cachoatdongbacai"));
                        } else if ($key == "Tổ chức trong khuôn viên tự, viện") {
                            echo $this->element("layout/table/tb_vertical_auto", array("data" => $val, "id" => "tochuctrongkhuonvientuvien"));
                        } else if ($key == "Tổ chức ngoài khuôn viên tự, viện") {
                            echo $this->element("layout/table/tb_vertical_auto", array("data" => $val, "id" => "tochucngoaikhuonvientuvien"));
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