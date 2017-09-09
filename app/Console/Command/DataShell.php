<?php

App::uses('ComponentCollection', 'Controller');
App::uses('UtilityComponent', 'Controller/Component');

class DataShell extends AppShell
{
    public function main()
    {
        $this->formatNumber();
        $this->calculate();
    }

    public function calculate()
    {
        $collection = new ComponentCollection();
        $this->Utility = new UtilityComponent($collection);

        $this->out('Calculate dat-dai.');
        $model = [
            1 => 'Cosotinnguong',
        //    2 => 'Diemnhomtinlanh',
            3 => 'Cosohoigiaoislam',
            4 => 'Hodaocaodai',
            5 => 'Chihoitinhdocusiphatgiaovietnam',
            6 => 'Chihoitinlanh',
            7 => 'Dongtuconggiao',
            8 => 'Giaoxu',
            9 => 'Tuvienphatgiao'
        ];

        foreach ($model as $id => $name) {
            $this->out("{$id}: $name");
        }
        $this->out('99: All model');
        $in = '';
        while (!(int) $in) {
            $in = $this->in('Please chose model');
        }

        $this->out('Calculating ...');

        if ($in < 99) {
            $model = [$model[$in]];
        }
        foreach ($model as $name) {
            $this->makeCalculate($name);
        }

        $in = '';
        while (!in_array($in, array('y', 'Y', 'n', 'N'))) {
            $in = $this->in('Are you sure to updating ? (y or n)');
        }
        if (mb_strtolower($in) == 'y') {
            $this->out('Executing update db');
            foreach ($model as $name) {
                $this->makeCalculate($name, true);
            }
            $this->out('Finished updating db');
        }
        $this->out('Finished calculate.');
    }

    private function makeCalculate($model, $update = false)
    {
        $time = date('his');
        $log_folder = "repair/calculator/{$time}.{$model}";

        $option = $this->calculateMapping($model);
        extract($option);

        $conditions = [
            'is_add' => 1,
        ];

        $obj = ClassRegistry::init($model);
        $data = $obj->find('all', array(
            'fields' => $data_field,
            'conditions' => $conditions,
        ));

        $data = Hash::combine($data, '{n}.' . $model . '.id', '{n}.' . $model);

        if (!$update) {
            $this->log(print_r($data, true), $log_folder . '.before');
        }
        // die;

        $final = [];
        foreach ($data as $id => $target) {
            $tmp = [];
            foreach ($json_field as $field => $token) {
                $total = 0;
                $string = trim($target[$field], '.,');
                if ($string) {
                    if (mb_strpos($string, $token) !== false) {
                        $result = $this->retrieveSumData($string, $token);
                        $total = $this->Utility->sumList($result);
                    } else {
                        $total = $this->Utility->retrieveNumberFromString($string);
                    }
                }
                $tmp[$field] = $total;
            }

            $final[$id] = $this->calculateCore($target, $tmp, $sum_field);
        }
        if ($update) {
            foreach ($final as $id => $item) {
                $obj->save($item);
                $this->log(print_r($obj->getQueries(), true), $log_folder . '.query');
            }
        } else {
            $this->log(print_r($final, true), $log_folder . '.after');
        }
    }

    private function calculateCore($target, $addition, $sum_field)
    {
        $result = [
            'id' => $target['id']
        ];

        // $this->log('b4', 'repair/calculator/data');
        // $this->log(print_r($target, true), 'repair/calculator/data');
        $target = array_merge($target, $addition);
        // $this->log('af', 'repair/calculator/data');
        // $this->log(print_r($target, true), 'repair/calculator/target');
        // $this->log(print_r($addition, true), 'repair/calculator/addition');

        foreach ($sum_field as $field => $list) {
            $total = 0;
            foreach ($list as $item) {
                $total += isset($target[$item]) ? $target[$item] : 0;
            }

            $result[$field] = $total;
            $target[$field] = $total;
        }

        return $result;
    }

    private function retrieveSumData($string, $keyword)
    {
        $list = explode(';', trim($string, ','));

        $result = [];
        foreach ($list as $item) {
            $target = explode(',', $item);
            foreach ($target as $value) {
                $flag = mb_strpos($value, $keyword) !== false;
                if ($flag) {
                    $value = str_replace($keyword, '', $value);
                    $value = str_replace(',', '.', $value);
                    $value = str_replace(':', '', $value);
                    $value = str_replace('_', '', $value);

                    $result[] = $this->Utility->retrieveNumberFromString($value);
                }
            }
        }

        return $result;
    }

