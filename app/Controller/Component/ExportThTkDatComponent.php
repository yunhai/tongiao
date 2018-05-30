<?php

class ExportThTkDatComponent extends Component
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

        $list = [
            CONG_GIAO => 'Conggiao',
            PHAT_GIAO => 'Tuvienphatgiao',
            CAO_DAI => 'Hodaocaodai',
            TINH_DO_CU_SI => 'Chihoitinhdocusiphatgiaovietnam',
            HOI_GIAO => 'Cosohoigiaoislam',
            HOA_HAO => 'Phatgiaohoahoa',
            TIN_NGUONG => 'Cosotinnguong',
        ];

        $statictis = [];

        $export = [];
        $province = $this->Province->getProvince($filter_location);

        $index = 1;
        foreach ($province as $code => $name) {
            $export[$code] = [
                'index' => $index++,
                'location' => $name,
                'total' => 0,
                'licensed_total' => 0,
                'licensed_other' => 0,
                'licensed_main' => 0,
                'unlicense' => 0
            ];
            $statictis[$code] = [
                'total' => 0,
                'licensed_total' => 0,
                'licensed_other' => 0,
                'licensed_main' => 0,
                'unlicense' => 0,
            ];
        }

        $fields = [
            'total',
            'licensed_main',
            'licensed_other',
            'unlicense',
        ];

        foreach ($list as $field_index => $model) {
            if (!empty($filter_group) && !in_array($field_index, $filter_group)) {
                continue;
            }
            $func = 'cal_' . mb_strtolower($model);
            $tmp = $this->$func($model, $province);

            foreach ($province as $provice_code => $name) {
                if (!empty($tmp[$provice_code])) {
                    $partial = array_values($tmp[$provice_code]);
                    $statictis[$provice_code]['total'] += $tmp[$provice_code]['total'];

                    $statictis[$provice_code]['licensed_main'] += $tmp[$provice_code]['licensed_main'];
                    $statictis[$provice_code]['licensed_other'] += $tmp[$provice_code]['licensed_other'];

                    $statictis[$provice_code]['licensed_total'] = ($statictis[$provice_code]['licensed_main'] + $statictis[$provice_code]['licensed_other']);
                    $statictis[$provice_code]['unlicense'] += $tmp[$provice_code]['unlicense'];
                } else {
                    $partial = [0, 0, 0, 0];
                }

                foreach ($partial as $key => $value) {
                    $f = $fields[$key];
                    $export[$provice_code][$model . '_' . $f] = $value;
                }
            }
        }

        foreach ($export as $provice_code => &$item) {
            $item['total'] = $statictis[$provice_code]['total'];
            $item['licensed_total'] = $statictis[$provice_code]['licensed_total'];
            $item['licensed_main'] = $statictis[$provice_code]['licensed_main'];
            $item['licensed_other'] = $statictis[$provice_code]['licensed_other'];
            $item['unlicense'] = $statictis[$provice_code]['unlicense'];
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
        $dtcg = $this->cal_dongtuconggiao('Dongtuconggiao');
        $gx = $this->cal_giaoxu('Giaoxu');

        foreach ($dtcg as $province_code => &$item) {
            if (isset($gx[$province_code])) {
                $item['total'] = $this->Utility->retrieveNumberFromString($gx[$province_code]['total']);
                $item['licensed_main'] = $this->Utility->retrieveNumberFromString($gx[$province_code]['licensed_main']);
                $item['licensed_other'] = $this->Utility->retrieveNumberFromString($gx[$province_code]['licensed_other']);
                $item['unlicense'] = $this->Utility->retrieveNumberFromString($gx[$province_code]['unlicense']);
                unset($gx[$province_code]);
            }
        }

        if ($gx) {
            $dtcg = array_merge($dtcg, $gx);
        }

        return $dtcg;
    }

    private function cal_dongtuconggiao($model)
    {
        $option = $this->calculateMapping($model);
        extract($option);

        $data = $this->getData($model, $data_field);

        return $this->calculate($data, $formular, $model);
    }

    private function cal_giaoxu($model)
    {
        $option = $this->calculateMapping($model);
        extract($option);

        $data = $this->getData($model, $data_field);

        return $this->calculate($data, $formular, $model);
    }

    private function cal_cosotinnguong($model)
    {
        $option = $this->calculateMapping($model);
        extract($option);

        $data = $this->getData($model, $data_field);

        return $this->calculate($data, $formular, $model);
    }

    private function cal_hodaocaodai($model)
    {
        $option = $this->calculateMapping($model);
        extract($option);

        $data = $this->getData($model, $data_field);

        return $this->calculate($data, $formular, $model);
    }

    private function cal_chihoitinhdocusiphatgiaovietnam($model)
    {
        $option = $this->calculateMapping($model);
        extract($option);

        $data = $this->getData($model, $data_field);

        return $this->calculate($data, $formular, $model);
    }

    private function cal_tuvienphatgiao($model)
    {
        $option = $this->calculateMapping($model);
        extract($option);

        $data = $this->getData($model, $data_field);

        return $this->calculate($data, $formular, $model);
    }

    private function cal_phatgiaohoahoa($model, $province)
    {
        $result = [];
        foreach ($province as $code => $name) {
            $result[$code] = [
                'total' => 0,
                'licensed_main' => 0,
                'licensed_other' => 0,
                'unlicense' => 0,
            ];
        }

        return $result;
    }

    private function cal_cosohoigiaoislam($model)
    {
        $option = $this->calculateMapping($model);
        extract($option);

        $data = $this->getData($model, $data_field);

        return $this->calculate($data, $formular, $model);
    }

    private function calculateMapping($model)
    {
        $model = mb_strtolower($model);

        if ($model == 'cosotinnguong') {
            $data_field = [
                'id',

                // cot 1
                'datdai_tongdientich',

                // cot 2
                'tongiao_dacap_dientich',

                // cot 3
                'nnlnntts_dacap_dientich',
                'gdyt_dacap_dientich',
                'dsdmdk_dacap_dientich',
            ];
            $formular = [
                'total' => ['datdai_tongdientich'],
                'licensed_main' => [
                    'tongiao_dacap_dientich',
                ],
                'licensed_other' => [
                    'nnlnntts_dacap_dientich',
                    'gdyt_dacap_dientich',
                    'dsdmdk_dacap_dientich',
                ]
            ];
        }

        $list = [
            'cosohoigiaoislam',
            'hodaocaodai',
            'chihoitinhdocusiphatgiaovietnam',
            'dongtuconggiao',
            'giaoxu',
            'tuvienphatgiao'
        ];

        if (in_array($model, $list)) {
            $data_field = [
                'id',
                // cot 1
                'datdai_tongdientich',

                // cot 2
                'dattrongkhuonvien_tongiao_dacap_dientich',
                'datngoaikhuonvien_tongiao_dacap_dientich_1',
                'datngoaikhuonvien_tongiao_dacap_dientich_2',
                'datngoaikhuonvien_tongiao_dacap_dientich_3',

                // cot 3
                'dattrongkhuonvien_nnlnntts_dacap_dientich',
                'datngoaikhuonvien_nnlnntts_dacap_dientich_1',
                'datngoaikhuonvien_nnlnntts_dacap_dientich_2',
                'datngoaikhuonvien_nnlnntts_dacap_dientich_3',
                'dattrongkhuonvien_gdyt_dacap_dientich',
                'datngoaikhuonvien_gdyt_dacap_dientich_1',
                'datngoaikhuonvien_gdyt_dacap_dientich_2',
                'datngoaikhuonvien_gdyt_dacap_dientich_3',
                'dattrongkhuonvien_dsdmdk_dacap_dientich',
                'datngoaikhuonvien_dsdmdk_dacap_dientich_1',
                'datngoaikhuonvien_dsdmdk_dacap_dientich_2',
                'datngoaikhuonvien_dsdmdk_dacap_dientich_3',
            ];
            $formular = [
                'total' => ['datdai_tongdientich'],
                'licensed_main' => [
                    'dattrongkhuonvien_tongiao_dacap_dientich',
                    'datngoaikhuonvien_tongiao_dacap_dientich_1',
                    'datngoaikhuonvien_tongiao_dacap_dientich_2',
                    'datngoaikhuonvien_tongiao_dacap_dientich_3',
                ],
                'licensed_other' => [
                    'dattrongkhuonvien_nnlnntts_dacap_dientich',
                    'datngoaikhuonvien_nnlnntts_dacap_dientich_1',
                    'datngoaikhuonvien_nnlnntts_dacap_dientich_2',
                    'datngoaikhuonvien_nnlnntts_dacap_dientich_3',
                    'dattrongkhuonvien_gdyt_dacap_dientich',
                    'datngoaikhuonvien_gdyt_dacap_dientich_1',
                    'datngoaikhuonvien_gdyt_dacap_dientich_2',
                    'datngoaikhuonvien_gdyt_dacap_dientich_3',
                    'dattrongkhuonvien_dsdmdk_dacap_dientich',
                    'datngoaikhuonvien_dsdmdk_dacap_dientich_1',
                    'datngoaikhuonvien_dsdmdk_dacap_dientich_2',
                    'datngoaikhuonvien_dsdmdk_dacap_dientich_3',
                ]
            ];
        }

        array_push($data_field, $this->getLocationFieldName($model));

        return compact('data_field', 'formular');
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

    private function calculate($data, $formular, $model)
    {
        $result = [];

        $province_field = $this->getLocationFieldName($model);
        foreach ($data as $id => $item) {
            $provice_code = $this->Province->retrieveProvinceCode($item[$province_field]);
            if (!$provice_code) {
                continue;
            }

            $total = 0;
            foreach ($formular['total'] as $field) {
                if (!empty($item[$field])) {
                    $total += $item[$field];
                }
            }

            $licensed_main = 0;
            foreach ($formular['licensed_main'] as $field) {
                if (!empty($item[$field])) {
                    $licensed_main += $item[$field];
                }
            }

            $licensed_other = 0;
            foreach ($formular['licensed_other'] as $field) {
                if (!empty($item[$field])) {
                    $licensed_other += $item[$field];
                }
            }

            $unlicense = round($total - ($licensed_main + $licensed_other), 2);

            if (!isset($result[$provice_code])) {
                $result[$provice_code] = [
                    'total' => [],
                    'licensed_main' => [],
                    'licensed_other' => [],
                    'unlicense' => []
                ];
            }

            if ($total) {
                array_push($result[$provice_code]['total'], $total);
            }
            if ($licensed_main) {
                array_push($result[$provice_code]['licensed_main'], $licensed_main);
            }
            if ($licensed_other) {
                array_push($result[$provice_code]['licensed_other'], $licensed_other);
            }
            if ($unlicense) {
                array_push($result[$provice_code]['unlicense'], $unlicense);
            }
            unset($data[$id]);
        }

        foreach ($result as $provice_code => $list) {
            $sum = $result[$provice_code]['total'] ? array_sum($result[$provice_code]['total']) : 0;
            $result[$provice_code]['total'] = $sum;

            $sum = $result[$provice_code]['licensed_main'] ? array_sum($result[$provice_code]['licensed_main']) : 0;
            $result[$provice_code]['licensed_main'] = $sum;

            $sum = $result[$provice_code]['licensed_other'] ? array_sum($result[$provice_code]['licensed_other']) : 0;
            $result[$provice_code]['licensed_other'] = $sum;

            $sum = $result[$provice_code]['unlicense'] ? array_sum($result[$provice_code]['unlicense']) : 0;
            $result[$provice_code]['unlicense'] = $sum;
        }

        return $result;
    }

    private function getData($model, $data_field)
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
}
