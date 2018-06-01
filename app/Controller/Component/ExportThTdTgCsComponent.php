<?php

App::uses('ExportExcelComponent', 'Controller/Component');

class ExportThTdTgCsComponent extends ExportExcelComponent
{
    public function __construct()
    {
        parent::__construct();
        $this->map_field = [
            1 => 'so_cap',
            2 => 'trung_cap',
            3 => 'cao_dang',
            4 => 'dai_hoc',
            5 => 'sau_dai_hoc'
        ];

        $this->trinh_do = 'trinh_do';
    }

    public function export($filter = [])
    {
        $groups = [
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

    public function layout($filter = [])
    {
        $row_header_index = 5;
        $row_data_index = 8;
        $column_begin = 9;
        $column_structure = [
            CONG_GIAO => 5,
            PHAT_GIAO => 5,
            TIN_LANH => 5,
            CAO_DAI => 5,
            TINH_DO_CU_SI => 5,
            HOI_GIAO => 5,
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

    private function __getChucsaccaodai($model)
    {
        $province_field = '';
        $data = [];

        return $this->__groupData($data, $this->map_field, $province_field);
    }

    private function __getChucviectinhdocusiphathoivietnam($model)
    {
        $province_field = '';
        $data = [];

        return $this->__groupData($data, $this->map_field, $province_field);
    }

    private function __getChucviechoigiao($model)
    {
        $province_field = '';
        $data = [];

        return $this->__groupData($data, $this->map_field, $province_field);
    }

    ////////////////////////////////////////////
    private function __getChucsacnhatuhanhconggiaotrieu($model)
    {
        $fields = [
            'id',
        ];
        $conditions = [
            'trinhdochuyenmonvetongiao_bangcap <>' => '',
            'trinhdochuyenmonvetongiao_bangcap IS NOT NULL',
        ];
        $column = [
            'hoatdongtongiao_giaohat_diachi_huyen',
            'trinhdochuyenmonvetongiao_bangcap',
        ];

        $province_field = 'hoatdongtongiao_giaohat_diachi_huyen';

        $fields = array_merge($fields, $column);

        $vf = $this->__getChucsacnhatuhanhconggiaotrieuVf();

        $data = $this->__getData($model, compact('fields', 'conditions'), $vf);

        return $this->__groupData($data, $this->map_field, $province_field);
    }

    private function __getChucsacnhatuhanhconggiaotrieuVf()
    {
        $so_cap = 'WHEN
						trinhdochuyenmonvetongiao_bangcap LIKE "SƠ CẤP"
					THEN 1';

        $trung_cap = 'WHEN
						trinhdochuyenmonvetongiao_bangcap LIKE "TRUNG CẤP"
					THEN 2';

        $cao_dang = 'WHEN
						trinhdochuyenmonvetongiao_bangcap LIKE "CAO ĐẲNG"
					THEN 3';

        $dai_hoc = 'WHEN
						trinhdochuyenmonvetongiao_bangcap LIKE "ĐẠI HỌC" OR
						trinhdochuyenmonvetongiao_bangcap LIKE "Cử nhân"
					THEN 4';

        $sau_dai_hoc = 'WHEN
							trinhdochuyenmonvetongiao_bangcap LIKE "Cao học" OR
							trinhdochuyenmonvetongiao_bangcap LIKE "SAU ĐẠI HỌC" OR
							trinhdochuyenmonvetongiao_bangcap LIKE "THẠC SỸ" OR
							trinhdochuyenmonvetongiao_bangcap LIKE "TIẾN SỸ"
						THEN 5';

        $vf = "
			CASE
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
            'trinhdothanhoc_bangcap <>' => '',
            'trinhdothanhoc_bangcap IS NOT NULL',
        ];
        $column = [
            'diachi_huyen',
            'trinhdothanhoc_bangcap',
        ];

        $province_field = 'diachi_huyen';

        $fields = array_merge($fields, $column);

        $vf = $this->__getChucsacnhatuhanhcongiaodongtuVf();

        $data = $this->__getData($model, compact('fields', 'conditions'), $vf);

        return $this->__groupData($data, $this->map_field, $province_field);
    }

    private function __getChucsacnhatuhanhcongiaodongtuVf()
    {
        $so_cap = 'WHEN
						trinhdothanhoc_bangcap LIKE "SƠ CẤP"
					THEN 1';

        $trung_cap = 'WHEN
						trinhdothanhoc_bangcap LIKE "TRUNG CẤP"
					THEN 2';

        $cao_dang = 'WHEN
						trinhdothanhoc_bangcap LIKE "CAO ĐẲNG"
					THEN 3';

        $dai_hoc = 'WHEN
						trinhdothanhoc_bangcap LIKE "ĐẠI HỌC" OR
						trinhdothanhoc_bangcap LIKE "Cử nhân"
					THEN 4';

        $sau_dai_hoc = 'WHEN
							trinhdothanhoc_bangcap LIKE "Cao học" OR
							trinhdothanhoc_bangcap LIKE "SAU ĐẠI HỌC" OR
							trinhdothanhoc_bangcap LIKE "THẠC SỸ" OR
							trinhdothanhoc_bangcap LIKE "TIẾN SỸ"
						THEN 5';

        $vf = "
			CASE
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
            'id'
        ];
        $conditions = [
            'trinhdochuyenmonvetongiao_bangcap <>' => '',
            'trinhdochuyenmonvetongiao_bangcap IS NOT NULL',
        ];
        $column = [
            'tencosohoatdongtongiao_diachi_huyen',
            'trinhdochuyenmonvetongiao_bangcap',
        ];

        $province_field = 'tencosohoatdongtongiao_diachi_huyen';

        $fields = array_merge($fields, $column);

        $f = "__get{$model}Vf";
        $vf = $this->$f();

        $data = $this->__getData($model, compact('fields', 'conditions'), $vf);

        return $this->__groupData($data, $this->map_field, $province_field);
    }

    private function __getChucsacnhatuhanhphatgiaoVf()
    {
        $so_cap = 'WHEN
						trinhdochuyenmonvetongiao_bangcap LIKE "SƠ CẤP"
					THEN 1';

        $trung_cap = 'WHEN
						trinhdochuyenmonvetongiao_bangcap LIKE "TRUNG CẤP"
					THEN 2';

        $cao_dang = 'WHEN
						trinhdochuyenmonvetongiao_bangcap LIKE "CAO ĐẲNG"
					THEN 3';

        $dai_hoc = 'WHEN
						trinhdochuyenmonvetongiao_bangcap LIKE "ĐẠI HỌC" OR
						trinhdochuyenmonvetongiao_bangcap LIKE "Cử nhân"
					THEN 4';

        $sau_dai_hoc = 'WHEN
							trinhdochuyenmonvetongiao_bangcap LIKE "Cao học" OR
							trinhdochuyenmonvetongiao_bangcap LIKE "SAU ĐẠI HỌC" OR
							trinhdochuyenmonvetongiao_bangcap LIKE "THẠC SỸ" OR
							trinhdochuyenmonvetongiao_bangcap LIKE "TIẾN SỸ"
						THEN 5';

        $vf = "
			CASE
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
            'id'
        ];
        $conditions = [
            'trinhdothanhoc_bangcap <>' => '',
            'trinhdothanhoc_bangcap IS NOT NULL',
        ];
        $column = [
            'diemnhom_diachi_huyen',
            'trinhdothanhoc_bangcap',
        ];

        $province_field = 'diemnhom_diachi_huyen';

        $fields = array_merge($fields, $column);

        $f = "__get{$model}Vf";
        $vf = $this->$f();

        $data = $this->__getData($model, compact('fields', 'conditions'), $vf);

        return $this->__groupData($data, $this->map_field, $province_field);
    }

    private function __getChucsactinlanhVf()
    {
        $so_cap = 'WHEN
						trinhdothanhoc_bangcap LIKE "SƠ CẤP"
					THEN 1';

        $trung_cap = 'WHEN
						trinhdothanhoc_bangcap LIKE "TRUNG CẤP"
					THEN 2';

        $cao_dang = 'WHEN
						trinhdothanhoc_bangcap LIKE "CAO ĐẲNG"
					THEN 3';

        $dai_hoc = 'WHEN
						trinhdothanhoc_bangcap LIKE "ĐẠI HỌC" OR
						trinhdothanhoc_bangcap LIKE "Cử nhân"
					THEN 4';

        $sau_dai_hoc = 'WHEN
							trinhdothanhoc_bangcap LIKE "Cao học" OR
							trinhdothanhoc_bangcap LIKE "SAU ĐẠI HỌC" OR
							trinhdothanhoc_bangcap LIKE "THẠC SỸ" OR
							trinhdothanhoc_bangcap LIKE "TIẾN SỸ"
						THEN 5';

        $vf = "
			CASE
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

            $trinh_do = $item[$this->trinh_do];
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
}

/**
 * TH TRINH DO TON GIAO
 * TỔNG HỢP TRÌNH ĐỘ TÔN GIÁO CỦA CHỨC SẮC CÁC TÔN GIÁO
 *
 * 1. Bảng chucsactinlanh
 * A. BIÊN HÒA:
 * diemnhom_diachi_huyen = BIÊN HÒA và điều kiện
 * SƠ CẤP: trinhdothanhoc_bangcap LIKE SƠ CẤP
 * TRUNG CẤP: trinhdothanhoc_bangcap LIKE TRUNG CẤP
 * CAO ĐẲNG: trinhdothanhoc_bangcap LIKE CAO ĐẲNG
 * ĐẠI HỌC: trinhdothanhoc_bangcap LIKE ĐẠI HỌC
 * TRÊN ĐẠI HỌC: trinhdothanhoc_bangcap LIKE TRÊN ĐẠI HỌC
 * B. LONG KHÁNH:
 * diemnhom_diachi_huyen = LONG KHÁNH và điều kiện
 * SƠ CẤP: trinhdothanhoc_bangcap LIKE SƠ CẤP
 * TRUNG CẤP: trinhdothanhoc_bangcap LIKE TRUNG CẤP
 * CAO ĐẲNG: trinhdothanhoc_bangcap LIKE CAO ĐẲNG
 * ĐẠI HỌC: trinhdothanhoc_bangcap LIKE ĐẠI HỌC
 * TRÊN ĐẠI HỌC: trinhdothanhoc_bangcap LIKE TRÊN ĐẠI HỌC
 * C. XUÂN LỘC:
 * diemnhom_diachi_huyen = XUÂN LỘC và điều kiện
 * SƠ CẤP: trinhdothanhoc_bangcap LIKE SƠ CẤP
 * TRUNG CẤP: trinhdothanhoc_bangcap LIKE TRUNG CẤP
 * CAO ĐẲNG: trinhdothanhoc_bangcap LIKE CAO ĐẲNG
 * ĐẠI HỌC: trinhdothanhoc_bangcap LIKE ĐẠI HỌC
 * TRÊN ĐẠI HỌC: trinhdothanhoc_bangcap LIKE TRÊN ĐẠI HỌC
 * D. CẨM MỸ:
 * diemnhom_diachi_huyen = CẨM MỸ và điều kiện
 * SƠ CẤP: trinhdothanhoc_bangcap LIKE SƠ CẤP
 * TRUNG CẤP: trinhdothanhoc_bangcap LIKE TRUNG CẤP
 * CAO ĐẲNG: trinhdothanhoc_bangcap LIKE CAO ĐẲNG
 * ĐẠI HỌC: trinhdothanhoc_bangcap LIKE ĐẠI HỌC
 * TRÊN ĐẠI HỌC: trinhdothanhoc_bangcap LIKE TRÊN ĐẠI HỌC
 * E. TÂN PHÚ:
 * diemnhom_diachi_huyen = TÂN PHÚ và điều kiện
 * SƠ CẤP: trinhdothanhoc_bangcap LIKE SƠ CẤP
 * TRUNG CẤP: trinhdothanhoc_bangcap LIKE TRUNG CẤP
 * CAO ĐẲNG: trinhdothanhoc_bangcap LIKE CAO ĐẲNG
 * ĐẠI HỌC: trinhdothanhoc_bangcap LIKE ĐẠI HỌC
 * TRÊN ĐẠI HỌC: trinhdothanhoc_bangcap LIKE TRÊN ĐẠI HỌC
 * F. ĐỊNH QUÁN:
 * diemnhom_diachi_huyen = ĐỊNH QUÁN và điều kiện
 * SƠ CẤP: trinhdothanhoc_bangcap LIKE SƠ CẤP
 * TRUNG CẤP: trinhdothanhoc_bangcap LIKE TRUNG CẤP
 * CAO ĐẲNG: trinhdothanhoc_bangcap LIKE CAO ĐẲNG
 * ĐẠI HỌC: trinhdothanhoc_bangcap LIKE ĐẠI HỌC
 * TRÊN ĐẠI HỌC: trinhdothanhoc_bangcap LIKE TRÊN ĐẠI HỌC
 * G. THỐNG NHẤT:
 * diemnhom_diachi_huyen = THỐNG NHẤT và điều kiện
 * SƠ CẤP: trinhdothanhoc_bangcap LIKE SƠ CẤP
 * TRUNG CẤP: trinhdothanhoc_bangcap LIKE TRUNG CẤP
 * CAO ĐẲNG: trinhdothanhoc_bangcap LIKE CAO ĐẲNG
 * ĐẠI HỌC: trinhdothanhoc_bangcap LIKE ĐẠI HỌC
 * TRÊN ĐẠI HỌC: trinhdothanhoc_bangcap LIKE TRÊN ĐẠI HỌC
 * H. TRẢNG BOM:
 * diemnhom_diachi_huyen = TRẢNG BOM và điều kiện
 * SƠ CẤP: trinhdothanhoc_bangcap LIKE SƠ CẤP
 * TRUNG CẤP: trinhdothanhoc_bangcap LIKE TRUNG CẤP
 * CAO ĐẲNG: trinhdothanhoc_bangcap LIKE CAO ĐẲNG
 * ĐẠI HỌC: trinhdothanhoc_bangcap LIKE ĐẠI HỌC
 * TRÊN ĐẠI HỌC: trinhdothanhoc_bangcap LIKE TRÊN ĐẠI HỌC
 * I. VĨNH CỬU:
 * diemnhom_diachi_huyen = NHƠN TRẠCH và điều kiện
 * SƠ CẤP: trinhdothanhoc_bangcap LIKE SƠ CẤP
 * TRUNG CẤP: trinhdothanhoc_bangcap LIKE TRUNG CẤP
 * CAO ĐẲNG: trinhdothanhoc_bangcap LIKE CAO ĐẲNG
 * ĐẠI HỌC: trinhdothanhoc_bangcap LIKE ĐẠI HỌC
 * TRÊN ĐẠI HỌC: trinhdothanhoc_bangcap LIKE TRÊN ĐẠI HỌC
 * J. LONG THÀNH:
 * diemnhom_diachi_huyen = LONG THÀNH và điều kiện
 * SƠ CẤP: trinhdothanhoc_bangcap LIKE SƠ CẤP
 * TRUNG CẤP: trinhdothanhoc_bangcap LIKE TRUNG CẤP
 * CAO ĐẲNG: trinhdothanhoc_bangcap LIKE CAO ĐẲNG
 * ĐẠI HỌC: trinhdothanhoc_bangcap LIKE ĐẠI HỌC
 * TRÊN ĐẠI HỌC: trinhdothanhoc_bangcap LIKE TRÊN ĐẠI HỌC
 *
 * 2. Bảng chucsacnhatuhanhconggiaotrieu
 * A. BIÊN HÒA:
 * hoatdongtongiao_giaohat_diachi_huyen = BIÊN HÒA và điều kiện
 * SƠ CẤP: trinhdochuyenmonvetongiao_bangcap LIKE SƠ CẤP
 * TRUNG CẤP: trinhdochuyenmonvetongiao_bangcap LIKE TRUNG CẤP
 * CAO ĐẲNG: trinhdochuyenmonvetongiao_bangcap LIKE CAO ĐẲNG
 * ĐẠI HỌC: trinhdochuyenmonvetongiao_bangcap LIKE ĐẠI HỌC
 * TRÊN ĐẠI HỌC: trinhdochuyenmonvetongiao_bangcap LIKE TRÊN ĐẠI HỌC
 * B. LONG KHÁNH:
 * hoatdongtongiao_giaohat_diachi_huyen = LONG KHÁNH và điều kiện
 * SƠ CẤP: trinhdochuyenmonvetongiao_bangcap LIKE SƠ CẤP
 * TRUNG CẤP: trinhdochuyenmonvetongiao_bangcap LIKE TRUNG CẤP
 * CAO ĐẲNG: trinhdochuyenmonvetongiao_bangcap LIKE CAO ĐẲNG
 * ĐẠI HỌC: trinhdochuyenmonvetongiao_bangcap LIKE ĐẠI HỌC
 * TRÊN ĐẠI HỌC: trinhdochuyenmonvetongiao_bangcap LIKE TRÊN ĐẠI HỌC
 * C. XUÂN LỘC:
 * hoatdongtongiao_giaohat_diachi_huyen = XUÂN LỘC và điều kiện
 * SƠ CẤP: trinhdochuyenmonvetongiao_bangcap LIKE SƠ CẤP
 * TRUNG CẤP: trinhdochuyenmonvetongiao_bangcap LIKE TRUNG CẤP
 * CAO ĐẲNG: trinhdochuyenmonvetongiao_bangcap LIKE CAO ĐẲNG
 * ĐẠI HỌC: trinhdochuyenmonvetongiao_bangcap LIKE ĐẠI HỌC
 * TRÊN ĐẠI HỌC: trinhdochuyenmonvetongiao_bangcap LIKE TRÊN ĐẠI HỌC
 * D. CẨM MỸ:
 * hoatdongtongiao_giaohat_diachi_huyen = CẨM MỸ và điều kiện
 * SƠ CẤP: trinhdochuyenmonvetongiao_bangcap LIKE SƠ CẤP
 * TRUNG CẤP: trinhdochuyenmonvetongiao_bangcap LIKE TRUNG CẤP
 * CAO ĐẲNG: trinhdochuyenmonvetongiao_bangcap LIKE CAO ĐẲNG
 * ĐẠI HỌC: trinhdochuyenmonvetongiao_bangcap LIKE ĐẠI HỌC
 * TRÊN ĐẠI HỌC: trinhdochuyenmonvetongiao_bangcap LIKE TRÊN ĐẠI HỌC
 * E. TÂN PHÚ:
 * hoatdongtongiao_giaohat_diachi_huyen = TÂN PHÚ và điều kiện
 * SƠ CẤP: trinhdochuyenmonvetongiao_bangcap LIKE SƠ CẤP
 * TRUNG CẤP: trinhdochuyenmonvetongiao_bangcap LIKE TRUNG CẤP
 * CAO ĐẲNG: trinhdochuyenmonvetongiao_bangcap LIKE CAO ĐẲNG
 * ĐẠI HỌC: trinhdochuyenmonvetongiao_bangcap LIKE ĐẠI HỌC
 * TRÊN ĐẠI HỌC: trinhdochuyenmonvetongiao_bangcap LIKE TRÊN ĐẠI HỌC
 * F. ĐỊNH QUÁN:
 * hoatdongtongiao_giaohat_diachi_huyen = ĐỊNH QUÁN và điều kiện
 * SƠ CẤP: trinhdochuyenmonvetongiao_bangcap LIKE SƠ CẤP
 * TRUNG CẤP: trinhdochuyenmonvetongiao_bangcap LIKE TRUNG CẤP
 * CAO ĐẲNG: trinhdochuyenmonvetongiao_bangcap LIKE CAO ĐẲNG
 * ĐẠI HỌC: trinhdochuyenmonvetongiao_bangcap LIKE ĐẠI HỌC
 * TRÊN ĐẠI HỌC: trinhdochuyenmonvetongiao_bangcap LIKE TRÊN ĐẠI HỌC
 * G. THỐNG NHẤT:
 * hoatdongtongiao_giaohat_diachi_huyen = THỐNG NHẤT và điều kiện
 * SƠ CẤP: trinhdochuyenmonvetongiao_bangcap LIKE SƠ CẤP
 * TRUNG CẤP: trinhdochuyenmonvetongiao_bangcap LIKE TRUNG CẤP
 * CAO ĐẲNG: trinhdochuyenmonvetongiao_bangcap LIKE CAO ĐẲNG
 * ĐẠI HỌC: trinhdochuyenmonvetongiao_bangcap LIKE ĐẠI HỌC
 * TRÊN ĐẠI HỌC: trinhdochuyenmonvetongiao_bangcap LIKE TRÊN ĐẠI HỌC
 * H. TRẢNG BOM:
 * hoatdongtongiao_giaohat_diachi_huyen = TRẢNG BOM và điều kiện
 * SƠ CẤP: trinhdochuyenmonvetongiao_bangcap LIKE SƠ CẤP
 * TRUNG CẤP: trinhdochuyenmonvetongiao_bangcap LIKE TRUNG CẤP
 * CAO ĐẲNG: trinhdochuyenmonvetongiao_bangcap LIKE CAO ĐẲNG
 * ĐẠI HỌC: trinhdochuyenmonvetongiao_bangcap LIKE ĐẠI HỌC
 * TRÊN ĐẠI HỌC: trinhdochuyenmonvetongiao_bangcap LIKE TRÊN ĐẠI HỌC
 * I. VĨNH CỬU:
 * hoatdongtongiao_giaohat_diachi_huyen = NHƠN TRẠCH và điều kiện
 * SƠ CẤP: trinhdochuyenmonvetongiao_bangcap LIKE SƠ CẤP
 * TRUNG CẤP: trinhdochuyenmonvetongiao_bangcap LIKE TRUNG CẤP
 * CAO ĐẲNG: trinhdochuyenmonvetongiao_bangcap LIKE CAO ĐẲNG
 * ĐẠI HỌC: trinhdochuyenmonvetongiao_bangcap LIKE ĐẠI HỌC
 * TRÊN ĐẠI HỌC: trinhdochuyenmonvetongiao_bangcap LIKE TRÊN ĐẠI HỌC
 * J. LONG THÀNH:
 * hoatdongtongiao_giaohat_diachi_huyen = LONG THÀNH và điều kiện
 * SƠ CẤP: trinhdochuyenmonvetongiao_bangcap LIKE SƠ CẤP
 * TRUNG CẤP: trinhdochuyenmonvetongiao_bangcap LIKE TRUNG CẤP
 * CAO ĐẲNG: trinhdochuyenmonvetongiao_bangcap LIKE CAO ĐẲNG
 * ĐẠI HỌC: trinhdochuyenmonvetongiao_bangcap LIKE ĐẠI HỌC
 * TRÊN ĐẠI HỌC: trinhdochuyenmonvetongiao_bangcap LIKE TRÊN ĐẠI HỌC
 *
 * 3. Bảng chucsacnhatuhanhcongiaodongtu
 * A. BIÊN HÒA:
 * diachi_huyen = BIÊN HÒA và điều kiện
 * SƠ CẤP: trinhdothanhoc_bangcap LIKE SƠ CẤP
 * TRUNG CẤP: trinhdothanhoc_bangcap LIKE TRUNG CẤP
 * CAO ĐẲNG: trinhdothanhoc_bangcap LIKE CAO ĐẲNG
 * ĐẠI HỌC: trinhdothanhoc_bangcap LIKE ĐẠI HỌC
 * TRÊN ĐẠI HỌC: trinhdothanhoc_bangcap LIKE TRÊN ĐẠI HỌC
 * B. LONG KHÁNH:
 * diachi_huyen = LONG KHÁNH và điều kiện
 * SƠ CẤP: trinhdothanhoc_bangcap LIKE SƠ CẤP
 * TRUNG CẤP: trinhdothanhoc_bangcap LIKE TRUNG CẤP
 * CAO ĐẲNG: trinhdothanhoc_bangcap LIKE CAO ĐẲNG
 * ĐẠI HỌC: trinhdothanhoc_bangcap LIKE ĐẠI HỌC
 * TRÊN ĐẠI HỌC: trinhdothanhoc_bangcap LIKE TRÊN ĐẠI HỌC
 * C. XUÂN LỘC:
 * diachi_huyen = XUÂN LỘC và điều kiện
 * SƠ CẤP: trinhdothanhoc_bangcap LIKE SƠ CẤP
 * TRUNG CẤP: trinhdothanhoc_bangcap LIKE TRUNG CẤP
 * CAO ĐẲNG: trinhdothanhoc_bangcap LIKE CAO ĐẲNG
 * ĐẠI HỌC: trinhdothanhoc_bangcap LIKE ĐẠI HỌC
 * TRÊN ĐẠI HỌC: trinhdothanhoc_bangcap LIKE TRÊN ĐẠI HỌC
 * D. CẨM MỸ:
 * diachi_huyen = CẨM MỸ và điều kiện
 * SƠ CẤP: trinhdothanhoc_bangcap LIKE SƠ CẤP
 * TRUNG CẤP: trinhdothanhoc_bangcap LIKE TRUNG CẤP
 * CAO ĐẲNG: trinhdothanhoc_bangcap LIKE CAO ĐẲNG
 * ĐẠI HỌC: trinhdothanhoc_bangcap LIKE ĐẠI HỌC
 * TRÊN ĐẠI HỌC: trinhdothanhoc_bangcap LIKE TRÊN ĐẠI HỌC
 * E. TÂN PHÚ:
 * diachi_huyen = TÂN PHÚ và điều kiện
 * SƠ CẤP: trinhdothanhoc_bangcap LIKE SƠ CẤP
 * TRUNG CẤP: trinhdothanhoc_bangcap LIKE TRUNG CẤP
 * CAO ĐẲNG: trinhdothanhoc_bangcap LIKE CAO ĐẲNG
 * ĐẠI HỌC: trinhdothanhoc_bangcap LIKE ĐẠI HỌC
 * TRÊN ĐẠI HỌC: trinhdothanhoc_bangcap LIKE TRÊN ĐẠI HỌC
 * F. ĐỊNH QUÁN:
 * diachi_huyen = ĐỊNH QUÁN và điều kiện
 * SƠ CẤP: trinhdothanhoc_bangcap LIKE SƠ CẤP
 * TRUNG CẤP: trinhdothanhoc_bangcap LIKE TRUNG CẤP
 * CAO ĐẲNG: trinhdothanhoc_bangcap LIKE CAO ĐẲNG
 * ĐẠI HỌC: trinhdothanhoc_bangcap LIKE ĐẠI HỌC
 * TRÊN ĐẠI HỌC: trinhdothanhoc_bangcap LIKE TRÊN ĐẠI HỌC
 * G. THỐNG NHẤT:
 * diachi_huyen = THỐNG NHẤT và điều kiện
 * SƠ CẤP: trinhdothanhoc_bangcap LIKE SƠ CẤP
 * TRUNG CẤP: trinhdothanhoc_bangcap LIKE TRUNG CẤP
 * CAO ĐẲNG: trinhdothanhoc_bangcap LIKE CAO ĐẲNG
 * ĐẠI HỌC: trinhdothanhoc_bangcap LIKE ĐẠI HỌC
 * TRÊN ĐẠI HỌC: trinhdothanhoc_bangcap LIKE TRÊN ĐẠI HỌC
 * H. TRẢNG BOM:
 * diachi_huyen = TRẢNG BOM và điều kiện
 * SƠ CẤP: trinhdothanhoc_bangcap LIKE SƠ CẤP
 * TRUNG CẤP: trinhdothanhoc_bangcap LIKE TRUNG CẤP
 * CAO ĐẲNG: trinhdothanhoc_bangcap LIKE CAO ĐẲNG
 * ĐẠI HỌC: trinhdothanhoc_bangcap LIKE ĐẠI HỌC
 * TRÊN ĐẠI HỌC: trinhdothanhoc_bangcap LIKE TRÊN ĐẠI HỌC
 * I. VĨNH CỬU:
 * diachi_huyen = NHƠN TRẠCH và điều kiện
 * SƠ CẤP: trinhdothanhoc_bangcap LIKE SƠ CẤP
 * TRUNG CẤP: trinhdothanhoc_bangcap LIKE TRUNG CẤP
 * CAO ĐẲNG: trinhdothanhoc_bangcap LIKE CAO ĐẲNG
 * ĐẠI HỌC: trinhdothanhoc_bangcap LIKE ĐẠI HỌC
 * TRÊN ĐẠI HỌC: trinhdothanhoc_bangcap LIKE TRÊN ĐẠI HỌC
 * J. LONG THÀNH:
 * diachi_huyen = LONG THÀNH và điều kiện
 * SƠ CẤP: trinhdothanhoc_bangcap LIKE SƠ CẤP
 * TRUNG CẤP: trinhdothanhoc_bangcap LIKE TRUNG CẤP
 * CAO ĐẲNG: trinhdothanhoc_bangcap LIKE CAO ĐẲNG
 * ĐẠI HỌC: trinhdothanhoc_bangcap LIKE ĐẠI HỌC
 * TRÊN ĐẠI HỌC: trinhdothanhoc_bangcap LIKE TRÊN ĐẠI HỌC
 *
 * 4. Bảng chucsacnhatuhanhphatgiao
 * A. BIÊN HÒA:
 * tencosohoatdongtongiao_diachi_huyen = BIÊN HÒA và điều kiện
 * SƠ CẤP: trinhdochuyenmonvetongiao_bangcap LIKE SƠ CẤP
 * TRUNG CẤP: trinhdochuyenmonvetongiao_bangcap LIKE TRUNG CẤP
 * CAO ĐẲNG: trinhdochuyenmonvetongiao_bangcap LIKE CAO ĐẲNG
 * ĐẠI HỌC: trinhdochuyenmonvetongiao_bangcap LIKE ĐẠI HỌC
 * TRÊN ĐẠI HỌC: trinhdochuyenmonvetongiao_bangcap LIKE TRÊN ĐẠI HỌC
 * B. LONG KHÁNH:
 * tencosohoatdongtongiao_diachi_huyen = LONG KHÁNH và điều kiện
 * SƠ CẤP: trinhdochuyenmonvetongiao_bangcap LIKE SƠ CẤP
 * TRUNG CẤP: trinhdochuyenmonvetongiao_bangcap LIKE TRUNG CẤP
 * CAO ĐẲNG: trinhdochuyenmonvetongiao_bangcap LIKE CAO ĐẲNG
 * ĐẠI HỌC: trinhdochuyenmonvetongiao_bangcap LIKE ĐẠI HỌC
 * TRÊN ĐẠI HỌC: trinhdochuyenmonvetongiao_bangcap LIKE TRÊN ĐẠI HỌC
 * C. XUÂN LỘC:
 * tencosohoatdongtongiao_diachi_huyen = XUÂN LỘC và điều kiện
 * SƠ CẤP: trinhdochuyenmonvetongiao_bangcap LIKE SƠ CẤP
 * TRUNG CẤP: trinhdochuyenmonvetongiao_bangcap LIKE TRUNG CẤP
 * CAO ĐẲNG: trinhdochuyenmonvetongiao_bangcap LIKE CAO ĐẲNG
 * ĐẠI HỌC: trinhdochuyenmonvetongiao_bangcap LIKE ĐẠI HỌC
 * TRÊN ĐẠI HỌC: trinhdochuyenmonvetongiao_bangcap LIKE TRÊN ĐẠI HỌC
 * D. CẨM MỸ:
 * tencosohoatdongtongiao_diachi_huyen = CẨM MỸ và điều kiện
 * SƠ CẤP: trinhdochuyenmonvetongiao_bangcap LIKE SƠ CẤP
 * TRUNG CẤP: trinhdochuyenmonvetongiao_bangcap LIKE TRUNG CẤP
 * CAO ĐẲNG: trinhdochuyenmonvetongiao_bangcap LIKE CAO ĐẲNG
 * ĐẠI HỌC: trinhdochuyenmonvetongiao_bangcap LIKE ĐẠI HỌC
 * TRÊN ĐẠI HỌC: trinhdochuyenmonvetongiao_bangcap LIKE TRÊN ĐẠI HỌC
 * E. TÂN PHÚ:
 * tencosohoatdongtongiao_diachi_huyen = TÂN PHÚ và điều kiện
 * SƠ CẤP: trinhdochuyenmonvetongiao_bangcap LIKE SƠ CẤP
 * TRUNG CẤP: trinhdochuyenmonvetongiao_bangcap LIKE TRUNG CẤP
 * CAO ĐẲNG: trinhdochuyenmonvetongiao_bangcap LIKE CAO ĐẲNG
 * ĐẠI HỌC: trinhdochuyenmonvetongiao_bangcap LIKE ĐẠI HỌC
 * TRÊN ĐẠI HỌC: trinhdochuyenmonvetongiao_bangcap LIKE TRÊN ĐẠI HỌC
 * F. ĐỊNH QUÁN:
 * tencosohoatdongtongiao_diachi_huyen = ĐỊNH QUÁN và điều kiện
 * SƠ CẤP: trinhdochuyenmonvetongiao_bangcap LIKE SƠ CẤP
 * TRUNG CẤP: trinhdochuyenmonvetongiao_bangcap LIKE TRUNG CẤP
 * CAO ĐẲNG: trinhdochuyenmonvetongiao_bangcap LIKE CAO ĐẲNG
 * ĐẠI HỌC: trinhdochuyenmonvetongiao_bangcap LIKE ĐẠI HỌC
 * TRÊN ĐẠI HỌC: trinhdochuyenmonvetongiao_bangcap LIKE TRÊN ĐẠI HỌC
 * G. THỐNG NHẤT:
 * tencosohoatdongtongiao_diachi_huyen = THỐNG NHẤT và điều kiện
 * SƠ CẤP: trinhdochuyenmonvetongiao_bangcap LIKE SƠ CẤP
 * TRUNG CẤP: trinhdochuyenmonvetongiao_bangcap LIKE TRUNG CẤP
 * CAO ĐẲNG: trinhdochuyenmonvetongiao_bangcap LIKE CAO ĐẲNG
 * ĐẠI HỌC: trinhdochuyenmonvetongiao_bangcap LIKE ĐẠI HỌC
 * TRÊN ĐẠI HỌC: trinhdochuyenmonvetongiao_bangcap LIKE TRÊN ĐẠI HỌC
 * H. TRẢNG BOM:
 * tencosohoatdongtongiao_diachi_huyen = TRẢNG BOM và điều kiện
 * SƠ CẤP: trinhdochuyenmonvetongiao_bangcap LIKE SƠ CẤP
 * TRUNG CẤP: trinhdochuyenmonvetongiao_bangcap LIKE TRUNG CẤP
 * CAO ĐẲNG: trinhdochuyenmonvetongiao_bangcap LIKE CAO ĐẲNG
 * ĐẠI HỌC: trinhdochuyenmonvetongiao_bangcap LIKE ĐẠI HỌC
 * TRÊN ĐẠI HỌC: trinhdochuyenmonvetongiao_bangcap LIKE TRÊN ĐẠI HỌC
 * I. VĨNH CỬU:
 * tencosohoatdongtongiao_diachi_huyen = NHƠN TRẠCH và điều kiện
 * SƠ CẤP: trinhdochuyenmonvetongiao_bangcap LIKE SƠ CẤP
 * TRUNG CẤP: trinhdochuyenmonvetongiao_bangcap LIKE TRUNG CẤP
 * CAO ĐẲNG: trinhdochuyenmonvetongiao_bangcap LIKE CAO ĐẲNG
 * ĐẠI HỌC: trinhdochuyenmonvetongiao_bangcap LIKE ĐẠI HỌC
 * TRÊN ĐẠI HỌC: trinhdochuyenmonvetongiao_bangcap LIKE TRÊN ĐẠI HỌC
 * J. LONG THÀNH:
 * tencosohoatdongtongiao_diachi_huyen = LONG THÀNH và điều kiện
 * SƠ CẤP: trinhdochuyenmonvetongiao_bangcap LIKE SƠ CẤP
 * TRUNG CẤP: trinhdochuyenmonvetongiao_bangcap LIKE TRUNG CẤP
 * CAO ĐẲNG: trinhdochuyenmonvetongiao_bangcap LIKE CAO ĐẲNG
 * ĐẠI HỌC: trinhdochuyenmonvetongiao_bangcap LIKE ĐẠI HỌC
 * TRÊN ĐẠI HỌC: trinhdochuyenmonvetongiao_bangcap LIKE TRÊN ĐẠI HỌC
 *
 * 5. Bảng chucsaccaodai
 * Trả về dữ liệu cố định bằng 0
 *
 * 6. Bảng chucviectinhdocusiphathoivietnam
 * Trả về dữ liệu cố định bằng 0
 *
 * 7. Bảng chucviechoigiao
 * Trả về dữ liệu cố định bằng 0
 *
 * CÔNG GIÁO = 2. Bảng chucsacnhatuhanhconggiaotrieu + 3. Bảng chucsacnhatuhanhcongiaodongtu
 * PHẬT GIÁO = 4. Bảng chucsacnhatuhanhphatgiao
 * TIN LÀNH = 1. Bảng chucsactinlanh
 * CAO ĐÀI = 5. Bảng chucsaccaodai
 * TỊNH ĐỘ CƯ SĨ PHẬT HỘI VIỆT NAM = 6. Bảng chucviectinhdocusiphathoivietnam
 * HỒI GIÁO = 7. Bảng chucviechoigiao
 */