    private function calculateMapping($model)
    {
        $model = mb_strtolower($model);

        $result = [];
        if ($model == 'cosotinnguong') {
            $data_field = [
                'id',
                'datdai_tongdientich',

                'tongiao_dientich',
                'tongiao_dacap_dientich',
                'tongiao_chuacap_dientich',
                'tongiao_dacap_gcn_quyensudungdat',

                'nnlnntts_dientich',
                'nnlnntts_dacap_dientich',
                'nnlnntts_dacap_gcn_quyensudungdat',
                'nnlnntts_chuacap_dientich',

                'gdyt_dientich',
                'gdyt_dacap_dientich',
                'gdyt_dacap_gcn_quyensudungdat',
                'gdyt_chuacap_dientich',

                'dsdmdk_dientich',
                'dsdmdk_dacap_dientich',
                'dsdmdk_dacap_gcn_quyensudungdat',
                'dsdmdk_chuacap_dientich'
            ];

            $json_field = [
                'tongiao_dacap_gcn_quyensudungdat' => 'tongiao_dacap_dientich',
                'nnlnntts_dacap_gcn_quyensudungdat' => 'nnlnntts_dacap_dientich',
                'gdyt_dacap_gcn_quyensudungdat' => 'gdyt_dacap_dientich',
                'dsdmdk_dacap_gcn_quyensudungdat' => 'dsdmdk_dacap_dientich',

                'tongiao_chuacap_dientich' => 'tongiao_chuacap_dientich',
                'nnlnntts_chuacap_dientich' => 'nnlnntts_chuacap_dientich',
                'gdyt_chuacap_dientich' => 'gdyt_chuacap_dientich',
                'dsdmdk_chuacap_dientich' => 'dsdmdk_chuacap_dientich',
            ];

            $sum_field = [
                'tongiao_dacap_dientich' => ['tongiao_dacap_gcn_quyensudungdat'],
                'nnlnntts_dacap_dientich' => ['nnlnntts_dacap_gcn_quyensudungdat'],
                'gdyt_dacap_dientich' => ['gdyt_dacap_gcn_quyensudungdat'],
                'dsdmdk_dacap_dientich' => ['dsdmdk_dacap_gcn_quyensudungdat'],

                'tongiao_dientich' => ['tongiao_dacap_gcn_quyensudungdat', 'tongiao_chuacap_dientich'],
                'nnlnntts_dientich' => ['nnlnntts_dacap_gcn_quyensudungdat', 'nnlnntts_chuacap_dientich'],
                'gdyt_dientich' => ['gdyt_dacap_gcn_quyensudungdat', 'gdyt_chuacap_dientich'],
                'dsdmdk_dientich' => ['dsdmdk_dacap_gcn_quyensudungdat', 'dsdmdk_chuacap_dientich'],

                'datdai_tongdientich' => [
                    'tongiao_dientich',
                    'nnlnntts_dientich',
                    'gdyt_dientich',
                    'dsdmdk_dientich'
                ]
            ];
        }

        $list = [
            'cosohoigiaoislam',
            'hodaocaodai',
            'chihoitinhdocusiphatgiaovietnam',
            'chihoitinlanh',
            'dongtuconggiao',
            'giaoxu',
            'tuvienphatgiao'
        ];

        if (in_array($model, $list)) {
            $data_field = [
                'id',

                'datdai_tongdientich',
                'dattrongkhuonvien',
                'datngoaikhuonvien',

                'dattrongkhuonvien_tongiao_dientich',
                'dattrongkhuonvien_tongiao_dacap_dientich',
                'dattrongkhuonvien_tongiao_chuacap_dientich',
                'dattrongkhuonvien_tongiao_dacap_gcn_quyensudungdat',

                'datngoaikhuonvien_tongiao_dientich_1',
                'datngoaikhuonvien_tongiao_dacap_dientich_1',
                'datngoaikhuonvien_tongiao_chuacap_dientich_1',
                'datngoaikhuonvien_tongiao_dacap_gcn_quyensudungdat_1',

                'datngoaikhuonvien_tongiao_dientich_2',
                'datngoaikhuonvien_tongiao_dacap_dientich_2',
                'datngoaikhuonvien_tongiao_chuacap_dientich_2',
                'datngoaikhuonvien_tongiao_dacap_gcn_quyensudungdat_2',

                'datngoaikhuonvien_tongiao_dientich_3',
                'datngoaikhuonvien_tongiao_dacap_dientich_3',
                'datngoaikhuonvien_tongiao_chuacap_dientich_3',
                'datngoaikhuonvien_tongiao_dacap_gcn_quyensudungdat_3',


                'dattrongkhuonvien_nnlnntts_dientich',
                'dattrongkhuonvien_nnlnntts_dacap_dientich',
                'dattrongkhuonvien_nnlnntts_chuacap_dientich',
                'dattrongkhuonvien_nnlnntts_dacap_gcn_quyensudungdat',

                'datngoaikhuonvien_nnlnntts_dientich_1',
                'datngoaikhuonvien_nnlnntts_dacap_dientich_1',
                'datngoaikhuonvien_nnlnntts_chuacap_dientich_1',
                'datngoaikhuonvien_nnlnntts_dacap_gcn_quyensudungdat_1',

                'datngoaikhuonvien_nnlnntts_dientich_2',
                'datngoaikhuonvien_nnlnntts_dacap_dientich_2',
                'datngoaikhuonvien_nnlnntts_chuacap_dientich_2',
                'datngoaikhuonvien_nnlnntts_dacap_gcn_quyensudungdat_2',

                'datngoaikhuonvien_nnlnntts_dientich_3',
                'datngoaikhuonvien_nnlnntts_dacap_dientich_3',
                'datngoaikhuonvien_nnlnntts_chuacap_dientich_3',
                'datngoaikhuonvien_nnlnntts_dacap_gcn_quyensudungdat_3',

                'dattrongkhuonvien_gdyt_dientich',
                'dattrongkhuonvien_gdyt_dacap_dientich',
                'dattrongkhuonvien_gdyt_chuacap_dientich',
                'dattrongkhuonvien_gdyt_dacap_gcn_quyensudungdat',

                'datngoaikhuonvien_gdyt_dientich_1',
                'datngoaikhuonvien_gdyt_dacap_dientich_1',
                'datngoaikhuonvien_gdyt_chuacap_dientich_1',
                'datngoaikhuonvien_gdyt_dacap_gcn_quyensudungdat_1',

                'datngoaikhuonvien_gdyt_dientich_2',
                'datngoaikhuonvien_gdyt_dacap_dientich_2',
                'datngoaikhuonvien_gdyt_chuacap_dientich_2',
                'datngoaikhuonvien_gdyt_dacap_gcn_quyensudungdat_2',

                'datngoaikhuonvien_gdyt_dientich_3',
                'datngoaikhuonvien_gdyt_dacap_dientich_3',
                'datngoaikhuonvien_gdyt_chuacap_dientich_3',
                'datngoaikhuonvien_gdyt_dacap_gcn_quyensudungdat_3',

                'dattrongkhuonvien_dsdmdk_dientich',
                'dattrongkhuonvien_dsdmdk_dacap_dientich',
                'dattrongkhuonvien_dsdmdk_chuacap_dientich',
                'dattrongkhuonvien_dsdmdk_dacap_gcn_quyensudungdat',

                'datngoaikhuonvien_dsdmdk_dientich_1',
                'datngoaikhuonvien_dsdmdk_dacap_dientich_1',
                'datngoaikhuonvien_dsdmdk_chuacap_dientich_1',
                'datngoaikhuonvien_dsdmdk_dacap_gcn_quyensudungdat_1',

                'datngoaikhuonvien_dsdmdk_dientich_2',
                'datngoaikhuonvien_dsdmdk_dacap_dientich_2',
                'datngoaikhuonvien_dsdmdk_chuacap_dientich_2',
                'datngoaikhuonvien_dsdmdk_dacap_gcn_quyensudungdat_2',

                'datngoaikhuonvien_dsdmdk_dientich_3',
                'datngoaikhuonvien_dsdmdk_dacap_dientich_3',
                'datngoaikhuonvien_dsdmdk_chuacap_dientich_3',
                'datngoaikhuonvien_dsdmdk_dacap_gcn_quyensudungdat_3'
            ];

            $json_field = [
                'dattrongkhuonvien_tongiao_dacap_gcn_quyensudungdat' => 'dattrongkhuonvien_tongiao_dacap_dientich',
                'dattrongkhuonvien_nnlnntts_dacap_gcn_quyensudungdat' => 'dattrongkhuonvien_nnlnntts_dacap_dientich',
                'dattrongkhuonvien_gdyt_dacap_gcn_quyensudungdat' => 'dattrongkhuonvien_gdyt_dacap_dientich',
                'dattrongkhuonvien_dsdmdk_dacap_gcn_quyensudungdat' => 'dattrongkhuonvien_dsdmdk_dacap_dientich',
                'datngoaikhuonvien_tongiao_dacap_gcn_quyensudungdat_1' => 'datngoaikhuonvien_tongiao_dacap_dientich_1',
                'datngoaikhuonvien_nnlnntts_dacap_gcn_quyensudungdat_1' => 'datngoaikhuonvien_nnlnntts_dacap_dientich_1',
                'datngoaikhuonvien_gdyt_dacap_gcn_quyensudungdat_1' => 'datngoaikhuonvien_gdyt_dacap_dientich_1',
                'datngoaikhuonvien_dsdmdk_dacap_gcn_quyensudungdat_1' => 'datngoaikhuonvien_dsdmdk_dacap_dientich_1',
                'datngoaikhuonvien_tongiao_dacap_gcn_quyensudungdat_2' => 'datngoaikhuonvien_tongiao_dacap_dientich_2',
                'datngoaikhuonvien_nnlnntts_dacap_gcn_quyensudungdat_2' => 'datngoaikhuonvien_nnlnntts_dacap_dientich_2',
                'datngoaikhuonvien_gdyt_dacap_gcn_quyensudungdat_2' => 'datngoaikhuonvien_gdyt_dacap_dientich_2',
                'datngoaikhuonvien_dsdmdk_dacap_gcn_quyensudungdat_2' => 'datngoaikhuonvien_dsdmdk_dacap_dientich_2',
                'datngoaikhuonvien_tongiao_dacap_gcn_quyensudungdat_3' => 'datngoaikhuonvien_tongiao_dacap_dientich_3',
                'datngoaikhuonvien_nnlnntts_dacap_gcn_quyensudungdat_3' => 'datngoaikhuonvien_nnlnntts_dacap_dientich_3',
                'datngoaikhuonvien_gdyt_dacap_gcn_quyensudungdat_3' => 'datngoaikhuonvien_gdyt_dacap_dientich_3',
                'datngoaikhuonvien_dsdmdk_dacap_gcn_quyensudungdat_3' => 'datngoaikhuonvien_dsdmdk_dacap_dientich_3',
                'dattrongkhuonvien_tongiao_chuacap_dientich' => 'dattrongkhuonvien_tongiao_chuacap_dientich',
                'dattrongkhuonvien_nnlnntts_chuacap_dientich' => 'dattrongkhuonvien_nnlnntts_chuacap_dientich',
                'dattrongkhuonvien_gdyt_chuacap_dientich' => 'dattrongkhuonvien_gdyt_chuacap_dientich',
                'dattrongkhuonvien_dsdmdk_chuacap_dientich' => 'dattrongkhuonvien_dsdmdk_chuacap_dientich',
                'datngoaikhuonvien_tongiao_chuacap_dientich_1' => 'datngoaikhuonvien_tongiao_chuacap_dientich_1',
                'datngoaikhuonvien_nnlnntts_chuacap_dientich_1' => 'datngoaikhuonvien_nnlnntts_chuacap_dientich_1',
                'datngoaikhuonvien_gdyt_chuacap_dientich_1' => 'datngoaikhuonvien_gdyt_chuacap_dientich_1',
                'datngoaikhuonvien_dsdmdk_chuacap_dientich_1' => 'datngoaikhuonvien_dsdmdk_chuacap_dientich_1',
                'datngoaikhuonvien_tongiao_chuacap_dientich_2' => 'datngoaikhuonvien_tongiao_chuacap_dientich_2',
                'datngoaikhuonvien_nnlnntts_chuacap_dientich_2' => 'datngoaikhuonvien_nnlnntts_chuacap_dientich_2',
                'datngoaikhuonvien_gdyt_chuacap_dientich_2' => 'datngoaikhuonvien_gdyt_chuacap_dientich_2',
                'datngoaikhuonvien_dsdmdk_chuacap_dientich_2' => 'datngoaikhuonvien_dsdmdk_chuacap_dientich_2',
                'datngoaikhuonvien_tongiao_chuacap_dientich_3' => 'datngoaikhuonvien_tongiao_chuacap_dientich_3',
                'datngoaikhuonvien_nnlnntts_chuacap_dientich_3' => 'datngoaikhuonvien_nnlnntts_chuacap_dientich_3',
                'datngoaikhuonvien_gdyt_chuacap_dientich_3' => 'datngoaikhuonvien_gdyt_chuacap_dientich_3',
                'datngoaikhuonvien_dsdmdk_chuacap_dientich_3' => 'datngoaikhuonvien_dsdmdk_chuacap_dientich_3',
                'dattrongkhuonvien_tongiao_dacap_gcn_quyensudungdat' => 'dattrongkhuonvien_tongiao_dacap_dientich',
            ];

            $sum_field = [
                'dattrongkhuonvien_tongiao_dacap_dientich' => ['dattrongkhuonvien_tongiao_dacap_gcn_quyensudungdat'],
                'dattrongkhuonvien_nnlnntts_dacap_dientich' => ['dattrongkhuonvien_nnlnntts_dacap_gcn_quyensudungdat'],
                'dattrongkhuonvien_gdyt_dacap_dientich' => ['dattrongkhuonvien_gdyt_dacap_gcn_quyensudungdat'],
                'dattrongkhuonvien_dsdmdk_dacap_dientich' => ['dattrongkhuonvien_dsdmdk_dacap_gcn_quyensudungdat'],
                'datngoaikhuonvien_tongiao_dacap_dientich_1' => ['datngoaikhuonvien_tongiao_dacap_gcn_quyensudungdat_1'],
                'datngoaikhuonvien_nnlnntts_dacap_dientich_1' => ['datngoaikhuonvien_nnlnntts_dacap_gcn_quyensudungdat_1'],
                'datngoaikhuonvien_gdyt_dacap_dientich_1' => ['datngoaikhuonvien_gdyt_dacap_gcn_quyensudungdat_1'],
                'datngoaikhuonvien_dsdmdk_dacap_dientich_1' => ['datngoaikhuonvien_dsdmdk_dacap_gcn_quyensudungdat_1'],
                'datngoaikhuonvien_tongiao_dacap_dientich_2' => ['datngoaikhuonvien_tongiao_dacap_gcn_quyensudungdat_2'],
                'datngoaikhuonvien_nnlnntts_dacap_dientich_2' => ['datngoaikhuonvien_nnlnntts_dacap_gcn_quyensudungdat_2'],
                'datngoaikhuonvien_gdyt_dacap_dientich_2' => ['datngoaikhuonvien_gdyt_dacap_gcn_quyensudungdat_2'],
                'datngoaikhuonvien_dsdmdk_dacap_dientich_2' => ['datngoaikhuonvien_dsdmdk_dacap_gcn_quyensudungdat_2'],
                'datngoaikhuonvien_tongiao_dacap_dientich_3' => ['datngoaikhuonvien_tongiao_dacap_gcn_quyensudungdat_3'],
                'datngoaikhuonvien_nnlnntts_dacap_dientich_3' => ['datngoaikhuonvien_nnlnntts_dacap_gcn_quyensudungdat_3'],
                'datngoaikhuonvien_gdyt_dacap_dientich_3' => ['datngoaikhuonvien_gdyt_dacap_gcn_quyensudungdat_3'],
                'datngoaikhuonvien_dsdmdk_dacap_dientich_3' => ['datngoaikhuonvien_dsdmdk_dacap_gcn_quyensudungdat_3'],
                'dattrongkhuonvien_tongiao_chuacap_dientich' => ['dattrongkhuonvien_tongiao_chuacap_dientich'],
                'dattrongkhuonvien_nnlnntts_chuacap_dientich' => ['dattrongkhuonvien_nnlnntts_chuacap_dientich'],
                'dattrongkhuonvien_gdyt_chuacap_dientich' => ['dattrongkhuonvien_gdyt_chuacap_dientich'],
                'dattrongkhuonvien_dsdmdk_chuacap_dientich' => ['dattrongkhuonvien_dsdmdk_chuacap_dientich'],
                'datngoaikhuonvien_tongiao_chuacap_dientich_1' => ['datngoaikhuonvien_tongiao_chuacap_dientich_1'],
                'datngoaikhuonvien_nnlnntts_chuacap_dientich_1' => ['datngoaikhuonvien_nnlnntts_chuacap_dientich_1'],
                'datngoaikhuonvien_gdyt_chuacap_dientich_1' => ['datngoaikhuonvien_gdyt_chuacap_dientich_1'],
                'datngoaikhuonvien_dsdmdk_chuacap_dientich_1' => ['datngoaikhuonvien_dsdmdk_chuacap_dientich_1'],
                'datngoaikhuonvien_tongiao_chuacap_dientich_2' => ['datngoaikhuonvien_tongiao_chuacap_dientich_2'],
                'datngoaikhuonvien_nnlnntts_chuacap_dientich_2' => ['datngoaikhuonvien_nnlnntts_chuacap_dientich_2'],
                'datngoaikhuonvien_gdyt_chuacap_dientich_2' => ['datngoaikhuonvien_gdyt_chuacap_dientich_2'],
                'datngoaikhuonvien_dsdmdk_chuacap_dientich_2' => ['datngoaikhuonvien_dsdmdk_chuacap_dientich_2'],
                'datngoaikhuonvien_tongiao_chuacap_dientich_3' => ['datngoaikhuonvien_tongiao_chuacap_dientich_3'],
                'datngoaikhuonvien_nnlnntts_chuacap_dientich_3' => ['datngoaikhuonvien_nnlnntts_chuacap_dientich_3'],
                'datngoaikhuonvien_gdyt_chuacap_dientich_3' => ['datngoaikhuonvien_gdyt_chuacap_dientich_3'],
                'datngoaikhuonvien_dsdmdk_chuacap_dientich_3' => ['datngoaikhuonvien_dsdmdk_chuacap_dientich_3'],

                'dattrongkhuonvien_tongiao_dientich' => ['dattrongkhuonvien_tongiao_dacap_gcn_quyensudungdat', 'dattrongkhuonvien_tongiao_chuacap_dientich'],
                'dattrongkhuonvien_nnlnntts_dientich' => ['dattrongkhuonvien_nnlnntts_dacap_dientich', 'dattrongkhuonvien_nnlnntts_chuacap_dientich'],
                'dattrongkhuonvien_gdyt_dientich' => ['dattrongkhuonvien_gdyt_dacap_dientich', 'dattrongkhuonvien_gdyt_chuacap_dientich'],
                'dattrongkhuonvien_dsdmdk_dientich' => ['dattrongkhuonvien_dsdmdk_dacap_dientich', 'dattrongkhuonvien_dsdmdk_chuacap_dientich'],

                'datngoaikhuonvien_tongiao_dientich_1' => ['datngoaikhuonvien_tongiao_dacap_dientich_1', 'datngoaikhuonvien_tongiao_chuacap_dientich_1'],
                'datngoaikhuonvien_nnlnntts_dientich_1' => ['datngoaikhuonvien_nnlnntts_dacap_dientich_1', 'datngoaikhuonvien_nnlnntts_chuacap_dientich_1'],
                'datngoaikhuonvien_gdyt_dientich_1' => ['datngoaikhuonvien_gdyt_dacap_dientich_1', 'datngoaikhuonvien_gdyt_chuacap_dientich_1'],
                'datngoaikhuonvien_dsdmdk_dientich_1' => ['datngoaikhuonvien_dsdmdk_dacap_dientich_1', 'datngoaikhuonvien_dsdmdk_chuacap_dientich_1'],

                'datngoaikhuonvien_tongiao_dientich_2' => ['datngoaikhuonvien_tongiao_dacap_dientich_2', 'datngoaikhuonvien_tongiao_chuacap_dientich_2'],
                'datngoaikhuonvien_nnlnntts_dientich_2' => ['datngoaikhuonvien_nnlnntts_dacap_dientich_2', 'datngoaikhuonvien_nnlnntts_chuacap_dientich_2'],
                'datngoaikhuonvien_gdyt_dientich_2' => ['datngoaikhuonvien_gdyt_dacap_dientich_2', 'datngoaikhuonvien_gdyt_chuacap_dientich_2'],
                'datngoaikhuonvien_dsdmdk_dientich_2' => ['datngoaikhuonvien_dsdmdk_dacap_dientich_2', 'datngoaikhuonvien_dsdmdk_chuacap_dientich_2'],

                'datngoaikhuonvien_tongiao_dientich_3' => ['datngoaikhuonvien_tongiao_dacap_dientich_3', 'datngoaikhuonvien_tongiao_chuacap_dientich_3'],
                'datngoaikhuonvien_nnlnntts_dientich_3' => ['datngoaikhuonvien_nnlnntts_dacap_dientich_3', 'datngoaikhuonvien_nnlnntts_chuacap_dientich_3'],
                'datngoaikhuonvien_gdyt_dientich_3' => ['datngoaikhuonvien_gdyt_dacap_dientich_3', 'datngoaikhuonvien_gdyt_chuacap_dientich_3'],
                'datngoaikhuonvien_dsdmdk_dientich_3' => ['datngoaikhuonvien_dsdmdk_dacap_dientich_3', 'datngoaikhuonvien_dsdmdk_chuacap_dientich_3'],

                'dattrongkhuonvien' => [
                    'dattrongkhuonvien_tongiao_dientich',
                    'dattrongkhuonvien_nnlnntts_dientich',
                    'dattrongkhuonvien_gdyt_dientich',
                    'dattrongkhuonvien_dsdmdk_dientich',
                ],

                'datngoaikhuonvien' => [
                    'datngoaikhuonvien_tongiao_dientich',
                    'datngoaikhuonvien_nnlnntts_dientich',
                    'datngoaikhuonvien_gdyt_dientich',
                    'datngoaikhuonvien_dsdmdk_dientich',
                    'datngoaikhuonvien_tongiao_dientich_1',
                    'datngoaikhuonvien_nnlnntts_dientich_1',
                    'datngoaikhuonvien_gdyt_dientich_1',
                    'datngoaikhuonvien_dsdmdk_dientich_1',
                    'datngoaikhuonvien_tongiao_dientich_2',
                    'datngoaikhuonvien_nnlnntts_dientich_2',
                    'datngoaikhuonvien_gdyt_dientich_2',
                    'datngoaikhuonvien_dsdmdk_dientich_2',
                    'datngoaikhuonvien_tongiao_dientich_3',
                    'datngoaikhuonvien_nnlnntts_dientich_3',
                    'datngoaikhuonvien_gdyt_dientich_3',
                    'datngoaikhuonvien_dsdmdk_dientich_3',
                ],

                'datdai_tongdientich' => [
                    'dattrongkhuonvien',
                    'datngoaikhuonvien',
                ]
            ];
        }

        return compact('ignore_field', 'sum_field', 'data_field', 'json_field');
    }

