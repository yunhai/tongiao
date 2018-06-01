<?php

App::uses('ExportExcelComponent', 'Controller/Component');
class ExportThCsCyComponent extends ExportExcelComponent
{
    public function layout($filter = [])
    {
        $row_header_index = 3;
        $row_data_index = 6;
        $column_begin = 4;
        $column_structure = [
            CONG_GIAO => 6,
            PHAT_GIAO => 6,
            TIN_LANH => 4,
            CAO_DAI => 5,
            HOI_GIAO => 1,
            TINH_DO_CU_SI => 3
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
            2 => [
                'D2' => 'AB2'
            ]
        ];

        return compact('column_begin', 'column_structure', 'column_remove', 'row_header_index', 'row_data_index', 'cell_total_count', 'buffer');
    }

    public function export($filter = [])
    {
        $groups = [
            CONG_GIAO => 'Chucsacnhatuhanhconggiaotrieu',
            PHAT_GIAO => 'Chucsacnhatuhanhphatgiao',
            TIN_LANH => 'Chucsactinlanh',
            CAO_DAI => 'Chucsaccaodai',
            HOI_GIAO => 'Chucviechoigiao',
            TINH_DO_CU_SI => 'Chucviectinhdocusiphathoivietnam'
        ];

        $filter_group = $filter['ton_giao'];
        $filter_location = $filter['prefecture'];

        $province = $this->Province->getProvince($filter_location);

        $export = $this->init($province);

        foreach ($groups as $field_index => $model) {
            if (!empty($filter_group) && !in_array($field_index, $filter_group)) {
                continue;
            }
            $func = '__get' . $model;
            $tmp = $this->$func($model);

            foreach ($province as $provice_code => $name) {
                $partial = $tmp[$provice_code];

                foreach ($partial as $field => $value) {
                    if ($field === 'total') {
                        $export[$provice_code]['total'] += $value;
                    }
                    $export[$provice_code][$model . '_' . $field] = $value;
                }
            }
        }

        return $this->sum($export);
    }

    private function init($province)
    {
        $index = 1;
        $export = [];

        foreach ($province as $code => $name) {
            $export[$code] = [
                    'index' => $index++,
                    'province' => $name,
                    'total' => 0,
                ];
        }

        return $export;
    }

    private function __getChucsacnhatuhanhconggiaotrieu($model)
    {
        $location = 'noiohiennay_huyen';

        $fields = [
            'id',
            $location,
            'hoatdongtongiao_chucvuhiennay_truongbanchuyenmon',
            'hoatdongtongiao_chucvuhiennay_thanhvienbantuvan',
            'hoatdongtongiao_chucvuhiennay_thanhvienhoidonglinhmuc',
            'hoatdongtongiao_chucvuhiennay_linhhuongcuahoidoan',
            'hoatdongtongiao_chucvuhiennay_hattruong',
            'hoatdongtongiao_chucvuhiennay_chanhxu',
            'hoatdongtongiao_chucvuhiennay_phoxu',
        ];

        $conditions = [
            $location . ' is not null',
            $location . ' <> ' => '',
        ];


        $data = $this->__getData($model, compact('fields', 'conditions'));
        $result = [];
        foreach ($data as $id => $element) {
            $toagiacmuc = 0;
            if ($element['hoatdongtongiao_chucvuhiennay_truongbanchuyenmon'] ||
                $element['hoatdongtongiao_chucvuhiennay_thanhvienbantuvan'] ||
                $element['hoatdongtongiao_chucvuhiennay_thanhvienhoidonglinhmuc'] ||
                $element['hoatdongtongiao_chucvuhiennay_linhhuongcuahoidoan']
            ) {
                $toagiacmuc = 1;
            }
            $tmp = [
                'toagiammuc' => $toagiacmuc,
                'daichungvien' => 0,
                'giaohat' => $element['hoatdongtongiao_chucvuhiennay_hattruong'],
                'chanhxu' => $element['hoatdongtongiao_chucvuhiennay_chanhxu'],
                'phoxu' => $element['hoatdongtongiao_chucvuhiennay_phoxu'],
            ];

            $result[] = array_merge($element, $tmp);
        }
        $column = [
               'toagiammuc',
               'daichungvien',
               'giaohat',
               'chanhxu',
               'phoxu',
        ];

        return $this->__groupData($result, $column, $location);
    }

