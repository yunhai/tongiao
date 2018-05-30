<?php
class ExportThDtComponent extends Component
{
    public function __construct()
    {
        App::uses('ProvinceComponent', 'Controller/Component');
        $this->Province = new ProvinceComponent(new ComponentCollection());
    }

    public function export($filter)
    {
        $location_map = [
            'Giaoxu' => 'diachi_huyen',
            'Tuvienphatgiao' => 'diachi_huyen',
            'Chihoitinlanh' => 'diachi_huyen',
            'Hodaocaodai' => 'tenhodao_diachi_huyen',
            'Chihoitinhdocusiphatgiaovietnam' => 'tenchihoi_diachi_huyen',
            'Hoahao' => '',
            'Cosohoigiaoislam' => 'tenthanhduong_diachi_huyen'
        ];

        $groups = [
            CONG_GIAO => 'Giaoxu',
            PHAT_GIAO => 'Tuvienphatgiao',
            TIN_LANH => 'Chihoitinlanh',
            CAO_DAI => 'Hodaocaodai',
            TINH_DO_CU_SI => 'Chihoitinhdocusiphatgiaovietnam',
            HOA_HAO => 'Hoahao',
            HOI_GIAO => 'Cosohoigiaoislam',
        ];

        $criteria = [
            'cosothotu_ditichlichsu' => 'DI TÍCH LỊCH SỬ',
            'cosothotu_ditichvanhoa' => 'DI TÍCH VĂN HÓA',
            'cosothotu_ditichlichsuvanhoa' => 'DI TÍCH LS-VH',
            'cosothotu_ditichkientrucnghethuat' => 'DI TÍCH KIẾN TRÚC NGHỆ THUẬT',
            'cosothotu_ditichkhaoco' => 'DI TÍCH KHẢO CỔ',
        ];

        $filter_group = $filter['ton_giao'];
        $filter_location = $filter['prefecture'];
        $province = $this->Province->getProvince($filter_location);

        $export = [];
        $init = $this->init($province);

        foreach ($groups as $field_index => $model) {
            if (!empty($filter_group) && !in_array($field_index, $filter_group)) {
                continue;
            }

            $func = '__statis';
            $location = $location_map[$model];
            if (!$location) {
                $func = '__statisTmp';
            }
            $tmp = $this->$func($model, $location);

            foreach ($province as $provice_code => $name) {
                $rows = $tmp[$provice_code];

                foreach ($rows as $field => $element) {
                    $target = [];
                    if (empty($export["{$provice_code}_{$field}"])) {
                        $export["{$provice_code}_{$field}"] = $init[$provice_code];
                        $export["{$provice_code}_{$field}"]['criteria'] = $criteria[$field];
                    }
                    foreach ($element as $key => $value) {
                        $export["{$provice_code}_{$field}"]["total_{$key}"] += $value;
                        $target["{$model}_{$key}"] = $value;
                    }
                    $export["{$provice_code}_{$field}"] = array_merge($export["{$provice_code}_{$field}"], $target);
                }
            }
        }

        return $this->sum($export);
    }

    private function sum($data, $start = 3)
    {
        $total = [];

        foreach ($data as $location => $target) {
            $index = 0;
            foreach ($target as $field => $value) {
                if (++$index <= $start) {
                    $total["final_total_{$field}"] = '';

                    continue;
                }

                $total["final_total_{$field}"] = isset($total["final_total_{$field}"]) ? $total["final_total_{$field}"] : 0;
                $total["final_total_{$field}"] += $value;
            }
        }
        $data['final_total'] = $total;

        return $data;
    }

    private function __statis($model, $province_field)
    {
        $fields = [
            'id',
            $province_field
        ];
        $conditions = [
            "{$province_field} <>" => '',
            "{$province_field} is not null"
        ];
        $column = [
            'cosothotu_ditichlichsu',
            'cosothotu_ditichvanhoa',
            'cosothotu_ditichlichsuvanhoa',
            'cosothotu_ditichkientrucnghethuat',
            'cosothotu_ditichkhaoco',
            'cosothotu_captrunguong',
            'cosothotu_captinh',
        ];

        $fields = array_merge($fields, $column);

        $data = $this->__getData($model, compact('fields', 'conditions'));

        return $this->__groupData($data, $column, $province_field);
    }

