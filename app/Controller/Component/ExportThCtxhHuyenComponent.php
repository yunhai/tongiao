<?php

class ExportThCtxhHuyenComponent extends Component
{
    public function __construct()
    {
        App::uses('ProvinceComponent', 'Controller/Component');
        $this->Province = new ProvinceComponent(new ComponentCollection());

        App::uses('UtilityComponent', 'Controller/Component');
        $this->Utility = new UtilityComponent(new ComponentCollection());

        $this->map_field = [
            1 => 'hoidongnhandan_caphuyen',
            2 => 'uybanmttqvn_caphuyen',
            3 => 'hoinongdan_caphuyen',
            4 => 'hoilienhiepphunu_caphuyen',
            5 => 'hoilienhiepthanhnien_caphuyen',
            6 => 'hoichuthapdo_caphuyen',
            7 => 'cactochuckhac_caphuyen'
        ];
    }

    public function export()
    {
        $export_fields = [
            [
                'Chucsacnhatuhanhconggiaotrieu',
                'Chucsacnhatuhanhcongiaodongtu'
            ],
            [
                'Chucsacnhatuhanhphatgiao',
                'Huynhtruonggiadinhphattu'
            ],
            [
                'Chucsactinlanh',
            ],
            [
                'Chucsaccaodai'
            ],
            [
                'Chucviectinhdocusiphathoivietnam'
            ],
            [
                'Chucviecphathoahao'
            ],
            [
                'Chucviechoigiao'
            ]
        ];

        $province = $this->Province->getProvince();

        $export = $this->init($province);

        foreach ($export_fields as $field_index => $list) {
            $tmp = $this->__calculate($list);
            foreach ($province as $provice_code => $name) {
                $partial = $tmp[$provice_code];

                $index = 0;
                foreach ($partial as $count) {
                    $key = $this->map_field[++$index];

                    $export[$provice_code]['total'] += $count;
                    $export[$provice_code][$key] += $count;
                    $export[$provice_code][$field_index . '_' . $key] = $count;
                }
            }
        }

        return $export;
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
            foreach ($this->map_field as $field) {
                $export[$code][$field] = 0;
            }
        }

