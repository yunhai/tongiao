<?php

class ExportThCsPcComponent extends Component
{
    public function __construct()
    {
        App::uses('ExportThCscvComponent', 'Controller/Component');
        $this->basic = new ExportThCscvComponent(new ComponentCollection());
    }

    public function export($filter = [])
    {
        $exclude = [
            'Chucsacnhatuhanhconggiaotrieu_betrentongquyen',
            'Chucsacnhatuhanhconggiaotrieu_giamtinh',
            'final_total_Chucsacnhatuhanhconggiaotrieu_betrentongquyen',
            'final_total_Chucsacnhatuhanhconggiaotrieu_giamtinh'
        ];

        $export = $this->basic->export($filter);

        foreach ($export as &$element) {
            foreach ($exclude as $f) {
                unset($element[$f]);
            }
        }

        return $export;
    }
}

/**
     * TH CHUC SAC PCPP
     * TỔNG HỢP CHỨC SẮC CÁC TÔN GIÁO ĐƯỢC PHONG CHỨC, PHONG PHẨM
     *
     * I. CÔNG GIÁO
     * 1. Bảng chucsacnhatuhanhconggiaotrieu
     * Tương ứng với từng huyện: BIÊN HÒA/LONG KHÁNH/XUÂN LỘC/CẨM MỸ/TÂN PHÚ/ĐỊNH QUÁN/THỐNG NHẤT/TRẢNG BOM/VĨNH CỬU/NHƠN TRẠCH/LONG THÀNH
     * noiohiennay_huyen = Tương ứng với từng huyện ở trên và điều kiện
     * GIÁM MỤC: phamsactrongtongiao_namphong_giammuc != null
     * LINH MỤC: phamsactrongtongiao_namphong_linhmuc != null
     *
     * II. PHẬT GIÁO
     * 2. Bảng chucsacnhatuhanhphatgiao
     * Tương ứng với từng huyện: BIÊN HÒA/LONG KHÁNH/XUÂN LỘC/CẨM MỸ/TÂN PHÚ/ĐỊNH QUÁN/THỐNG NHẤT/TRẢNG BOM/VĨNH CỬU/NHƠN TRẠCH/LONG THÀNH
     * noiohiennay_huyen = Tương ứng với từng huyện ở trên và điều kiện
     * HÒA THƯỢNG: phaphieu = 'Nam' và ntn_tanphong_hoathuong_hoac_nitruong != null
     * THƯỢNG TỌA: phaphieu = 'Nam' và ntn_tanphong_thuongtao_hoac_nisu != null
     * NI TRƯỞNG: phaphieu = 'Nữ' và ntn_tanphong_hoathuong_hoac_nitruong != null
     * NI SƯ: phaphieu = 'Nữ' và ntn_tanphong_thuongtao_hoac_nisu != null
     *
     * III. TIN LÀNH
     * 3. Bảng chucsactinlanh
     * Tương ứng với từng huyện: BIÊN HÒA/LONG KHÁNH/XUÂN LỘC/CẨM MỸ/TÂN PHÚ/ĐỊNH QUÁN/THỐNG NHẤT/TRẢNG BOM/VĨNH CỬU/NHƠN TRẠCH/LONG THÀNH
     * noiohiennay_huyen = Tương ứng với từng huyện ở trên và điều kiện
     * MỤC SƯ: phamsactrongtongiao_ntn_duocphong_mucsu != null
     * MỤC SƯ NHIỆM CHỨC: phamsactrongtongiao_ntn_duocphong_mucsunc != null
     * TRUYỀN ĐẠO: phamsactrongtongiao_ntn_duocphong_truyendao != null
     *
     * IV. CAO ĐÀI
     * 4. Bảng chucsaccaodai
     * Tương ứng với từng huyện: BIÊN HÒA/LONG KHÁNH/XUÂN LỘC/CẨM MỸ/TÂN PHÚ/ĐỊNH QUÁN/THỐNG NHẤT/TRẢNG BOM/VĨNH CỬU/NHƠN TRẠCH/LONG THÀNH
     * noiohiennay_huyen = Tương ứng với từng huyện ở trên và điều kiện
     * PHỐI SƯ: phamsac_ntn_cauthang_phosu != null
     * GIÁO SƯ: phamsac_ntn_cauthang_giaosu != null
     * GIÁO HỮU: phamsac_ntn_cauthang_giaohuu != null
     * LỄ SANH VÀ TƯƠNG ĐƯƠNG: phamsac_ntn_cauphong_lesanh != null
     *
     * V. HỒI GIÁO
     * 5. Bảng chucviechoigiao
     * Tương ứng với từng huyện: BIÊN HÒA/LONG KHÁNH/XUÂN LỘC/CẨM MỸ/TÂN PHÚ/ĐỊNH QUÁN/THỐNG NHẤT/TRẢNG BOM/VĨNH CỬU/NHƠN TRẠCH/LONG THÀNH
     * noiohiennay_huyen = Tương ứng với từng huyện ở trên và điều kiện
     * HAKIM: phamsactrongtongiao_ntn_bonhiem_hakim != null
     * NAEP: phamsactrongtongiao_ntn_bonhiem_naep != null
     * AHLY: Để mặc định bằng 0
     * KHOTIP: phamsactrongtongiao_ntn_bonhiem_khotip != null
     * IMAM: phamsactrongtongiao_ntn_bonhiem_imam != null
     * TUON: phamsactrongtongiao_ntn_bonhiem_tuon != null
     *
     * VI. TĐCSPHVN
     * 5. Bảng chucviectinhdocusiphathoivietnam
     * Tương ứng với từng huyện: BIÊN HÒA/LONG KHÁNH/XUÂN LỘC/CẨM MỸ/TÂN PHÚ/ĐỊNH QUÁN/THỐNG NHẤT/TRẢNG BOM/VĨNH CỬU/NHƠN TRẠCH/LONG THÀNH
     * noiohiennay_huyen = Tương ứng với từng huyện ở trên và điều kiện
     * GIẢNG SƯ: phamsactrongtongiao_ntn_bonhiem_phogiangsu != null
     * THUYẾT TRÌNH VIÊN: phamsactrongtongiao_ntn_bonhiem_thuyettrinhvien != null
     * Y SĨ: Để mặc định bằng 0
     * Y SINH: Để mặc định bằng 0
     *
     */
