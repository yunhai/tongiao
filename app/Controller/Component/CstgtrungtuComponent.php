<?php

class CstgtrungtuComponent extends Component
{
    public function __construct()
    {
        App::uses('ProvinceComponent', 'Controller/Component');
        $this->Province = new ProvinceComponent(new ComponentCollection());

        App::uses('UtilityComponent', 'Controller/Component');
        $this->Utility = new UtilityComponent(new ComponentCollection());
    }

    public function export()
    {
        $list = [
            'Dongtuconggiao',
            'Tuvienphatgiao',
            'Chihoitinlanh',
            'Hodaocaodai',
            'Chihoitinhdocusiphatgiaovietnam',
            'Phatgiaohoahao', // chua lam
            'Cosohoigiaoislam',
            'Cosotinnguong',
        ];

        $province = $this->Province->getProvince();

        $index = 1;
        foreach ($province as $code => $name) {
            $export[$code] = [
                $index++,
                $name,
                0,
                0
            ];
        }

        foreach ($list as $model) {
            $func = 'cal_' . strtolower($model);
            $tmp = $this->$func($model);

            foreach ($province as $provice_code => $name) {
                $data = $tmp[$provice_code];
                $export[$provice_code][2] += $data['so_lan'];
                $export[$provice_code][3] += $data['so_tien'];

                $export[$provice_code] = array_merge($export[$provice_code], array_values($data));
            }
        }

        return $export;
    }

    private function cal_dongtuconggiao($model)
    {
        $result = [];
        $province = $this->Province->getProvince();
        foreach ($province as $provice_code => $name) {
            $result[$provice_code] = [
                'so_lan' => 0,
                'so_tien' => 0,
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

            $result[$provice_code]['so_lan'] += $this->convertToNumber($item['ttttcs_solan']);
            $result[$provice_code]['so_tien'] += $this->convertToNumber($item['ttttcs_tongkinhphi']);
        }

        return $result;
    }

    private function cal_tuvienphatgiao($model)
    {
        $result = [];
        $province = $this->Province->getProvince();
        foreach ($province as $provice_code => $name) {
            $result[$provice_code] = [
                'so_lan' => 0,
                'so_tien' => 0,
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

            $result[$provice_code]['so_lan'] += $this->convertToNumber($item['ttttcs_solan']);
            $result[$provice_code]['so_tien'] += $this->convertToNumber($item['ttttcs_tongkinhphi']);
        }

        return $result;
    }

    private function cal_chihoitinlanh($model)
    {
        $result = [];
        $province = $this->Province->getProvince();
        foreach ($province as $provice_code => $name) {
            $result[$provice_code] = [
                'so_lan' => 0,
                'so_tien' => 0,
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

            $result[$provice_code]['so_lan'] += $this->convertToNumber($item['ttttcs_solan']);
            $result[$provice_code]['so_tien'] += $this->convertToNumber($item['ttttcs_tongkinhphi']);
        }

        return $result;
    }

    private function cal_hodaocaodai($model)
    {
        $result = [];
        $province = $this->Province->getProvince();
        foreach ($province as $provice_code => $name) {
            $result[$provice_code] = [
                'so_lan' => 0,
                'so_tien' => 0,
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

            $result[$provice_code]['so_lan'] += $this->convertToNumber($item['ttttcs_solan']);
            $result[$provice_code]['so_tien'] += $this->convertToNumber($item['ttttcs_tongkinhphi']);
        }

        return $result;
    }

    private function cal_chihoitinhdocusiphatgiaovietnam($model)
    {
        $result = [];
        $province = $this->Province->getProvince();
        foreach ($province as $provice_code => $name) {
            $result[$provice_code] = [
                'so_lan' => 0,
                'so_tien' => 0,
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

            $result[$provice_code]['so_lan'] += $this->convertToNumber($item['ttttcs_solan']);
            $result[$provice_code]['so_tien'] += $this->convertToNumber($item['ttttcs_tongkinhphi']);
        }

        return $result;
    }

    private function cal_phatgiaohoahao($model)
    {
        $result = [];
        $province = $this->Province->getProvince();
        foreach ($province as $provice_code => $name) {
            $result[$provice_code] = [
                'so_lan' => 0,
                'so_tien' => 0,
            ];
        }

        return $result;
    }

    private function cal_cosohoigiaoislam($model)
    {
        $result = [];
        $province = $this->Province->getProvince();
        foreach ($province as $provice_code => $name) {
            $result[$provice_code] = [
                'so_lan' => 0,
                'so_tien' => 0,
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

            $result[$provice_code]['so_lan'] += $this->convertToNumber($item['ttttcs_solan']);
            $result[$provice_code]['so_tien'] += $this->convertToNumber($item['ttttcs_tongkinhphi']);
        }

        return $result;
    }

    private function cal_cosotinnguong($model)
    {
        $result = [];
        $province = $this->Province->getProvince();
        foreach ($province as $provice_code => $name) {
            $result[$provice_code] = [
                'so_lan' => 0,
                'so_tien' => 0,
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

            $result[$provice_code]['so_lan'] += $this->convertToNumber($item['ttttcs_solan']);
            $result[$provice_code]['so_tien'] += $this->convertToNumber($item['ttttcs_tongkinhphi']);
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

    private function convertToNumber($string)
    {
        return (int) ($this->Utility->retrieveNumberFromString($string));
    }

    private function calculateMapping($model)
    {
        $model = mb_strtolower($model);
        $data_field = [];
        switch ($model) {
            case 'dongtuconggiao':
            case 'tuvienphatgiao':
            case 'chihoitinlanh':
            case 'hodaocaodai':
            case 'chihoitinhdocusiphatgiaovietnam':
            case 'cosohoigiaoislam':
            case 'cosotinnguong':
                $data_field = [
                    'id',
                    'ttttcs_solan',
                    'ttttcs_tongkinhphi'
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