        return $export;
    }

    private function __calculate($list)
    {
        $rows = [];
        foreach ($list as $model) {
            $func = '__get' . $model;
            array_push($rows, $this->$func($model));
        }

        $result = [];
        foreach ($rows as $row) {
            foreach ($row as $province => $data) {
                if (empty($result[$province])) {
                    $result[$province] = [];
                }

                $index = 0;
                foreach ($data as $v) {
                    ++$index;
                    if (isset($result[$province][$index])) {
                        $result[$province][$index] += $v;
                    } else {
                        $result[$province][$index] = $v;
                    }
                }
            }
        }

        return $result;
    }

    private function __getChucviechoigiao($model)
    {
        $fields = [
            'id',
            'hoatdongtongiaotai_diachi_huyen'
        ];
        $conditions = [
            'OR' => [
                'hoidongnhandan_caphuyen' => 1,
                'ubmttqvn_caphuyen' => 1,
                'hoichuthapdo_caphuyen' => 1,
                'hoinongdan_caphuyen' => 1,
                'hoilienhiepphunu_caphuyen' => 1,
                'doanthanhnien_caphuyen' => 1,
                'tochuckhac_caphuyen' => 1,
            ]
        ];
        $column = [
            'hoidongnhandan_caphuyen',
            'ubmttqvn_caphuyen',
            'hoinongdan_caphuyen',
            'hoilienhiepphunu_caphuyen',
            'doanthanhnien_caphuyen',
            'hoichuthapdo_caphuyen',
            // 'tochuckhac_caphuyen'
        ];
        $province_field = 'hoatdongtongiaotai_diachi_huyen';

        $fields = array_merge($fields, $column);
        $data = $this->__getData($model, compact('fields', 'conditions'));

        return $this->__groupData($data, $column, $province_field);
    }

    private function __getChucviecphathoahao($model)
    {
        $fields = [
            'id',
            'hoatdongtongiaotai_diachi_huyen'
        ];
        $conditions = [
            'OR' => [
                'hoidongnhandan_caphuyen' => 1,
                'uybanmttqvn_caphuyen' => 1,
                'hoichuthapdo_caphuyen' => 1,
                'hoinongdan_caphuyen' => 1,
                'hoilienhiepphunu_caphuyen' => 1,
                'doanthanhnien_caphuyen' => 1,
                'tochuckhac_caphuyen' => 1
            ]
        ];
        $column = [
            'hoidongnhandan_caphuyen',
            'uybanmttqvn_caphuyen',
            'hoinongdan_caphuyen',
            'hoilienhiepphunu_caphuyen',
            'doanthanhnien_caphuyen',
            'hoichuthapdo_caphuyen',
            'tochuckhac_caphuyen'
        ];
        $province_field = 'hoatdongtongiaotai_diachi_huyen';

        $fields = array_merge($fields, $column);
        $data = $this->__getData($model, compact('fields', 'conditions'));

        return $this->__groupData($data, $column, $province_field);
    }

    private function __getChucviectinhdocusiphathoivietnam($model)
    {
        $fields = [
            'id',
            'hoatdongtongiaotai_diachi_huyen'
        ];
        $conditions = [
            'OR' => [
                'hoidongnhandan_caphuyen' => 1,
                'ubmttqvn_caphuyen' => 1,
                'hoichuthapdo_caphuyen' => 1,
                'hoinongdan_caphuyen' => 1,
                'hoilienhiepphunu_caphuyen' => 1,
                'doanthanhnien_caphuyen' => 1,
                'tochuckhac_caphuyen' => 1
            ]
        ];
        $column = [
            'hoidongnhandan_caphuyen',
            'ubmttqvn_caphuyen',
            'hoinongdan_caphuyen',
            'hoilienhiepphunu_caphuyen',
            'doanthanhnien_caphuyen',
            'hoichuthapdo_caphuyen',
            'tochuckhac_caphuyen'
        ];
        $province_field = 'hoatdongtongiaotai_diachi_huyen';

        $fields = array_merge($fields, $column);
        $data = $this->__getData($model, compact('fields', 'conditions'));

        return $this->__groupData($data, $column, $province_field);
    }

    private function __getChucsaccaodai($model)
    {
        $fields = [
            'id',
            'hoatdongtongiaotai_diachi_huyen'
        ];
        $conditions = [
            'OR' => [
                'thamgiacactcctxh_hoidongnhandan_caphuyen' => 1,
                'thamgiacactcctxh_uybanmttqvn_caphuyen' => 1,
                'thamgiacactcctxh_hoichuthapdo_caphuyen' => 1,
                'thamgiacactcctxh_hoinongdan_caphuyen' => 1,
                'thamgiacactcctxh_hoilienhiepphunu_caphuyen' => 1,
                'thamgiacactcctxh_doanthanhnien_caphuyen' => 1,
                'thamgiacactcctxh_tochuckhac_caphuyen' => 1
            ]
        ];
        $column = [
            'thamgiacactcctxh_hoidongnhandan_caphuyen',
            'thamgiacactcctxh_uybanmttqvn_caphuyen',
            'thamgiacactcctxh_hoinongdan_caphuyen',
            'thamgiacactcctxh_hoilienhiepphunu_caphuyen',
            'thamgiacactcctxh_doanthanhnien_caphuyen',
            'thamgiacactcctxh_hoichuthapdo_caphuyen',
            'thamgiacactcctxh_tochuckhac_caphuyen'
        ];
        $province_field = 'hoatdongtongiaotai_diachi_huyen';

        $fields = array_merge($fields, $column);
        $data = $this->__getData($model, compact('fields', 'conditions'));

        return $this->__groupData($data, $column, $province_field);
    }

    private function __getHuynhtruonggiadinhphattu($model)
    {
        $fields = [
            'id',
            'diachi_huyen'
        ];
        $conditions = [
            'OR' => [
                'thamgia_hoidongnhandan_caphuyen' => 1,
                'thamgia_ubmttqvn_caphuyen' => 1,
                'thamgia_hoinongdan_caphuyen' => 1,
                'thamgia_hoilienhiepphunu_caphuyen' => 1,
                'thamgia_hoilienhiepthanhnien_caphuyen' => 1,
                'thamgia_hoichuthapdo_caphuyen' => 1,
                'thamgia_cactochuckhac_caphuyen' => 1
            ]
        ];
        $column = [
            'thamgia_hoidongnhandan_caphuyen',
            'thamgia_ubmttqvn_caphuyen',
            'thamgia_hoinongdan_caphuyen',
            'thamgia_hoilienhiepphunu_caphuyen',
            'thamgia_hoilienhiepthanhnien_caphuyen',
            'thamgia_hoichuthapdo_caphuyen',
            'thamgia_cactochuckhac_caphuyen'
        ];
        $province_field = 'diachi_huyen';

        $fields = array_merge($fields, $column);
        $data = $this->__getData($model, compact('fields', 'conditions'));

        return $this->__groupData($data, $column, $province_field);
    }

    private function __getChucsacnhatuhanhphatgiao($model)
    {
        $fields = [
            'id',
            'tencosohoatdongtongiao_diachi_huyen'
        ];
        $conditions = [
            'OR' => [
                'hoatdongtongiao_thamgia_hoidongnhandan_caphuyen' => 1,
                'hoatdongtongiao_thamgia_ubmttqvn_caphuyen' => 1,
                'hoatdongtongiao_thamgia_hoichuthapdo_caphuyen' => 1,
                'hoatdongtongiao_thamgia_hoinongdan_caphuyen' => 1,
                'hoatdongtongiao_thamgia_hoilienhiepthanhnien_caphuyen' => 1,
                'hoatdongtongiao_thamgia_hoilienhiepphunu_caphuyen' => 1,
                'hoatdongtongiao_thamgia_cactochuckhac_caphuyen' => 1
            ]
        ];
        $column = [
            'hoatdongtongiao_thamgia_hoidongnhandan_caphuyen',
            'hoatdongtongiao_thamgia_ubmttqvn_caphuyen',
            'hoatdongtongiao_thamgia_hoichuthapdo_caphuyen',
            'hoatdongtongiao_thamgia_hoinongdan_caphuyen',
            'hoatdongtongiao_thamgia_hoilienhiepthanhnien_caphuyen',
            'hoatdongtongiao_thamgia_hoilienhiepphunu_caphuyen',
            'hoatdongtongiao_thamgia_cactochuckhac_caphuyen'
        ];
        $province_field = 'tencosohoatdongtongiao_diachi_huyen';

        $fields = array_merge($fields, $column);
        $data = $this->__getData($model, compact('fields', 'conditions'));

        return $this->__groupData($data, $column, $province_field);
    }

    private function __getChucsactinlanh($model)
    {
        $fields = [
            'id',
            'diemnhom_diachi_huyen'
        ];
        $conditions = [
            'OR' => [
                'hoidongnhandan_caphuyen' => 1,
                'uybanmttqvn_caphuyen' => 1,
                'hoichuthapdo_caphuyen' => 1,
                'hoinongdan_caphuyen' => 1,
                'hoilienhiepthanhnien_caphuyen' => 1,
                'hoilienhiepphunu_caphuyen' => 1,
                'cactochuckhac_caphuyen' => 1
            ]
        ];
        $column = [
            'hoidongnhandan_caphuyen',
            'uybanmttqvn_caphuyen',
            'hoinongdan_caphuyen',
            'hoilienhiepphunu_caphuyen',
            'hoilienhiepthanhnien_caphuyen',
            'hoichuthapdo_caphuyen',
            'cactochuckhac_caphuyen'
        ];
        $province_field = 'diemnhom_diachi_huyen';

        $fields = array_merge($fields, $column);
        $data = $this->__getData($model, compact('fields', 'conditions'));

        return $this->__groupData($data, $column, $province_field);
    }

    private function __getChucsacnhatuhanhconggiaotrieu($model)
    {
        $fields = [
            'id',
            'hoatdongtongiao_giaohat_diachi_huyen'
        ];
        $conditions = [
            'OR' => [
                'hoatdongtongiao_thamgia_hoidongnhandan_caphuyen' => 1,
                'hoatdongtongiao_thamgia_ubmttqvn_caphuyen' => 1,
                'hoatdongtongiao_thamgia_hoichuthapdo_caphuyen' => 1,
                'hoatdongtongiao_thamgia_hoinongdan_caphuyen' => 1,
                'hoatdongtongiao_thamgia_hoilienhiepthanhnien_caphuyen' => 1,
                'hoatdongtongiao_thamgia_hoilienhiepphunu_caphuyen' => 1,
                'hoatdongtongiao_thamgia_cactochuckhac_caphuyen' => 1
            ]
        ];
        $column = [
            'hoatdongtongiao_thamgia_hoidongnhandan_caphuyen',
            'hoatdongtongiao_thamgia_ubmttqvn_caphuyen',
            'hoatdongtongiao_thamgia_hoinongdan_caphuyen',
            'hoatdongtongiao_thamgia_hoilienhiepphunu_caphuyen',
            'hoatdongtongiao_thamgia_hoilienhiepthanhnien_caphuyen',
            'hoatdongtongiao_thamgia_hoichuthapdo_caphuyen',
            'hoatdongtongiao_thamgia_cactochuckhac_caphuyen'
        ];
        $province_field = 'hoatdongtongiao_giaohat_diachi_huyen';

        $fields = array_merge($fields, $column);
        $data = $this->__getData($model, compact('fields', 'conditions'));

        return $this->__groupData($data, $column, $province_field);
    }

    private function __getChucsacnhatuhanhcongiaodongtu($model)
    {
        $fields = [
            'id',
            'diachi_huyen'
        ];

        $conditions = [
            'OR' => [
                'hoatdongtongiao_thamgia_hoidongnhandan_caphuyen' => 1,
                'hoatdongtongiao_thamgia_ubmttqvn_caphuyen' => 1,
                'hoatdongtongiao_thamgia_hoichuthapdo_caphuyen' => 1,
                'hoatdongtongiao_thamgia_hoinongdan_caphuyen' => 1,
                'hoatdongtongiao_thamgia_hoilienhiepthanhnien_caphuyen' => 1,
                'hoatdongtongiao_thamgia_hoilienhiepphunu_caphuyen' => 1,
                'hoatdongtongiao_thamgia_cactochuckhac_caphuyen' => 1
            ]
        ];

        $column = [
            'hoatdongtongiao_thamgia_hoidongnhandan_caphuyen',
            'hoatdongtongiao_thamgia_ubmttqvn_caphuyen',
            'hoatdongtongiao_thamgia_hoinongdan_caphuyen',
            'hoatdongtongiao_thamgia_hoilienhiepphunu_caphuyen',
            'hoatdongtongiao_thamgia_hoilienhiepthanhnien_caphuyen',
            'hoatdongtongiao_thamgia_hoichuthapdo_caphuyen',
            'hoatdongtongiao_thamgia_cactochuckhac_caphuyen'
        ];
        $province_field = 'diachi_huyen';

        $fields = array_merge($fields, $column);
        $data = $this->__getData($model, compact('fields', 'conditions'));

        return $this->__groupData($data, $column, $province_field);
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

        foreach ($province as $provice_code => $name) {
            foreach ($column as $col) {
                $result[$provice_code][$col] = 0;
            }
        }

        foreach ($data as $id => $item) {
            $provice_code = $this->Province->retrieveProvinceCode($item[$province_field]);
            if (!$provice_code) {
                continue;
            }

            foreach ($result[$provice_code] as $key => &$count) {
                if ($item[$key]) {
                    $count++;
                }
            }
        }

        return $result;
    }
}

