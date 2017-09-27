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

    public function export()
    {
        $list = [
            'Conggiao',
            'Tuvienphatgiao',
            'Hodaocaodai',
            'Chihoitinhdocusiphatgiaovietnam',
            'Cosohoigiaoislam',
            'Phatgiaohoahoa'
        ];

        $single = [
            'Hodaocaodai',
            'Chihoitinhdocusiphatgiaovietnam',
            'Cosohoigiaoislam',
            'Phatgiaohoahoa'
        ];

        $province = $this->Province->getProvince();

        $index = 1;
        foreach ($province as $code => $name) {
            $export[$code] = [
                $index++,
                $name,
                0,
            ];
        }

        foreach ($list as $model) {
            $func = 'cal_' . strtolower($model);
            $tmp = $this->$func($model);

            foreach ($province as $provice_code => $name) {
                $partial = array_values($tmp[$provice_code]);

                if (in_array($model, $single)) {
                    $export[$provice_code][2] += array_sum($partial);
                } else {
                    $export[$provice_code][2] += $tmp[$provice_code]['total'];
                }

                $export[$provice_code] = array_merge($export[$provice_code], $partial);
            }
        }

        return $export;
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

            $keyword = (iconv('UTF-8', 'ASCII//TRANSLIT', $item['tentuvien']));
            $keyword = strtolower(str_replace(' ', '-', $keyword));

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

            $keyword = (iconv('UTF-8', 'ASCII//TRANSLIT', $item['tentuvien']));
            $keyword = strtolower(str_replace(' ', '-', $keyword));
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
            $val = [$val];
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
            $val = [$val];
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
            $val = [$val];
        }

        return $result;
    }

    private function cal_phatgiaohoahoa($model)
    {
        $result = [];
        $province = $this->Province->getProvince();
        foreach ($province as $provice_code => $name) {
            $result[$provice_code] = 0;
        }

        foreach ($result as $key => &$val) {
            $val = [$val];
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
            case 'phatgiaohoahoa':
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
}
