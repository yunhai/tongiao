<?php

App::uses('ComponentCollection', 'Controller');
App::uses('UtilityComponent', 'Controller/Component');

class RepairShell extends AppShell
{
    public function main()
    {
        $this->out('Hello world.');
    }

    public function test()
    {
        $collection = new ComponentCollection();
        $this->Utility = new UtilityComponent($collection);

        $string = '800;200.2;1,000.5';
        $array = $this->Utility->seperateNumberFromString($string);
        $this->out($this->Utility->sumList($array));
    }

    public function sum()
    {
        $model = [
            1 => 'Cosotinnguong',
            'Diemnhomtinlanh',
            'Cosohoigiaoislam',
            'Hodaocaodai',
            'Chihoitinhdocusiphatgiaovietnam',
            'Chihoitinlanh',
            'Dongtuconggiao',
            'Giaoxu',
            'Tuvienphatgiao'
        ];

        foreach ($model as $id => $name) {
            $this->out("{$id}: $name");
        }
        $this->out('99: All model');
        $in = '';
        while (!(int) $in) {
            $in = $this->in('Please chose model');
        }

        $this->out('Repairing ...');
        $collection = new ComponentCollection();
        $this->Utility = new UtilityComponent($collection);

        if ($in < 99) {
            $model = [$model[$in]];
        }
        foreach ($model as $name) {
            $this->makeSum($name);
        }

        $in = '';
        while (!in_array($in, array('y', 'Y', 'n', 'N'))) {
            $in = $this->in('Are you sure to updating ? (y or n)');
        }
        if (mb_strtolower($in) == 'y') {
            $this->out('Executing update db');
            foreach ($model as $name) {
                $this->makeSum($name, true);
            }
            $this->out('Finished updating db');
        }
        $this->out('Finished');
    }

    public function makeSum($model = '', $update = false)
    {
        $func = 'makeSum_' . strtolower($model);
        return $this->$func($model, $update);
    }

    public function makeSum_cosotinnguong($model, $update = false)
    {
        $after_log = "repair/sum/after/{$model}";
        $before_log = "repair/sum/before/{$model}";
        $track_log = "repair/sum/track/{$model}";

        $obj = ClassRegistry::init($model);
        $field = [
            'id',
            'datdai_tongdientich',
            'tongiao_dientich',

            'tongiao_dacap_dientich',
            'tongiao_chuacap_dientich',
            'tongiao_dacap_gcn_quyensudungdat',

            'nnlnntts_dacap_dientich',
            'nnlnntts_dacap_gcn_quyensudungdat',
            'nnlnntts_chuacap_dientich',

            'gdyt_dacap_dientich',
            'gdyt_dacap_gcn_quyensudungdat',
            'gdyt_chuacap_dientich',

            'dsdmdk_dacap_dientich',
            'dsdmdk_dacap_gcn_quyensudungdat',
            'dsdmdk_chuacap_dientich'
        ];
        $conditions = [
            'is_add' => 1,
        ];
        $data = $obj->find('all', array(
            'fields' => $field,
            'conditions' => $conditions
        ));

        $data = Hash::combine($data, '{n}.' . $model . '.id', '{n}.' . $model);

        if (!$update) {
            $this->log(print_r($data, true), $before_log);
        }

        $field = [
            'tongiao_dacap_gcn_quyensudungdat' => 'tongiao_dacap_dientich',
            'nnlnntts_dacap_gcn_quyensudungdat' => 'nnlnntts_dacap_dientich',
            'gdyt_dacap_gcn_quyensudungdat' => 'gdyt_dacap_dientich',
            'dsdmdk_dacap_gcn_quyensudungdat' => 'dsdmdk_dacap_dientich',
        ];

        $final = [];
        foreach ($data as $id => $target) {
            $tmp = [];
            foreach ($field as $k => $v) {
                $string = $target[$k];
                if ($string) {
                    $f = $v;
                    $result = $this->retrieveSumData($string, $f);
                    $tmp[$f] = $this->Utility->sumList($result);
                }
            }

            if ($tmp) {
                $final[$id] = array_merge(['id' => $id], $tmp);
            }
        }


        if ($update) {
            foreach ($final as $id => $item) {
                //    $obj->save($item);
            }
        } else {
            $this->log(print_r($final, true), $after_log);
        }

        $this->out('makeSum_cosotinnguong');
    }
    
    public function makeSum_cosohoigiaoislam($model, $update = false)
    {
        $after_log = "repair/sum/after/{$model}";
        $before_log = "repair/sum/before/{$model}";
        $track_log = "repair/sum/track/{$model}";

        $obj = ClassRegistry::init($model);
        $field = [
            'id',

            'dattrongkhuonvien_tongiao_dacap_dientich',
            'dattrongkhuonvien_tongiao_chuacap_dientich',
            'dattrongkhuonvien_tongiao_dacap_gcn_quyensudungdat',

            'dattrongkhuonvien_nnlnntts_dacap_dientich',
            'dattrongkhuonvien_nnlnntts_chuacap_dientich',
            'dattrongkhuonvien_nnlnntts_dacap_gcn_quyensudungdat',

            'dattrongkhuonvien_gdyt_dacap_dientich',
            'dattrongkhuonvien_gdyt_chuacap_dientich',
            'dattrongkhuonvien_gdyt_dacap_gcn_quyensudungdat',

            'dattrongkhuonvien_dsdmdk_dacap_dientich', 
            'dattrongkhuonvien_dsdmdk_chuacap_dientich',
            'dattrongkhuonvien_dsdmdk_dacap_gcn_quyensudungdat',
            
            'datngoaikhuonvien_tongiao_dacap_dientich_1', 
            'datngoaikhuonvien_tongiao_chuacap_dientich_1',
            'datngoaikhuonvien_tongiao_dacap_gcn_quyensudungdat_1',
        
            'datngoaikhuonvien_nnlnntts_dacap_dientich_1', 
            'datngoaikhuonvien_nnlnntts_chuacap_dientich_1',
            'datngoaikhuonvien_nnlnntts_dacap_gcn_quyensudungdat_1',
        
            'datngoaikhuonvien_gdyt_dacap_dientich_1', 
            'datngoaikhuonvien_gdyt_chuacap_dientich_1',
            'datngoaikhuonvien_gdyt_dacap_gcn_quyensudungdat_1',
        
            'datngoaikhuonvien_dsdmdk_dacap_dientich_1', 
            'datngoaikhuonvien_dsdmdk_chuacap_dientich_1',
            'datngoaikhuonvien_dsdmdk_dacap_gcn_quyensudungdat_1',
        
            'datngoaikhuonvien_tongiao_dacap_dientich_2', 
            'datngoaikhuonvien_tongiao_chuacap_dientich_2',
            'datngoaikhuonvien_tongiao_dacap_gcn_quyensudungdat_2',
        
            'datngoaikhuonvien_nnlnntts_dacap_dientich_2', 
            'datngoaikhuonvien_nnlnntts_chuacap_dientich_2',
            'datngoaikhuonvien_nnlnntts_dacap_gcn_quyensudungdat_2',
        
            'datngoaikhuonvien_gdyt_dacap_dientich_2', 
            'datngoaikhuonvien_gdyt_chuacap_dientich_2',
            'datngoaikhuonvien_gdyt_dacap_gcn_quyensudungdat_2',
        
            'datngoaikhuonvien_dsdmdk_dacap_dientich_2', 
            'datngoaikhuonvien_dsdmdk_chuacap_dientich_2',
            'datngoaikhuonvien_dsdmdk_dacap_gcn_quyensudungdat_2',
        
            'datngoaikhuonvien_tongiao_dacap_dientich_3', 
            'datngoaikhuonvien_tongiao_chuacap_dientich_3',
            'datngoaikhuonvien_tongiao_dacap_gcn_quyensudungdat_3',
        
            'datngoaikhuonvien_nnlnntts_dacap_dientich_3', 
            'datngoaikhuonvien_nnlnntts_chuacap_dientich_3',
            'datngoaikhuonvien_nnlnntts_dacap_gcn_quyensudungdat_3',
        
            'datngoaikhuonvien_gdyt_dacap_dientich_3', 
            'datngoaikhuonvien_gdyt_chuacap_dientich_3',
            'datngoaikhuonvien_gdyt_dacap_gcn_quyensudungdat_3',
            
            'datngoaikhuonvien_dsdmdk_dacap_dientich_3', 
            'datngoaikhuonvien_dsdmdk_chuacap_dientich_3',
            'datngoaikhuonvien_dsdmdk_dacap_gcn_quyensudungdat_3'
        ];
        $conditions = [
            'is_add' => 1,
        ];
        $data = $obj->find('all', array(
            'fields' => $field,
            'conditions' => $conditions
        ));

        $data = Hash::combine($data, '{n}.' . $model . '.id', '{n}.' . $model);

        if (!$update) {
            $this->log(print_r($data, true), $before_log);
        }

        $field = [
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
        ];

        $final = [];
        foreach ($data as $id => $target) {
            $tmp = [];
            foreach ($field as $k => $v) {
                $string = $target[$k];
                if ($string) {
                    $f = $v;
                    $result = $this->retrieveSumData($string, $f);
                    $tmp[$f] = $this->Utility->sumList($result);
                }
            }

            if ($tmp) {
                $final[$id] = array_merge(['id' => $id], $tmp);
            }
        }


        if ($update) {
            foreach ($final as $id => $item) {
                //    $obj->save($item);
            }
        } else {
            $this->log(print_r($final, true), $after_log);
        }

        $this->out('makeSum_cosohoigiaoislam');
    }

