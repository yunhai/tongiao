<?php

class ExportThDtCsComponent extends Component
{
    public function __construct()
    {
        App::uses('ProvinceComponent', 'Controller/Component');
        $this->Province = new ProvinceComponent(new ComponentCollection());
    }

    public function export($filter = [])
    {
        $groups = [
            CONG_GIAO => [
                'Chucsacnhatuhanhconggiaotrieu',
                'Chucsacnhatuhanhcongiaodongtu'
            ],
            PHAT_GIAO => ['Chucsacnhatuhanhphatgiao'],
            CAO_DAI => ['Chucsactinlanh'],
            TINH_DO_CU_SI => ['Chucsaccaodai'],
            HOI_GIAO => ['Chucviechoigiao'],
            HOA_HAO => ['Chucviectinhdocusiphathoivietnam'],
            TIN_NGUONG => ['Nguoihoatdongtinnguongchuyennghiep']
        ];

        $map_name = array(
            CONG_GIAO => 'cong_giao',
            PHAT_GIAO => 'phat_giao',
            CAO_DAI => 'cao_dai',
            TINH_DO_CU_SI => 'tinh_do_cu_si',
            HOI_GIAO => 'hoi_giao',
            HOA_HAO => 'hoa_hao',
            TIN_NGUONG => 'tin_nguong',
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
                foreach ($partial as $key => $val) {
                    $export[$provice_code]['total_' . $key] += $val;
                }
                foreach ($partial as $field => $value) {
                    $fn = $map_name[$field_index];
                    $export[$provice_code][$fn . '_' . $field] = $value;
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

    private function __calculate($list = [])
    {
        $tmp = [];
        foreach ($list as $model) {
            $func = '__getDataRange';
            array_push($tmp, $this->$func($model));
        }

        $final = [];
        foreach ($tmp as $element) {
            foreach ($element as $province => $statis) {
                foreach ($statis as $range => $count) {
                    if (!isset($final[$province][$range])) {
                        $final[$province][$range] = 0;
                    }

                    $final[$province][$range] += $count;
                }
            }
        }

        return $final;
    }

    private function init($province)
    {
        $index = 1;
        $export = [];

        foreach ($province as $code => $name) {
            $export[$code] = [
                'index' => $index++,
                'province' => $name,
                'total_u20' => 0,
                'total_u40' => 0,
                'total_u60' => 0,
                'total_u90' => 0,
            ];
        }

        return $export;
    }

    private function __getDataRange($model)
    {
        $fields = [
            'id',
            'noiohiennay_huyen'
        ];
        $conditions = [
            'noiohiennay_huyen <>' => '',
            'noiohiennay_huyen is not null',
            'ngaythangnamsinh <>' => '',
            'ngaythangnamsinh is not null',
        ];
        $column = [
            'ngaythangnamsinh'
        ];
        $province_field = 'noiohiennay_huyen';

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
            $result[$provice_code] = array(
                'u20' => 0,
                'u40' => 0,
                'u60' => 0,
                'u90' => 0,
            );
        }

        foreach ($data as $id => $item) {
            $provice_code = $this->Province->retrieveProvinceCode($item[$province_field]);
            if (!$provice_code) {
                continue;
            }
            $ageRange = $this->__calculateAgeRange($item['ngaythangnamsinh']);

            if (isset($result[$provice_code][$ageRange])) {
                $result[$provice_code][$ageRange]++;
            }
        }

        return $result;
    }

    private function __calculateAgeRange($dob)
    {
        if ($dob) {
            $tmp = explode('/', $dob);
            $year = end($tmp);
            $age = date('Y') - $year;
            if ($age < 21) {
                return 'u20';
            }
            if ($age < 41) {
                return 'u40';
            }
            if ($age < 62) {
                return 'u60';
            }
            return 'u90';
        }

        return 0;
    }
}

/**
 * DO TUOI CUA CHAC SAC
 * BẢNG TỔNG HỢP LỨA TUỔI CỦA CHỨC SẮC CÁC TÔN GIÁO, TÍN NGƯỠNG TRÊN ĐỊA BÀN TỈNH
 *
 * I. CÔNG GIÁO
 * 1. Bảng chucsacnhatuhanhconggiaotrieu + chucsacnhatuhanhcongiaodongtu
 * Tương ứng với từng huyện: BIÊN HÒA/LONG KHÁNH/XUÂN LỘC/CẨM MỸ/TÂN PHÚ/ĐỊNH QUÁN/THỐNG NHẤT/TRẢNG BOM/VĨNH CỬU/NHƠN TRẠCH/LONG THÀNH
 * noiohiennay_huyen = Tương ứng với từng huyện ở trên và điều kiện
 * Dưới 20
 * 21 đến 40
 * 41 đến 61
 * Trên 61
 * => Lấy năm hiện tại trừ đi cho dữ liệu trong cột ngaythangnamsinh để biết được nằm ở mốc tuổi nào
 *
 * II. PHẬT GIÁO
 * 2. Bảng chucsacnhatuhanhphatgiao
 * Tương ứng với từng huyện: BIÊN HÒA/LONG KHÁNH/XUÂN LỘC/CẨM MỸ/TÂN PHÚ/ĐỊNH QUÁN/THỐNG NHẤT/TRẢNG BOM/VĨNH CỬU/NHƠN TRẠCH/LONG THÀNH
 * noiohiennay_huyen = Tương ứng với từng huyện ở trên và điều kiện
 * Dưới 20
 * 21 đến 40
 * 41 đến 61
 * Trên 61
 * => Lấy năm hiện tại trừ đi cho dữ liệu trong cột ngaythangnamsinh để biết được nằm ở mốc tuổi nào
 *
 * III. TIN LÀNH
 * 3. Bảng chucsactinlanh
 * Tương ứng với từng huyện: BIÊN HÒA/LONG KHÁNH/XUÂN LỘC/CẨM MỸ/TÂN PHÚ/ĐỊNH QUÁN/THỐNG NHẤT/TRẢNG BOM/VĨNH CỬU/NHƠN TRẠCH/LONG THÀNH
 * noiohiennay_huyen = Tương ứng với từng huyện ở trên và điều kiện
 * Dưới 20
 * 21 đến 40
 * 41 đến 61
 * Trên 61
 * => Lấy năm hiện tại trừ đi cho dữ liệu trong cột ngaythangnamsinh để biết được nằm ở mốc tuổi nào
 *
 * IV. CAO ĐÀI
 * 4. Bảng chucsaccaodai
 * Tương ứng với từng huyện: BIÊN HÒA/LONG KHÁNH/XUÂN LỘC/CẨM MỸ/TÂN PHÚ/ĐỊNH QUÁN/THỐNG NHẤT/TRẢNG BOM/VĨNH CỬU/NHƠN TRẠCH/LONG THÀNH
 * noiohiennay_huyen = Tương ứng với từng huyện ở trên và điều kiện
 * Dưới 20
 * 21 đến 40
 * 41 đến 61
 * Trên 61
 * => Lấy năm hiện tại trừ đi cho dữ liệu trong cột ngaythangnamsinh để biết được nằm ở mốc tuổi nào
 *
 * V. HỒI GIÁO
 * 5. Bảng chucviechoigiao
 * Tương ứng với từng huyện: BIÊN HÒA/LONG KHÁNH/XUÂN LỘC/CẨM MỸ/TÂN PHÚ/ĐỊNH QUÁN/THỐNG NHẤT/TRẢNG BOM/VĨNH CỬU/NHƠN TRẠCH/LONG THÀNH
 * noiohiennay_huyen = Tương ứng với từng huyện ở trên và điều kiện
 * Dưới 20
 * 21 đến 40
 * 41 đến 61
 * Trên 61
 * => Lấy năm hiện tại trừ đi cho dữ liệu trong cột ngaythangnamsinh để biết được nằm ở mốc tuổi nào
 *
 * VI. TĐCSPHVN
 * 6. Bảng chucviectinhdocusiphathoivietnam
 * Tương ứng với từng huyện: BIÊN HÒA/LONG KHÁNH/XUÂN LỘC/CẨM MỸ/TÂN PHÚ/ĐỊNH QUÁN/THỐNG NHẤT/TRẢNG BOM/VĨNH CỬU/NHƠN TRẠCH/LONG THÀNH
 * noiohiennay_huyen = Tương ứng với từng huyện ở trên và điều kiện
 * Dưới 20
 * 21 đến 40
 * 41 đến 61
 * Trên 61
 * => Lấy năm hiện tại trừ đi cho dữ liệu trong cột ngaythangnamsinh để biết được nằm ở mốc tuổi nào
 *
 * VII. TÍN NGƯỠNG
 * 7. Bảng nguoihoatdongtinnguongchuyennghiep
 * Tương ứng với từng huyện: BIÊN HÒA/LONG KHÁNH/XUÂN LỘC/CẨM MỸ/TÂN PHÚ/ĐỊNH QUÁN/THỐNG NHẤT/TRẢNG BOM/VĨNH CỬU/NHƠN TRẠCH/LONG THÀNH
 * noiohiennay_huyen = Tương ứng với từng huyện ở trên và điều kiện
 * Dưới 20
 * 21 đến 40
 * 41 đến 61
 * Trên 61
 * => Lấy năm hiện tại trừ đi cho dữ liệu trong cột ngaythangnamsinh để biết được nằm ở mốc tuổi nào
 *
 * cột ngaythangnamsinh có thể lưu dữ liệu kiểu ngày/tháng/năm hoặc tháng/năm hoặc năm, nên tìm cách tính theo định dạnh trên
 *
 */
