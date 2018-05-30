<?php

class CosotongiaoComponent extends Component
{
    public function __construct()
    {
        App::uses('ProvinceComponent', 'Controller/Component');
        $this->Province = new ProvinceComponent(new ComponentCollection());

        App::uses('UtilityComponent', 'Controller/Component');
        $this->Utility = new UtilityComponent(new ComponentCollection());
    }

    public function export($filter = [])
    {
        $filter_group = $filter['ton_giao'];
        $filter_location = $filter['prefecture'];

        $sum = [
            'Dongtuconggiao',
            'Tuvienphatgiao',
        ];

        $list = [
            CONG_GIAO => 'Dongtuconggiao',
            PHAT_GIAO => 'Tuvienphatgiao',
            CAO_DAI => 'Hodaocaodai',
            TINH_DO_CU_SI => 'Chihoitinhdocusiphatgiaovietnam',
            HOI_GIAO => 'Cosohoigiaoislam',
            HOA_HAO => 'Chucviecphathoahao',
            TIN_NGUONG => 'Cosotinnguong',
        ];

        $filter_group = $filter['ton_giao'];
        $filter_location = $filter['prefecture'];

        $province = $this->Province->getProvince($filter_location);

        $index = 1;
        foreach ($province as $code => $name) {
            $export[$code] = [
                'index' => $index++,
                'location' => $name,
                'total' => 0
            ];
        }

        foreach ($list as $field_index => $model) {
            if (!empty($filter_group) && !in_array($field_index, $filter_group)) {
                continue;
            }
            $func = 'cal_' . strtolower($model);
            $tmp = $this->$func($model);

            foreach ($province as $provice_code => $name) {
                $data = $tmp[$provice_code];
                if (in_array($model, $sum)) {
                    $total = $data['tong'];
                } else {
                    $total = array_sum($data);
                }
                $export[$provice_code]['total'] += $total;

                foreach ($data as $field => $value) {
                    $export[$provice_code][$model . '_' . $field] = $value;
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

    private function cal_dongtuconggiao($model)
    {
        $result = [];
        $province = $this->Province->getProvince();
        foreach ($province as $provice_code => $name) {
            $result[$provice_code] = [
                'tong' => 0,
                'nha_tho' => 0,
                'thap_chuong' => 0,
                'nha_xu' => 0,
                'nha_giao_ly' => 0,
                'nha_sinh_hoat' => 0,
                'den_dai_tuong' => 0,
                'khac' => 0,
            ];
        }

        return $result;
    }

    private function cal_tuvienphatgiao($model)
    {
        $result = [];
        $province = $this->Province->getProvince();
        foreach ($province as $provice_code => $name) {
            $result[$provice_code] = [
                'tong' => 0,
                'chua' => 0,
                'tinh-xa' => 0,
                'tinh-that' => 0,
                'thien-vien' => 0,
                'tu-vien' => 0,
                'niem-phat-duong' => 0,
            ];
        }
        $option = $this->calculateMapping($model);

        extract($option);

        $data = $this->getData($model, $data_field);

        $province_field = $this->getLocationFieldName($model);
        foreach ($data as $id => $item) {
            $provice_code = $this->Province->retrieveProvinceCode($item[$province_field]);
            if (!$provice_code) {
                continue;
            }

            $keyword = $this->Utility->slug($item['tentuvien']);

            foreach ($result[$provice_code] as $key => &$count) {
                if (strpos($keyword, $key) !== false) {
                    $count++;
                    break;
                }
            }
        }

        foreach ($result as $key => &$item) {
            $item['tong'] = array_sum($item);
        }

        return $result;
    }

    private function cal_hodaocaodai($model)
    {
        $result = [];
        $province = $this->Province->getProvince();
        foreach ($province as $provice_code => $name) {
            $result[$provice_code] = [
                'thanh-that' => 0,
                'dien-tho-phat-mau' => 0,
            ];
        }

        $option = $this->calculateMapping($model);

        extract($option);

        $data = $this->getData($model, $data_field);

        $province_field = $this->getLocationFieldName($model);
        foreach ($data as $id => $item) {
            $provice_code = $this->Province->retrieveProvinceCode($item[$province_field]);
            if (!$provice_code) {
                continue;
            }

            $keyword = $this->Utility->slug($item['tenhodao']);

            foreach ($result[$provice_code] as $key => &$count) {
                if (strpos($keyword, $key) !== false) {
                    $count++;
                    break;
                }
            }
        }

        return $result;
    }

    private function cal_chihoitinhdocusiphatgiaovietnam($model)
    {
        $result = [];
        $province = $this->Province->getProvince();
        foreach ($province as $provice_code => $name) {
            $result[$provice_code] = [
                'chi-hoi' => 0,
            ];
        }

        $option = $this->calculateMapping($model);

        extract($option);

        $data = $this->getData($model, $data_field);

        $province_field = $this->getLocationFieldName($model);
        foreach ($data as $id => $item) {
            $provice_code = $this->Province->retrieveProvinceCode($item[$province_field]);
            if (!$provice_code) {
                continue;
            }

            $keyword = $this->Utility->slug($item['tenchihoi']);

            foreach ($result[$provice_code] as $key => &$count) {
                if (strpos($keyword, $key) !== false) {
                    $count++;
                    break;
                }
            }
        }

        return $result;
    }

    private function cal_cosohoigiaoislam($model)
    {
        $result = [];
        $province = $this->Province->getProvince();
        foreach ($province as $provice_code => $name) {
            $result[$provice_code] = [
                'tieu-thanh-duong' => 0,
                'thanh-duong' => 0,
            ];
        }

        $option = $this->calculateMapping($model);

        extract($option);

        $data = $this->getData($model, $data_field);

        $province_field = $this->getLocationFieldName($model);
        foreach ($data as $id => $item) {
            $provice_code = $this->Province->retrieveProvinceCode($item[$province_field]);
            if (!$provice_code) {
                continue;
            }

            $keyword = $this->Utility->slug($item['tenthanhduong']);

            foreach ($result[$provice_code] as $key => &$count) {
                if (strpos($keyword, $key) !== false) {
                    $count++;
                    break;
                }
            }
        }

        $final = [];
        foreach ($result as $key => $item) {
            $final[$key] = [
                'thanh-duong' => $item['thanh-duong'],
                'tieu-thanh-duong' => $item['tieu-thanh-duong'],
            ];
        }

        return $final;
    }

    private function cal_chucviecphathoahao($model)
    {
        $result = [];
        $province = $this->Province->getProvince();
        foreach ($province as $provice_code => $name) {
            $result[$provice_code] = [
                'ban-dai-dien' => 0,
                'ban-tri-su' => 0,
            ];
        }

        $option = $this->calculateMapping($model);

        extract($option);

        $data = $this->getData($model, $data_field);

        $province_field = $this->getLocationFieldName($model);
        foreach ($data as $id => $item) {
            $provice_code = $this->Province->retrieveProvinceCode($item[$province_field]);
            if (!$provice_code) {
                continue;
            }

            $keyword = $this->Utility->slug($item['hoatdongtongiaotai']);

            foreach ($result[$provice_code] as $key => &$count) {
                if (strpos($keyword, $key) !== false) {
                    $count++;
                    break;
                }
            }
        }

        return $result;
    }

    private function cal_cosotinnguong($model)
    {
        $result = [];
        $province = $this->Province->getProvince();
        foreach ($province as $provice_code => $name) {
            $result[$provice_code] = [
                'dinh' => 0,
                'den' => 0,
                'am' => 0,
                'mieu' => 0,
                'khac' => 0,
            ];
        }

        $option = $this->calculateMapping($model);

        extract($option);

        $data = $this->getData($model, $data_field);

        $province_field = $this->getLocationFieldName($model);
        foreach ($data as $id => $item) {
            $provice_code = $this->Province->retrieveProvinceCode($item[$province_field]);
            if (!$provice_code) {
                continue;
            }

            $keyword = $this->Utility->slug($item['tencoso']);

            $result[$provice_code]['khac'] += 1;
            foreach ($result[$provice_code] as $key => &$count) {
                if (strpos($keyword, $key) !== false) {
                    $count++;
                    $result[$provice_code]['khac'] -= 1;
                    break;
                }
            }
        }

        return $result;
    }

    public function getData($model, $data_field)
    {
        $obj = ClassRegistry::init($model);
        $conditions = [
            'is_add' => 1,
        ];
        $data = $obj->find('all', array(
            'fields' => $data_field,
            'conditions' => $conditions,
        ));

        return Hash::combine($data, '{n}.' . $model . '.id', '{n}.' . $model);
    }

    private function calculateMapping($model)
    {
        $model = mb_strtolower($model);
        $data_field = [];
        switch ($model) {
            case 'tuvienphatgiao':
                $data_field = [
                    'id',
                    'tentuvien',
                ];
                break;
            case 'hodaocaodai':
                $data_field = [
                    'id',
                    'tenhodao',
                ];
                break;
            case 'chihoitinhdocusiphatgiaovietnam':
                $data_field = [
                    'id',
                    'tenchihoi',
                ];
                break;
            case 'cosohoigiaoislam':
                $data_field = [
                    'id',
                    'tenthanhduong',
                ];
                break;
            case 'chucviecphathoahao':
                $data_field = [
                    'id',
                    'hoatdongtongiaotai',
                ];
                break;
            case 'cosotinnguong':
                $data_field = [
                    'id',
                    'tencoso',
                ];
                break;

        }

        array_push($data_field, $this->getLocationFieldName($model));

        return compact('data_field');
    }

    private function getLocationFieldName($model = '')
    {
        $model = mb_strtolower($model);
        $location = [
            'chihoitinlanh' => 'diachi_huyen',
            'dongtuconggiao' => 'diachi_huyen',
            'cosotinnguong' => 'diachi_huyen',
            'hodaocaodai' => 'tenhodao_diachi_huyen',
            'chihoitinhdocusiphatgiaovietnam' => 'tenchihoi_diachi_huyen',
            'tuvienphatgiao' => 'diachi_huyen',
            'cosohoigiaoislam' => 'tenthanhduong_diachi_huyen',
            'chucviecphathoahao' => 'hoatdongtongiaotai_diachi_huyen',
        ];

        return $location[$model];
    }

    /*
        CÔNG GIÁO
            D4 TỔNG
            E5 NHÀ THỜ
            F6 THÁP CHUÔNG
            G7 NHÀ XỨ
            H8 NHÀ GIÁO LÝ
            I9 NHÀ SINH HOẠT
            J10 ĐẾN, ĐÀI, TƯỢNG
            K11 KHÁC
        PHẬT GIÁO
            L12 TỔNG
                Tổng của (M13, P16, Q17, R18)
            M13 CHÙA
                Đếm trong bảng tuvienphatgiao lọc theo
                    tentuvien like CHÙA
                    diachi_huyen
            P16 TỊNH THẤT
                Đếm trong bảng tuvienphatgiao lọc theo
                    tentuvien like TỊNH THẤT
                    diachi_huyen
            Q17 TU VIỆN
                Đếm trong bảng tuvienphatgiao lọc theo
                    tentuvien like TU VIỆN
                    diachi_huyen
            R18 NIỆM PHẬT ĐƯỜNG
                Đếm trong bảng tuvienphatgiao lọc theo
                    tentuvien like NIỆM PHẬT ĐƯỜNG
                    diachi_huyen
        CAO ĐÀI
            S19 THÁNH THẤT
                Đếm trong bảng hodaocaodai lọc theo
                    tenhodao like THÁNH THẤT
                    tenhodao_diachi_huyen
            T20 ĐIỆN THỜ PHẬT MẪU
                Đếm trong bảng hodaocaodai lọc theo
                    tenhodao like ĐIỆN THỜ PHẬT MẪU
                    tenhodao_diachi_huyen
        TỊNH ĐỘ CƯ SĨ VIỆT NAM
            U21 CHI HỘI
                Đếm trong bảng chihoitinhdocusiphatgiaovietnam lọc theo
                    tenchihoi like ĐIỆN THỜ PHẬT MẪU
                    tenchihoi_diachi_huyen
        HỒI GIÁO
            V22 THÁNH ĐƯỜNG
                Đếm trong bảng cosohoigiaoislam lọc theo
                    tenthanhduong like THÁNH ĐƯỜNG
                    tenthanhduong_diachi_huyen
            W23 TIỂU THÁNH ĐƯỜNG
                Đếm trong bảng cosohoigiaoislam lọc theo
                    tenthanhduong like TIỂU THÁNH ĐƯỜNG
                    tenthanhduong_diachi_huyen
        PHẬT GIÁO HÒA HẢO
            X24 VP. BAN ĐẠI DIỆN
                Đếm trong bảng chucviecphathoahao lọc theo
                    hoatdongtongiaotai like VP. BAN ĐẠI DIỆN
                    hoatdongtongiaotai_diachi_huyen
            Y25 BAN TRỊ SỰ
                Đếm trong bảng chucviecphathoahao lọc theo
                    hoatdongtongiaotai like BAN TRỊ SỰ
                    hoatdongtongiaotai_diachi_huyen
        TÍN NGƯỠNG
            E26 ĐÌNH
                Đếm trong bảng cosotinnguong lọc theo
                    tencoso like ĐÌNH
                    diachi_huyen
            AA27 ĐỀN
                Đếm trong bảng cosotinnguong lọc theo
                    tencoso like ĐỀN
                    diachi_huyen
            AB28 AM
                Đếm trong bảng cosotinnguong lọc theo
                    tencoso like AM
                    diachi_huyen
            AC29 MIẾU
                Đếm trong bảng cosotinnguong lọc theo
                    tencoso like MIẾU
                    diachi_huyen
            AD30 KHÁC
                Đếm trong bảng cosotinnguong lọc theo
                    Ngoài nhữ thằng (E26, AA27, AB28, AC29, AD30)
                    diachi_huyen
     */
}