    public function makeSum_chihoitinhdocusiphatgiaovietnam($model, $update = false)
    {
        $after_log = "repair/sum/after/{$model}";
        $before_log = "repair/sum/before/{$model}";
        $track_log = "repair/sum/track/{$model}";

        $obj = ClassRegistry::init($model);
        $field = [
            'id',

            'dattrongkhuonvien_tongiao_dacap_dientich',
            'dattrongkhuonvien_tongiao_chuacap_dientich',
            'dattrongkhuonvien_tongiao_dacap_gcn_quyensudungdat',

            'dattrongkhuonvien_nnlnntts_dacap_dientich',
            'dattrongkhuonvien_nnlnntts_chuacap_dientich',
            'dattrongkhuonvien_nnlnntts_dacap_gcn_quyensudungdat',

            'dattrongkhuonvien_gdyt_dacap_dientich',
            'dattrongkhuonvien_gdyt_chuacap_dientich',
            'dattrongkhuonvien_gdyt_dacap_gcn_quyensudungdat',

            'dattrongkhuonvien_dsdmdk_dacap_dientich', 
            'dattrongkhuonvien_dsdmdk_chuacap_dientich',
            'dattrongkhuonvien_dsdmdk_dacap_gcn_quyensudungdat',
            
            'datngoaikhuonvien_tongiao_dacap_dientich_1', 
            'datngoaikhuonvien_tongiao_chuacap_dientich_1',
            'datngoaikhuonvien_tongiao_dacap_gcn_quyensudungdat_1',
        
            'datngoaikhuonvien_nnlnntts_dacap_dientich_1', 
            'datngoaikhuonvien_nnlnntts_chuacap_dientich_1',
            'datngoaikhuonvien_nnlnntts_dacap_gcn_quyensudungdat_1',
        
            'datngoaikhuonvien_gdyt_dacap_dientich_1', 
            'datngoaikhuonvien_gdyt_chuacap_dientich_1',
            'datngoaikhuonvien_gdyt_dacap_gcn_quyensudungdat_1',
        
            'datngoaikhuonvien_dsdmdk_dacap_dientich_1', 
            'datngoaikhuonvien_dsdmdk_chuacap_dientich_1',
            'datngoaikhuonvien_dsdmdk_dacap_gcn_quyensudungdat_1',
        
            'datngoaikhuonvien_tongiao_dacap_dientich_2', 
            'datngoaikhuonvien_tongiao_chuacap_dientich_2',
            'datngoaikhuonvien_tongiao_dacap_gcn_quyensudungdat_2',
        
            'datngoaikhuonvien_nnlnntts_dacap_dientich_2', 
            'datngoaikhuonvien_nnlnntts_chuacap_dientich_2',
            'datngoaikhuonvien_nnlnntts_dacap_gcn_quyensudungdat_2',
        
            'datngoaikhuonvien_gdyt_dacap_dientich_2', 
            'datngoaikhuonvien_gdyt_chuacap_dientich_2',
            'datngoaikhuonvien_gdyt_dacap_gcn_quyensudungdat_2',
        
            'datngoaikhuonvien_dsdmdk_dacap_dientich_2', 
            'datngoaikhuonvien_dsdmdk_chuacap_dientich_2',
            'datngoaikhuonvien_dsdmdk_dacap_gcn_quyensudungdat_2',
        
            'datngoaikhuonvien_tongiao_dacap_dientich_3', 
            'datngoaikhuonvien_tongiao_chuacap_dientich_3',
            'datngoaikhuonvien_tongiao_dacap_gcn_quyensudungdat_3',
        
            'datngoaikhuonvien_nnlnntts_dacap_dientich_3', 
            'datngoaikhuonvien_nnlnntts_chuacap_dientich_3',
            'datngoaikhuonvien_nnlnntts_dacap_gcn_quyensudungdat_3',
        
            'datngoaikhuonvien_gdyt_dacap_dientich_3', 
            'datngoaikhuonvien_gdyt_chuacap_dientich_3',
            'datngoaikhuonvien_gdyt_dacap_gcn_quyensudungdat_3',
            
            'datngoaikhuonvien_dsdmdk_dacap_dientich_3', 
            'datngoaikhuonvien_dsdmdk_chuacap_dientich_3',
            'datngoaikhuonvien_dsdmdk_dacap_gcn_quyensudungdat_3'
        ];
        $conditions = [
            'is_add' => 1,
        ];
        $data = $obj->find('all', array(
            'fields' => $field,
            'conditions' => $conditions
        ));

        $data = Hash::combine($data, '{n}.' . $model . '.id', '{n}.' . $model);

        if (!$update) {
            $this->log(print_r($data, true), $before_log);
        }

        $field = [
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
        ];

        $final = [];
        foreach ($data as $id => $target) {
            $tmp = [];
            foreach ($field as $k => $v) {
                $string = $target[$k];
                if ($string) {
                    $f = $v;
                    $result = $this->retrieveSumData($string, $f);
                    $tmp[$f] = $this->Utility->sumList($result);
                }
            }

            if ($tmp) {
                $final[$id] = array_merge(['id' => $id], $tmp);
            }
        }


        if ($update) {
            foreach ($final as $id => $item) {
                //    $obj->save($item);
            }
        } else {
            $this->log(print_r($final, true), $after_log);
        }

        $this->out('makeSum_chihoitinhdocusiphatgiaovietnam');
    }
    