    private function __getChucsacnhatuhanhphatgiao($model)
    {
        $location = 'noiohiennay_huyen';

        $fields = [
            'id',
            $location,
            'hoatdongtongiao_chucvuhiennay_thanhvienbantrisucaptinh',
            'cm_bantrisu_captinh',
            'hoatdongtongiao_chucvuhiennay_thanhvienbantrisucaphuyen',
            'hoatdongtongiao_chucvuhiennay_trutri',
        ];

        $conditions = [
            $location . ' is not null',
            $location . ' <> ' => '',
        ];


        $data = $this->__getData($model, compact('fields', 'conditions'));
        $result = [];
        foreach ($data as $id => $element) {
            $tmp = [
                'tv_bts_tinh' => $element['hoatdongtongiao_chucvuhiennay_thanhvienbantrisucaptinh'],
                'ban_bts_tinh' => $element['cm_bantrisu_captinh'],
                'truong_daotao_tongiao' => 0,
                'tv_bts_huyen' => $element['hoatdongtongiao_chucvuhiennay_thanhvienbantrisucaphuyen'],
                'trutri' => $element['hoatdongtongiao_chucvuhiennay_trutri'],
            ];

            $result[] = array_merge($element, $tmp);
        }

        $column = [
               'tv_bts_tinh',
               'ban_bts_tinh',
               'truong_daotao_tongiao',
               'tv_bts_huyen',
               'trutri',
        ];

        return $this->__groupData($result, $column, $location);
    }

    private function __getChucsactinlanh($model)
    {
        $location = 'noiohiennay_huyen';

        $fields = [
            'id',
            $location,
            'tvbandaidiencaptinh',
            'quannhiem',
            'phutaquannhiem',
        ];

        $conditions = [
            $location . ' is not null',
            $location . ' <> ' => '',
        ];

        $data = $this->__getData($model, compact('fields', 'conditions'));

        $column = [
               'tvbandaidiencaptinh',
            'quannhiem',
            'phutaquannhiem',
        ];

        return $this->__groupData($data, $column, $location);
    }

    private function __getChucsaccaodai($model)
    {
        $location = 'noiohiennay_huyen';

        $fields = [
            'id',
            $location,
            'chucvuhiennay_thanhvienbddct',
            'chucvuhiennay_caiquan',
            'chucvuhiennay_phobancaiquan',
            'chucvuhiennay_thanhvienbddct',
        ];

        $conditions = [
            $location . ' is not null',
            $location . ' <> ' => '',
        ];

        $data = $this->__getData($model, compact('fields', 'conditions'));
        $result = [];
        foreach ($data as $id => $element) {
            $tmp = [
                'chucvuhiennay_thanhvienbddct' => $element['chucvuhiennay_thanhvienbddct'] ? 1 : 0,
                'chucvuhiennay_phobancaiquan' => 0,
                'chucvuhiennay_caiquan' => $element['chucvuhiennay_caiquan'] ? 1 : 0,
                'chucvuhiennay_phobancaiquan' => $element['chucvuhiennay_phobancaiquan'] ? 1 : 0,
                'chucvuhiennay_thanhvienbddct2' => $element['chucvuhiennay_thanhvienbddct'] ? 1 : 0,
            ];

            $result[] = array_merge($element, $tmp);
        }

        $column = [
            'chucvuhiennay_thanhvienbddct',
            'chucvuhiennay_phobancaiquan',
            'chucvuhiennay_caiquan',
            'chucvuhiennay_phobancaiquan',
            'chucvuhiennay_thanhvienbddct2',
        ];

        return $this->__groupData($result, $column, $location);
    }

