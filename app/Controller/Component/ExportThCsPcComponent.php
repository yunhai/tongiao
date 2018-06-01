<?php

App::uses('ExportExcelComponent', 'Controller/Component');

class ExportThCsPcComponent extends ExportExcelComponent
{
    public function __construct()
    {
        parent::__construct();
        App::uses('ExportThCscvComponent', 'Controller/Component');
        $this->basic = new ExportThCscvComponent(new ComponentCollection());
    }

    public function export($filter = [])
    {
        $exclude = [
            'Chucsacnhatuhanhconggiaotrieu_betrentongquyen' => 'Chucsacnhatuhanhconggiaotrieu_total',
            'Chucsacnhatuhanhconggiaotrieu_giamtinh' => 'Chucsacnhatuhanhconggiaotrieu_total',
        ];

        $export = $this->basic->export($filter);
        unset($export['final_total']);

        foreach ($export as &$element) {
            foreach ($exclude as $f => $t) {
                if (isset($element[$f])) {
                    $element[$t] = $element[$t] - $element[$f];
                    unset($element[$f]);
                }
            }
        }

        return $this->sum($export);
    }

    public function layout($filter = [])
    {
        $row_header_index = 5;
        $row_data_index = 8;
        $column_begin = 4;
        $column_structure = [
            CONG_GIAO => 3,
            PHAT_GIAO => 5,
            TIN_LANH => 4,
            CAO_DAI => 5,
            HOI_GIAO => 7,
            TINH_DO_CU_SI => 5
        ];

        $column_remove = [];
        $cell_total_count = 2;
        if ($filter) {
            foreach ($column_structure as $index => $tmp) {
                if (!in_array($index, $filter)) {
                    $column_remove[$index] = $index;
                }
            }
        }
        $buffer = [
            4 => [
                [
                    'size' => [1, 29],
                    'group' => [
                        CONG_GIAO,
                        PHAT_GIAO,
                        TIN_LANH,
                        CAO_DAI,
                        HOI_GIAO,
                        TINH_DO_CU_SI
                    ],
                ],
            ]
        ];

        return compact('column_begin', 'column_structure', 'column_remove', 'row_header_index', 'row_data_index', 'cell_total_count', 'buffer');
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