    public function makeSum_hodaocaodai($model, $update = false)
    {
        $after_log = "repair/sum/after/{$model}";
        $before_log = "repair/sum/before/{$model}";
        $track_log = "repair/sum/track/{$model}";

        $obj = ClassRegistry::init($model);
        $field = [
            'id',

            'dattrongkhuonvien_tongiao_dacap_dientich',
            'dattrongkhuonvien_tongiao_chuacap_dientich',
            'dattrongkhuonvien_tongiao_dacap_gcn_quyensudungdat',

            'dattrongkhuonvien_nnlnntts_dacap_dientich',
            'dattrongkhuonvien_nnlnntts_chuacap_dientich',
            'dattrongkhuonvien_nnlnntts_dacap_gcn_quyensudungdat',

            'dattrongkhuonvien_gdyt_dacap_dientich',
            'dattrongkhuonvien_gdyt_chuacap_dientich',
            'dattrongkhuonvien_gdyt_dacap_gcn_quyensudungdat',

            'dattrongkhuonvien_dsdmdk_dacap_dientich', 
            'dattrongkhuonvien_dsdmdk_chuacap_dientich',
            'dattrongkhuonvien_dsdmdk_dacap_gcn_quyensudungdat',
            
            'datngoaikhuonvien_tongiao_dacap_dientich_1', 
            'datngoaikhuonvien_tongiao_chuacap_dientich_1',
            'datngoaikhuonvien_tongiao_dacap_gcn_quyensudungdat_1',
        
            'datngoaikhuonvien_nnlnntts_dacap_dientich_1', 
            'datngoaikhuonvien_nnlnntts_chuacap_dientich_1',
            'datngoaikhuonvien_nnlnntts_dacap_gcn_quyensudungdat_1',
        
            'datngoaikhuonvien_gdyt_dacap_dientich_1', 
            'datngoaikhuonvien_gdyt_chuacap_dientich_1',
            'datngoaikhuonvien_gdyt_dacap_gcn_quyensudungdat_1',
        
            'datngoaikhuonvien_dsdmdk_dacap_dientich_1', 
            'datngoaikhuonvien_dsdmdk_chuacap_dientich_1',
            'datngoaikhuonvien_dsdmdk_dacap_gcn_quyensudungdat_1',
        
            'datngoaikhuonvien_tongiao_dacap_dientich_2', 
            'datngoaikhuonvien_tongiao_chuacap_dientich_2',
            'datngoaikhuonvien_tongiao_dacap_gcn_quyensudungdat_2',
        
            'datngoaikhuonvien_nnlnntts_dacap_dientich_2', 
            'datngoaikhuonvien_nnlnntts_chuacap_dientich_2',
            'datngoaikhuonvien_nnlnntts_dacap_gcn_quyensudungdat_2',
        
            'datngoaikhuonvien_gdyt_dacap_dientich_2', 
            'datngoaikhuonvien_gdyt_chuacap_dientich_2',
            'datngoaikhuonvien_gdyt_dacap_gcn_quyensudungdat_2',
        
            'datngoaikhuonvien_dsdmdk_dacap_dientich_2', 
            'datngoaikhuonvien_dsdmdk_chuacap_dientich_2',
            'datngoaikhuonvien_dsdmdk_dacap_gcn_quyensudungdat_2',
        
            'datngoaikhuonvien_tongiao_dacap_dientich_3', 
            'datngoaikhuonvien_tongiao_chuacap_dientich_3',
            'datngoaikhuonvien_tongiao_dacap_gcn_quyensudungdat_3',
        
            'datngoaikhuonvien_nnlnntts_dacap_dientich_3', 
            'datngoaikhuonvien_nnlnntts_chuacap_dientich_3',
            'datngoaikhuonvien_nnlnntts_dacap_gcn_quyensudungdat_3',
        
            'datngoaikhuonvien_gdyt_dacap_dientich_3', 
            'datngoaikhuonvien_gdyt_chuacap_dientich_3',
            'datngoaikhuonvien_gdyt_dacap_gcn_quyensudungdat_3',
            
            'datngoaikhuonvien_dsdmdk_dacap_dientich_3', 
            'datngoaikhuonvien_dsdmdk_chuacap_dientich_3',
            'datngoaikhuonvien_dsdmdk_dacap_gcn_quyensudungdat_3'
        ];
        $conditions = [
            'is_add' => 1,
        ];
        $data = $obj->find('all', array(
            'fields' => $field,
            'conditions' => $conditions
        ));

        $data = Hash::combine($data, '{n}.' . $model . '.id', '{n}.' . $model);

        if (!$update) {
            $this->log(print_r($data, true), $before_log);
        }

        $field = [
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
        ];

        $final = [];
        foreach ($data as $id => $target) {
            $tmp = [];
            foreach ($field as $k => $v) {
                $string = $target[$k];
                if ($string) {
                    $f = $v;
                    $result = $this->retrieveSumData($string, $f);
                    $tmp[$f] = $this->Utility->sumList($result);
                }
            }

            if ($tmp) {
                $final[$id] = array_merge(['id' => $id], $tmp);
            }
        }


        if ($update) {
            foreach ($final as $id => $item) {
                //    $obj->save($item);
            }
        } else {
            $this->log(print_r($final, true), $after_log);
        }

        $this->out('makeSum_hodaocaodai');
    }
    