    public function formatNumber()
    {
        $collection = new ComponentCollection();
        $this->Utility = new UtilityComponent($collection);

        $this->out('Formating number.');
        $model = [
            1 => 'Cosotinnguong',
        //    2 => 'Diemnhomtinlanh',
            3 => 'Cosohoigiaoislam',
            4 => 'Hodaocaodai',
            5 => 'Chihoitinhdocusiphatgiaovietnam',
            6 => 'Chihoitinlanh',
            7 => 'Dongtuconggiao',
            8 => 'Giaoxu',
            9 => 'Tuvienphatgiao'
        ];

        foreach ($model as $id => $name) {
            $this->out("{$id}: $name");
        }
        $this->out('99: All model');
        $in = '';
        while (!(int) $in) {
            $in = $this->in('Please chose model');
        }

        $this->out('Formating number ...');

        if ($in < 99) {
            $model = [$model[$in]];
        }
        foreach ($model as $name) {
            $this->makeFormatNumber($name);
        }

        $in = '';
        while (!in_array($in, array('y', 'Y', 'n', 'N'))) {
            $in = $this->in('Are you sure to updating ? (y or n)');
        }
        if (mb_strtolower($in) == 'y') {
            $this->out('Executing update db');
            foreach ($model as $name) {
                $this->makeFormatNumber($name, true);
            }
            $this->out('Finished updating db');
        }
        $this->out('Finished formating number.');
    }