    private function __statisTmp($model)
    {
        $result = [];
        $province = $this->Province->getProvince();

        $tmp = [
            'tw' => 0,
            'tinh' => 0
        ];
        foreach ($province as $provice_code => $name) {
            $result[$provice_code] = [
                'cosothotu_ditichlichsu' => $tmp,
                'cosothotu_ditichvanhoa' => $tmp,
                'cosothotu_ditichlichsuvanhoa' => $tmp,
                'cosothotu_ditichkientrucnghethuat' => $tmp,
                'cosothotu_ditichkhaoco' => $tmp
            ];
        }

        return $result;
    }

    private function init($province)
    {
        $index = 1;
        $export = [];

        foreach ($province as $code => $name) {
            $export[$code] = [
                'index' => $index++,
                'province' => $name,
                'criteria' => '',
                'total_tw' => 0,
                'total_tinh' => 0
            ];
        }

        return $export;
    }

    private function __getData($model, $option = [])
    {
        $obj = ClassRegistry::init($model);
        $data = $obj->find('all', $option);

        return Hash::combine($data, '{n}.' . $model . '.id', '{n}.' . $model);
    }

    private function __groupData($data, $column, $province_field)
    {
        $result = [];
        $province = $this->Province->getProvince();

        $exclude = [
            'cosothotu_captrunguong',
            'cosothotu_captinh',
        ];

        foreach ($province as $provice_code => $name) {
            $result[$provice_code] = array();
            foreach ($column as $col) {
                if (in_array($col, $exclude)) {
                    continue;
                }
                $result[$provice_code][$col] = [
                    'tw' => 0,
                    'tinh' => 0,
                ];
            }
        }

        foreach ($data as $id => $item) {
            $provice_code = $this->Province->retrieveProvinceCode($item[$province_field]);
            if (!$provice_code) {
                continue;
            }
            foreach ($result[$provice_code] as $key => &$element) {
                if ($item[$key]) {
                    if ($item['cosothotu_captrunguong']) {
                        $element['tw'] += intval($item['cosothotu_captrunguong']);
                    }
                    if ($item['cosothotu_captinh']) {
                        $element['tinh'] += intval($item['cosothotu_captinh']);
                    }
                }
            }
        }

        return $result;
    }
}