    public function makeSum_tuvienphatgiao($model, $update = false)
    {
        $after_log = "repair/sum/after/{$model}";
        $before_log = "repair/sum/before/{$model}";
        $track_log = "repair/sum/track/{$model}";

        $obj = ClassRegistry::init($model);
        $field = [
            'id',

            'dattrongkhuonvien_tongiao_dacap_dientich',
            'dattrongkhuonvien_tongiao_chuacap_dientich',
            'dattrongkhuonvien_tongiao_dacap_gcn_quyensudungdat',

            'dattrongkhuonvien_nnlnntts_dacap_dientich',
            'dattrongkhuonvien_nnlnntts_chuacap_dientich',
            'dattrongkhuonvien_nnlnntts_dacap_gcn_quyensudungdat',

            'dattrongkhuonvien_gdyt_dacap_dientich',
            'dattrongkhuonvien_gdyt_chuacap_dientich',
            'dattrongkhuonvien_gdyt_dacap_gcn_quyensudungdat',

            'dattrongkhuonvien_dsdmdk_dacap_dientich', 
            'dattrongkhuonvien_dsdmdk_chuacap_dientich',
            'dattrongkhuonvien_dsdmdk_dacap_gcn_quyensudungdat',
            
            'datngoaikhuonvien_tongiao_dacap_dientich_1', 
            'datngoaikhuonvien_tongiao_chuacap_dientich_1',
            'datngoaikhuonvien_tongiao_dacap_gcn_quyensudungdat_1',
        
            'datngoaikhuonvien_nnlnntts_dacap_dientich_1', 
            'datngoaikhuonvien_nnlnntts_chuacap_dientich_1',
            'datngoaikhuonvien_nnlnntts_dacap_gcn_quyensudungdat_1',
        
            'datngoaikhuonvien_gdyt_dacap_dientich_1', 
            'datngoaikhuonvien_gdyt_chuacap_dientich_1',
            'datngoaikhuonvien_gdyt_dacap_gcn_quyensudungdat_1',
        
            'datngoaikhuonvien_dsdmdk_dacap_dientich_1', 
            'datngoaikhuonvien_dsdmdk_chuacap_dientich_1',
            'datngoaikhuonvien_dsdmdk_dacap_gcn_quyensudungdat_1',
        
            'datngoaikhuonvien_tongiao_dacap_dientich_2', 
            'datngoaikhuonvien_tongiao_chuacap_dientich_2',
            'datngoaikhuonvien_tongiao_dacap_gcn_quyensudungdat_2',
        
            'datngoaikhuonvien_nnlnntts_dacap_dientich_2', 
            'datngoaikhuonvien_nnlnntts_chuacap_dientich_2',
            'datngoaikhuonvien_nnlnntts_dacap_gcn_quyensudungdat_2',
        
            'datngoaikhuonvien_gdyt_dacap_dientich_2', 
            'datngoaikhuonvien_gdyt_chuacap_dientich_2',
            'datngoaikhuonvien_gdyt_dacap_gcn_quyensudungdat_2',
        
            'datngoaikhuonvien_dsdmdk_dacap_dientich_2', 
            'datngoaikhuonvien_dsdmdk_chuacap_dientich_2',
            'datngoaikhuonvien_dsdmdk_dacap_gcn_quyensudungdat_2',
        
            'datngoaikhuonvien_tongiao_dacap_dientich_3', 
            'datngoaikhuonvien_tongiao_chuacap_dientich_3',
            'datngoaikhuonvien_tongiao_dacap_gcn_quyensudungdat_3',
        
            'datngoaikhuonvien_nnlnntts_dacap_dientich_3', 
            'datngoaikhuonvien_nnlnntts_chuacap_dientich_3',
            'datngoaikhuonvien_nnlnntts_dacap_gcn_quyensudungdat_3',
        
            'datngoaikhuonvien_gdyt_dacap_dientich_3', 
            'datngoaikhuonvien_gdyt_chuacap_dientich_3',
            'datngoaikhuonvien_gdyt_dacap_gcn_quyensudungdat_3',
            
            'datngoaikhuonvien_dsdmdk_dacap_dientich_3', 
            'datngoaikhuonvien_dsdmdk_chuacap_dientich_3',
            'datngoaikhuonvien_dsdmdk_dacap_gcn_quyensudungdat_3'
        ];
        $conditions = [
            'is_add' => 1,
        ];
        $data = $obj->find('all', array(
            'fields' => $field,
            'conditions' => $conditions
        ));

        $data = Hash::combine($data, '{n}.' . $model . '.id', '{n}.' . $model);

        if (!$update) {
            $this->log(print_r($data, true), $before_log);
        }

        $field = [
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
        ];

        $final = [];
        foreach ($data as $id => $target) {
            $tmp = [];
            foreach ($field as $k => $v) {
                $string = $target[$k];
                if ($string) {
                    $f = $v;
                    $result = $this->retrieveSumData($string, $f);
                    $tmp[$f] = $this->Utility->sumList($result);
                }
            }

            if ($tmp) {
                $final[$id] = array_merge(['id' => $id], $tmp);
            }
        }


        if ($update) {
            foreach ($final as $id => $item) {
                //    $obj->save($item);
            }
        } else {
            $this->log(print_r($final, true), $after_log);
        }

        $this->out('makeSum_tuvienphatgiao');
    }
    
    public function makeSum_dongtuconggiao($model, $update = false)
    {
        $after_log = "repair/sum/after/{$model}";
        $before_log = "repair/sum/before/{$model}";
        $track_log = "repair/sum/track/{$model}";

        $obj = ClassRegistry::init($model);
        $field = [
            'id',

            'dattrongkhuonvien_tongiao_dacap_dientich',
            'dattrongkhuonvien_tongiao_chuacap_dientich',
            'dattrongkhuonvien_tongiao_dacap_gcn_quyensudungdat',

            'dattrongkhuonvien_nnlnntts_dacap_dientich',
            'dattrongkhuonvien_nnlnntts_chuacap_dientich',
            'dattrongkhuonvien_nnlnntts_dacap_gcn_quyensudungdat',

            'dattrongkhuonvien_gdyt_dacap_dientich',
            'dattrongkhuonvien_gdyt_chuacap_dientich',
            'dattrongkhuonvien_gdyt_dacap_gcn_quyensudungdat',

            'dattrongkhuonvien_dsdmdk_dacap_dientich', 
            'dattrongkhuonvien_dsdmdk_chuacap_dientich',
            'dattrongkhuonvien_dsdmdk_dacap_gcn_quyensudungdat',
            
            'datngoaikhuonvien_tongiao_dacap_dientich_1', 
            'datngoaikhuonvien_tongiao_chuacap_dientich_1',
            'datngoaikhuonvien_tongiao_dacap_gcn_quyensudungdat_1',
        
            'datngoaikhuonvien_nnlnntts_dacap_dientich_1', 
            'datngoaikhuonvien_nnlnntts_chuacap_dientich_1',
            'datngoaikhuonvien_nnlnntts_dacap_gcn_quyensudungdat_1',
        
            'datngoaikhuonvien_gdyt_dacap_dientich_1', 
            'datngoaikhuonvien_gdyt_chuacap_dientich_1',
            'datngoaikhuonvien_gdyt_dacap_gcn_quyensudungdat_1',
        
            'datngoaikhuonvien_dsdmdk_dacap_dientich_1', 
            'datngoaikhuonvien_dsdmdk_chuacap_dientich_1',
            'datngoaikhuonvien_dsdmdk_dacap_gcn_quyensudungdat_1',
        
            'datngoaikhuonvien_tongiao_dacap_dientich_2', 
            'datngoaikhuonvien_tongiao_chuacap_dientich_2',
            'datngoaikhuonvien_tongiao_dacap_gcn_quyensudungdat_2',
        
            'datngoaikhuonvien_nnlnntts_dacap_dientich_2', 
            'datngoaikhuonvien_nnlnntts_chuacap_dientich_2',
            'datngoaikhuonvien_nnlnntts_dacap_gcn_quyensudungdat_2',
        
            'datngoaikhuonvien_gdyt_dacap_dientich_2', 
            'datngoaikhuonvien_gdyt_chuacap_dientich_2',
            'datngoaikhuonvien_gdyt_dacap_gcn_quyensudungdat_2',
        
            'datngoaikhuonvien_dsdmdk_dacap_dientich_2', 
            'datngoaikhuonvien_dsdmdk_chuacap_dientich_2',
            'datngoaikhuonvien_dsdmdk_dacap_gcn_quyensudungdat_2',
        
            'datngoaikhuonvien_tongiao_dacap_dientich_3', 
            'datngoaikhuonvien_tongiao_chuacap_dientich_3',
            'datngoaikhuonvien_tongiao_dacap_gcn_quyensudungdat_3',
        
            'datngoaikhuonvien_nnlnntts_dacap_dientich_3', 
            'datngoaikhuonvien_nnlnntts_chuacap_dientich_3',
            'datngoaikhuonvien_nnlnntts_dacap_gcn_quyensudungdat_3',
        
            'datngoaikhuonvien_gdyt_dacap_dientich_3', 
            'datngoaikhuonvien_gdyt_chuacap_dientich_3',
            'datngoaikhuonvien_gdyt_dacap_gcn_quyensudungdat_3',
            
            'datngoaikhuonvien_dsdmdk_dacap_dientich_3', 
            'datngoaikhuonvien_dsdmdk_chuacap_dientich_3',
            'datngoaikhuonvien_dsdmdk_dacap_gcn_quyensudungdat_3'
        ];
        $conditions = [
            'is_add' => 1,
        ];
        $data = $obj->find('all', array(
            'fields' => $field,
            'conditions' => $conditions
        ));

        $data = Hash::combine($data, '{n}.' . $model . '.id', '{n}.' . $model);

        if (!$update) {
            $this->log(print_r($data, true), $before_log);
        }

        $field = [
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
        ];

        $final = [];
        foreach ($data as $id => $target) {
            $tmp = [];
            foreach ($field as $k => $v) {
                $string = $target[$k];
                if ($string) {
                    $f = $v;
                    $result = $this->retrieveSumData($string, $f);
                    $tmp[$f] = $this->Utility->sumList($result);
                }
            }

            if ($tmp) {
                $final[$id] = array_merge(['id' => $id], $tmp);
            }
        }


        if ($update) {
            foreach ($final as $id => $item) {
                //    $obj->save($item);
            }
        } else {
            $this->log(print_r($final, true), $after_log);
        }

        $this->out('makeSum_dongtuconggiao');
    }
    