    private function __getChucviechoigiao($model)
    {
        $location = 'noiohiennay_huyen';

        $fields = [
            'id',
            $location,
            'chucvuhiennay_thanhvienbangiaoca',
        ];

        $conditions = [
            $location . ' is not null',
            $location . ' <> ' => '',
        ];

        $data = $this->__getData($model, compact('fields', 'conditions'));

        $column = [
               'chucvuhiennay_thanhvienbangiaoca',
        ];

        return $this->__groupData($data, $column, $location, false);
    }

    private function __getChucviectinhdocusiphathoivietnam($model)
    {
        $location = 'noiohiennay_huyen';

        $fields = [
            'id',
            $location,
            'thanhvienbantrisucaptinh',
            'thanhvienbantrisucaptrunguong',
        ];

        $conditions = [
            $location . ' is not null',
            $location . ' <> ' => '',
        ];

        $data = $this->__getData($model, compact('fields', 'conditions'));

        $column = [
            'thanhvienbantrisucaptinh',
            'thanhvienbantrisucaptrunguong',
        ];

        return $this->__groupData($data, $column, $location);
    }

    private function __getData($model, $option = [])
    {
        $obj = ClassRegistry::init($model);
        $data = $obj->find('all', $option);

        return Hash::combine($data, '{n}.' . $model . '.id', '{n}.' . $model);
    }

    private function __groupData($data, $column, $province_field, $total_flag = true)
    {
        $result = [];
        $province = $this->Province->getProvince();

        foreach ($province as $provice_code => $name) {
            if ($total_flag) {
                $result[$provice_code] = [
                    'total' => 0
                ];
            }
            foreach ($column as $col) {
                $result[$provice_code][$col] = 0;
            }
        }

        foreach ($data as $id => $item) {
            $provice_code = $this->Province->retrieveProvinceCode($item[$province_field]);
            if (!$provice_code) {
                continue;
            }

            foreach ($column as $col) {
                if ($item[$col]) {
                    if ($total_flag) {
                        $result[$provice_code]['total'] = $result[$provice_code]['total'] + 1;
                    }

                    $result[$provice_code][$col] = $result[$provice_code][$col] + 1;
                }
            }
        }

        return $result;
    }
}

