<?php

class ExportThTdVhCsComponent extends Component
{
    public function __construct()
    {
        App::uses('ProvinceComponent', 'Controller/Component');
        $this->Province = new ProvinceComponent(new ComponentCollection());

        $this->map_field = [
            1 => 'tieu_hoc',
            2 => 'thcs',
            3 => 'thpt',
            4 => 'so_cap',
            5 => 'trung_cap',
            6 => 'cao_dang',
            7 => 'dai_hoc',
            8 => 'sau_dai_hoc'
        ];

        $this->trinh_do = 'trinh_do';
    }

    public function export($filter = [])
    {
        $export_fields = [
            CONG_GIAO => [
                'Chucsacnhatuhanhconggiaotrieu',
                'Chucsacnhatuhanhcongiaodongtu'
            ],
            PHAT_GIAO => [
                'Chucsacnhatuhanhphatgiao'
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
            HOI_GIAO => [
                'Chucviechoigiao'
            ]
        ];

        $map_name = [
            CONG_GIAO => 'cong_giao',
            PHAT_GIAO => 'phat_giao',
            TIN_LANH => 'tin_lanh',
            CAO_DAI => 'cao_dai',
            TINH_DO_CU_SI => 'tinh_do_cu_si',
            HOI_GIAO => 'hoi_giao'
        ];

        $filter_group = $filter['ton_giao'];
        $filter_location = $filter['prefecture'];

        $province = $this->Province->getProvince($filter_location);

        $export = $this->init($province);

        foreach ($export_fields as $field_index => $list) {
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

    private function sum($data, $start = 2)
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


    private function __getChucsacnhatuhanhconggiaotrieu($model)
    {
        $fields = [
            'id',
        ];
        $conditions = [
            'trinhdohocvan_bangcap <>' => '',
            'trinhdohocvan_bangcap IS NOT NULL',
        ];
        $column = [
            'hoatdongtongiao_giaohat_diachi_huyen',
            'trinhdohocvan_bangcap',
        ];

        $province_field = 'hoatdongtongiao_giaohat_diachi_huyen';

        $fields = array_merge($fields, $column);

        $vf = $this->__getChucsacnhatuhanhconggiaotrieuVf();

        $data = $this->__getData($model, compact('fields', 'conditions'), $vf);

        return $this->__groupData($data, $this->map_field, $province_field);
    }

    private function __getChucsacnhatuhanhconggiaotrieuVf()
    {
        $tieu_hoc = 'WHEN
                        trinhdohocvan_bangcap IN (1, 2, 3, 4, 5) OR
                        trinhdohocvan_bangcap IN ("1/12", "2/12", "3/12", "4/12", "5/12")
                    THEN 1';
        $thcs = 'WHEN
                        trinhdohocvan_bangcap IN (6, 7, 8, 9) OR
                        trinhdohocvan_bangcap IN ("6/12", "7/12", "8/12", "9/12")
                    THEN 2';
        $thpt = 'WHEN
                        trinhdohocvan_bangcap IN (10, 11, 12) OR
                        trinhdohocvan_bangcap IN ("10/12", "11/12", "12/12", "Tú Tài")
                    THEN 3';
        $so_cap = 'WHEN
                        trinhdohocvan_bangcap LIKE "SƠ CẤP"
                    THEN 4';

        $trung_cap = 'WHEN
                        trinhdohocvan_bangcap LIKE "TRUNG CẤP%"
                    THEN 5';

        $cao_dang = 'WHEN
                        trinhdohocvan_bangcap LIKE "CAO ĐẲNG%"
                    THEN 6';

        $dai_hoc = 'WHEN
                        trinhdohocvan_bangcap LIKE "ĐẠI HỌC%" OR
                        trinhdohocvan_bangcap LIKE "CỬ NHÂN%"
                    THEN 7';

        $sau_dai_hoc = 'WHEN
                            trinhdohocvan_bangcap LIKE "CAO HỌC%" OR
                            trinhdohocvan_bangcap LIKE "SAU ĐẠI HỌC%" OR
                            trinhdohocvan_bangcap LIKE "THẠC SỸ%" OR
                            trinhdohocvan_bangcap LIKE "TIẾN SỸ%"
                        THEN 8';

        $vf = "
                    CASE
                        {$tieu_hoc}
                        {$thcs}
                        {$thpt}
                        {$sau_dai_hoc}
                        {$dai_hoc}
                        {$cao_dang}
                        {$trung_cap}
                        {$so_cap}
                        ELSE 0
                    END
                ";

        return $vf;
    }

    private function __getChucsacnhatuhanhcongiaodongtu($model)
    {
        $fields = [
            'id',
        ];
        $conditions = [
            'trinhdohocvan_bangcap <>' => '',
            'trinhdohocvan_bangcap IS NOT NULL',
        ];
        $column = [
            'diachi_huyen',
            'trinhdohocvan_bangcap',
        ];

        $province_field = 'diachi_huyen';

        $fields = array_merge($fields, $column);

        $vf = $this->__getChucsacnhatuhanhconggiaotrieuVf();

        $data = $this->__getData($model, compact('fields', 'conditions'), $vf);

        return $this->__groupData($data, $this->map_field, $province_field);
    }

    private function __getChucsacnhatuhanhcongiaodongtuVf()
    {
        $tieu_hoc = 'WHEN
                        trinhdohocvan_bangcap IN (1, 2, 3, 4, 5) OR
                        trinhdohocvan_bangcap IN ("1/12", "2/12", "3/12", "4/12", "5/12")
                    THEN 1';
        $thcs = 'WHEN
                        trinhdohocvan_bangcap IN (6, 7, 8, 9) OR
                        trinhdohocvan_bangcap IN ("6/12", "7/12", "8/12", "9/12")
                    THEN 2';
        $thpt = 'WHEN
                        trinhdohocvan_bangcap IN (10, 11, 12) OR
                        trinhdohocvan_bangcap IN ("10/12", "11/12", "12/12", "Tú Tài")
                    THEN 3';
        $so_cap = 'WHEN
                        trinhdohocvan_bangcap LIKE "SƠ CẤP"
                    THEN 4';

        $trung_cap = 'WHEN
                        trinhdohocvan_bangcap LIKE "TRUNG CẤP%"
                    THEN 5';

        $cao_dang = 'WHEN
                        trinhdohocvan_bangcap LIKE "CAO ĐẲNG%"
                    THEN 6';

        $dai_hoc = 'WHEN
                        trinhdohocvan_bangcap LIKE "ĐẠI HỌC%" OR
                        trinhdohocvan_bangcap LIKE "CỬ NHÂN%"
                    THEN 7';

        $sau_dai_hoc = 'WHEN
                            trinhdohocvan_bangcap LIKE "CAO HỌC%" OR
                            trinhdohocvan_bangcap LIKE "SAU ĐẠI HỌC%" OR
                            trinhdohocvan_bangcap LIKE "THẠC SỸ%" OR
                            trinhdohocvan_bangcap LIKE "TIẾN SỸ%"
                        THEN 8';

        $vf = "
                    CASE
                        {$tieu_hoc}
                        {$thcs}
                        {$thpt}
                        {$sau_dai_hoc}
                        {$dai_hoc}
                        {$cao_dang}
                        {$trung_cap}
                        {$so_cap}
                        ELSE 0
                    END
                ";

        return $vf;
    }

    private function __getChucsacnhatuhanhphatgiao($model)
    {
        $fields = [
            'id',
        ];
        $conditions = [
            'trinhdohocvan_bangcap <>' => '',
            'trinhdohocvan_bangcap IS NOT NULL',
        ];
        $column = [
            'tencosohoatdongtongiao_diachi_huyen',
            'trinhdohocvan_bangcap',
        ];

        $province_field = 'tencosohoatdongtongiao_diachi_huyen';

        $fields = array_merge($fields, $column);

        $vf = $this->__getChucsacnhatuhanhconggiaotrieuVf();

        $data = $this->__getData($model, compact('fields', 'conditions'), $vf);

        return $this->__groupData($data, $this->map_field, $province_field);
    }

    private function __getChucsacnhatuhanhphatgiaoVf()
    {
        $tieu_hoc = 'WHEN
                        trinhdohocvan_bangcap IN (1, 2, 3, 4, 5) OR
                        trinhdohocvan_bangcap IN ("1/12", "2/12", "3/12", "4/12", "5/12")
                    THEN 1';
        $thcs = 'WHEN
                        trinhdohocvan_bangcap IN (6, 7, 8, 9) OR
                        trinhdohocvan_bangcap IN ("6/12", "7/12", "8/12", "9/12")
                    THEN 2';
        $thpt = 'WHEN
                        trinhdohocvan_bangcap IN (10, 11, 12) OR
                        trinhdohocvan_bangcap IN ("10/12", "11/12", "12/12", "Tú Tài")
                    THEN 3';
        $so_cap = 'WHEN
                        trinhdohocvan_bangcap LIKE "SƠ CẤP"
                    THEN 4';

        $trung_cap = 'WHEN
                        trinhdohocvan_bangcap LIKE "TRUNG CẤP%"
                    THEN 5';

        $cao_dang = 'WHEN
                        trinhdohocvan_bangcap LIKE "CAO ĐẲNG%"
                    THEN 6';

        $dai_hoc = 'WHEN
                        trinhdohocvan_bangcap LIKE "ĐẠI HỌC%" OR
                        trinhdohocvan_bangcap LIKE "CỬ NHÂN%"
                    THEN 7';

        $sau_dai_hoc = 'WHEN
                            trinhdohocvan_bangcap LIKE "CAO HỌC%" OR
                            trinhdohocvan_bangcap LIKE "SAU ĐẠI HỌC%" OR
                            trinhdohocvan_bangcap LIKE "THẠC SỸ%" OR
                            trinhdohocvan_bangcap LIKE "TIẾN SỸ%"
                        THEN 8';

        $vf = "
                    CASE
                        {$tieu_hoc}
                        {$thcs}
                        {$thpt}
                        {$sau_dai_hoc}
                        {$dai_hoc}
                        {$cao_dang}
                        {$trung_cap}
                        {$so_cap}
                        ELSE 0
                    END
                ";

        return $vf;
    }

    private function __getChucsactinlanh($model)
    {
        $fields = [
            'id',
        ];
        $conditions = [
            'trinhdohocvan_bangcap <>' => '',
            'trinhdohocvan_bangcap IS NOT NULL',
        ];
        $column = [
            'diemnhom_diachi_huyen',
            'trinhdohocvan_bangcap',
        ];

        $province_field = 'diemnhom_diachi_huyen';

        $fields = array_merge($fields, $column);

        $vf = $this->__getChucsacnhatuhanhconggiaotrieuVf();

        $data = $this->__getData($model, compact('fields', 'conditions'), $vf);

        return $this->__groupData($data, $this->map_field, $province_field);
    }

    private function __getChucsactinlanhVf()
    {
        $tieu_hoc = 'WHEN
                        trinhdohocvan_bangcap IN (1, 2, 3, 4, 5) OR
                        trinhdohocvan_bangcap IN ("1/12", "2/12", "3/12", "4/12", "5/12")
                    THEN 1';
        $thcs = 'WHEN
                        trinhdohocvan_bangcap IN (6, 7, 8, 9) OR
                        trinhdohocvan_bangcap IN ("6/12", "7/12", "8/12", "9/12")
                    THEN 2';
        $thpt = 'WHEN
                        trinhdohocvan_bangcap IN (10, 11, 12) OR
                        trinhdohocvan_bangcap IN ("10/12", "11/12", "12/12", "Tú Tài")
                    THEN 3';
        $so_cap = 'WHEN
                        trinhdohocvan_bangcap LIKE "SƠ CẤP"
                    THEN 4';

        $trung_cap = 'WHEN
                        trinhdohocvan_bangcap LIKE "TRUNG CẤP%"
                    THEN 5';

        $cao_dang = 'WHEN
                        trinhdohocvan_bangcap LIKE "CAO ĐẲNG%"
                    THEN 6';

        $dai_hoc = 'WHEN
                        trinhdohocvan_bangcap LIKE "ĐẠI HỌC%" OR
                        trinhdohocvan_bangcap LIKE "CỬ NHÂN%"
                    THEN 7';

        $sau_dai_hoc = 'WHEN
                            trinhdohocvan_bangcap LIKE "CAO HỌC%" OR
                            trinhdohocvan_bangcap LIKE "SAU ĐẠI HỌC%" OR
                            trinhdohocvan_bangcap LIKE "THẠC SỸ%" OR
                            trinhdohocvan_bangcap LIKE "TIẾN SỸ%"
                        THEN 8';

        $vf = "
                    CASE
                        {$tieu_hoc}
                        {$thcs}
                        {$thpt}
                        {$sau_dai_hoc}
                        {$dai_hoc}
                        {$cao_dang}
                        {$trung_cap}
                        {$so_cap}
                        ELSE 0
                    END
                ";

        return $vf;
    }

    private function __getChucsaccaodai($model)
    {
        $fields = [
            'id',
        ];
        $conditions = [
            'trinhdohocvan_bangcap <>' => '',
            'trinhdohocvan_bangcap IS NOT NULL',
        ];
        $column = [
            'hoatdongtongiaotai_diachi_huyen',
            'trinhdohocvan_bangcap',
        ];

        $province_field = 'hoatdongtongiaotai_diachi_huyen';

        $fields = array_merge($fields, $column);

        $vf = $this->__getChucsacnhatuhanhconggiaotrieuVf();

        $data = $this->__getData($model, compact('fields', 'conditions'), $vf);

        return $this->__groupData($data, $this->map_field, $province_field);
    }

    private function __getChucsaccaodaiVf()
    {
        $tieu_hoc = 'WHEN
                        trinhdohocvan_bangcap IN (1, 2, 3, 4, 5) OR
                        trinhdohocvan_bangcap IN ("1/12", "2/12", "3/12", "4/12", "5/12")
                    THEN 1';
        $thcs = 'WHEN
                        trinhdohocvan_bangcap IN (6, 7, 8, 9) OR
                        trinhdohocvan_bangcap IN ("6/12", "7/12", "8/12", "9/12")
                    THEN 2';
        $thpt = 'WHEN
                        trinhdohocvan_bangcap IN (10, 11, 12) OR
                        trinhdohocvan_bangcap IN ("10/12", "11/12", "12/12", "Tú Tài")
                    THEN 3';
        $so_cap = 'WHEN
                        trinhdohocvan_bangcap LIKE "SƠ CẤP"
                    THEN 4';

        $trung_cap = 'WHEN
                        trinhdohocvan_bangcap LIKE "TRUNG CẤP%"
                    THEN 5';

        $cao_dang = 'WHEN
                        trinhdohocvan_bangcap LIKE "CAO ĐẲNG%"
                    THEN 6';

        $dai_hoc = 'WHEN
                        trinhdohocvan_bangcap LIKE "ĐẠI HỌC%" OR
                        trinhdohocvan_bangcap LIKE "CỬ NHÂN%"
                    THEN 7';

        $sau_dai_hoc = 'WHEN
                            trinhdohocvan_bangcap LIKE "CAO HỌC%" OR
                            trinhdohocvan_bangcap LIKE "SAU ĐẠI HỌC%" OR
                            trinhdohocvan_bangcap LIKE "THẠC SỸ%" OR
                            trinhdohocvan_bangcap LIKE "TIẾN SỸ%"
                        THEN 8';

        $vf = "
                    CASE
                        {$tieu_hoc}
                        {$thcs}
                        {$thpt}
                        {$sau_dai_hoc}
                        {$dai_hoc}
                        {$cao_dang}
                        {$trung_cap}
                        {$so_cap}
                        ELSE 0
                    END
                ";

        return $vf;
    }

    private function __getChucviectinhdocusiphathoivietnam($model)
    {
        $fields = [
            'id',
        ];
        $conditions = [
            'trinhdohocvan_bangcap <>' => '',
            'trinhdohocvan_bangcap IS NOT NULL',
        ];
        $column = [
            'hoatdongtongiaotai_diachi_huyen',
            'trinhdohocvan_bangcap',
        ];

        $province_field = 'hoatdongtongiaotai_diachi_huyen';

        $fields = array_merge($fields, $column);

        $vf = $this->__getChucsacnhatuhanhconggiaotrieuVf();

        $data = $this->__getData($model, compact('fields', 'conditions'), $vf);

        return $this->__groupData($data, $this->map_field, $province_field);
    }

    private function __getChucviectinhdocusiphathoivietnamVf()
    {
        $tieu_hoc = 'WHEN
                        trinhdohocvan_bangcap IN (1, 2, 3, 4, 5) OR
                        trinhdohocvan_bangcap IN ("1/12", "2/12", "3/12", "4/12", "5/12")
                    THEN 1';
        $thcs = 'WHEN
                        trinhdohocvan_bangcap IN (6, 7, 8, 9) OR
                        trinhdohocvan_bangcap IN ("6/12", "7/12", "8/12", "9/12")
                    THEN 2';
        $thpt = 'WHEN
                        trinhdohocvan_bangcap IN (10, 11, 12) OR
                        trinhdohocvan_bangcap IN ("10/12", "11/12", "12/12", "Tú Tài")
                    THEN 3';
        $so_cap = 'WHEN
                        trinhdohocvan_bangcap LIKE "SƠ CẤP"
                    THEN 4';

        $trung_cap = 'WHEN
                        trinhdohocvan_bangcap LIKE "TRUNG CẤP%"
                    THEN 5';

        $cao_dang = 'WHEN
                        trinhdohocvan_bangcap LIKE "CAO ĐẲNG%"
                    THEN 6';

        $dai_hoc = 'WHEN
                        trinhdohocvan_bangcap LIKE "ĐẠI HỌC%" OR
                        trinhdohocvan_bangcap LIKE "CỬ NHÂN%"
                    THEN 7';

        $sau_dai_hoc = 'WHEN
                            trinhdohocvan_bangcap LIKE "CAO HỌC%" OR
                            trinhdohocvan_bangcap LIKE "SAU ĐẠI HỌC%" OR
                            trinhdohocvan_bangcap LIKE "THẠC SỸ%" OR
                            trinhdohocvan_bangcap LIKE "TIẾN SỸ%"
                        THEN 8';

        $vf = "
                    CASE
                        {$tieu_hoc}
                        {$thcs}
                        {$thpt}
                        {$sau_dai_hoc}
                        {$dai_hoc}
                        {$cao_dang}
                        {$trung_cap}
                        {$so_cap}
                        ELSE 0
                    END
                ";

        return $vf;
    }

    private function __getChucviechoigiao($model)
    {
        $fields = [
            'id',
        ];
        $conditions = [
            'trinhdohocvan_bangcap <>' => '',
            'trinhdohocvan_bangcap IS NOT NULL',
        ];
        $column = [
            'hoatdongtongiaotai_diachi_huyen',
            'trinhdohocvan_bangcap',
        ];

        $province_field = 'hoatdongtongiaotai_diachi_huyen';

        $fields = array_merge($fields, $column);

        $vf = $this->__getChucsacnhatuhanhconggiaotrieuVf();

        $data = $this->__getData($model, compact('fields', 'conditions'), $vf);

        return $this->__groupData($data, $this->map_field, $province_field);
    }

    private function __getChucviechoigiaoVf()
    {
        $tieu_hoc = 'WHEN
                        trinhdohocvan_bangcap IN (1, 2, 3, 4, 5) OR
                        trinhdohocvan_bangcap IN ("1/12", "2/12", "3/12", "4/12", "5/12")
                    THEN 1';
        $thcs = 'WHEN
                        trinhdohocvan_bangcap IN (6, 7, 8, 9) OR
                        trinhdohocvan_bangcap IN ("6/12", "7/12", "8/12", "9/12")
                    THEN 2';
        $thpt = 'WHEN
                        trinhdohocvan_bangcap IN (10, 11, 12) OR
                        trinhdohocvan_bangcap IN ("10/12", "11/12", "12/12", "Tú Tài")
                    THEN 3';
        $so_cap = 'WHEN
                        trinhdohocvan_bangcap LIKE "SƠ CẤP"
                    THEN 4';

        $trung_cap = 'WHEN
                        trinhdohocvan_bangcap LIKE "TRUNG CẤP%"
                    THEN 5';

        $cao_dang = 'WHEN
                        trinhdohocvan_bangcap LIKE "CAO ĐẲNG%"
                    THEN 6';

        $dai_hoc = 'WHEN
                        trinhdohocvan_bangcap LIKE "ĐẠI HỌC%" OR
                        trinhdohocvan_bangcap LIKE "CỬ NHÂN%"
                    THEN 7';

        $sau_dai_hoc = 'WHEN
                            trinhdohocvan_bangcap LIKE "CAO HỌC%" OR
                            trinhdohocvan_bangcap LIKE "SAU ĐẠI HỌC%" OR
                            trinhdohocvan_bangcap LIKE "THẠC SỸ%" OR
                            trinhdohocvan_bangcap LIKE "TIẾN SỸ%"
                        THEN 8';

        $vf = "
                    CASE
                        {$tieu_hoc}
                        {$thcs}
                        {$thpt}
                        {$sau_dai_hoc}
                        {$dai_hoc}
                        {$cao_dang}
                        {$trung_cap}
                        {$so_cap}
                        ELSE 0
                    END
                ";

        return $vf;
    }

    private function __getData($model, $option = [], $vf)
    {
        $obj = ClassRegistry::init($model);

        $obj->virtualFields[$this->trinh_do] = $vf;
        array_push($option['fields'], $model . '.' . $this->trinh_do);

        $data = $obj->find('all', $option);

        return Hash::combine($data, '{n}.' . $model . '.id', '{n}.' . $model);
    }

    private function __groupData($data, $column, $province_field)
    {
        $tmp = [];
        $result = [];
        $province = $this->Province->getProvince();

        foreach ($province as $provice_code => $name) {
            $result[$provice_code] = [];
            $tmp[$provice_code] = [];
            foreach ($column as $key => $col) {
                $tmp[$provice_code][$key] = 0;
            }
        }

        foreach ($data as $id => $item) {
            $provice_code = $this->Province->retrieveProvinceCode($item[$province_field]);
            if (!$provice_code) {
                continue;
            }

            $trinh_do = intval($item[$this->trinh_do]);
            if ($trinh_do && $trinh_do < 6) {
                $tmp[$provice_code][$trinh_do]++;
            }
        }

        foreach ($tmp as $provice_code => $list) {
            foreach ($list as $key => $value) {
                $result[$provice_code][$column[$key]] = $value;
            }
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
}

/**
 * TH TRINH DO VH
 * TỔNG HỢP TRÌNH ĐỘ VĂN HÓA CỦA CHỨC SẮC CÁC TÔN GIÁO
 *
 * 1. Bảng chucsactinlanh
 * Tương ứng với từng huyện: BIÊN HÒA/LONG KHÁNH/XUÂN LỘC/CẨM MỸ/TÂN PHÚ/ĐỊNH QUÁN/THỐNG NHẤT/TRẢNG BOM/VĨNH CỬU/NHƠN TRẠCH/LONG THÀNH
 * diemnhom_diachi_huyen = Tương ứng với từng huyện ở trên và điều kiện
 * TIỂU HỌC VÀ TƯƠNG ĐƯƠNG  : trinhdohocvan_bangcap nằm trong mảng sau (1,2,3,4,5,1/12,2/12,3/12,4/12,5/12)
 * THCS VÀ TƯƠNG ĐƯƠNG      : trinhdohocvan_bangcap nằm trong mảng sau (6,7,8,9,6/12,7/12,8/12,9/12)
 * THPT VÀ TƯƠNG ĐƯƠNG      : trinhdohocvan_bangcap nằm trong mảng sau (10,11,12,10/12,11/12,12/12)
 * SƠ CẤP                   : trinhdothanhoc_bangcap LIKE "SƠ CẤP"
 * TRUNG CẤP                : trinhdothanhoc_bangcap LIKE "TRUNG CẤP"
 * CAO ĐẲNG                 : trinhdothanhoc_bangcap LIKE "CAO ĐẲNG"
 * ĐẠI HỌC                  : trinhdothanhoc_bangcap LIKE "ĐẠI HỌC" OR "Cử nhân"
 * TRÊN ĐẠI HỌC             : trinhdothanhoc_bangcap LIKE "Cao học" OR "SAU ĐẠI HỌC" OR "THẠC SỸ" OR "TIẾN SỸ"
 *
 * 2. Bảng chucsacnhatuhanhconggiaotrieu
 * Tương ứng với từng huyện: BIÊN HÒA/LONG KHÁNH/XUÂN LỘC/CẨM MỸ/TÂN PHÚ/ĐỊNH QUÁN/THỐNG NHẤT/TRẢNG BOM/VĨNH CỬU/NHƠN TRẠCH/LONG THÀNH
 * hoatdongtongiao_giaohat_diachi_huyen = Tương ứng với từng huyện ở trên và điều kiện
 * TIỂU HỌC VÀ TƯƠNG ĐƯƠNG  : trinhdohocvan_bangcap nằm trong mảng sau (1,2,3,4,5,1/12,2/12,3/12,4/12,5/12)
 * THCS VÀ TƯƠNG ĐƯƠNG      : trinhdohocvan_bangcap nằm trong mảng sau (6,7,8,9,6/12,7/12,8/12,9/12)
 * THPT VÀ TƯƠNG ĐƯƠNG      : trinhdohocvan_bangcap nằm trong mảng sau (10,11,12,10/12,11/12,12/12)
 * SƠ CẤP                   : trinhdothanhoc_bangcap LIKE "SƠ CẤP"
 * TRUNG CẤP                : trinhdothanhoc_bangcap LIKE "TRUNG CẤP"
 * CAO ĐẲNG                 : trinhdothanhoc_bangcap LIKE "CAO ĐẲNG"
 * ĐẠI HỌC                  : trinhdothanhoc_bangcap LIKE "ĐẠI HỌC" OR "Cử nhân"
 * TRÊN ĐẠI HỌC             : trinhdothanhoc_bangcap LIKE "Cao học" OR "SAU ĐẠI HỌC" OR "THẠC SỸ" OR "TIẾN SỸ"
 *
 * 3. Bảng chucsacnhatuhanhcongiaodongtu
 * Tương ứng với từng huyện: BIÊN HÒA/LONG KHÁNH/XUÂN LỘC/CẨM MỸ/TÂN PHÚ/ĐỊNH QUÁN/THỐNG NHẤT/TRẢNG BOM/VĨNH CỬU/NHƠN TRẠCH/LONG THÀNH
 * diachi_huyen = Tương ứng với từng huyện ở trên và điều kiện
 * TIỂU HỌC VÀ TƯƠNG ĐƯƠNG  : trinhdohocvan_bangcap nằm trong mảng sau (1,2,3,4,5,1/12,2/12,3/12,4/12,5/12)
 * THCS VÀ TƯƠNG ĐƯƠNG      : trinhdohocvan_bangcap nằm trong mảng sau (6,7,8,9,6/12,7/12,8/12,9/12)
 * THPT VÀ TƯƠNG ĐƯƠNG      : trinhdohocvan_bangcap nằm trong mảng sau (10,11,12,10/12,11/12,12/12)
 * SƠ CẤP                   : trinhdothanhoc_bangcap LIKE "SƠ CẤP"
 * TRUNG CẤP                : trinhdothanhoc_bangcap LIKE "TRUNG CẤP"
 * CAO ĐẲNG                 : trinhdothanhoc_bangcap LIKE "CAO ĐẲNG"
 * ĐẠI HỌC                  : trinhdothanhoc_bangcap LIKE "ĐẠI HỌC" OR "Cử nhân"
 * TRÊN ĐẠI HỌC             : trinhdothanhoc_bangcap LIKE "Cao học" OR "SAU ĐẠI HỌC" OR "THẠC SỸ" OR "TIẾN SỸ"
 *
 * 4. Bảng chucsacnhatuhanhphatgiao
 * Tương ứng với từng huyện: BIÊN HÒA/LONG KHÁNH/XUÂN LỘC/CẨM MỸ/TÂN PHÚ/ĐỊNH QUÁN/THỐNG NHẤT/TRẢNG BOM/VĨNH CỬU/NHƠN TRẠCH/LONG THÀNH
 * tencosohoatdongtongiao_diachi_huyen = Tương ứng với từng huyện ở trên và điều kiện
 * TIỂU HỌC VÀ TƯƠNG ĐƯƠNG  : trinhdohocvan_bangcap nằm trong mảng sau (1,2,3,4,5,1/12,2/12,3/12,4/12,5/12)
 * THCS VÀ TƯƠNG ĐƯƠNG      : trinhdohocvan_bangcap nằm trong mảng sau (6,7,8,9,6/12,7/12,8/12,9/12)
 * THPT VÀ TƯƠNG ĐƯƠNG      : trinhdohocvan_bangcap nằm trong mảng sau (10,11,12,10/12,11/12,12/12)
 * SƠ CẤP                   : trinhdothanhoc_bangcap LIKE "SƠ CẤP"
 * TRUNG CẤP                : trinhdothanhoc_bangcap LIKE "TRUNG CẤP"
 * CAO ĐẲNG                 : trinhdothanhoc_bangcap LIKE "CAO ĐẲNG"
 * ĐẠI HỌC                  : trinhdothanhoc_bangcap LIKE "ĐẠI HỌC" OR "Cử nhân"
 * TRÊN ĐẠI HỌC             : trinhdothanhoc_bangcap LIKE "Cao học" OR "SAU ĐẠI HỌC" OR "THẠC SỸ" OR "TIẾN SỸ"
 *
 * 5. Bảng chucsaccaodai
 * Tương ứng với từng huyện: BIÊN HÒA/LONG KHÁNH/XUÂN LỘC/CẨM MỸ/TÂN PHÚ/ĐỊNH QUÁN/THỐNG NHẤT/TRẢNG BOM/VĨNH CỬU/NHƠN TRẠCH/LONG THÀNH
 * hoatdongtongiaotai_diachi_huyen = Tương ứng với từng huyện ở trên và điều kiện
 * TIỂU HỌC VÀ TƯƠNG ĐƯƠNG  : trinhdohocvan_bangcap nằm trong mảng sau (1,2,3,4,5,1/12,2/12,3/12,4/12,5/12)
 * THCS VÀ TƯƠNG ĐƯƠNG      : trinhdohocvan_bangcap nằm trong mảng sau (6,7,8,9,6/12,7/12,8/12,9/12)
 * THPT VÀ TƯƠNG ĐƯƠNG      : trinhdohocvan_bangcap nằm trong mảng sau (10,11,12,10/12,11/12,12/12)
 * SƠ CẤP                   : trinhdothanhoc_bangcap LIKE "SƠ CẤP"
 * TRUNG CẤP                : trinhdothanhoc_bangcap LIKE "TRUNG CẤP"
 * CAO ĐẲNG                 : trinhdothanhoc_bangcap LIKE "CAO ĐẲNG"
 * ĐẠI HỌC                  : trinhdothanhoc_bangcap LIKE "ĐẠI HỌC" OR "Cử nhân"
 * TRÊN ĐẠI HỌC             : trinhdothanhoc_bangcap LIKE "Cao học" OR "SAU ĐẠI HỌC" OR "THẠC SỸ" OR "TIẾN SỸ"
 *
 * 6. Bảng chucviectinhdocusiphathoivietnam
 * Tương ứng với từng huyện: BIÊN HÒA/LONG KHÁNH/XUÂN LỘC/CẨM MỸ/TÂN PHÚ/ĐỊNH QUÁN/THỐNG NHẤT/TRẢNG BOM/VĨNH CỬU/NHƠN TRẠCH/LONG THÀNH
 * hoatdongtongiaotai_diachi_huyen = Tương ứng với từng huyện ở trên và điều kiện
 * TIỂU HỌC VÀ TƯƠNG ĐƯƠNG  : trinhdohocvan_bangcap nằm trong mảng sau (1,2,3,4,5,1/12,2/12,3/12,4/12,5/12)
 * THCS VÀ TƯƠNG ĐƯƠNG      : trinhdohocvan_bangcap nằm trong mảng sau (6,7,8,9,6/12,7/12,8/12,9/12)
 * THPT VÀ TƯƠNG ĐƯƠNG      : trinhdohocvan_bangcap nằm trong mảng sau (10,11,12,10/12,11/12,12/12)
 * SƠ CẤP                   : trinhdothanhoc_bangcap LIKE "SƠ CẤP"
 * TRUNG CẤP                : trinhdothanhoc_bangcap LIKE "TRUNG CẤP"
 * CAO ĐẲNG                 : trinhdothanhoc_bangcap LIKE "CAO ĐẲNG"
 * ĐẠI HỌC                  : trinhdothanhoc_bangcap LIKE "ĐẠI HỌC" OR "Cử nhân"
 * TRÊN ĐẠI HỌC             : trinhdothanhoc_bangcap LIKE "Cao học" OR "SAU ĐẠI HỌC" OR "THẠC SỸ" OR "TIẾN SỸ"
 *
 * 7. Bảng chucviechoigiao
 * Tương ứng với từng huyện: BIÊN HÒA/LONG KHÁNH/XUÂN LỘC/CẨM MỸ/TÂN PHÚ/ĐỊNH QUÁN/THỐNG NHẤT/TRẢNG BOM/VĨNH CỬU/NHƠN TRẠCH/LONG THÀNH
 * hoatdongtongiaotai_diachi_huyen = Tương ứng với từng huyện ở trên và điều kiện
 * TIỂU HỌC VÀ TƯƠNG ĐƯƠNG  : trinhdohocvan_bangcap nằm trong mảng sau (1,2,3,4,5,1/12,2/12,3/12,4/12,5/12)
 * THCS VÀ TƯƠNG ĐƯƠNG      : trinhdohocvan_bangcap nằm trong mảng sau (6,7,8,9,6/12,7/12,8/12,9/12)
 * THPT VÀ TƯƠNG ĐƯƠNG      : trinhdohocvan_bangcap nằm trong mảng sau (10,11,12,10/12,11/12,12/12)
 * SƠ CẤP                   : trinhdothanhoc_bangcap LIKE "SƠ CẤP"
 * TRUNG CẤP                : trinhdothanhoc_bangcap LIKE "TRUNG CẤP"
 * CAO ĐẲNG                 : trinhdothanhoc_bangcap LIKE "CAO ĐẲNG"
 * ĐẠI HỌC                  : trinhdothanhoc_bangcap LIKE "ĐẠI HỌC" OR "Cử nhân"
 * TRÊN ĐẠI HỌC             : trinhdothanhoc_bangcap LIKE "Cao học" OR "SAU ĐẠI HỌC" OR "THẠC SỸ" OR "TIẾN SỸ"
 *
 * CÔNG GIÁO = 2. Bảng chucsacnhatuhanhconggiaotrieu + 3. Bảng chucsacnhatuhanhcongiaodongtu
 * PHẬT GIÁO = 4. Bảng chucsacnhatuhanhphatgiao
 * TIN LÀNH = 1. Bảng chucsactinlanh
 * CAO ĐÀI = 5. Bảng chucsaccaodai
 * TỊNH ĐỘ CƯ SĨ PHẬT HỘI VIỆT NAM = 6. Bảng chucviectinhdocusiphathoivietnam
 * HỒI GIÁO = 7. Bảng chucviechoigiao
 */
