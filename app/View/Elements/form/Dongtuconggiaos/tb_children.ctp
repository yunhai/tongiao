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
                            $key == "Nơi đăng ký hộ khẩu thường trú" || 
                            $key == "Nơi ở hiện nay" || 
                            $key == "Tôn giáo" || 
                            $key == "Nông nghiệp, lâm nghiệp, nuôi trồng thủy sản" ||
                            $key == "Giáo dục, y tế" || 
                            $key == "Đất sử dụng mục đích khác" ||
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
                            $key == "Cấp công nhận" || 
                            $key == "Theo Quyết định" || 
                            $key == "Số tu sĩ tham gia các tổ chức chính trị - xã hội, tổ chức xã hội" || 
                            $key == "Địa chỉ giáo xứ" || 
                            //$key == "Đã cấp GCN quyền sử dụng đất" || 
                            $key == "Chưa cấp GCN quyền sử dụng đất" || 
                            $key == "(1)" || 
                            $key == "(2)" || 
                            $key == "(3)"
                        ) {
                            echo $this->element("form/Dongtuconggiaos/tb_children", array("data" => $val, "is_call" => 1));
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
                        } else if ($key == "Các công trình tôn giáo trong khuôn viên cộng đoàn/tu viện/đan viện") {
                            echo $this->element("layout/table/tb_vertical_auto", array("data" => $val, "id" => "caccongtrinhtongiaotrongkhuonviencongdoan"));
                        } else if ($key == "Các công trình ngoài khuôn viên của cộng đoàn/tu viện/đan viện") {
                            echo $this->element("layout/table/tb_vertical_auto", array("data" => $val, "id" => "caccongtrinhngoaikhuonviencuacongdoan"));
                        } else if ($key == "Các cơ sở hoạt động tôn giáo từ trước đến nay") {
                            echo $this->element("layout/fields/textarea", array("name" => $val["value"]));
                        } else if ($key == "Hình thức hoạt động tôn giáo") {
                            echo $this->element("layout/fields/textarea", array("name" => $val["value"]));
                        } else if ($key == "Các hoạt động bác ái, từ thiện xã hội, y tế, giáo dục do cộng đoàn/tu viện/đan viện đang tổ chức thực hiện (cơ sở bảo trợ xã hội, giáo dục, y tế, từ thiện và ghi rõ người phụ trách)") {
                            echo $this->element("layout/table/tb_vertical_auto", array("data" => $val, "id" => "cachoatdongbacai"));
                        } else if ($key == "Một số lễ nghi cơ sở thường xuyên tổ chức tại cơ sở") {
                            echo $this->element("layout/table/tb_vertical_auto", array("data" => $val, "id" => "motsolenghicosothuongxuyentochuctaicoso"));
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