    private function makeFormatNumber($model = '', $update = false)
    {
        $time = date('his');
        $log_folder = "repair/format/{$time}.{$model}";

        $field = $this->formatNumberMapping($model);
        $conditions = [
            'is_add' => 1
        ];

        $obj = ClassRegistry::init($model);
        $data = $obj->find('all', array(
            'fields' => $field,
            'conditions' => $conditions
        ));

        $data = Hash::combine($data, '{n}.' . $model . '.id', '{n}.' . $model);

        if (!$update) {
            $this->log(print_r($data, true), $log_folder . '.before');
        }

        $track = [];
        foreach ($data as $id => $list) {
            foreach ($list as $f => $value) {
                if ($f == 'id') {
                    continue;
                }

                $data[$id][$f] = $this->Utility->retrieveNumberFromString($value);
                $track[$id][$f] = isset($track[$id][$f]) ? $track[$id][$f] : [];
                $track[$id][$f] = [
                    'before' => $value,
                    'after' => $data[$id][$f]
                ];
            }
        }
        if ($update) {
            foreach ($data as $id => $item) {
                $obj->save($item);
                $this->log(print_r($obj->getQueries(), true), $log_folder . '.query');
            }
        } else {
            $this->log(print_r($track, true), $log_folder . '.track');
            $this->log(print_r($data, true), $log_folder . '.after');
        }
    }

