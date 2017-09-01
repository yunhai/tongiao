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
                            if ($key == "tructhuocdongtu_diachi" ||
                                $key == "nguoidodau_tencoso_tenquocte_diachi" || 
                                $key == "linhmuclinhhuong_tencoso_tenquocte_diachi" || 
                                $key == "noiohiennay_diachi"
                            ) {
                                echo "Địa chỉ";
                            } elseif ($key == "thoigiankhanlandau_noitochuclekhan" || 
                                $key == "thoigiankhantam_noitochuclekhan" || 
                                $key == "thoigiankhantron_noitochuclekhan"
                            ) {
                                echo "Nơi tổ chức lễ khấn";
                            } elseif ($key == "phamsactongiao_noiphong_phote" || 
                                $key == "phamsactongiao_noiphong_linhmuc"
                            ) {
                                echo "Nơi phong";
                            } elseif ($key == "hoatdongtongiao_betrendong_nambonhiem" || 
                                $key == "hoatdongtongiao_betrentinhdong_nambonhiem" || 
                                $key == "hoatdongtongiao_betrenmiendong_nambonhiem" || 
                                $key == "hoatdongtongiao_betrencongdoan_nambonhiem" || 
                                $key == "hoatdongtongiao_thanhvienbantuvantgmxl_nambonhiem" || 
                                $key == "hoatdongtongiao_thanhvienhoidonglinhmuc_nambonhiem" || 
                                $key == "hoatdongtongiao_thanhvienhoidonglinhmuc_nambonhiem" || 
                                $key == "nguoidodau_betrendong_nambonhiem" ||
                                $key == "nguoidodau_betrentinhdong_nambonhiem" || 
                                $key == "nguoidodau_betrenmiendong_nambonhiem" || 
                                $key == "nguoidodau_betrencongdoan_nambonhiem" || 
                                $key == "nguoidodau_thanhvienbantuvantgmxl_nambonhiem" || 
                                $key == "nguoidodau_thanhvienhoidonglinhmuc_nambonhiem" || 
                                $key == "nguoidodau_linhhuongcuahoidoan_nambonhiem" || 
                                $key == "linhmucdong_betrendong_nambonhiem" || 
                                $key == "linhmucdong_betrentinhdong_nambonhiem" || 
                                $key == "linhmucdong_betrenmiendong_nambonhiem" || 
                                $key == "linhmucdong_betrencongdoan_nambonhiem" || 
                                $key == "linhmucdong_thanhvienbantuvantgmxl_nambonhiem" || 
                                $key == "linhmucdong_thanhvienhoidonglinhmuc_nambonhiem" || 
                                $key == "linhmucdong_linhhuongcuahoidoan_nambonhiem" || 
                                $key == "linhmuctrieu_chanhxu_nambonhiem" || 
                                $key == "linhmuctrieu_phoxu_nambonhiem" || 
                                $key == "linhmuctrieu_phutaxu_nambonhiem" || 
                                $key == "linhmuctrieu_quannhiemxu_nambonhiem" || 
                                $key == "linhmuctrieu_hattruong_nambonhiem" || 
                                $key == "linhmuctrieu_truongbanchuyenmon_nambonhiem" || 
                                $key == "linhmuctrieu_thanhvienbantuvan_nambonhiem" || 
                                $key == "linhmuctrieu_thanhvienhoidonglinhmuc_nambonhiem" || 
                                $key == "linhmuctrieu_linhhuongcuahoidong_nambonhiem"
                            ) {
                                echo "Năm bổ nhiệm";
                            } elseif ($key == "linhmucdong_phamsachiennay" ||
                                $key == "linhmuctrieu_phamsachiennay" 
                            ) {
                                echo "Phẩm sắc hiện nay";
                            } elseif ($key == "trinhdohocvan_bangcap") {
                                echo "Trình độ học vấn";
                            } elseif ($key == "trinhdothanhoc_bangcap") {
                                echo "Trình độ Thần học";
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
                            $key == "Nơi đăng ký hộ khẩu thường trú" || 
                            $key == "Nơi ở hiện nay" || 
                            $key == "Hội đồng nhân dân" || 
                            $key == "Ủy Ban MTTQVN" || 
                            $key == "Hội cựu Chiến binh" || 
                            $key == "Hội Nông dân" || 
                            $key == "Hội Chữ thập đỏ" || 
                            $key == "Đoàn thanh niên" || 
                            $key == "Hội Liên hiệp Thanh niên" || 
                            $key == "Hội Liên hiệp Phụ nữ" || 
                            $key == "Ủy ban, Ban Đoàn kết Công giáo" || 
                            $key == "Các tổ chức khác" || 
                            $key == "Địa chỉ Giáo xứ" || 
                            $key == "linhmucdong_phamsachiennay" || 
                            $key == "Chức vụ hiện nay trong tổ chức tôn giáo" ||
                            $key == "Tham gia các tổ chức chính trị - xã hội, tổ chức xã hội" || 
                            $key == "linhmuctrieu_phamsachiennay"
                            ) {
                            echo $this->element("form/Chucsacnhatuhanhcongiaodongtus/tb_children", array("data" => $val, "is_call" => 1));
                        } elseif ($key == "Giới tính") {
                            echo $this->element("form/gioitinh");
                        } else if ($key == "Bố, mẹ đẻ") {
                            echo $this->element("form/Chucsacnhatuhanhcongiaodongtus/tb_children_quanhe", array("data" => $val, "is_call" => 1));
                        } else if ($key == "Anh chị em ruột") {
                            echo $this->element("layout/table/tb_vertical_auto", array("data" => $val, "id" => "anhchiemruot"));
                        } else if ($key == "Trình độ học vấn") {
                            echo $this->element("layout/table/tb_vertical_auto", array("data" => $val, "id" => "trinhdohocvan"));
                        } else if ($key == "Trình độ Thần học") {
                            echo $this->element("layout/table/tb_vertical_auto", array("data" => $val, "id" => "trinhdothanhoc"));
                        } else if ($key == "Trình độ ngoại ngữ") {
                            echo $this->element("layout/table/tb_vertical_auto", array("data" => $val, "id" => "trinhdongoaingu"));
                        } else if ($key == "Trình độ tin học") {
                            echo $this->element("layout/table/tb_vertical_auto", array("data" => $val, "id" => "trinhdotinhoc"));
                        } else if ($key == "Chức vụ khác và thời gian được bổ nhiệm") {
                            echo $this->element("layout/fields/textarea", array("name" => $val["value"]));
                        } else if ($key == "Đã qua các lớp đào tạo, bồi dưỡng về tôn giáo trong nước") {
                            echo $this->element("layout/table/tb_vertical_auto", array("data" => $val, "id" => "daquacaclopdaotaoboiduongvetongiaotrongnuoc"));
                        } else if ($key == "Quá trình hoạt động tôn giáo ở trong nước") {
                            echo $this->element("layout/table/tb_vertical_auto", array("data" => $val, "id" => "quatrinhhoatdongtongiaootrongnuoc"));
                        } else if ($key == "Đã qua các lớp đào tạo, bồi dưỡng về tôn giáo ở nước ngoài") {
                            echo $this->element("layout/table/tb_vertical_auto", array("data" => $val, "id" => "daquacaclopdaotaoboiduongvetongiaoonuocngoai"));
                        } else if ($key == "Quá trình hoạt động tôn giáo ở nước ngoài") {
                            echo $this->element("layout/table/tb_vertical_auto", array("data" => $val, "id" => "quatrinhhoatdongtongiaoonuocngoai"));
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