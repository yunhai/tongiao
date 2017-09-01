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
                            if ($key == "soho_dantoc_soho_sonhankhau" || 
                                $key == "giaodancohokhau_soho" || 
                                $key == "giaodandidan_soho" || 
                                $key == "giaodandantocthieuso_soho"
                            ) {
                                echo "Số hộ";
                            } elseif ($key == "shdddcphd_soluonghoivien" || $key == "shdcdcphd_soluonghoivien") {
                                echo "Số lượng hội viên";
                            } elseif ($key == "shdddcphd" || $key == "shdcdcphd" ) {
                                echo "Số hội đoàn";
                            } elseif ($key == "solinhmucphoxu_phoxu1_nguyenquan" || 
                                $key == "solinhmucphoxu_phoxu2_nguyenquan" || 
                                $key == "solinhmucphoxu_phoxu3_nguyenquan" || 
                                $key == "phote_nguyenquan"
                            ) {
                                echo "Nguyên quán";
                            } elseif ($key == "phonoi_namsinh" || $key == "phongoai_namsinh" || $key == "thuky_namsinh") {
                                echo "Năm sinh";
                            } elseif ($key == "phonoi_sodienthoai" || $key == "phongoai_sodienthoai" || $key == "thuky_sodienthoai") {
                                echo "Số điện thoại";
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
                        if ($key == "Chứng minh nhân dân" || 
                            $key == "Địa chỉ (nhà thờ xứ)" || 
                            $key == "Giáo dân có hộ khẩu" || 
                            $key == "Giáo dân di dân" || 
                            $key == "Giáo dân dân tộc thiểu số" || 
                            $key == "Tôn giáo" || 
                            $key == "Nông nghiệp, lâm nghiệp, nuôi trồng thủy sản" ||
                            $key == "Giáo dục, y tế" || 
                            $key == "Nghĩa địa" || 
                            $key == "Đất sử dụng mục đích khác" || 
                            $key == "Cấp công nhận" || 
                            $key == "Theo Quyết định" || 
                            $key == "Nguyên quán" || 
                            $key == "a) Phó xứ 1" || 
                            $key == "b) Phó xứ 2" || 
                            $key == "c) Phó xứ 3" || 
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
                            $key == "Số lượng linh mục, nhà tu hành tham gia" || 
                            $key == "Số giáo dân tham gia" || 
                            $key == "Số giáo dân đang làm việc tại các cơ quan nhà nước, tổ chức chính trị - xã hội" || 
                            //$key == "Đã cấp GCN quyền sử dụng đất" || 
                            $key == "Chưa cấp GCN quyền sử dụng đất" || 
                            $key == "(1)" || 
                            $key == "(2)" || 
                            $key == "(3)"
                        ) {
                            echo $this->element("form/Giaoxus/tb_children", array("data" => $val, "is_call" => 1));
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
                        } else if ($key == "Giáo họ") {
                            echo $this->element("layout/table/tb_vertical_auto", array("data" => $val, "id" => "giaoho"));
                        } else if ($key == "Hội đoàn phục vụ lễ nghi tôn giáo") {
                            echo $this->element("layout/table/tb_vertical_auto", array("data" => $val, "id" => "hoidoanphucvulenghitongiao"));
                        } else if ($key == "shdddcphd") {
                            echo $this->element("layout/table/tb_vertical_auto", array("data" => $val, "id" => "sohoidoanduoccapphephoatdong_sohoidoan"));
                        } else if ($key == "shdcdcphd") {
                            echo $this->element("layout/table/tb_vertical_auto", array("data" => $val, "id" => "sohoidoanchuaduoccapphephoatdong_sohoidoan"));
                        } else if ($key == "Các công trình trong khuôn viên của nhà thờ xứ") {
                            echo $this->element("layout/table/tb_vertical_auto", array("data" => $val, "id" => "caccongtrinhtrongkhuonviencuanhathoxu"));
                        } else if ($key == "Các công trình ngoài khuôn viên của nhà thờ xứ") {
                            echo $this->element("layout/table/tb_vertical_auto", array("data" => $val, "id" => "caccongtrinhngoaikhuonviencuanhathoxu"));
                        } else if ($key == "Ủy viên") {
                            echo $this->element("layout/table/tb_vertical_auto", array("data" => $val, "id" => "uyvien"));
                        } else if ($key == "Tại giáo xứ có cộng đoàn, dòng tu, tu viện, đan viện nào đang hoạt động tôn giáo") {
                            echo $this->element("layout/table/tb_vertical_auto", array("data" => $val, "id" => "taigiaoxucocongdoan_danghoatdongtongiao"));
                        } else if ($key == "Các hoạt động bác ái, từ thiện xã hội, y tế, giáo dục do giáo xứ tổ chức thực hiện (cơ sở bảo trợ xã hội, giáo dục, y tế, từ thiện và ghi rõ người phụ trách)") {
                            echo $this->element("layout/table/tb_vertical_auto", array("data" => $val, "id" => "cachoatdongbacai_dogiaoxu"));
                        } else if ($key == "Các hoạt động bác ái, từ thiện xã hội, y tế, giáo dục do dòng tu (cộng đoàn, tu viện) hoạt động tôn giáo giáo xứ tổ chức thực hiện (cơ sở bảo trợ xã hội, giáo dục, y tế, từ thiện và ghi rõ người phụ trách)") {
                            echo $this->element("layout/table/tb_vertical_auto", array("data" => $val, "id" => "cachoatdongbacai_dodongtu"));
                        } else if ($key == "Tổ chức trong khuôn viên giáo xứ") {
                            echo $this->element("layout/table/tb_vertical_auto", array("data" => $val, "id" => "tochuctrongkhuonviengiaoxu"));
                        } else if ($key == "Tổ chức ngoài cơ sở thờ tự") {
                            echo $this->element("layout/table/tb_vertical_auto", array("data" => $val, "id" => "tochucngoaicosothotu"));
                        } else if ($key == "Quan hệ với các tổ chức, cá nhân tôn giáo nước ngoài (được tài trợ kinh phí để thực hiện)") {
                            echo $this->element("layout/table/tb_vertical_auto", array("data" => $val, "id" => "quanhevoicactochuccanhantongiaonuocngoai"));
                        } else if ($key == "Các cơ sở hoạt động tôn giáo từ trước đến nay") {
                            echo $this->element("layout/fields/textarea", array("name" => $val["value"]));
                        } else if ($key == "Các cơ sở quản nhiệm, hoạt động tôn giáo từ trước đến nay") {
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