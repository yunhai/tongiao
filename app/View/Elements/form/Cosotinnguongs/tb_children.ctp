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
                            if ($key == "tongiao_dacap_gcn_quyensudungdat" || 
                                $key == "nnlnntts_dacap_gcn_quyensudungdat" || 
                                $key == "gdyt_dacap_gcn_quyensudungdat" || 
                                $key == "dsdmdk_dacap_gcn_quyensudungdat"
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
                            //$key == "Tôn giáo" ||
                            $key == "Tín ngưỡng" || 
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
                            //$key == "Đã cấp GCN quyền sử dụng đất" || 
                            $key == "Chưa cấp GCN quyền sử dụng đất"
                        ) {
                            echo $this->element("form/Cosotinnguongs/tb_children", array("data" => $val, "is_call" => 1));
                        } elseif ($key == "tongiao_dacap_gcn_quyensudungdat" || 
                            $key == "nnlnntts_dacap_gcn_quyensudungdat" || 
                            $key == "gdyt_dacap_gcn_quyensudungdat" || 
                            $key == "dsdmdk_dacap_gcn_quyensudungdat" 
                        ) {
                            echo $this->element("layout/table/tb_vertical_auto", array("data" => $val, "id" => $key));
                        } else if ($key == "Thành phần ban trị sự/ ban đại diện/ ban quản lý/ ban quý tế/ ...") {
                            echo $this->element("layout/table/tb_vertical_auto", array("data" => $val, "id" => "thanhphanbantrisu"));
                        } else if ($key == "Người hoạt động tín ngưỡng chuyên nghiệp của cơ sở") {
                            echo $this->element("layout/table/tb_vertical_auto", array("data" => $val, "id" => "nguoihoatdongtinnguongchuyennghiepcuacoso"));
                        } else if ($key == "Các hoạt động bác ái, từ thiện xã hội, y tế, giáo dục do cơ sở tín ngưỡng tổ chức thực hiện (cơ sở bảo trợ xã hội, giáo dục, y tế, từ thiện và ghi rõ người phụ trách)") {
                            echo $this->element("layout/table/tb_vertical_auto", array("data" => $val, "id" => "cachoatdongbacai"));
                        } else if ($key == "Một số lễ nghi tín ngưỡng cơ sở thường xuyên tổ chức hàng năm") {
                            echo $this->element("layout/table/tb_vertical_auto", array("data" => $val, "id" => "motsolenghitinnguongcosothuongxuyentochuchangnam"));
                        } else if ($key == "Các công trình của cơ sở tín ngưỡng") {
                            echo $this->element("layout/table/tb_vertical_auto", array("data" => $val, "id" => "caccongtrinhcuacosotinnguong"));
                        } else if ($key == "Đối tượng thờ cúng") {
                            echo $this->element("layout/table/tb_vertical_auto", array("data" => $val, "id" => "doituongthocung"));
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