    private function formatNumberMapping($model = '')
    {
        $model = mb_strtolower($model);

        if ($model == 'cosotinnguong') {
            return [
                'id',
                'datdai_tongdientich',
                'tongiao_dientich',
                'nnlnntts_dientich',
                'gdyt_dientich',
                'dsdmdk_dientich',
            ];
        }

        $list = [
            'cosohoigiaoislam',
            'hodaocaodai',
            'chihoitinhdocusiphatgiaovietnam',
            'chihoitinlanh',
            'dongtuconggiao',
            'giaoxu',
            'tuvienphatgiao'
        ];

        if (in_array($model, $list)) {
            return [
                'id',
                'datdai_tongdientich',
                'dattrongkhuonvien',
                'dattrongkhuonvien_tongiao_dientich',
                'dattrongkhuonvien_tongiao_dacap_dientich',
                'dattrongkhuonvien_nnlnntts_dientich',
                'dattrongkhuonvien_nnlnntts_dacap_dientich',
                'dattrongkhuonvien_gdyt_dientich',
                'dattrongkhuonvien_gdyt_dacap_dientich',
                'dattrongkhuonvien_dsdmdk_dientich',
                'dattrongkhuonvien_dsdmdk_dacap_dientich',
                'datngoaikhuonvien',
                'datngoaikhuonvien_tongiao_dientich_1',
                'datngoaikhuonvien_tongiao_dacap_dientich_1',
                'datngoaikhuonvien_nnlnntts_dientich_1',
                'datngoaikhuonvien_nnlnntts_dacap_dientich_1',
                'datngoaikhuonvien_gdyt_dientich_1',
                'datngoaikhuonvien_gdyt_dacap_dientich_1',
                'datngoaikhuonvien_dsdmdk_dientich_1',
                'datngoaikhuonvien_dsdmdk_dacap_dientich_1',
                'datngoaikhuonvien_tongiao_dientich_2',
                'datngoaikhuonvien_tongiao_dacap_dientich_2',
                'datngoaikhuonvien_nnlnntts_dientich_2',
                'datngoaikhuonvien_nnlnntts_dacap_dientich_2',
                'datngoaikhuonvien_gdyt_dientich_2',
                'datngoaikhuonvien_gdyt_dacap_dientich_2',
                'datngoaikhuonvien_dsdmdk_dientich_2',
                'datngoaikhuonvien_dsdmdk_dacap_dientich_2',
                'datngoaikhuonvien_tongiao_dientich_3',
                'datngoaikhuonvien_tongiao_dacap_dientich_3',
                'datngoaikhuonvien_nnlnntts_dientich_3',
                'datngoaikhuonvien_nnlnntts_dacap_dientich_3',
                'datngoaikhuonvien_gdyt_dientich_3',
                'datngoaikhuonvien_gdyt_dacap_dientich_3',
                'datngoaikhuonvien_dsdmdk_dientich_3',
                'datngoaikhuonvien_dsdmdk_dacap_dientich_3',
            ];
        }

        return [];
    }
}