    public function makeSum_giaoxu($model, $update = false)
    {
        $after_log = "repair/sum/after/{$model}";
        $before_log = "repair/sum/before/{$model}";
        $track_log = "repair/sum/track/{$model}";

        $obj = ClassRegistry::init($model);
        $field = [
            'id',

            'dattrongkhuonvien_tongiao_dacap_dientich',
            'dattrongkhuonvien_tongiao_chuacap_dientich',
            'dattrongkhuonvien_tongiao_dacap_gcn_quyensudungdat',

            'dattrongkhuonvien_nnlnntts_dacap_dientich',
            'dattrongkhuonvien_nnlnntts_chuacap_dientich',
            'dattrongkhuonvien_nnlnntts_dacap_gcn_quyensudungdat',

            'dattrongkhuonvien_gdyt_dacap_dientich',
            'dattrongkhuonvien_gdyt_chuacap_dientich',
            'dattrongkhuonvien_gdyt_dacap_gcn_quyensudungdat',

            'dattrongkhuonvien_dsdmdk_dacap_dientich', 
            'dattrongkhuonvien_dsdmdk_chuacap_dientich',
            'dattrongkhuonvien_dsdmdk_dacap_gcn_quyensudungdat',
            
            'datngoaikhuonvien_tongiao_dacap_dientich_1', 
            'datngoaikhuonvien_tongiao_chuacap_dientich_1',
            'datngoaikhuonvien_tongiao_dacap_gcn_quyensudungdat_1',
        
            'datngoaikhuonvien_nnlnntts_dacap_dientich_1', 
            'datngoaikhuonvien_nnlnntts_chuacap_dientich_1',
            'datngoaikhuonvien_nnlnntts_dacap_gcn_quyensudungdat_1',
        
            'datngoaikhuonvien_gdyt_dacap_dientich_1', 
            'datngoaikhuonvien_gdyt_chuacap_dientich_1',
            'datngoaikhuonvien_gdyt_dacap_gcn_quyensudungdat_1',
        
            'datngoaikhuonvien_dsdmdk_dacap_dientich_1', 
            'datngoaikhuonvien_dsdmdk_chuacap_dientich_1',
            'datngoaikhuonvien_dsdmdk_dacap_gcn_quyensudungdat_1',
        
            'datngoaikhuonvien_tongiao_dacap_dientich_2', 
            'datngoaikhuonvien_tongiao_chuacap_dientich_2',
            'datngoaikhuonvien_tongiao_dacap_gcn_quyensudungdat_2',
        
            'datngoaikhuonvien_nnlnntts_dacap_dientich_2', 
            'datngoaikhuonvien_nnlnntts_chuacap_dientich_2',
            'datngoaikhuonvien_nnlnntts_dacap_gcn_quyensudungdat_2',
        
            'datngoaikhuonvien_gdyt_dacap_dientich_2', 
            'datngoaikhuonvien_gdyt_chuacap_dientich_2',
            'datngoaikhuonvien_gdyt_dacap_gcn_quyensudungdat_2',
        
            'datngoaikhuonvien_dsdmdk_dacap_dientich_2', 
            'datngoaikhuonvien_dsdmdk_chuacap_dientich_2',
            'datngoaikhuonvien_dsdmdk_dacap_gcn_quyensudungdat_2',
        
            'datngoaikhuonvien_tongiao_dacap_dientich_3', 
            'datngoaikhuonvien_tongiao_chuacap_dientich_3',
            'datngoaikhuonvien_tongiao_dacap_gcn_quyensudungdat_3',
        
            'datngoaikhuonvien_nnlnntts_dacap_dientich_3', 
            'datngoaikhuonvien_nnlnntts_chuacap_dientich_3',
            'datngoaikhuonvien_nnlnntts_dacap_gcn_quyensudungdat_3',
        
            'datngoaikhuonvien_gdyt_dacap_dientich_3', 
            'datngoaikhuonvien_gdyt_chuacap_dientich_3',
            'datngoaikhuonvien_gdyt_dacap_gcn_quyensudungdat_3',
            
            'datngoaikhuonvien_dsdmdk_dacap_dientich_3', 
            'datngoaikhuonvien_dsdmdk_chuacap_dientich_3',
            'datngoaikhuonvien_dsdmdk_dacap_gcn_quyensudungdat_3'
        ];
        $conditions = [
            'is_add' => 1,
        ];
        $data = $obj->find('all', array(
            'fields' => $field,
            'conditions' => $conditions
        ));

        $data = Hash::combine($data, '{n}.' . $model . '.id', '{n}.' . $model);

        if (!$update) {
            $this->log(print_r($data, true), $before_log);
        }

        $field = [
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
        ];

        $final = [];
        foreach ($data as $id => $target) {
            $tmp = [];
            foreach ($field as $k => $v) {
                $string = $target[$k];
                if ($string) {
                    $f = $v;
                    $result = $this->retrieveSumData($string, $f);
                    $tmp[$f] = $this->Utility->sumList($result);
                }
            }

            if ($tmp) {
                $final[$id] = array_merge(['id' => $id], $tmp);
            }
        }


        if ($update) {
            foreach ($final as $id => $item) {
                //    $obj->save($item);
            }
        } else {
            $this->log(print_r($final, true), $after_log);
        }

        $this->out('makeSum_giaoxu');
    }
    