/**
     * THBNCS
     * TỔNG HỢP CHỨC SẮC CÁC TÔN GIÁO ĐƯỢC BỔ NHIỆM, CHUẨN Y
     *
     * I. CÔNG GIÁO
     * 1. Bảng chucsacnhatuhanhconggiaotrieu
     * Tương ứng với từng huyện: BIÊN HÒA/LONG KHÁNH/XUÂN LỘC/CẨM MỸ/TÂN PHÚ/ĐỊNH QUÁN/THỐNG NHẤT/TRẢNG BOM/VĨNH CỬU/NHƠN TRẠCH/LONG THÀNH
     * noiohiennay_huyen = Tương ứng với từng huyện ở trên và điều kiện
     * CÁC BAN THUỘC TÒA GIÁM  MỤC: hoatdongtongiao_chucvuhiennay_truongbanchuyenmon = true hoặc
     *                              hoatdongtongiao_chucvuhiennay_thanhvienbantuvan = true hoặc
     *                              hoatdongtongiao_chucvuhiennay_thanhvienhoidonglinhmuc = true hoặc
     *                              hoatdongtongiao_chucvuhiennay_linhhuongcuahoidoan = true
     * ĐẠI CHỦNG VIỆN: Để mặc định bằng 0
     * GIÁO HẠT: hoatdongtongiao_chucvuhiennay_hattruong = true
     * CHÁNH XỨ: hoatdongtongiao_chucvuhiennay_chanhxu = true
     * PHÓ XỨ: hoatdongtongiao_chucvuhiennay_phoxu = true
     *
     * II. PHẬT GIÁO
     * 2. Bảng chucsacnhatuhanhphatgiao
     * Tương ứng với từng huyện: BIÊN HÒA/LONG KHÁNH/XUÂN LỘC/CẨM MỸ/TÂN PHÚ/ĐỊNH QUÁN/THỐNG NHẤT/TRẢNG BOM/VĨNH CỬU/NHƠN TRẠCH/LONG THÀNH
     * noiohiennay_huyen = Tương ứng với từng huyện ở trên và điều kiện
     * THÀNH VIÊN BTS CẤP TỈNH: hoatdongtongiao_chucvuhiennay_thanhvienbantrisucaptinh = true
     * CÁC BAN THUỘC BTS CẤP TỈNH: cm_bantrisu_captinh = true
     * CÁC TRƯỜNG ĐÀO TẠO TÔN GIÁO: Để mặc định bằng 0
     * THÀNH VIÊN BTS CẤP HUYỆN: hoatdongtongiao_chucvuhiennay_thanhvienbantrisucaphuyen = true
     * TRỤ TRÌ: hoatdongtongiao_chucvuhiennay_trutri = true
     *
     * III. TIN LÀNH
     * 3. Bảng chucsactinlanh
     * Tương ứng với từng huyện: BIÊN HÒA/LONG KHÁNH/XUÂN LỘC/CẨM MỸ/TÂN PHÚ/ĐỊNH QUÁN/THỐNG NHẤT/TRẢNG BOM/VĨNH CỬU/NHƠN TRẠCH/LONG THÀNH
     * noiohiennay_huyen = Tương ứng với từng huyện ở trên và điều kiện
     * THÀNH VIÊN BAN ĐẠI DIỆN: tvbandaidiencaptinh = true
     * QUẢN NHIỆM/PHỤ TRÁCH CHI HỘI: quannhiem = true
     * PHỤ TÁ QUẢN NHIỆM CHI HỘI: phutaquannhiem = true
     *
     * IV. CAO ĐÀI
     * 4. Bảng chucsaccaodai
     * Tương ứng với từng huyện: BIÊN HÒA/LONG KHÁNH/XUÂN LỘC/CẨM MỸ/TÂN PHÚ/ĐỊNH QUÁN/THỐNG NHẤT/TRẢNG BOM/VĨNH CỬU/NHƠN TRẠCH/LONG THÀNH
     * noiohiennay_huyen = Tương ứng với từng huyện ở trên và điều kiện
     * THÀNH VIÊN BAN ĐẠI DIỆN, ĐẠI DIỆN: chucvuhiennay_thanhvienbddct != null
     * ĐẦU HỌ ĐẠO: Để mặc định bằng 0
     * TRƯỞNG BAN CAI QUẢN: chucvuhiennay_caiquan != null
     * PHÓ BAN CAI QUẢN: chucvuhiennay_phobancaiquan != null
     * THÀNH VIÊN BAN GIÁO CẢ: chucvuhiennay_thanhvienbddct != null
     *
     * V. TĐCSPHVN:
     * 5. Bảng chucviectinhdocusiphathoivietnam
     * Tương ứng với từng huyện: BIÊN HÒA/LONG KHÁNH/XUÂN LỘC/CẨM MỸ/TÂN PHÚ/ĐỊNH QUÁN/THỐNG NHẤT/TRẢNG BOM/VĨNH CỬU/NHƠN TRẠCH/LONG THÀNH
     * noiohiennay_huyen = Tương ứng với từng huyện ở trên và điều kiện
     * THÀNH VIÊN BTS CẤP TỈNH: thanhvienbantrisucaptinh = true
     * THÀNH VIÊN BAN TRỊ SỰ CHI HỘI: thanhvienbantrisucaptrunguong = true
     *
     */