/**
 * TH CS THAM GIA CT-XH CAP HUYEN
 * TỔNG HỢP CHỨC SẮC TÔN GIÁO THAM GIA CÁC TỔ CHỨC CHÍNH TRỊ - XÃ HỘI CẤP HUYỆN
 *
 * * 1. Bảng chucsactinlanh
 * - lấy dữ liệu thõa điều kiện sau:
 * BIÊN HÒA: diemnhom_diachi_huyen = BIÊN HÒA
 * LONG KHÁNH: diemnhom_diachi_huyen = LONG KHÁNH
 * XUÂN LỘC: diemnhom_diachi_huyen = XUÂN LỘC
 * CẨM MỸ: diemnhom_diachi_huyen = CẨM MỸ
 * TÂN PHÚ: diemnhom_diachi_huyen = TÂN PHÚ
 * ĐỊNH QUÁN: diemnhom_diachi_huyen = ĐỊNH QUÁN
 * THỐNG NHẤT: diemnhom_diachi_huyen = THỐNG NHẤT
 * TRẢNG BOM: diemnhom_diachi_huyen = TRẢNG BOM
 * VĨNH CỬU: diemnhom_diachi_huyen = NHƠN TRẠCH
 * LONG THÀNH: diemnhom_diachi_huyen = LONG THÀNH
 * và điều kiện
 * cột hoidongnhandan_caphuyen = true hoặc
 * cột uybanmttqvn_caphuyen = true hoặc
 * cột hoichuthapdo_caphuyen = true hoặc
 * cột hoinongdan_caphuyen = true hoặc
 * cột hoilienhiepthanhnien_caphuyen = true hoặc
 * cột hoilienhiepphunu_caphuyen = true hoặc
 * cột cactochuckhac_caphuyen = true
 *
 * 2. Bảng chucsacnhatuhanhconggiaotrieu
 * - lấy dữ liệu thõa điều kiện sau:
 * BIÊN HÒA: hoatdongtongiao_giaohat_diachi_huyen = BIÊN HÒA
 * LONG KHÁNH: hoatdongtongiao_giaohat_diachi_huyen = LONG KHÁNH
 * XUÂN LỘC: hoatdongtongiao_giaohat_diachi_huyen = XUÂN LỘC
 * CẨM MỸ: hoatdongtongiao_giaohat_diachi_huyen = CẨM MỸ
 * TÂN PHÚ: hoatdongtongiao_giaohat_diachi_huyen = TÂN PHÚ
 * ĐỊNH QUÁN: hoatdongtongiao_giaohat_diachi_huyen = ĐỊNH QUÁN
 * THỐNG NHẤT: hoatdongtongiao_giaohat_diachi_huyen = THỐNG NHẤT
 * TRẢNG BOM: hoatdongtongiao_giaohat_diachi_huyen = TRẢNG BOM
 * VĨNH CỬU: hoatdongtongiao_giaohat_diachi_huyen = NHƠN TRẠCH
 * LONG THÀNH: hoatdongtongiao_giaohat_diachi_huyen = LONG THÀNH
 * và điều kiện
 * cột hoatdongtongiao_thamgia_hoidongnhandan_caphuyen = true hoặc
 * cột hoatdongtongiao_thamgia_ubmttqvn_caphuyen = true hoặc
 * cột hoatdongtongiao_thamgia_hoichuthapdo_caphuyen = true hoặc
 * cột hoatdongtongiao_thamgia_hoinongdan_caphuyen = true hoặc
 * cột hoatdongtongiao_thamgia_hoilienhiepthanhnien_caphuyen = true hoặc
 * cột hoatdongtongiao_thamgia_hoilienhiepphunu_caphuyen = true hoặc
 * cột hoatdongtongiao_thamgia_cactochuckhac_caphuyen = true
 *
 * 3. Bảng chucsacnhatuhanhcongiaodongtu
 * - lấy dữ liệu thõa điều kiện sau:
 * BIÊN HÒA: diachi_huyen = BIÊN HÒA
 * LONG KHÁNH: diachi_huyen = LONG KHÁNH
 * XUÂN LỘC: diachi_huyen = XUÂN LỘC
 * CẨM MỸ: diachi_huyen = CẨM MỸ
 * TÂN PHÚ: diachi_huyen = TÂN PHÚ
 * ĐỊNH QUÁN: diachi_huyen = ĐỊNH QUÁN
 * THỐNG NHẤT: diachi_huyen = THỐNG NHẤT
 * TRẢNG BOM: diachi_huyen = TRẢNG BOM
 * VĨNH CỬU: diachi_huyen = NHƠN TRẠCH
 * LONG THÀNH: diachi_huyen = LONG THÀNH
 * và điều kiện
 * cột hoatdongtongiao_thamgia_hoidongnhandan_caphuyen = true hoặc
 * cột hoatdongtongiao_thamgia_ubmttqvn_caphuyen = true hoặc
 * cột hoatdongtongiao_thamgia_hoichuthapdo_caphuyen = true hoặc
 * cột hoatdongtongiao_thamgia_hoinongdan_caphuyen = true hoặc
 * cột hoatdongtongiao_thamgia_hoilienhiepthanhnien_caphuyen = true hoặc
 * cột hoatdongtongiao_thamgia_hoilienhiepphunu_caphuyen = true hoặc
 * cột hoatdongtongiao_thamgia_cactochuckhac_caphuyen = true
 *
 * 4. Bảng chucviecphathoahao
 * - lấy dữ liệu thõa điều kiện sau:
 * BIÊN HÒA: hoatdongtongiaotai_diachi_huyen = BIÊN HÒA
 * LONG KHÁNH: hoatdongtongiaotai_diachi_huyen = LONG KHÁNH
 * XUÂN LỘC: hoatdongtongiaotai_diachi_huyen = XUÂN LỘC
 * CẨM MỸ: hoatdongtongiaotai_diachi_huyen = CẨM MỸ
 * TÂN PHÚ: hoatdongtongiaotai_diachi_huyen = TÂN PHÚ
 * ĐỊNH QUÁN: hoatdongtongiaotai_diachi_huyen = ĐỊNH QUÁN
 * THỐNG NHẤT: hoatdongtongiaotai_diachi_huyen = THỐNG NHẤT
 * TRẢNG BOM: hoatdongtongiaotai_diachi_huyen = TRẢNG BOM
 * VĨNH CỬU: hoatdongtongiaotai_diachi_huyen = NHƠN TRẠCH
 * LONG THÀNH: hoatdongtongiaotai_diachi_huyen = LONG THÀNH
 * và điều kiện
 * cột hoidongnhandan_caphuyen = true hoặc
 * cột uybanmttqvn_caphuyen = true hoặc
 * cột hoichuthapdo_caphuyen = true hoặc
 * cột hoinongdan_caphuyen = true hoặc
 * cột hoilienhiepphunu_caphuyen = true hoặc
 * cột doanthanhnien_caphuyen = true hoặc
 * cột tochuckhac_caphuyen = true
 *
 * 5. Bảng chucviectinhdocusiphathoivietnam
 * - lấy dữ liệu thõa điều kiện sau:
 * BIÊN HÒA: hoatdongtongiaotai_diachi_huyen = BIÊN HÒA
 * LONG KHÁNH: hoatdongtongiaotai_diachi_huyen = LONG KHÁNH
 * XUÂN LỘC: hoatdongtongiaotai_diachi_huyen = XUÂN LỘC
 * CẨM MỸ: hoatdongtongiaotai_diachi_huyen = CẨM MỸ
 * TÂN PHÚ: hoatdongtongiaotai_diachi_huyen = TÂN PHÚ
 * ĐỊNH QUÁN: hoatdongtongiaotai_diachi_huyen = ĐỊNH QUÁN
 * THỐNG NHẤT: hoatdongtongiaotai_diachi_huyen = THỐNG NHẤT
 * TRẢNG BOM: hoatdongtongiaotai_diachi_huyen = TRẢNG BOM
 * VĨNH CỬU: hoatdongtongiaotai_diachi_huyen = NHƠN TRẠCH
 * LONG THÀNH: hoatdongtongiaotai_diachi_huyen = LONG THÀNH
 * và điều kiện
 * cột hoidongnhandan_caphuyen = true hoặc
 * cột ubmttqvn_caphuyen = true hoặc
 * cột hoichuthapdo_caphuyen = true hoặc
 * cột hoinongdan_caphuyen = true hoặc
 * cột hoilienhiepphunu_caphuyen = true hoặc
 * cột doanthanhnien_caphuyen = true hoặc
 * cột tochuckhac_caphuyen = true
 *
 * 6. Bảng chucsaccaodai
 * - lấy dữ liệu thõa điều kiện sau:
 * BIÊN HÒA: hoatdongtongiaotai_diachi_huyen = BIÊN HÒA
 * LONG KHÁNH: hoatdongtongiaotai_diachi_huyen = LONG KHÁNH
 * XUÂN LỘC: hoatdongtongiaotai_diachi_huyen = XUÂN LỘC
 * CẨM MỸ: hoatdongtongiaotai_diachi_huyen = CẨM MỸ
 * TÂN PHÚ: hoatdongtongiaotai_diachi_huyen = TÂN PHÚ
 * ĐỊNH QUÁN: hoatdongtongiaotai_diachi_huyen = ĐỊNH QUÁN
 * THỐNG NHẤT: hoatdongtongiaotai_diachi_huyen = THỐNG NHẤT
 * TRẢNG BOM: hoatdongtongiaotai_diachi_huyen = TRẢNG BOM
 * VĨNH CỬU: hoatdongtongiaotai_diachi_huyen = NHƠN TRẠCH
 * LONG THÀNH: hoatdongtongiaotai_diachi_huyen = LONG THÀNH
 * và điều kiện
 * cột thamgiacactcctxh_hoidongnhandan_caphuyen = true hoặc
 * cột thamgiacactcctxh_uybanmttqvn_caphuyen = true hoặc
 * cột thamgiacactcctxh_hoichuthapdo_caphuyen = true hoặc
 * cột thamgiacactcctxh_hoinongdan_caphuyen = true hoặc
 * cột thamgiacactcctxh_hoilienhiepphunu_caphuyen = true hoặc
 * cột thamgiacactcctxh_doanthanhnien_caphuyen = true hoặc
 * cột thamgiacactcctxh_tochuckhac_caphuyen = true
 *
 * 7. Bảng chucsacnhatuhanhphatgiao
 * - lấy dữ liệu thõa điều kiện sau:
 * BIÊN HÒA: tencosohoatdongtongiao_diachi_huyen = BIÊN HÒA
 * LONG KHÁNH: tencosohoatdongtongiao_diachi_huyen = LONG KHÁNH
 * XUÂN LỘC: tencosohoatdongtongiao_diachi_huyen = XUÂN LỘC
 * CẨM MỸ: tencosohoatdongtongiao_diachi_huyen = CẨM MỸ
 * TÂN PHÚ: tencosohoatdongtongiao_diachi_huyen = TÂN PHÚ
 * ĐỊNH QUÁN: tencosohoatdongtongiao_diachi_huyen = ĐỊNH QUÁN
 * THỐNG NHẤT: tencosohoatdongtongiao_diachi_huyen = THỐNG NHẤT
 * TRẢNG BOM: tencosohoatdongtongiao_diachi_huyen = TRẢNG BOM
 * VĨNH CỬU: tencosohoatdongtongiao_diachi_huyen = NHƠN TRẠCH
 * LONG THÀNH: tencosohoatdongtongiao_diachi_huyen = LONG THÀNH
 * và điều kiện
 * cột hoatdongtongiao_thamgia_hoidongnhandan_caphuyen = true hoặc
 * cột hoatdongtongiao_thamgia_ubmttqvn_caphuyen = true hoặc
 * cột hoatdongtongiao_thamgia_hoichuthapdo_caphuyen = true hoặc
 * cột hoatdongtongiao_thamgia_hoinongdan_caphuyen = true hoặc
 * cột hoatdongtongiao_thamgia_hoilienhiepthanhnien_caphuyen = true hoặc
 * cột hoatdongtongiao_thamgia_hoilienhiepphunu_caphuyen = true hoặc
 * cột hoatdongtongiao_thamgia_cactochuckhac_caphuyen = true
 *
 * 8. Bảng huynhtruonggiadinhphattu
 * - lấy dữ liệu thõa điều kiện sau:
 * BIÊN HÒA: diachi_huyen = BIÊN HÒA
 * LONG KHÁNH: diachi_huyen = LONG KHÁNH
 * XUÂN LỘC: diachi_huyen = XUÂN LỘC
 * CẨM MỸ: diachi_huyen = CẨM MỸ
 * TÂN PHÚ: diachi_huyen = TÂN PHÚ
 * ĐỊNH QUÁN: diachi_huyen = ĐỊNH QUÁN
 * THỐNG NHẤT: diachi_huyen = THỐNG NHẤT
 * TRẢNG BOM: diachi_huyen = TRẢNG BOM
 * VĨNH CỬU: diachi_huyen = NHƠN TRẠCH
 * LONG THÀNH: diachi_huyen = LONG THÀNH
 * và điều kiện
 * cột thamgia_hoidongnhandan_caphuyen = true hoặc
 * cột thamgia_ubmttqvn_caphuyen = true hoặc
 * cột thamgia_hoinongdan_caphuyen = true hoặc
 * cột thamgia_hoichuthapdo_caphuyen = true hoặc
 * cột thamgia_hoilienhiepthanhnien_caphuyen = true hoặc
 * cột thamgia_hoilienhiepphunu_caphuyen = true hoặc
 * cột thamgia_cactochuckhac_caphuyen = true
 *
 * 9. Bảng chucviechoigiao
 * - lấy dữ liệu thõa điều kiện sau:
 * BIÊN HÒA: hoatdongtongiaotai_diachi_huyen = BIÊN HÒA
 * LONG KHÁNH: hoatdongtongiaotai_diachi_huyen = LONG KHÁNH
 * XUÂN LỘC: hoatdongtongiaotai_diachi_huyen = XUÂN LỘC
 * CẨM MỸ: hoatdongtongiaotai_diachi_huyen = CẨM MỸ
 * TÂN PHÚ: hoatdongtongiaotai_diachi_huyen = TÂN PHÚ
 * ĐỊNH QUÁN: hoatdongtongiaotai_diachi_huyen = ĐỊNH QUÁN
 * THỐNG NHẤT: hoatdongtongiaotai_diachi_huyen = THỐNG NHẤT
 * TRẢNG BOM: hoatdongtongiaotai_diachi_huyen = TRẢNG BOM
 * VĨNH CỬU: hoatdongtongiaotai_diachi_huyen = NHƠN TRẠCH
 * LONG THÀNH: hoatdongtongiaotai_diachi_huyen = LONG THÀNH
 * và điều kiện
 * cột hoidongnhandan_caphuyen = true hoặc
 * cột ubmttqvn_caphuyen = true hoặc
 * cột hoichuthapdo_caphuyen = true hoặc
 * cột hoinongdan_caphuyen = true hoặc
 * cột hoilienhiepphunu_caphuyen = true hoặc
 * cột doanthanhnien_caphuyen = true hoặc
 * cột tochuckhac_caphuyen = true
 *
 * Tính tổng dữ liệu trên theo huyện
 *
 * CÔNG GIÁO = 2. Bảng chucsacnhatuhanhconggiaotrieu + 3. Bảng chucsacnhatuhanhcongiaodongtu
 * PHẬT GIÁO = 7. Bảng chucsacnhatuhanhphatgiao + 8. Bảng huynhtruonggiadinhphattu
 * TIN LÀNH = 1. Bảng chucsactinlanh
 * CAO ĐÀI = 6. Bảng chucsaccaodai
 * TỊNH ĐỘ CƯ SĨ PHẬT HỘI VIỆT NAM = 5. Bảng chucviectinhdocusiphathoivietnam
 * PHẬT GIÁO HÒA HẢO = 4. Bảng chucviecphathoahao
 * HỒI GIÁO = 9. Bảng chucviechoigiao
 */
