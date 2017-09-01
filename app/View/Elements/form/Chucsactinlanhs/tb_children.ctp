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
                            if ($key == "congnhanvetochuc_ngaycap") {
                                echo "Ngày cấp";
                            } elseif ($key == "congnhanvetochuc_coquancap") {
                                echo "Cơ quan cấp";
                            } elseif ($key == "capdangkyhoatdong_ngaycap") {
                                echo "Ngày cấp";
                            } elseif ($key == "capdangkyhoatdong_coquancap") {
                                echo "Cơ quan cấp";
                            } elseif ($key == "trinhdohocvan_bangcap") {
                                echo "Trình độ học vấn";
                            } elseif ($key == "trinhdothanhoc_bangcap") {
                                echo "Trình độ thần học";
                            } elseif ($key == "trinhdongoaingu_bangcap") {
                                echo "Trình độ ngoại ngữ";
                            } elseif ($key == "trinhdotinhoc_bangcap") {
                                echo "Trình độ tin học";
                            } elseif ($key == "ntn_duocphongtruyendao" ||
                                    $key == "ntn_duocphongmucsunc" ||
                                    $key == "ntn_duocphongmucsu"
                            ) {
                                echo "Nơi phong";
                            } elseif ($key == "ptdm_nambonhiem" ||
                                    $key == "ptqn_nambonhiem" ||
                                    $key == "qn_nambonhiem" ||
                                    $key == "tvbddct_nambonhiem" ||
                                    $key == "tvbch_nambonhiem"
                            ) {
                                echo "Năm bổ nhiệm";
                            } elseif ($key == "bdthnh_thoigianboiduong") {
                                echo "Thời gian bồi dưỡng";
                            } elseif ($key == "bdthnh_diadiemboiduong") {
                                echo "Địa điểm bồi dưỡng";
                            } elseif ($key == "bdthnh_hinhthuccapchungchivanbang") {
                                echo "Hình thức cấp chứng chỉ, văn bằng";
                            } elseif ($key == "bdthdh_thoigianboiduong") {
                                echo "Thời gian bồi dưỡng";
                            } elseif ($key == "bdthdh_diadiemboiduong") {
                                echo "Địa điểm bồi dưỡng";
                            } elseif ($key == "bdthdh_hinhthuccapchungchivanbang") {
                                echo "Hình thức cấp chứng chỉ, văn bằng";
                            } elseif ($key == "hvtkth_thoigianboiduong") {
                                echo "Thời gian bồi dưỡng";
                            } elseif ($key == "hvtkth_diadiemboiduong") {
                                echo "Địa điểm bồi dưỡng";
                            } elseif ($key == "hvtkth_hinhthuccapchungchivanbang") {
                                echo "Hình thức cấp chứng chỉ, văn bằng";
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
                            $key == "Đối với chi hội" ||
                            $key == "Đối với điểm nhóm" ||
                            $key == "Hội đồng nhân dân" ||
                            $key == "Ủy Ban MTTQVN" ||
                            $key == "Hội Nông dân" ||
                            $key == "Hội Chữ thập đỏ" ||
                            $key == "Hội Liên hiệp Thanh niên" ||
                            $key == "Hội Liên hiệp Phụ nữ" ||
                            $key == "Các tổ chức khác"
                    ) {
                        echo $this->element("form/Chucsactinlanhs/tb_children", array("data" => $val, "is_call" => 1));
                    } elseif ($key == "Giới tính") {
                        echo $this->element("form/gioitinh");
                    } else if ($key == "Trình độ học vấn") {
                        echo $this->element("layout/table/tb_vertical_auto", array("data" => $val, "id" => "trinhdohocvan"));
                    } else if ($key == "Trình độ thần học") {
                        echo $this->element("layout/table/tb_vertical_auto", array("data" => $val, "id" => "trinhdothanhoc"));
                    } else if ($key == "Trình độ ngoại ngữ") {
                        echo $this->element("layout/table/tb_vertical_auto", array("data" => $val, "id" => "trinhdongoaingu"));
                    } else if ($key == "Trình độ tin học") {
                        echo $this->element("layout/table/tb_vertical_auto", array("data" => $val, "id" => "trinhdotinhoc"));
                    } else if ($key == "Bố, mẹ đẻ") {
                        echo $this->element("form/Chucsactinlanhs/tb_children_quanhe", array("data" => $val, "is_call" => 1));
                    } else if ($key == "Bố, mẹ vợ") {
                        echo $this->element("form/Chucsactinlanhs/tb_children_quanhe", array("data" => $val, "is_call" => 1));
                    } else if ($key == "Anh chị em ruột") {
                        echo $this->element("layout/table/tb_vertical_auto", array("data" => $val, "id" => "anhchiemruot"));
                    } else if ($key == "Anh chị em vợ (chồng)") {
                        echo $this->element("layout/table/tb_vertical_auto", array("data" => $val, "id" => "anhchiemvochong"));
                    } else if ($key == "Vợ (chồng) và con") {
                        echo $this->element("layout/table/tb_vertical_auto", array("data" => $val, "id" => "vochongvacon"));
                    } else if ($key == "Quá trình hoạt động tôn giáo ở trong nước") {
                        echo $this->element("layout/table/tb_vertical_auto", array("data" => $val, "id" => "quatrinhhoatdongtongiaootrongnuoc"));
                    } else if ($key == "Quá trình hoạt động tôn giáo ở nước ngoài") {
                        echo $this->element("layout/table/tb_vertical_auto", array("data" => $val, "id" => "quatrinhhoatdongtongiaoongoainuoc"));
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