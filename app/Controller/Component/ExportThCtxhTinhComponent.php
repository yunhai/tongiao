<?php
App::uses('ExportExcelComponent', 'Controller/Component');
class ExportThCtxhTinhComponent extends ExportExcelComponent
{
    public function __construct()
    {
        App::uses('ProvinceComponent', 'Controller/Component');
        $this->Province = new ProvinceComponent(new ComponentCollection());

        $this->map_field = [
            1 => 'hoidongnhandan_captinh',
            2 => 'uybanmttqvn_captinh',
            3 => 'hoinongdan_captinh',
            4 => 'hoilienhiepphunu_captinh',
            5 => 'hoilienhiepthanhnien_captinh',
            6 => 'hoichuthapdo_captinh',
            7 => 'cactochuckhac_captinh'
        ];
    }

    public function layout($filter = [])
    {
        $row_data_index = 6;
        $row_header_index = 4;
        $column_begin = 11;
        $column_structure = [
            CONG_GIAO => '7',
            PHAT_GIAO => '7',
            TIN_LANH => '7',
            CAO_DAI => '7',
            TINH_DO_CU_SI => '7',
            HOA_HAO => '7',
            HOI_GIAO => '6'
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

        return compact('column_begin', 'column_structure', 'column_remove', 'row_header_index', 'row_data_index', 'cell_total_count');
    }
    
    public function export($filter = [])
    {
        $groups = [
            CONG_GIAO => [
                'Chucsacnhatuhanhconggiaotrieu',
                'Chucsacnhatuhanhcongiaodongtu'
            ],
            PHAT_GIAO => [
                'Chucsacnhatuhanhphatgiao',
                'Huynhtruonggiadinhphattu'
            ],
            TIN_LANH => [
                'Chucsactinlanh',
            ],
            CAO_DAI => [
                'Chucsaccaodai'
            ],
            TINH_DO_CU_SI => [
                'Chucviectinhdocusiphathoivietnam'
            ],
            HOA_HAO => [
                'Chucviecphathoahao'
            ],
            HOI_GIAO => [
                'Chucviechoigiao'
            ]
        ];

        $map_name = array(
            CONG_GIAO => 'cong_giao',
            PHAT_GIAO => 'phat_giao',
            TIN_LANH => 'tinh_lanh',
            CAO_DAI => 'cao_dai',
            TINH_DO_CU_SI => 'tinh_do_cu_si',
            HOA_HAO => 'hoa_hao',
            HOI_GIAO => 'hoi_giao'
        );

        $filter_group = $filter['ton_giao'];
        $filter_location = $filter['prefecture'];

        $province = $this->Province->getProvince($filter_location);

        $export = $this->init($province);

        foreach ($groups as $field_index => $list) {
            if (!empty($filter_group) && !in_array($field_index, $filter_group)) {
                continue;
            }

            $tmp = $this->__calculate($list);
            foreach ($province as $provice_code => $name) {
                $partial = $tmp[$provice_code];

                $index = 0;
                foreach ($partial as $count) {
                    $key = $this->map_field[++$index];

                    $export[$provice_code]['total'] += $count;
                    $export[$provice_code][$key] += $count;

                    $fn = $map_name[$field_index];
                    $export[$provice_code][$fn . '_' . $key] = $count;
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
                    $v = intval($v);
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
                'hoidongnhandan_captinh' => 1,
                'ubmttqvn_captinh' => 1,
                'hoichuthapdo_captinh' => 1,
                'hoinongdan_captinh' => 1,
                'hoilienhiepphunu_captinh' => 1,
                'doanthanhnien_captinh' => 1,
                'tochuckhac_captinh' => 1,
            ]
        ];
        $column = [
            'hoidongnhandan_captinh',
            'ubmttqvn_captinh',
            'hoinongdan_captinh',
            'hoilienhiepphunu_captinh',
            'doanthanhnien_captinh',
            'hoichuthapdo_captinh',
            // 'tochuckhac_captinh'
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
                'hoidongnhandan_captinh' => 1,
                'uybanmttqvn_captinh' => 1,
                'hoichuthapdo_captinh' => 1,
                'hoinongdan_captinh' => 1,
                'hoilienhiepphunu_captinh' => 1,
                'doanthanhnien_captinh' => 1,
                'tochuckhac_captinh' => 1
            ]
        ];
        $column = [
            'hoidongnhandan_captinh',
            'uybanmttqvn_captinh',
            'hoinongdan_captinh',
            'hoilienhiepphunu_captinh',
            'doanthanhnien_captinh',
            'hoichuthapdo_captinh',
            'tochuckhac_captinh'
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
                'hoidongnhandan_captinh' => 1,
                'ubmttqvn_captinh' => 1,
                'hoichuthapdo_captinh' => 1,
                'hoinongdan_captinh' => 1,
                'hoilienhiepphunu_captinh' => 1,
                'doanthanhnien_captinh' => 1,
                'tochuckhac_captinh' => 1
            ]
        ];
        $column = [
            'hoidongnhandan_captinh',
            'ubmttqvn_captinh',
            'hoinongdan_captinh',
            'hoilienhiepphunu_captinh',
            'doanthanhnien_captinh',
            'hoichuthapdo_captinh',
            'tochuckhac_captinh'
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
                'thamgiacactcctxh_hoidongnhandan_captinh' => 1,
                'thamgiacactcctxh_uybanmttqvn_captinh' => 1,
                'thamgiacactcctxh_hoichuthapdo_captinh' => 1,
                'thamgiacactcctxh_hoinongdan_captinh' => 1,
                'thamgiacactcctxh_hoilienhiepphunu_captinh' => 1,
                'thamgiacactcctxh_doanthanhnien_captinh' => 1,
                'thamgiacactcctxh_tochuckhac_captinh' => 1
            ]
        ];
        $column = [
            'thamgiacactcctxh_hoidongnhandan_captinh',
            'thamgiacactcctxh_uybanmttqvn_captinh',
            'thamgiacactcctxh_hoinongdan_captinh',
            'thamgiacactcctxh_hoilienhiepphunu_captinh',
            'thamgiacactcctxh_doanthanhnien_captinh',
            'thamgiacactcctxh_hoichuthapdo_captinh',
            'thamgiacactcctxh_tochuckhac_captinh'
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
                'thamgia_hoidongnhandan_captinh' => 1,
                'thamgia_ubmttqvn_captinh' => 1,
                'thamgia_hoinongdan_captinh' => 1,
                'thamgia_hoilienhiepphunu_captinh' => 1,
                'thamgia_hoilienhiepthanhnien_captinh' => 1,
                'thamgia_hoichuthapdo_captinh' => 1,
                'thamgia_cactochuckhac_captinh' => 1
            ]
        ];
        $column = [
            'thamgia_hoidongnhandan_captinh',
            'thamgia_ubmttqvn_captinh',
            'thamgia_hoinongdan_captinh',
            'thamgia_hoilienhiepphunu_captinh',
            'thamgia_hoilienhiepthanhnien_captinh',
            'thamgia_hoichuthapdo_captinh',
            'thamgia_cactochuckhac_captinh'
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
                'hoatdongtongiao_thamgia_hoidongnhandan_captinh' => 1,
                'hoatdongtongiao_thamgia_ubmttqvn_captinh' => 1,
                'hoatdongtongiao_thamgia_hoichuthapdo_captinh' => 1,
                'hoatdongtongiao_thamgia_hoinongdan_captinh' => 1,
                'hoatdongtongiao_thamgia_hoilienhiepthanhnien_captinh' => 1,
                'hoatdongtongiao_thamgia_hoilienhiepphunu_captinh' => 1,
                'hoatdongtongiao_thamgia_cactochuckhac_captinh' => 1
            ]
        ];
        $column = [
            'hoatdongtongiao_thamgia_hoidongnhandan_captinh',
            'hoatdongtongiao_thamgia_ubmttqvn_captinh',
            'hoatdongtongiao_thamgia_hoichuthapdo_captinh',
            'hoatdongtongiao_thamgia_hoinongdan_captinh',
            'hoatdongtongiao_thamgia_hoilienhiepthanhnien_captinh',
            'hoatdongtongiao_thamgia_hoilienhiepphunu_captinh',
            'hoatdongtongiao_thamgia_cactochuckhac_captinh'
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
                'hoidongnhandan_captinh' => 1,
                'uybanmttqvn_captinh' => 1,
                'hoichuthapdo_captinh' => 1,
                'hoinongdan_captinh' => 1,
                'hoilienhiepthanhnien_captinh' => 1,
                'hoilienhiepphunu_captinh' => 1,
                'cactochuckhac_captinh' => 1
            ]
        ];
        $column = [
            'hoidongnhandan_captinh',
            'uybanmttqvn_captinh',
            'hoinongdan_captinh',
            'hoilienhiepphunu_captinh',
            'hoilienhiepthanhnien_captinh',
            'hoichuthapdo_captinh',
            'cactochuckhac_captinh'
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
                'hoatdongtongiao_thamgia_hoidongnhandan_captinh' => 1,
                'hoatdongtongiao_thamgia_ubmttqvn_captinh' => 1,
                'hoatdongtongiao_thamgia_hoichuthapdo_captinh' => 1,
                'hoatdongtongiao_thamgia_hoinongdan_captinh' => 1,
                'hoatdongtongiao_thamgia_hoilienhiepthanhnien_captinh' => 1,
                'hoatdongtongiao_thamgia_hoilienhiepphunu_captinh' => 1,
                'hoatdongtongiao_thamgia_cactochuckhac_captinh' => 1
            ]
        ];
        $column = [
            'hoatdongtongiao_thamgia_hoidongnhandan_captinh',
            'hoatdongtongiao_thamgia_ubmttqvn_captinh',
            'hoatdongtongiao_thamgia_hoinongdan_captinh',
            'hoatdongtongiao_thamgia_hoilienhiepphunu_captinh',
            'hoatdongtongiao_thamgia_hoilienhiepthanhnien_captinh',
            'hoatdongtongiao_thamgia_hoichuthapdo_captinh',
            'hoatdongtongiao_thamgia_cactochuckhac_captinh'
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
                'hoatdongtongiao_thamgia_hoidongnhandan_captinh' => 1,
                'hoatdongtongiao_thamgia_ubmttqvn_captinh' => 1,
                'hoatdongtongiao_thamgia_hoichuthapdo_captinh' => 1,
                'hoatdongtongiao_thamgia_hoinongdan_captinh' => 1,
                'hoatdongtongiao_thamgia_hoilienhiepthanhnien_captinh' => 1,
                'hoatdongtongiao_thamgia_hoilienhiepphunu_captinh' => 1,
                'hoatdongtongiao_thamgia_cactochuckhac_captinh' => 1
            ]
        ];

        $column = [
            'hoatdongtongiao_thamgia_hoidongnhandan_captinh',
            'hoatdongtongiao_thamgia_ubmttqvn_captinh',
            'hoatdongtongiao_thamgia_hoinongdan_captinh',
            'hoatdongtongiao_thamgia_hoilienhiepphunu_captinh',
            'hoatdongtongiao_thamgia_hoilienhiepthanhnien_captinh',
            'hoatdongtongiao_thamgia_hoichuthapdo_captinh',
            'hoatdongtongiao_thamgia_cactochuckhac_captinh'
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
