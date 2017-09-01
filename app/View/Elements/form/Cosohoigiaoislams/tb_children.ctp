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
                            if ($key == "truongbangiaoca_dantoc") {
                                echo "Dân tộc";
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
                            $key == "Tín ngưỡng của đồng bào dân tộc thiểu số" || 
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
                            $key == "Ủy ban, Ban Đoàn kết Công giáo" || 
                            $key == "Các tổ chức khác" || 
                            $key == "Số lượng chức sắc tham gia" || 
                            $key == "Số lượng chức việc tham gia" || 
                            $key == "Số tín đồ tham gia" || 
                            $key == "Số tín đồ đang làm việc tại các cơ quan nhà nước, chính trị - xã hội" || 
                            //$key == "Đã cấp GCN quyền sử dụng đất" || 
                            $key == "Chưa cấp GCN quyền sử dụng đất" || 
                            $key == "(1)" || 
                            $key == "(2)" || 
                            $key == "(3)"
                        ) {
                            echo $this->element("form/Cosohoigiaoislams/tb_children", array("data" => $val, "is_call" => 1));
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
                        } else if ($key == "Dân tộc") {
                            echo $this->element("layout/table/tb_vertical_auto", array("data" => $val, "id" => "soho_dantoc_soho_sonhankhau"));
                        } else if ($key == "Các công trình tôn giáo trong khuôn viên thánh đường/tiểu thánh đường") {
                            echo $this->element("layout/table/tb_vertical_auto", array("data" => $val, "id" => "caccongtrinhtongiaotrongkhuonvienthanhduong"));
                        } else if ($key == "Các công trình ngoài khuôn viên của thánh đường/tiểu thánh đường") {
                            echo $this->element("layout/table/tb_vertical_auto", array("data" => $val, "id" => "caccongtrinhngoaikhuonviencuathanhduong"));
                        } else if ($key == "Các cơ sở hoạt động tôn giáo từ trước đến nay") {
                            echo $this->element("layout/fields/textarea", array("name" => $val["value"]));
                        } else if ($key == "Các hoạt động bác ái, từ thiện xã hội, y tế, giáo dục do Thánh đường/Tiểu Thánh đường tổ chức thực hiện (cơ sở bảo trợ xã hội, giáo dục, y tế, từ thiện và ghi rõ người phụ trách)") {
                            echo $this->element("layout/table/tb_vertical_auto", array("data" => $val, "id" => "cachoatdongbacai"));
                        } else if ($key == "Tổ chức trong khuôn viên thánh đường/tiểu thánh đường") {
                            echo $this->element("layout/table/tb_vertical_auto", array("data" => $val, "id" => "tochuctrongkhuonvienthanhduong"));
                        } else if ($key == "Tổ chức ngoài khuôn viên thánh đường/tiểu thánh đường") {
                            echo $this->element("layout/table/tb_vertical_auto", array("data" => $val, "id" => "tochucngoaikhuonvienthanhduong"));
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