    private function retrieveSumData($string, $keyword)
    {
        $list = explode(';', $string);

        $result = [];
        foreach ($list as $item) {
            $target = explode(',', $item);
            foreach ($target as $value) {
                $flag = strpos($value, $keyword) !== false;
                if ($flag) {
                    $value = str_replace($keyword, '', $value);
                    $value = str_replace(':', '', $value);
                    $value = str_replace('_', '', $value);

                    $result[] = $this->Utility->retrieveNumberFromString($value);
                }
            }
        }
        return $result;
    }









    public function format()
    {
        $model = [
            1 => 'Cosotinnguong',
            //'Diemnhomtinlanh',
            'Cosohoigiaoislam',
            'Hodaocaodai',
            'Chihoitinhdocusiphatgiaovietnam',
            //'Chihoitinlanh',
            'Dongtuconggiao',
            'Giaoxu',
            'Tuvienphatgiao'
        ];

        foreach ($model as $id => $name) {
            $this->out("{$id}: $name");
        }
        $this->out('99: All model');
        $in = '';
        while (!(int) $in) {
            $in = $this->in('Please chose model');
        }

        $this->out('Repairing ...');
        $collection = new ComponentCollection();
        $this->Utility = new UtilityComponent($collection);

        if ($in < 99) {
            $model = [$model[$in]];
        }
        foreach ($model as $name) {
            $this->makeFormat($name);
        }

        $in = '';
        while (!in_array($in, array('y', 'Y', 'n', 'N'))) {
            $in = $this->in('Are you sure to updating ? (y or n)');
        }
        if (mb_strtolower($in) == 'y') {
            $this->out('Executing update db');
            foreach ($model as $name) {
                $this->makeFormat($name, true);
            }
            $this->out('Finished updating db');
        }
        $this->out('Finished');
    }