/**
 * TONG HOP DI TICH
 * TỔNG HỢP CƠ SỞ TÔN GIÁO, TÍN NGƯỠNG ĐƯỢC XẾP HẠNG DI TÍCH TRÊN ĐỊA BÀN TỈNH
 *
 * I. CÔNG GIÁO
 * 1. Bảng giaoxu
 * Tương ứng với từng huyện: BIÊN HÒA/LONG KHÁNH/XUÂN LỘC/CẨM MỸ/TÂN PHÚ/ĐỊNH QUÁN/THỐNG NHẤT/TRẢNG BOM/VĨNH CỬU/NHƠN TRẠCH/LONG THÀNH
 * diachi_huyen = Tương ứng với từng huyện ở trên và điều kiện
 * DI TÍCH LỊCH SỬ: cosothotu_ditichlichsu = true
 *      TRUNG ƯƠNG: cosothotu_captrunguong = true
 *      TỈNH      : cosothotu_captinh = true
 * DI TÍCH VĂN HÓA: cosothotu_ditichvanhoa = true
 *      TRUNG ƯƠNG: cosothotu_captrunguong = true
 *      TỈNH      : cosothotu_captinh = true
 * DI TÍCH LS-VH: cosothotu_ditichlichsuvanhoa = true
 *      TRUNG ƯƠNG: cosothotu_captrunguong = true
 *      TỈNH      : cosothotu_captinh = true
 * DI TÍCH KIẾN TRÚC NGHỆ THUẬT: cosothotu_ditichkientrucnghethuat = true
 *      TRUNG ƯƠNG: cosothotu_captrunguong = true
 *      TỈNH      : cosothotu_captinh = true
 * DI TÍCH KHẢO CỔ: cosothotu_ditichkhaoco = true
 *      TRUNG ƯƠNG: cosothotu_captrunguong = true
 *      TỈNH      : cosothotu_captinh = true
 *
 * II. PHẬT GIÁO
 * 2. Bảng tuvienphatgiao
 * Tương ứng với từng huyện: BIÊN HÒA/LONG KHÁNH/XUÂN LỘC/CẨM MỸ/TÂN PHÚ/ĐỊNH QUÁN/THỐNG NHẤT/TRẢNG BOM/VĨNH CỬU/NHƠN TRẠCH/LONG THÀNH
 * diachi_huyen = Tương ứng với từng huyện ở trên và điều kiện
 * DI TÍCH LỊCH SỬ: cosothotu_ditichlichsu = true
 *      TRUNG ƯƠNG: cosothotu_captrunguong = true
 *      TỈNH      : cosothotu_captinh = true
 * DI TÍCH VĂN HÓA: cosothotu_ditichvanhoa = true
 *      TRUNG ƯƠNG: cosothotu_captrunguong = true
 *      TỈNH      : cosothotu_captinh = true
 * DI TÍCH LS-VH: cosothotu_ditichlichsuvanhoa = true
 *      TRUNG ƯƠNG: cosothotu_captrunguong = true
 *      TỈNH      : cosothotu_captinh = true
 * DI TÍCH KIẾN TRÚC NGHỆ THUẬT: cosothotu_ditichkientrucnghethuat = true
 *      TRUNG ƯƠNG: cosothotu_captrunguong = true
 *      TỈNH      : cosothotu_captinh = true
 * DI TÍCH KHẢO CỔ: cosothotu_ditichkhaoco = true
 *      TRUNG ƯƠNG: cosothotu_captrunguong = true
 *      TỈNH      : cosothotu_captinh = true
 *
 * III. TIN LÀNH
 * 3. Bảng chihoitinlanh
 * Tương ứng với từng huyện: BIÊN HÒA/LONG KHÁNH/XUÂN LỘC/CẨM MỸ/TÂN PHÚ/ĐỊNH QUÁN/THỐNG NHẤT/TRẢNG BOM/VĨNH CỬU/NHƠN TRẠCH/LONG THÀNH
 * diachi_huyen = Tương ứng với từng huyện ở trên và điều kiện
 * DI TÍCH LỊCH SỬ: cosothotu_ditichlichsu = true
 *      TRUNG ƯƠNG: cosothotu_captrunguong = true
 *      TỈNH      : cosothotu_captinh = true
 * DI TÍCH VĂN HÓA: cosothotu_ditichvanhoa = true
 *      TRUNG ƯƠNG: cosothotu_captrunguong = true
 *      TỈNH      : cosothotu_captinh = true
 * DI TÍCH LS-VH: cosothotu_ditichlichsuvanhoa = true
 *      TRUNG ƯƠNG: cosothotu_captrunguong = true
 *      TỈNH      : cosothotu_captinh = true
 * DI TÍCH KIẾN TRÚC NGHỆ THUẬT: cosothotu_ditichkientrucnghethuat = true
 *      TRUNG ƯƠNG: cosothotu_captrunguong = true
 *      TỈNH      : cosothotu_captinh = true
 * DI TÍCH KHẢO CỔ: cosothotu_ditichkhaoco = true
 *      TRUNG ƯƠNG: cosothotu_captrunguong = true
 *      TỈNH      : cosothotu_captinh = true
 *
 * IV. CAO ĐÀI
 * 4. Bảng hodaocaodai
 * Tương ứng với từng huyện: BIÊN HÒA/LONG KHÁNH/XUÂN LỘC/CẨM MỸ/TÂN PHÚ/ĐỊNH QUÁN/THỐNG NHẤT/TRẢNG BOM/VĨNH CỬU/NHƠN TRẠCH/LONG THÀNH
 * tenhodao_diachi_huyen = Tương ứng với từng huyện ở trên và điều kiện
 * DI TÍCH LỊCH SỬ: cosothotu_ditichlichsu = true
 *      TRUNG ƯƠNG: cosothotu_captrunguong = true
 *      TỈNH      : cosothotu_captinh = true
 * DI TÍCH VĂN HÓA: cosothotu_ditichvanhoa = true
 *      TRUNG ƯƠNG: cosothotu_captrunguong = true
 *      TỈNH      : cosothotu_captinh = true
 * DI TÍCH LS-VH: cosothotu_ditichlichsuvanhoa = true
 *      TRUNG ƯƠNG: cosothotu_captrunguong = true
 *      TỈNH      : cosothotu_captinh = true
 * DI TÍCH KIẾN TRÚC NGHỆ THUẬT: cosothotu_ditichkientrucnghethuat = true
 *      TRUNG ƯƠNG: cosothotu_captrunguong = true
 *      TỈNH      : cosothotu_captinh = true
 * DI TÍCH KHẢO CỔ: cosothotu_ditichkhaoco = true
 *      TRUNG ƯƠNG: cosothotu_captrunguong = true
 *      TỈNH      : cosothotu_captinh = true
 *
 * V. TỊNH ĐỘ CƯ SĨ PHẬT HỘI VIỆT NAM
 * 5. Bảng chihoitinhdocusiphatgiaovietnam
 * Tương ứng với từng huyện: BIÊN HÒA/LONG KHÁNH/XUÂN LỘC/CẨM MỸ/TÂN PHÚ/ĐỊNH QUÁN/THỐNG NHẤT/TRẢNG BOM/VĨNH CỬU/NHƠN TRẠCH/LONG THÀNH
 * tenchihoi_diachi_huyen = Tương ứng với từng huyện ở trên và điều kiện
 * DI TÍCH LỊCH SỬ: cosothotu_ditichlichsu = true
 *      TRUNG ƯƠNG: cosothotu_captrunguong = true
 *      TỈNH      : cosothotu_captinh = true
 * DI TÍCH VĂN HÓA: cosothotu_ditichvanhoa = true
 *      TRUNG ƯƠNG: cosothotu_captrunguong = true
 *      TỈNH      : cosothotu_captinh = true
 * DI TÍCH LS-VH: cosothotu_ditichlichsuvanhoa = true
 *      TRUNG ƯƠNG: cosothotu_captrunguong = true
 *      TỈNH      : cosothotu_captinh = true
 * DI TÍCH KIẾN TRÚC NGHỆ THUẬT: cosothotu_ditichkientrucnghethuat = true
 *      TRUNG ƯƠNG: cosothotu_captrunguong = true
 *      TỈNH      : cosothotu_captinh = true
 * DI TÍCH KHẢO CỔ: cosothotu_ditichkhaoco = true
 *      TRUNG ƯƠNG: cosothotu_captrunguong = true
 *      TỈNH      : cosothotu_captinh = true
 *
 * VI. PHẬT GIÁO HÒA HẢO
 * DI TÍCH LỊCH SỬ: Để mặc định cho TRUNG ƯƠNG và TỈNH bằng 0
 * DI TÍCH VĂN HÓA: Để mặc định cho TRUNG ƯƠNG và TỈNH bằng 0
 * DI TÍCH LS-VH: Để mặc định cho TRUNG ƯƠNG và TỈNH bằng 0
 * DI TÍCH KIẾN TRÚC NGHỆ THUẬT: Để mặc định cho TRUNG ƯƠNG và TỈNH bằng 0
 * DI TÍCH KHẢO CỔ: Để mặc định cho TRUNG ƯƠNG và TỈNH bằng 0
 *
 * VII. HỒI GIÁO
 * 7. Bảng cosohoigiaoislam
 * Tương ứng với từng huyện: BIÊN HÒA/LONG KHÁNH/XUÂN LỘC/CẨM MỸ/TÂN PHÚ/ĐỊNH QUÁN/THỐNG NHẤT/TRẢNG BOM/VĨNH CỬU/NHƠN TRẠCH/LONG THÀNH
 * tenthanhduong_diachi_huyen = Tương ứng với từng huyện ở trên và điều kiện
 * DI TÍCH LỊCH SỬ: cosothotu_ditichlichsu = true
 *      TRUNG ƯƠNG: cosothotu_captrunguong = true
 *      TỈNH      : cosothotu_captinh = true
 * DI TÍCH VĂN HÓA: cosothotu_ditichvanhoa = true
 *      TRUNG ƯƠNG: cosothotu_captrunguong = true
 *      TỈNH      : cosothotu_captinh = true
 * DI TÍCH LS-VH: cosothotu_ditichlichsuvanhoa = true
 *      TRUNG ƯƠNG: cosothotu_captrunguong = true
 *      TỈNH      : cosothotu_captinh = true
 * DI TÍCH KIẾN TRÚC NGHỆ THUẬT: cosothotu_ditichkientrucnghethuat = true
 *      TRUNG ƯƠNG: cosothotu_captrunguong = true
 *      TỈNH      : cosothotu_captinh = true
 * DI TÍCH KHẢO CỔ: cosothotu_ditichkhaoco = true
 *      TRUNG ƯƠNG: cosothotu_captrunguong = true
 *      TỈNH      : cosothotu_captinh = true
 *
 */
