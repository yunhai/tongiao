<?php

class TongiaocosoComponent extends Component
{
    public function __construct()
    {
        App::uses('ProvinceComponent', 'Controller/Component');
        $this->Province = new ProvinceComponent(new ComponentCollection());

        App::uses('UtilityComponent', 'Controller/Component');
        $this->Utility = new UtilityComponent(new ComponentCollection());
    }

    public function export($filter)
    {
        $filter_group = $filter['ton_giao'];
        $filter_location = $filter['prefecture'];

        $list = [
            CONG_GIAO => 'Conggiao',
            PHAT_GIAO => 'Tuvienphatgiao',
            CAO_DAI => 'Hodaocaodai',
            TINH_DO_CU_SI => 'Chihoitinhdocusiphatgiaovietnam',
            HOI_GIAO => 'Cosohoigiaoislam',
            HOA_HAO => 'Phatgiaohoahao'
        ];

        $single = [
            'Hodaocaodai',
            'Chihoitinhdocusiphatgiaovietnam',
            'Cosohoigiaoislam',
            'Phatgiaohoahao'
        ];

        $province = $this->Province->getProvince($filter_location);

        $index = 1;
        foreach ($province as $code => $name) {
            $export[$code] = [
                'index' => $index++,
                'location' => $name,
                'total' => 0,
            ];
        }

        foreach ($list as $field_index => $model) {
            if (!empty($filter_group) && !in_array($field_index, $filter_group)) {
                continue;
            }
            $func = 'cal_' . strtolower($model);
            $tmp = $this->$func($model);

            foreach ($province as $provice_code => $name) {
                $partial = ($tmp[$provice_code]);

                if (in_array($model, $single)) {
                    $export[$provice_code]['total'] += array_sum($partial);
                } else {
                    $export[$provice_code]['total'] += $tmp[$provice_code]['total'];
                }

                foreach ($partial as $field => $value) {
                    $export[$provice_code][$model . '__' . $field] = $value;
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

    private function cal_conggiao()
    {
        $giaoxu = $this->cal_conggiao_giaoxu('Giaoxu');

        $result = [];
        $province = $this->Province->getProvince();
        foreach ($province as $provice_code => $name) {
            $result[$provice_code] = [
                'total' => 0,
                'giao-xu' => isset($giaoxu[$provice_code]) ? $giaoxu[$provice_code] : 0,
                'dong-tu' => 0,
                'cong-doan' => 0,
                'tu-vien' => 0,
                'dan-vien' => 0,
            ];
        }

        $model = 'Dongtuconggiao';
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
            $item['total'] = array_sum($item);
        }

        return $result;
    }

    private function cal_conggiao_giaoxu($model = 'Giaoxu')
    {
        $result = [];

        $province = $this->Province->getProvince();
        foreach ($province as $provice_code => $name) {
            $result[$provice_code] = 0;
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

            $result[$provice_code] = $result[$provice_code] + 1;
        }

        return $result;
    }

    private function cal_tuvienphatgiao($model)
    {
        $result = [];
        $province = $this->Province->getProvince();
        foreach ($province as $provice_code => $name) {
            $result[$provice_code] = [
                'total' => 0,
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
            $item['total'] = array_sum($item);
        }

        return $result;
    }

    private function cal_hodaocaodai($model)
    {
        $result = [];
        $province = $this->Province->getProvince();
        foreach ($province as $provice_code => $name) {
            $result[$provice_code] = 0;
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

            $result[$provice_code] = $result[$provice_code] + 1;
        }

        foreach ($result as $key => &$val) {
            $val = [
                'ho-dao' => $val
            ];
        }

        return $result;
    }

    private function cal_chihoitinhdocusiphatgiaovietnam($model)
    {
        $result = [];
        $province = $this->Province->getProvince();
        foreach ($province as $provice_code => $name) {
            $result[$provice_code] = 0;
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

            $result[$provice_code] = $result[$provice_code] + 1;
        }

        foreach ($result as $key => &$val) {
            $val = [
                'chi-hoi' => $val
            ];
        }

        return $result;
    }

    private function cal_cosohoigiaoislam($model)
    {
        $result = [];
        $province = $this->Province->getProvince();
        foreach ($province as $provice_code => $name) {
            $result[$provice_code] = 0;
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

            $result[$provice_code] = $result[$provice_code] + 1;
        }

        foreach ($result as $key => &$val) {
            $val = [
                'thanh-duong' => $val
            ];
        }

        return $result;
    }

    private function cal_phatgiaohoahao($model)
    {
        $result = [];
        $province = $this->Province->getProvince();
        foreach ($province as $provice_code => $name) {
            $result[$provice_code] = 0;
        }

        foreach ($result as $key => &$val) {
            $val = [
                'ban-tri-su' => $val
            ];
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
            case 'hodaocaodai':
            case 'cosohoigiaoislam':
            case 'phatgiaohoahao':
            case 'chihoitinhdocusiphatgiaovietnam':
            case 'giaoxu':
                $data_field = [
                    'id',
                ];
                break;
            case 'tuvienphatgiao':
            case 'dongtuconggiao':
                $data_field = [
                    'id',
                    'tentuvien'
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
            'giaoxu' => 'diachi_huyen',
            'dongtuconggiao' => 'diachi_huyen',
            'cosotinnguong' => 'diachi_huyen',
            'hodaocaodai' => 'tenhodao_diachi_huyen',
            'chihoitinhdocusiphatgiaovietnam' => 'tenchihoi_diachi_huyen',
            'tuvienphatgiao' => 'diachi_huyen',
            'cosohoigiaoislam' => 'tenthanhduong_diachi_huyen'
        ];

        return $location[$model];
    }

    /**
     * 1.   CÔNG GIÁO
     *      E5 GIÁO XỨ
     *          Đếm trong bảng giaoxu lọc theo diachi_huyen
     *      F6 DÒNG TU
     *          Đếm trong bảng dongtuconggiao lọc theo
     *              tentuvien like DÒNG TU
     *              diachi_huyen
     *      G7 CỘNG ĐOÀN
     *          Đếm trong bảng dongtuconggiao lọc theo
     *              tentuvien like CỘNG ĐOÀN
     *              diachi_huyen
     *      H8 TU VIỆN
     *          Đếm trong bảng dongtuconggiao lọc theo
     *              tentuvien like TU VIỆN
     *              diachi_huyen
     *      I9 ĐAN VIỆN
     *          Đếm trong bảng dongtuconggiao lọc theo
     *              tentuvien like ĐAN VIỆN
     *              diachi_huyen
     * 2.   PHẬT GIÁO
     *      K11 CHÙA
     *          Đếm trong bảng tuvienphatgiao lọc theo
     *              tentuvien like CHÙA
     *              diachi_huyen
     *      L12 TỊNH XÁ
     *          Đếm trong bảng tuvienphatgiao lọc theo
     *              tentuvien like TỊNH XÁ
     *              diachi_huyen
     *      M13 TỊNH THẤT
     *          Đếm trong bảng tuvienphatgiao lọc theo
     *              tentuvien like TỊNH THẤT
     *              diachi_huyen
     *      N14 THIỀN VIỆN
     *          Đếm trong bảng tuvienphatgiao lọc theo
     *              tentuvien like THIỀN VIỆN
     *              diachi_huyen
     *      O15 TU VIỆN
     *          Đếm trong bảng tuvienphatgiao lọc theo
     *              tentuvien like TU VIỆN
     *              diachi_huyen
     *      P16 NIỆM PHẬT ĐƯỜNG
     *          Đếm trong bảng tuvienphatgiao lọc theo
     *              tentuvien like NIỆM PHẬT ĐƯỜNG
     *              diachi_huyen
     * 3.   CAO ĐÀI
     *      Q17 HỌ ĐẠO
     *          Đếm trong bảng hodaocaodai lọc theo
     *              tenhodao_diachi_huyen
     * 4.   TỊNH ĐỘ CƯ SĨ VIỆT NAM
     *      R18 CHIHỘI
     *          Đếm trong bảng chihoitinhdocusiphatgiaovietnam lọc theo
     *              tenchihoi_diachi_huyen
     * 5.   HỒI GIÁO
     *      S19 THÁNH ĐƯỜNG
     *          Đếm trong bảng cosohoigiaoislam lọc theo
     *              tenthanhduong_diachi_huyen
     * 6.   PHẬT GIÁO HÒA HẢO
     *      T20 BAN TRỊ SỰ
     *          CHỜ CONFIRM
     */
}