    private function makeFormat($model = '', $update = false)
    {
        $after_log = "repair/format/after/{$model}";
        $before_log = "repair/format/before/{$model}";
        $track_log = "repair/format/track/{$model}";

        $field = $this->formatMapping($model);
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
            $this->log(print_r($data, true), $before_log);
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
                //$obj->save($item);
            }
        } else {
            $this->log(print_r($track, true), $track_log);
            $this->log(print_r($data, true), $after_log);
        }
    }

    private function formatMapping($model = '')
    {
        $model = mb_strtolower($model);

        if ($model == 'cosotinnguong') {
            return [
                'id', 'datdai_tongdientich',
                'tongiao_dientich',
                //'tongiao_chuacap_dientich',
                'nnlnntts_dientich',
                //'nnlnntts_chuacap_dientich',
                'gdyt_dientich',
                //'gdyt_chuacap_dientich',
                'dsdmdk_dientich',
                //'dsdmdk_chuacap_dientich'
            ];
        }

        if ($model == 'diemnhomtinlanh') {
            return [
                'id', 'tongdientichdat',
                'tongiao_dientich',
                //'tongiao_chuacap_dientich',
                'nnlnntts_dientich',
                //'nnlnntts_chuacap_dientich',
                'gdyt_dientich',
                //'gdyt_chuacap_dientich',
                'dsdmdk_dientich',
                //'dsdmdk_chuacap_dientich'
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
                /*dattrongkhuonvien*/
                'dattrongkhuonvien', 'datdai_tongdientich',
                //Tôn giáo
                'dattrongkhuonvien_tongiao_dientich',
                //'dattrongkhuonvien_tongiao_dacap_gcn_quyensudungdat',
                'dattrongkhuonvien_tongiao_dacap_dientich',
                //'dattrongkhuonvien_tongiao_chuacap_dientich',
                //Nông nghiệp, lâm nghiệp, nuôi trồng thủy sản
                'dattrongkhuonvien_nnlnntts_dientich',
                //'dattrongkhuonvien_nnlnntts_dacap_gcn_quyensudungdat',
                'dattrongkhuonvien_nnlnntts_dacap_dientich',
                //'dattrongkhuonvien_nnlnntts_chuacap_dientich',
                //Giáo dục, y tế
                'dattrongkhuonvien_gdyt_dientich',
                //'dattrongkhuonvien_gdyt_dacap_gcn_quyensudungdat',
                'dattrongkhuonvien_gdyt_dacap_dientich',
                //'dattrongkhuonvien_gdyt_chuacap_dientich',
                //Đất sử dụng mục đích khác
                'dattrongkhuonvien_dsdmdk_dientich',
                //'dattrongkhuonvien_dsdmdk_dacap_gcn_quyensudungdat',
                'dattrongkhuonvien_dsdmdk_dacap_dientich',
                //'dattrongkhuonvien_dsdmdk_chuacap_dientich',

                /*datngoaikhuonvien*/
                'datngoaikhuonvien',
                //(1)Tôn giáo
                'datngoaikhuonvien_tongiao_dientich_1',
                //'datngoaikhuonvien_tongiao_dacap_gcn_quyensudungdat_1',
                'datngoaikhuonvien_tongiao_dacap_dientich_1',
                //'datngoaikhuonvien_tongiao_chuacap_dientich_1',
                //(1)Nông nghiệp, lâm nghiệp, nuôi trồng thủy sản
                'datngoaikhuonvien_nnlnntts_dientich_1',
                //'datngoaikhuonvien_nnlnntts_dacap_gcn_quyensudungdat_1',
                'datngoaikhuonvien_nnlnntts_dacap_dientich_1',
                //'datngoaikhuonvien_nnlnntts_chuacap_dientich_1',
                //(1)Giáo dục, y tế
                'datngoaikhuonvien_gdyt_dientich_1',
                //'datngoaikhuonvien_gdyt_dacap_gcn_quyensudungdat_1',
                'datngoaikhuonvien_gdyt_dacap_dientich_1',
                //'datngoaikhuonvien_gdyt_chuacap_dientich_1',
                //(1)Đất sử dụng mục đích khác
                'datngoaikhuonvien_dsdmdk_dientich_1',
                //'datngoaikhuonvien_dsdmdk_dacap_gcn_quyensudungdat_1',
                'datngoaikhuonvien_dsdmdk_dacap_dientich_1',
                //'datngoaikhuonvien_dsdmdk_chuacap_dientich_1',

                //(2)Tôn giáo
                'datngoaikhuonvien_tongiao_dientich_2',
                //'datngoaikhuonvien_tongiao_dacap_gcn_quyensudungdat_2',
                'datngoaikhuonvien_tongiao_dacap_dientich_2',
                //'datngoaikhuonvien_tongiao_chuacap_dientich_2',
                //(2)Nông nghiệp, lâm nghiệp, nuôi trồng thủy sản
                'datngoaikhuonvien_nnlnntts_dientich_2',
                //'datngoaikhuonvien_nnlnntts_dacap_gcn_quyensudungdat_2',
                'datngoaikhuonvien_nnlnntts_dacap_dientich_2',
                //'datngoaikhuonvien_nnlnntts_chuacap_dientich_2',
                //(2)Giáo dục, y tế
                'datngoaikhuonvien_gdyt_dientich_2',
                //'datngoaikhuonvien_gdyt_dacap_gcn_quyensudungdat_2',
                'datngoaikhuonvien_gdyt_dacap_dientich_2',
                //'datngoaikhuonvien_gdyt_chuacap_dientich_2',
                //(2)Đất sử dụng mục đích khác
                'datngoaikhuonvien_dsdmdk_dientich_2',
                //'datngoaikhuonvien_dsdmdk_dacap_gcn_quyensudungdat_2',
                'datngoaikhuonvien_dsdmdk_dacap_dientich_2',
                //'datngoaikhuonvien_dsdmdk_chuacap_dientich_2',

                //(3)Tôn giáo
                'datngoaikhuonvien_tongiao_dientich_3',
                //'datngoaikhuonvien_tongiao_dacap_gcn_quyensudungdat_3',
                'datngoaikhuonvien_tongiao_dacap_dientich_3',
                //'datngoaikhuonvien_tongiao_chuacap_dientich_3',
                //(3)Nông nghiệp, lâm nghiệp, nuôi trồng thủy sản
                'datngoaikhuonvien_nnlnntts_dientich_3',
                //'datngoaikhuonvien_nnlnntts_dacap_gcn_quyensudungdat_3',
                'datngoaikhuonvien_nnlnntts_dacap_dientich_3',
                //'datngoaikhuonvien_nnlnntts_chuacap_dientich_3',
                //(3)Giáo dục, y tế
                'datngoaikhuonvien_gdyt_dientich_3',
                //'datngoaikhuonvien_gdyt_dacap_gcn_quyensudungdat_3',
                'datngoaikhuonvien_gdyt_dacap_dientich_3',
                //'datngoaikhuonvien_gdyt_chuacap_dientich_3',
                //(3)Đất sử dụng mục đích khác
                'datngoaikhuonvien_dsdmdk_dientich_3',
                //'datngoaikhuonvien_dsdmdk_dacap_gcn_quyensudungdat_3',
                'datngoaikhuonvien_dsdmdk_dacap_dientich_3',
                //'datngoaikhuonvien_dsdmdk_chuacap_dientich_3'
            ];
        }

        return [];
    }

    public function number()
    {
        $collection = new ComponentCollection();
        $this->Utility = new UtilityComponent($collection);


        /**
         * Cột tongiao_dacap_gcn_quyensudungdat có chứa tongiao_dacap_dientich
         * tongiao_gcn______:00543______,tongiao_cqc_nc______:UBND huyện Định Quán ngày 23/10/2002______,tongiao_dacap_dientich______:1397.8______,tongiao_dacap_to_thua______:Tờ 24, thửa 60
         *
         *
         * Cột nnlnntts_dacap_gcn_quyensudungdat có chứa nnlnntts_dacap_dientich
         * nnlnntts_gcn______:AL 932265______,nnlnntts_cqc_nc______:16/5/2012______,nnlnntts_dacap_dientich______:50200
         *
         *
         * Cột gdyt_dacap_gcn_quyensudungdat có chứa gdyt_dacap_dientich
         *
         *
         * Cột dsdmdk_dacap_gcn_quyensudungdat có chứa dsdmdk_dacap_dientich
         *
         *
         * Cột dattrongkhuonvien_tongiao_dacap_gcn_quyensudungdat có chứa dattrongkhuonvien_tongiao_dacap_dientich
         * dattrongkhuonvien_tongiao_gcn______:CT 07478 và CT 04777______,dattrongkhuonvien_tongiao_cqc_nc______:Sở TN & MT tỉnh Đồng Nai ______,dattrongkhuonvien_tongiao_dacap_dientich______:462.5 và 796.6______,dattrongkhuonvien_tongiao_dacap_to_thua______:tờ 93, thửa  135 và tờ 93, thửa 40
         *
         *
         * Cột dattrongkhuonvien_nnlnntts_dacap_gcn_quyensudungdat có chứa dattrongkhuonvien_nnlnntts_dacap_dientich
         * dattrongkhuonvien_nnlnntts_gcn______:AK 193338______,dattrongkhuonvien_nnlnntts_cqc_nc______:UBND thành phố Biên Hòa ngày 30/01/2008 cấp cho cá nhân bà Nguyễn Thị Thanh Hà______,dattrongkhuonvien_nnlnntts_dacap_dientich______:1001.4______,dattrongkhuonvien_nnlnntts_dacap_to_thua______:tờ 50, thửa 252
         *
         *
         * Cột dattrongkhuonvien_gdyt_dacap_gcn_quyensudungdat có chứa dattrongkhuonvien_gdyt_dacap_dientich
         * dattrongkhuonvien_gdyt_gcn______:S 1017______,dattrongkhuonvien_gdyt_cqc_nc______:UBND tỉnh Đồng Nai ngày 21/10/2010______,dattrongkhuonvien_gdyt_dacap_dientich______:260______,dattrongkhuonvien_gdyt_dacap_to_thua______:10, 639
         *
         *
         * Cột dattrongkhuonvien_dsdmdk_dacap_gcn_quyensudungdat có chứa dattrongkhuonvien_dsdmdk_dacap_dientich
         * dattrongkhuonvien_dsdmdk_gcn______:AB 603105______,dattrongkhuonvien_dsdmdk_cqc_nc______:UBND huyện Định Quán 27/6/2005______,dattrongkhuonvien_dsdmdk_dacap_dientich______:15020______,dattrongkhuonvien_dsdmdk_dacap_to_thua______:tờ 02 thửa 796
         *
         * Cột datngoaikhuonvien_tongiao_dacap_gcn_quyensudungdat_1 có chứa datngoaikhuonvien_tongiao_dacap_dientich_1
         * datngoaikhuonvien_tongiao_gcn_1______:CT 18862______,datngoaikhuonvien_tongiao_cqc_nc_1______:UBND tỉnh Đồng Nai ______,datngoaikhuonvien_tongiao_dacap_dientich_1______:3056.9______,datngoaikhuonvien_tongiao_dacap_to_thua_1______:tờ 14, thửa 24
         *
         *
         * Cột datngoaikhuonvien_nnlnntts_dacap_gcn_quyensudungdat_1 có chứa datngoaikhuonvien_nnlnntts_dacap_dientich_1
         * datngoaikhuonvien_nnlnntts_gcn_1______:AD 325550______,datngoaikhuonvien_nnlnntts_cqc_nc_1______:UBND huyện Long Thành, ngày 18/10/2005 ______,datngoaikhuonvien_nnlnntts_dacap_dientich_1______:938______,datngoaikhuonvien_nnlnntts_dacap_to_thua_1______:59, 273
         *
         * Cột datngoaikhuonvien_gdyt_dacap_gcn_quyensudungdat_1 có chứa datngoaikhuonvien_gdyt_dacap_dientich_1
         * datngoaikhuonvien_gdyt_gcn_1______:AH 250117______,datngoaikhuonvien_gdyt_cqc_nc_1______:UBND huyện Long Thành ______,datngoaikhuonvien_gdyt_dacap_dientich_1______:1720______,datngoaikhuonvien_gdyt_dacap_to_thua_1______:6, 525
         *
         *
         * Cột datngoaikhuonvien_dsdmdk_dacap_gcn_quyensudungdat_1 có chứa datngoaikhuonvien_dsdmdk_dacap_dientich_1
         * datngoaikhuonvien_dsdmdk_gcn_1______:AN 582114______,datngoaikhuonvien_dsdmdk_cqc_nc_1______:UBND tỉnh Đồng Nai cấp ngày 29/9/2008______,datngoaikhuonvien_dsdmdk_dacap_dientich_1______:3142______,datngoaikhuonvien_dsdmdk_dacap_to_thua_1______:27/116______;datngoaikhuonvien_dsdmdk_gcn_1______:AN 582115______,datngoaikhuonvien_dsdmdk_cqc_nc_1______:UBND tỉnh Đồng Nai cấp ngày 29/9/2008______,datngoaikhuonvien_dsdmdk_dacap_dientich_1______:15441.8______,datngoaikhuonvien_dsdmdk_dacap_to_thua_1______:27/133______;datngoaikhuonvien_dsdmdk_gcn_1______:AN 582117______,datngoaikhuonvien_dsdmdk_cqc_nc_1______:UBND tỉnh Đồng Nai cấp ngày 29/9/2008______,datngoaikhuonvien_dsdmdk_dacap_dientich_1______:5885.7______,datngoaikhuonvien_dsdmdk_dacap_to_thua_1______:27/132
         *
         *
         * Cột datngoaikhuonvien_tongiao_dacap_gcn_quyensudungdat_2 có chứa datngoaikhuonvien_tongiao_dacap_dientich_2
         * datngoaikhuonvien_tongiao_gcn_2______:011061______,datngoaikhuonvien_tongiao_cqc_nc_2______:03/12/2007______,datngoaikhuonvien_tongiao_dacap_dientich_2______:527,2______,datngoaikhuonvien_tongiao_dacap_to_thua_2______:tờ 05,  thửa 128
         *
         *
         * Cột datngoaikhuonvien_nnlnntts_dacap_gcn_quyensudungdat_2 có chứa datngoaikhuonvien_nnlnntts_dacap_dientich_2
         * datngoaikhuonvien_nnlnntts_gcn_2______:BD 223461______,datngoaikhuonvien_nnlnntts_cqc_nc_2______:UBND huyện Long Thành, ngày 07/02/2014______,datngoaikhuonvien_nnlnntts_dacap_dientich_2______:121______,datngoaikhuonvien_nnlnntts_dacap_to_thua_2______:09, 1460
         *
         *
         * Cột datngoaikhuonvien_gdyt_dacap_gcn_quyensudungdat_2 có chứa datngoaikhuonvien_gdyt_dacap_dientich_2
         *
         *
         * Cột datngoaikhuonvien_dsdmdk_dacap_gcn_quyensudungdat_2 có chứa datngoaikhuonvien_dsdmdk_dacap_dientich_2
         *
         *
         * Cột datngoaikhuonvien_tongiao_dacap_gcn_quyensudungdat_3 có chứa datngoaikhuonvien_tongiao_dacap_dientich_3
         *
         *
         * Cột datngoaikhuonvien_nnlnntts_dacap_gcn_quyensudungdat_3 có chứa datngoaikhuonvien_nnlnntts_dacap_dientich_3
         *
         *
         * Cột datngoaikhuonvien_gdyt_dacap_gcn_quyensudungdat_3 có chứa datngoaikhuonvien_gdyt_dacap_dientich_3
         *
         *
         * Cột datngoaikhuonvien_dsdmdk_dacap_gcn_quyensudungdat_3 có chứa datngoaikhuonvien_dsdmdk_dacap_dientich_3
         *
         */

        $arrays = array(
            'tongiao_dacap_gcn_quyensudungdat' => 'tongiao_dacap_dientich',
            'nnlnntts_dacap_gcn_quyensudungdat' => 'nnlnntts_dacap_dientich',
            'gdyt_dacap_gcn_quyensudungdat' => 'gdyt_dacap_dientich',
            'dsdmdk_dacap_gcn_quyensudungdat' => 'dsdmdk_dacap_dientich',
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

        );

        $string = [
            '1300',
            '1,300',
            '1,300,000',
            '1.300',
            '1.300.000',
            '1300,25',
            '1300.25',
            '1300.32',
            '1.300,25',
            '1,300.25',
            '900m2',
            '900 m2',
            'khoảng 900 m2',
            'khoang 900 m2',
            'chieu. chungtoi, 900m2',

            //'2000 + 1.637,8',       //Cosotinnguongs/add/352        datdai_tongdientich,tongiao_chuacap_dientich
            //'462.5 và 796.6',
            //'3142; 15441.8; 5885.7',
            '412.715',
            '947,2 m2',
            '606.5 m2',
            //'13461,5 m2; 1512 m2; 14383 m2; 571,5 m2',
            //'16983,3 (17163,3)',    //Hodaocaodais/add/22
            //'2047+16983,3 m2',
            //'1690 m2 + 217 m2',     //Hodaocaodais/add/24
            //'709, 7 m2 (đất họ đạo 357 m2)',    //Hodaocaodais/add/40       datngoaikhuonvien_dsdmdk_dientich_2
            //'mượn 25/1080 m2 (tờ 9, thửa 122)', //Hodaocaodais/add/47       datdai_tongdientich
            //'đát thánh thất là 1,209 m2; đất Điện thờ Phật mẫu: 1.078 m2',      //Hodaocaodais/add/21   datdai_tongdientich
            '13.700.4 m2',
            //'Đất ơ nông thôn 150 m2, đất trồng cây lâu năm',        //Chihoitinhdocusiphatgiaovietnams/add/5
            //'đất nông thôn 150 m2, đất trồng cây lâu năm 919 m2',   //Chihoitinhdocusiphatgiaovietnams/add/14
            '2.045,4m2',
            '58.411,3 m2',
            '1132 m2 đất lộ giới',
            //'638m2 thuộc tờ 30, thửa 603. 533m2 thuộc tờ 20, thửa 600. 2634 m2 thuộc tờ 30, thửa 602. 1576 m2 thuộc tờ 37, thửa 143'    //Tuvienphatgiaos/add/579
        ];
        foreach ($string as $id => $string) {
            $this->out($string);
            $this->out($this->Utility->retrieveNumberFromString($string));
            $this->out(' ');
        }
    }
}
