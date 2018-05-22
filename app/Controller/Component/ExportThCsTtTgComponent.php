<?php

class ExportThCsTtTgComponent extends Component
{
    public function __construct()
    {
        $this->index = 1;
    }

    public function export()
    {
        $groups = [
            // 'Giaoxu',
            'Tuvienphatgiao',
            // 'Chihoitinlanh',
            // 'Hodaocaodai',
            // 'Chihoitinhdocusiphatgiaovietnam',
            // 'Cosohoigiaoislam',
            // 'Cosotinnguong',
        ];

        $export = [];

        foreach ($groups as $field_index => $model) {
            $export = array_merge($export, $this->__getInfo($model));
        }

        return $export;
    }

    private function __formatStt($target, $model)
    {
        $index = $this->index;
        $this->index += 1;
        return $index;
    }

    public function __getGiaoxu($model) {
        $fields = [
            'id',
            'tengiaoxu',
            'diachi_so',
            'diachi_duong',
            'diachi_ap',
            'diachi_xa',
            'diachi_huyen',
            'diachi_tinh',
            'giaodan_sonhankhau',
            'giaodandantocthieuso_sonhankhau',
            'sotusi',
            'sothanhvientrongthuongvu',
            'namthanhlap',
            'namxaydungnhatho',
            'ttttcs_solan',
            'ttttcs_tongkinhphi',
            'dattrongkhuonvien_tongiao_dientich',
            'dattrongkhuonvien_tongiao_chuacap_dientich',
            'datngoaikhuonvien_tongiao_dientich_1',
            'datngoaikhuonvien_tongiao_chuacap_dientich_1',
            'datngoaikhuonvien_tongiao_dientich_2',
            'datngoaikhuonvien_tongiao_chuacap_dientich_2',
            'datngoaikhuonvien_tongiao_dientich_3',
            'datngoaikhuonvien_tongiao_chuacap_dientich_3',
            'dattrongkhuonvien_nnlnntts_dientich',
            'dattrongkhuonvien_nnlnntts_chuacap_dientich',
            'dattrongkhuonvien_gdyt_dientich',
            'dattrongkhuonvien_gdyt_chuacap_dientich',
            // 'dattrongkhuonvien_nghiadia_dientich',
            // 'dattrongkhuonvien_nghiadia_chuacap_dientich',
            'dattrongkhuonvien_dsdmdk_dientich',
            'dattrongkhuonvien_dsdmdk_chuacap_dientich',
            'datngoaikhuonvien_nnlnntts_dientich_1',
            'datngoaikhuonvien_nnlnntts_chuacap_dientich_1',
            'datngoaikhuonvien_gdyt_dientich_1',
            'datngoaikhuonvien_gdyt_chuacap_dientich_1',
            'datngoaikhuonvien_nghiadia_dientich_1',
            'datngoaikhuonvien_nghiadia_chuacap_dientich_1',
            'datngoaikhuonvien_dsdmdk_dientich_1',
            'datngoaikhuonvien_dsdmdk_chuacap_dientich_1',
            'datngoaikhuonvien_nnlnntts_dientich_2',
            'datngoaikhuonvien_nnlnntts_chuacap_dientich_2',
            'datngoaikhuonvien_gdyt_dientich_2',
            'datngoaikhuonvien_gdyt_chuacap_dientich_2',
            'datngoaikhuonvien_nghiadia_dientich_2',
            'datngoaikhuonvien_nghiadia_chuacap_dientich_2',
            'datngoaikhuonvien_dsdmdk_dientich_2',
            'datngoaikhuonvien_dsdmdk_chuacap_dientich_2',
            'datngoaikhuonvien_nnlnntts_dientich_3',
            'datngoaikhuonvien_nnlnntts_chuacap_dientich_3',
            'datngoaikhuonvien_gdyt_dientich_3',
            'datngoaikhuonvien_gdyt_chuacap_dientich_3',
            'datngoaikhuonvien_nghiadia_dientich_3',
            'datngoaikhuonvien_nghiadia_chuacap_dientich_3',
            'datngoaikhuonvien_dsdmdk_dientich_3',
            'datngoaikhuonvien_dsdmdk_chuacap_dientich_3',
            'dattrongkhuonvien_tongiao_chuacap_dientich',
            'dattrongkhuonvien_nnlnntts_chuacap_dientich',
            'dattrongkhuonvien_gdyt_chuacap_dientich',
            'dattrongkhuonvien_dsdmdk_chuacap_dientich',
            'datngoaikhuonvien_tongiao_chuacap_dientich_1',
            'datngoaikhuonvien_nnlnntts_chuacap_dientich_1',
            'datngoaikhuonvien_gdyt_chuacap_dientich_1',
            'datngoaikhuonvien_nghiadia_chuacap_dientich_1',
            'datngoaikhuonvien_dsdmdk_chuacap_dientich_1',
            'datngoaikhuonvien_tongiao_chuacap_dientich_2',
            'datngoaikhuonvien_nnlnntts_chuacap_dientich_2',
            'datngoaikhuonvien_gdyt_chuacap_dientich_2',
            'datngoaikhuonvien_nghiadia_chuacap_dientich_2',
            'datngoaikhuonvien_dsdmdk_chuacap_dientich_2',
            'datngoaikhuonvien_tongiao_chuacap_dientich_3',
            'datngoaikhuonvien_nnlnntts_chuacap_dientich_3',
            'datngoaikhuonvien_gdyt_chuacap_dientich_3',
            'datngoaikhuonvien_nghiadia_chuacap_dientich_3',
            'datngoaikhuonvien_dsdmdk_chuacap_dientich_3',
            'cosothotu_ditichlichsu',
            'cosothotu_ditichvanhoa',
            'cosothotu_ditichlichsuvanhoa',
            'cosothotu_ditichkientrucnghethuat',
            'cosothotu_ditichkhaoco',
            'cosothotu_captrunguong',
            'cosothotu_captinh'
        ];
        $conditions = [
            'tengiaoxu <> ""',
            'tengiaoxu IS NOT NULL',
        ];

        $data = $this->__getData($model, compact('fields', 'conditions'));
        $result = $this->__statis($data, $model);

        return $result;
    }

    public function __getTuvienphatgiao($model) {
        $fields = [
            'tentuvien',
            'diachi_so',
            'diachi_duong',
            'diachi_ap',
            'diachi_xa',
            'diachi_huyen',
            'diachi_tinh',
            'daquyy',
            'soluongtindo',
            'daquyy',
            'phattu_dantoc_thieuso',
            'sochucsac',
            'sotusi',
            'namthanhlap',
            'namxaydung',
            'ttttcs_solan',
            'ttttcs_tongkinhphi',
            'dattrongkhuonvien_nnlnntts_dientich',
            'dattrongkhuonvien_gdyt_dientich',
            'dattrongkhuonvien_dsdmdk_dientich',
            'datngoaikhuonvien_nnlnntts_dientich_1',
            'datngoaikhuonvien_gdyt_dientich_1',
            'datngoaikhuonvien_dsdmdk_dientich_1',
            'datngoaikhuonvien_nnlnntts_dientich_2',
            'datngoaikhuonvien_gdyt_dientich_2',
            'datngoaikhuonvien_dsdmdk_dientich_2',
            'datngoaikhuonvien_nnlnntts_dientich_3',
            'datngoaikhuonvien_gdyt_dientich_3',
            'datngoaikhuonvien_dsdmdk_dientich_3',
            'dattrongkhuonvien_nnlnntts_chuacap_dientich',
            'dattrongkhuonvien_gdyt_chuacap_dientich',
            'dattrongkhuonvien_dsdmdk_chuacap_dientich',
            'datngoaikhuonvien_nnlnntts_chuacap_dientich_1',
            'datngoaikhuonvien_gdyt_chuacap_dientich_1',
            'datngoaikhuonvien_dsdmdk_chuacap_dientich_1',
            'datngoaikhuonvien_nnlnntts_chuacap_dientich_2',
            'datngoaikhuonvien_gdyt_chuacap_dientich_2',
            'datngoaikhuonvien_dsdmdk_chuacap_dientich_2',
            'datngoaikhuonvien_nnlnntts_chuacap_dientich_3',
            'datngoaikhuonvien_gdyt_chuacap_dientich_3',
            'datngoaikhuonvien_dsdmdk_chuacap_dientich_3',
            'dattrongkhuonvien_nnlnntts_dientich',
            'dattrongkhuonvien_gdyt_dientich',
            'dattrongkhuonvien_dsdmdk_dientich',
            'datngoaikhuonvien_nnlnntts_dientich_1',
            'datngoaikhuonvien_gdyt_dientich_1',
            'datngoaikhuonvien_dsdmdk_dientich_1',
            'datngoaikhuonvien_nnlnntts_dientich_2',
            'datngoaikhuonvien_gdyt_dientich_2',
            'datngoaikhuonvien_dsdmdk_dientich_2',
            'datngoaikhuonvien_nnlnntts_dientich_3',
            'datngoaikhuonvien_gdyt_dientich_3',
            'datngoaikhuonvien_dsdmdk_dientich_3',
            'dattrongkhuonvien_nnlnntts_chuacap_dientich',
            'dattrongkhuonvien_dsdmdk_chuacap_dientich',
            'datngoaikhuonvien_nnlnntts_chuacap_dientich_1',
            'datngoaikhuonvien_dsdmdk_chuacap_dientich_1',
            'datngoaikhuonvien_nnlnntts_chuacap_dientich_2',
            'datngoaikhuonvien_gdyt_chuacap_dientich_2',
            'datngoaikhuonvien_dsdmdk_chuacap_dientich_3',
            'datngoaikhuonvien_nnlnntts_chuacap_dientich_3',
            'datngoaikhuonvien_gdyt_chuacap_dientich_3',
            'datngoaikhuonvien_dsdmdk_chuacap_dientich_3',
            'dattrongkhuonvien_tongiao_chuacap_dientich',
            'dattrongkhuonvien_nnlnntts_chuacap_dientich',
            'dattrongkhuonvien_gdyt_chuacap_dientich',
            'dattrongkhuonvien_dsdmdk_chuacap_dientich',
            'datngoaikhuonvien_tongiao_chuacap_dientich_1',
            'datngoaikhuonvien_nnlnntts_chuacap_dientich_1',
            'datngoaikhuonvien_gdyt_chuacap_dientich_1',
            'datngoaikhuonvien_dsdmdk_chuacap_dientich_1',
            'datngoaikhuonvien_tongiao_chuacap_dientich_2',
            'datngoaikhuonvien_nnlnntts_chuacap_dientich_2',
            'datngoaikhuonvien_gdyt_chuacap_dientich_2',
            'datngoaikhuonvien_dsdmdk_chuacap_dientich_2',
            'datngoaikhuonvien_tongiao_chuacap_dientich_3',
            'datngoaikhuonvien_nnlnntts_chuacap_dientich_3',
            'datngoaikhuonvien_gdyt_chuacap_dientich_3',
            'datngoaikhuonvien_dsdmdk_chuacap_dientich_3',
            'cosothotu_ditichlichsu',
            'cosothotu_ditichvanhoa',
            'cosothotu_ditichlichsuvanhoa',
            'cosothotu_ditichkientrucnghethuat',
            'cosothotu_ditichkhaoco',
            'cosothotu_captrunguong',
            'cosothotu_captinh'
        ];
        $conditions = [
            'tentuvien <> ""',
            'tentuvien IS NOT NULL',
        ];

        $data = $this->__getData($model, compact('fields', 'conditions'));
        return $this->__statis($data, $model);
    }

    private function __getInfo($model)
    {
        $fields = [
            'tencosothotu',
            'diachi',
            'thuoctochuctongiao',
            'tindodathuchiennghiletongiao',
            'tindochuathuchiennghiletongiao',
            'tindoladantocthieuso',
            'chucsac',
            'tusi',
            'chucsacladantocthieuso',
            'chucviec',
            'chucviecladantocthieuso',
            'namthanhlap',
            'namxaydung',
            'sotien',
            'solan',
            'sotienlancuoi',
            'dacapgcnqsddat_tongiao',
            'dacapgcnqsddat_khac',
            'chuacapgcnqsddat',
            'kientruc',
            'xephangditich',
            'capcongnhan',
        ];

        $result = [];
        $data = $this->__getData($model);

        foreach ($data as $target) {
            $tmp = [];
            foreach ($fields as $f) {
                $func = '__get' . ucfirst($f);
                $tmp[$f] = $this->$func($target, $model);
            }

            $result[] = $tmp;
        }

        return $result;
    }

    private function __getTencosothotu($data, $model)
    {
        switch ($model) {
            case 'Giaoxu':
                $field = 'tengiaoxu';
                break;
            case 'Tuvienphatgiao':
                $field = 'tentuvien';
                break;
            case 'Chihoitinlanh':
                $field = 'tenchihoi';
                break;
            case 'Hodaocaodai':
                $field = 'tenhodao';
                break;
            case 'Chihoitinhdocusiphatgiaovietnam':
                $field = 'tenchihoi';
                break;
            case 'Cosohoigiaoislam':
                $field = 'tenthanhduong';
                break;
            case 'Cosotinnguong':
                $field = 'tencoso';
                break;
        }

        return $data[$field] ?: '';
    }

    private function __getDiachi($target, $model)
    {
        $fields = [];
        switch ($model) {
            case 'Giaoxu':
            case 'Tuvienphatgiao':
                $prefix = 'diachi_';
                $fields = [
                    $prefix . 'so',
                    $prefix . 'duong',
                    $prefix . 'ap',
                    $prefix . 'xa',
                    $prefix . 'huyen',
                    $prefix . 'tinh',
                ];
                break;
            case 'Chihoitinlanh':
                $prefix = 'diachi_';
                $fields = [
                    $prefix . 'so',
                    $prefix . 'ap',
                    $prefix . 'xa',
                    $prefix . 'huyen',
                    $prefix . 'tinh',
                ];
                break;
            case 'Hodaocaodai':
                $prefix = 'tenhodao_diachi_';
                $fields = [
                    $prefix . 'so',
                    $prefix . 'duong',
                    $prefix . 'ap',
                    $prefix . 'xa',
                    $prefix . 'huyen',
                    $prefix . 'tinh',
                ];
                break;
            case 'Chihoitinhdocusiphatgiaovietnam':
                $prefix = 'tenchihoi_diachi_';
                $fields = [
                    $prefix . 'so',
                    $prefix . 'duong',
                    $prefix . 'ap',
                    $prefix . 'xa',
                    $prefix . 'huyen',
                    $prefix . 'tinh',
                ];
                break;
            case 'Cosohoigiaoislam':
                $prefix = 'tenthanhduong_diachi_';
                $fields = [
                    $prefix . 'so',
                    $prefix . 'duong',
                    $prefix . 'ap',
                    $prefix . 'xa',
                    $prefix . 'huyen',
                    $prefix . 'tinh',
                ];
                break;
            case 'Cosotinnguong':
                $prefix = 'diachi_';
                $fields = [
                    $prefix . 'so',
                    $prefix . 'duong',
                    $prefix . 'ap',
                    $prefix . 'xa',
                    $prefix . 'huyen',
                    $prefix . 'tinh',
                ];
                break;
        }

        $string = '';
        if ($fields) {
            foreach ($fields as $f) {
                if ($target[$f]) {
                    $string .= $target[$f] . ', ';
                }
            }
        }
        return trim($string, ', ');
    }


    private function __getThuoctochuctongiao($data, $model)
    {
        $string = '';
        switch ($model) {
            case 'Giaoxu':
                $string = 'Công Giáo';
                break;
            case 'Tuvienphatgiao':
                $string = 'Phật Giáo';
                break;
            case 'Chihoitinlanh':
                $string = 'Tin Lành';
                break;
            case 'Hodaocaodai':
                $string = 'Cao Đài';
                break;
            case 'Chihoitinhdocusiphatgiaovietnam':
                $string = 'Tịnh độ cư sĩ phật hội';
                break;
            case 'Cosohoigiaoislam':
                $string = 'Hồi Giáo';
                break;
            case 'Cosotinnguong':
                $string = 'Tín Ngưỡng';
                break;
        }
        return $string;
    }

    private function __getTindodathuchiennghiletongiao($data, $model)
    {
        switch($model) {
            case 'Giaoxu':
                $field = 'giaodan_sonhankhau';
                break;
            case 'Tuvienphatgiao':
                $field = 'daquyy';
                break;

        }
        return $field ? $data[$field] : 0;
    }

    private function __getTindochuathuchiennghiletongiao($data, $model)
    {
        $result = '';
        switch($model) {
            case 'Giaoxu':
                $result =0;
                break;
            case 'Tuvienphatgiao':
                $result = $data['soluongtindo'] - $data['daquyy'];
                break;
        }
        return $result;
    }

    private function __getTindoladantocthieuso($data, $model)
    {
        switch($model) {
            case 'Giaoxu':
                $result = $data['soluongtindo'];
                $field = 'giaodandantocthieuso_sonhankhau';
                break;
            case 'Tuvienphatgiao':
                $result = $data['soluongtindo'];
                $field = 'phattu_dantoc_thieuso';
                break;
        }
        return $field ? $data[$field] : 0;
    }

    private function __getChucsac($data, $model)
    {
        $result = '';
        switch($model) {
            case 'Giaoxu':
                break;
            case 'Tuvienphatgiao':
                $result = $data['sochucsac'];
                break;
        }
        return $result;
    }

    private function __getTusi($data, $model)
    {
        $result = '';
        switch($model) {
            case 'Giaoxu':
                $result = $data['sotusi'];
                break;
            case 'Tuvienphatgiao':
                $result = $data['sotusi'];
                break;
        }
        return $result;
    }

    private function __getChucsacladantocthieuso($data, $model)
    {
        $result = '';
        switch($model) {
            case 'Giaoxu':
            case 'Tuvienphatgiao':
                $result = 0;
                break;
        }
        return $result;
    }

    private function __getChucviec($data, $model)
    {
        $result = '';
        switch($model) {
            case 'Giaoxu':
                $result = $data['sothanhvientrongthuongvu'];
                break;
            case 'Tuvienphatgiao':
                $result = 0;
                break;
        }
        return $result;
    }

    private function __getChucviecladantocthieuso($data, $model)
    {
        $result = '';
        switch($model) {
            case 'Giaoxu':
            case 'Tuvienphatgiao':
                $result = 0;
                break;
        }
        return $result;
    }

    private function __getNamthanhlap($data, $model)
    {
        $result = '';
        switch($model) {
            case 'Giaoxu':
            case 'Tuvienphatgiao':
                $result = $data['namthanhlap'];
                break;
        }
        return $result;
    }

    private function __getNamxaydung($data, $model)
    {
        $result = '';
        switch($model) {
            case 'Giaoxu':
                $result = $data['namxaydungnhatho'];
                break;
            case 'Tuvienphatgiao':
                $result = $data['namxaydung'];
                break;
        }
        return $result;
    }

    private function __getSotien($data, $model)
    {
        $result = '';
        switch($model) {
            case 'Giaoxu':
            case 'Tuvienphatgiao':
                $result = 0;
                break;
        }
        return $result;
    }

    private function __getSolan($data, $model)
    {
        $result = '';
        switch($model) {
            case 'Giaoxu':
                $result = $data['ttttcs_solan'];
                break;
            case 'Tuvienphatgiao':
                $result = $data['ttttcs_solan'];
                break;
        }
        return $result;
    }

    private function __getSotienlancuoi($data, $model)
    {
        $result = '';
        switch($model) {
            case 'Giaoxu':
                $result = $data['ttttcs_tongkinhphi'];
                break;
            case 'Tuvienphatgiao':
                $result = $data['ttttcs_tongkinhphi'];
                break;
        }
        return $result;
    }

    private function __getDacapgcnqsddat_tongiao($data, $model)
    {
        switch($model) {
            case 'Giaoxu':
                $field1 = [
                    'dattrongkhuonvien_tongiao_dientich',
                    'datngoaikhuonvien_tongiao_dientich_1',
                    'datngoaikhuonvien_tongiao_dientich_2',
                    'datngoaikhuonvien_tongiao_dientich_3',
                ];
                $field2 = [
                    'dattrongkhuonvien_tongiao_chuacap_dientich',
                    'datngoaikhuonvien_tongiao_chuacap_dientich_1',
                    'datngoaikhuonvien_tongiao_chuacap_dientich_2',
                    'datngoaikhuonvien_tongiao_chuacap_dientich_3',
                ];
                break;
            case 'Tuvienphatgiao':
                $field1 = [
                    'dattrongkhuonvien_nnlnntts_dientich',
                    'dattrongkhuonvien_gdyt_dientich',
                    'dattrongkhuonvien_dsdmdk_dientich',
                    'datngoaikhuonvien_nnlnntts_dientich_1',
                    'datngoaikhuonvien_gdyt_dientich_1',
                    'datngoaikhuonvien_dsdmdk_dientich_1',
                    'datngoaikhuonvien_nnlnntts_dientich_2',
                    'datngoaikhuonvien_gdyt_dientich_2',
                    'datngoaikhuonvien_dsdmdk_dientich_2',
                    'datngoaikhuonvien_nnlnntts_dientich_3',
                    'datngoaikhuonvien_gdyt_dientich_3',
                    'datngoaikhuonvien_dsdmdk_dientich_3',
                ];
                $field2 = [
                    'dattrongkhuonvien_nnlnntts_chuacap_dientich',
                    'dattrongkhuonvien_gdyt_chuacap_dientich',
                    'dattrongkhuonvien_dsdmdk_chuacap_dientich',
                    'datngoaikhuonvien_nnlnntts_chuacap_dientich_1',
                    'datngoaikhuonvien_gdyt_chuacap_dientich_1',
                    'datngoaikhuonvien_dsdmdk_chuacap_dientich_1',
                    'datngoaikhuonvien_nnlnntts_chuacap_dientich_2',
                    'datngoaikhuonvien_gdyt_chuacap_dientich_2',
                    'datngoaikhuonvien_dsdmdk_chuacap_dientich_2',
                    'datngoaikhuonvien_nnlnntts_chuacap_dientich_3',
                    'datngoaikhuonvien_gdyt_chuacap_dientich_3',
                    'datngoaikhuonvien_dsdmdk_chuacap_dientich_3',
                ];
                break;
        }

        $result = 0;
        foreach($field1 as $f) {
            $result += intval($data[$f]);
        }
        foreach($field2 as $f) {
            $result -= intval($data[$f]);
        }

        return ($result > 0) ? $result : 0;
    }

    private function __getDacapgcnqsddat_khac($data, $model)
    {
        switch($model) {
            case 'Giaoxu':
                $field1 = [
                    'dattrongkhuonvien_nnlnntts_dientich',
                    'dattrongkhuonvien_gdyt_dientich',
                    // 'dattrongkhuonvien_nghiadia_dientich',
                    'dattrongkhuonvien_dsdmdk_dientich',
                    'datngoaikhuonvien_nnlnntts_dientich_1',
                    'datngoaikhuonvien_gdyt_dientich_1',
                    'datngoaikhuonvien_nghiadia_dientich_1',
                    'datngoaikhuonvien_dsdmdk_dientich_1',
                    'datngoaikhuonvien_nnlnntts_dientich_2',
                    'datngoaikhuonvien_gdyt_dientich_2',
                    'datngoaikhuonvien_nghiadia_dientich_2',
                    'datngoaikhuonvien_dsdmdk_dientich_2',
                    'datngoaikhuonvien_nnlnntts_dientich_3',
                    'datngoaikhuonvien_gdyt_dientich_3',
                    'datngoaikhuonvien_nghiadia_dientich_3',
                    'datngoaikhuonvien_dsdmdk_dientich_3',
                ];
                $field2 = [
                    'dattrongkhuonvien_nnlnntts_chuacap_dientich',
                    'dattrongkhuonvien_gdyt_chuacap_dientich',
                    // 'dattrongkhuonvien_nghiadia_chuacap_dientich',
                    'dattrongkhuonvien_dsdmdk_chuacap_dientich',
                    'datngoaikhuonvien_nnlnntts_chuacap_dientich_1',
                    'datngoaikhuonvien_gdyt_chuacap_dientich_1',
                    'datngoaikhuonvien_nghiadia_chuacap_dientich_1',
                    'datngoaikhuonvien_dsdmdk_chuacap_dientich_1',
                    'datngoaikhuonvien_nnlnntts_chuacap_dientich_2',
                    'datngoaikhuonvien_gdyt_chuacap_dientich_2',
                    'datngoaikhuonvien_nghiadia_chuacap_dientich_2',
                    'datngoaikhuonvien_dsdmdk_chuacap_dientich_2',
                    'datngoaikhuonvien_nnlnntts_chuacap_dientich_3',
                    'datngoaikhuonvien_gdyt_chuacap_dientich_3',
                    'datngoaikhuonvien_nghiadia_chuacap_dientich_3',
                    'datngoaikhuonvien_dsdmdk_chuacap_dientich_3',
                ];
                break;
            case 'Tuvienphatgiao':
                $field1 = [
                    'dattrongkhuonvien_nnlnntts_dientich',
                    'dattrongkhuonvien_gdyt_dientich',
                    'dattrongkhuonvien_dsdmdk_dientich',
                    'datngoaikhuonvien_nnlnntts_dientich_1',
                    'datngoaikhuonvien_gdyt_dientich_1',
                    'datngoaikhuonvien_dsdmdk_dientich_1',
                    'datngoaikhuonvien_nnlnntts_dientich_2',
                    'datngoaikhuonvien_gdyt_dientich_2',
                    'datngoaikhuonvien_dsdmdk_dientich_2',
                    'datngoaikhuonvien_nnlnntts_dientich_3',
                    'datngoaikhuonvien_gdyt_dientich_3',
                    'datngoaikhuonvien_dsdmdk_dientich_3',
                ];
                $field2 = [
                    'dattrongkhuonvien_nnlnntts_chuacap_dientich',
                    'dattrongkhuonvien_gdyt_chuacap_dientich',
                    'dattrongkhuonvien_dsdmdk_chuacap_dientich',
                    'datngoaikhuonvien_nnlnntts_chuacap_dientich_1',
                    'datngoaikhuonvien_gdyt_chuacap_dientich_1',
                    'datngoaikhuonvien_dsdmdk_chuacap_dientich_1',
                    'datngoaikhuonvien_nnlnntts_chuacap_dientich_2',
                    'datngoaikhuonvien_gdyt_chuacap_dientich_2',
                    'datngoaikhuonvien_dsdmdk_chuacap_dientich_2',
                    'datngoaikhuonvien_nnlnntts_chuacap_dientich_3',
                    'datngoaikhuonvien_gdyt_chuacap_dientich_3',
                    'datngoaikhuonvien_dsdmdk_chuacap_dientich_3',
                ];
                break;
        }

        $result = 0;
        foreach($field1 as $f) {
            $result += intval($data[$f]);
        }
        foreach($field2 as $f) {
            $result -= intval($data[$f]);
        }

        return ($result > 0) ? $result : 0;
    }

    private function __getChuacapgcnqsddat($data, $model)
    {
        switch($model) {
            case 'Giaoxu':
                $field = [
                    'dattrongkhuonvien_tongiao_chuacap_dientich',
                    'dattrongkhuonvien_nnlnntts_chuacap_dientich',
                    'dattrongkhuonvien_gdyt_chuacap_dientich',
                    // 'dattrongkhuonvien_nghiadia_chuacap_dientich',
                    'dattrongkhuonvien_dsdmdk_chuacap_dientich',
                    'datngoaikhuonvien_tongiao_chuacap_dientich_1',
                    'datngoaikhuonvien_nnlnntts_chuacap_dientich_1',
                    'datngoaikhuonvien_gdyt_chuacap_dientich_1',
                    'datngoaikhuonvien_nghiadia_chuacap_dientich_1',
                    'datngoaikhuonvien_dsdmdk_chuacap_dientich_1',
                    'datngoaikhuonvien_tongiao_chuacap_dientich_2',
                    'datngoaikhuonvien_nnlnntts_chuacap_dientich_2',
                    'datngoaikhuonvien_gdyt_chuacap_dientich_2',
                    'datngoaikhuonvien_nghiadia_chuacap_dientich_2',
                    'datngoaikhuonvien_dsdmdk_chuacap_dientich_2',
                    'datngoaikhuonvien_tongiao_chuacap_dientich_3',
                    'datngoaikhuonvien_nnlnntts_chuacap_dientich_3',
                    'datngoaikhuonvien_gdyt_chuacap_dientich_3',
                    'datngoaikhuonvien_nghiadia_chuacap_dientich_3',
                    'datngoaikhuonvien_dsdmdk_chuacap_dientich_3'
                ];
                break;
            case 'Tuvienphatgiao':
                $field = [
                    'dattrongkhuonvien_tongiao_chuacap_dientich',
                    'dattrongkhuonvien_nnlnntts_chuacap_dientich',
                    'dattrongkhuonvien_gdyt_chuacap_dientich',
                    'dattrongkhuonvien_dsdmdk_chuacap_dientich',
                    'datngoaikhuonvien_tongiao_chuacap_dientich_1',
                    'datngoaikhuonvien_nnlnntts_chuacap_dientich_1',
                    'datngoaikhuonvien_gdyt_chuacap_dientich_1',
                    'datngoaikhuonvien_dsdmdk_chuacap_dientich_1',
                    'datngoaikhuonvien_tongiao_chuacap_dientich_2',
                    'datngoaikhuonvien_nnlnntts_chuacap_dientich_2',
                    'datngoaikhuonvien_gdyt_chuacap_dientich_2',
                    'datngoaikhuonvien_dsdmdk_chuacap_dientich_2',
                    'datngoaikhuonvien_tongiao_chuacap_dientich_3',
                    'datngoaikhuonvien_nnlnntts_chuacap_dientich_3',
                    'datngoaikhuonvien_gdyt_chuacap_dientich_3',
                    'datngoaikhuonvien_dsdmdk_chuacap_dientich_3',
                ];
                break;
        }

        $result = 0;
        foreach($field as $f) {
            $result += intval($data[$f]);
        }

        return $result;
    }

    private function __getKientruc($data, $model)
    {
        $result = '';
        switch($model) {
            case 'Giaoxu':
                break;
            case 'Tuvienphatgiao':
                $result = $data['ttttcs_solan'];
                break;
        }
        return $result;
    }

    private function __getXephangditich($data, $model)
    {
        $mode = [
            "cosothotu_ditichlichsu" => "Di tích lịch sử'",
            "cosothotu_ditichvanhoa" => "Di tích văn hóa",
            "cosothotu_ditichlichsuvanhoa" => "Di tích lịch sử văn hóa",
            "cosothotu_ditichkientrucnghethuat" => "Di tích kiến trúc nghệ thuật",
            "cosothotu_ditichkhaoco" => "Di tích khảo cổ'",
        ];

        foreach($mode as $f => $name) {
            if (!empty($data[$f])) {
                return $name;
            }
        }

        return '';
    }

    private function __getCapcongnhan($data, $model)
    {
        $mode = [
            "cosothotu_captrunguong" => "Cấp Trung ương",
            "cosothotu_captinh" => "Cấp tỉnh",
        ];

        foreach($mode as $f => $name) {
            if (!empty($data[$f])) {
                return $name;
            }
        }

        return '';
    }

    private function __getGiaoxuParams()
    {
        $location = 'tengiaoxu';
        $prefix = 'diachi_';
        $fields = [
            'id',
            $location,
            $prefix . 'so',
            $prefix . 'duong',
            $prefix . 'ap',
            $prefix . 'xa',
            $prefix . 'huyen',
            $prefix . 'tinh',
            'giaodan_sonhankhau',
            'giaodandantocthieuso_sonhankhau',
            'sotusi',
            'sothanhvientrongthuongvu',
            'namthanhlap',
            'namxaydungnhatho',
            'ttttcs_solan',
            'ttttcs_tongkinhphi',
            'dattrongkhuonvien_tongiao_dientich',
            'dattrongkhuonvien_tongiao_chuacap_dientich',
            'datngoaikhuonvien_tongiao_dientich_1',
            'datngoaikhuonvien_tongiao_chuacap_dientich_1',
            'datngoaikhuonvien_tongiao_dientich_2',
            'datngoaikhuonvien_tongiao_chuacap_dientich_2',
            'datngoaikhuonvien_tongiao_dientich_3',
            'datngoaikhuonvien_tongiao_chuacap_dientich_3',
            'dattrongkhuonvien_nnlnntts_dientich',
            'dattrongkhuonvien_nnlnntts_chuacap_dientich',
            'dattrongkhuonvien_gdyt_dientich',
            'dattrongkhuonvien_gdyt_chuacap_dientich',
            // 'dattrongkhuonvien_nghiadia_dientich',
            // 'dattrongkhuonvien_nghiadia_chuacap_dientich',
            'dattrongkhuonvien_dsdmdk_dientich',
            'dattrongkhuonvien_dsdmdk_chuacap_dientich',
            'datngoaikhuonvien_nnlnntts_dientich_1',
            'datngoaikhuonvien_nnlnntts_chuacap_dientich_1',
            'datngoaikhuonvien_gdyt_dientich_1',
            'datngoaikhuonvien_gdyt_chuacap_dientich_1',
            'datngoaikhuonvien_nghiadia_dientich_1',
            'datngoaikhuonvien_nghiadia_chuacap_dientich_1',
            'datngoaikhuonvien_dsdmdk_dientich_1',
            'datngoaikhuonvien_dsdmdk_chuacap_dientich_1',
            'datngoaikhuonvien_nnlnntts_dientich_2',
            'datngoaikhuonvien_nnlnntts_chuacap_dientich_2',
            'datngoaikhuonvien_gdyt_dientich_2',
            'datngoaikhuonvien_gdyt_chuacap_dientich_2',
            'datngoaikhuonvien_nghiadia_dientich_2',
            'datngoaikhuonvien_nghiadia_chuacap_dientich_2',
            'datngoaikhuonvien_dsdmdk_dientich_2',
            'datngoaikhuonvien_dsdmdk_chuacap_dientich_2',
            'datngoaikhuonvien_nnlnntts_dientich_3',
            'datngoaikhuonvien_nnlnntts_chuacap_dientich_3',
            'datngoaikhuonvien_gdyt_dientich_3',
            'datngoaikhuonvien_gdyt_chuacap_dientich_3',
            'datngoaikhuonvien_nghiadia_dientich_3',
            'datngoaikhuonvien_nghiadia_chuacap_dientich_3',
            'datngoaikhuonvien_dsdmdk_dientich_3',
            'datngoaikhuonvien_dsdmdk_chuacap_dientich_3',
            'dattrongkhuonvien_tongiao_chuacap_dientich',
            'dattrongkhuonvien_nnlnntts_chuacap_dientich',
            'dattrongkhuonvien_gdyt_chuacap_dientich',
            'dattrongkhuonvien_dsdmdk_chuacap_dientich',
            'datngoaikhuonvien_tongiao_chuacap_dientich_1',
            'datngoaikhuonvien_nnlnntts_chuacap_dientich_1',
            'datngoaikhuonvien_gdyt_chuacap_dientich_1',
            'datngoaikhuonvien_nghiadia_chuacap_dientich_1',
            'datngoaikhuonvien_dsdmdk_chuacap_dientich_1',
            'datngoaikhuonvien_tongiao_chuacap_dientich_2',
            'datngoaikhuonvien_nnlnntts_chuacap_dientich_2',
            'datngoaikhuonvien_gdyt_chuacap_dientich_2',
            'datngoaikhuonvien_nghiadia_chuacap_dientich_2',
            'datngoaikhuonvien_dsdmdk_chuacap_dientich_2',
            'datngoaikhuonvien_tongiao_chuacap_dientich_3',
            'datngoaikhuonvien_nnlnntts_chuacap_dientich_3',
            'datngoaikhuonvien_gdyt_chuacap_dientich_3',
            'datngoaikhuonvien_nghiadia_chuacap_dientich_3',
            'datngoaikhuonvien_dsdmdk_chuacap_dientich_3',
            'cosothotu_ditichlichsu',
            'cosothotu_ditichvanhoa',
            'cosothotu_ditichlichsuvanhoa',
            'cosothotu_ditichkientrucnghethuat',
            'cosothotu_ditichkhaoco',
            'cosothotu_captrunguong',
            'cosothotu_captinh'
        ];
        $conditions = [
            $location . ' <>' => '',
            $location . ' is not null',
        ];

        return compact('fields', 'conditions');
    }

    private function __getTuvienphatgiaoParams()
    {
        $location = 'tentuvien';
        $prefix = 'diachi_';
        $fields = [
            'id',
            $location,
            $prefix . 'so',
            $prefix . 'duong',
            $prefix . 'ap',
            $prefix . 'xa',
            $prefix . 'huyen',
            $prefix . 'tinh',
            'daquyy',
            'soluongtindo',
            'daquyy',
            'phattu_dantoc_thieuso',
            'sochucsac',
            'sotusi',
            'namthanhlap',
            'namxaydung',
            'ttttcs_solan',
            'ttttcs_tongkinhphi',
            'dattrongkhuonvien_nnlnntts_dientich',
            'dattrongkhuonvien_gdyt_dientich',
            'dattrongkhuonvien_dsdmdk_dientich',
            'datngoaikhuonvien_nnlnntts_dientich_1',
            'datngoaikhuonvien_gdyt_dientich_1',
            'datngoaikhuonvien_dsdmdk_dientich_1',
            'datngoaikhuonvien_nnlnntts_dientich_2',
            'datngoaikhuonvien_gdyt_dientich_2',
            'datngoaikhuonvien_dsdmdk_dientich_2',
            'datngoaikhuonvien_nnlnntts_dientich_3',
            'datngoaikhuonvien_gdyt_dientich_3',
            'datngoaikhuonvien_dsdmdk_dientich_3',
            'dattrongkhuonvien_nnlnntts_chuacap_dientich',
            'dattrongkhuonvien_gdyt_chuacap_dientich',
            'dattrongkhuonvien_dsdmdk_chuacap_dientich',
            'datngoaikhuonvien_nnlnntts_chuacap_dientich_1',
            'datngoaikhuonvien_gdyt_chuacap_dientich_1',
            'datngoaikhuonvien_dsdmdk_chuacap_dientich_1',
            'datngoaikhuonvien_nnlnntts_chuacap_dientich_2',
            'datngoaikhuonvien_gdyt_chuacap_dientich_2',
            'datngoaikhuonvien_dsdmdk_chuacap_dientich_2',
            'datngoaikhuonvien_nnlnntts_chuacap_dientich_3',
            'datngoaikhuonvien_gdyt_chuacap_dientich_3',
            'datngoaikhuonvien_dsdmdk_chuacap_dientich_3',
            'dattrongkhuonvien_nnlnntts_dientich',
            'dattrongkhuonvien_gdyt_dientich',
            'dattrongkhuonvien_dsdmdk_dientich',
            'datngoaikhuonvien_nnlnntts_dientich_1',
            'datngoaikhuonvien_gdyt_dientich_1',
            'datngoaikhuonvien_dsdmdk_dientich_1',
            'datngoaikhuonvien_nnlnntts_dientich_2',
            'datngoaikhuonvien_gdyt_dientich_2',
            'datngoaikhuonvien_dsdmdk_dientich_2',
            'datngoaikhuonvien_nnlnntts_dientich_3',
            'datngoaikhuonvien_gdyt_dientich_3',
            'datngoaikhuonvien_dsdmdk_dientich_3',
            'dattrongkhuonvien_nnlnntts_chuacap_dientich',
            'dattrongkhuonvien_gdyt_chuacap_dientich',
            'dattrongkhuonvien_dsdmdk_chuacap_dientich',
            'datngoaikhuonvien_nnlnntts_chuacap_dientich_1',
            'datngoaikhuonvien_gdyt_chuacap_dientich_1',
            'datngoaikhuonvien_dsdmdk_chuacap_dientich_1',
            'datngoaikhuonvien_nnlnntts_chuacap_dientich_2',
            'datngoaikhuonvien_gdyt_chuacap_dientich_2',
            'datngoaikhuonvien_dsdmdk_chuacap_dientich_2',
            'datngoaikhuonvien_nnlnntts_chuacap_dientich_3',
            'datngoaikhuonvien_gdyt_chuacap_dientich_3',
            'datngoaikhuonvien_dsdmdk_chuacap_dientich_3',
            'dattrongkhuonvien_tongiao_chuacap_dientich',
            'dattrongkhuonvien_nnlnntts_chuacap_dientich',
            'dattrongkhuonvien_gdyt_chuacap_dientich',
            'dattrongkhuonvien_dsdmdk_chuacap_dientich',
            'datngoaikhuonvien_tongiao_chuacap_dientich_1',
            'datngoaikhuonvien_nnlnntts_chuacap_dientich_1',
            'datngoaikhuonvien_gdyt_chuacap_dientich_1',
            'datngoaikhuonvien_dsdmdk_chuacap_dientich_1',
            'datngoaikhuonvien_tongiao_chuacap_dientich_2',
            'datngoaikhuonvien_nnlnntts_chuacap_dientich_2',
            'datngoaikhuonvien_gdyt_chuacap_dientich_2',
            'datngoaikhuonvien_dsdmdk_chuacap_dientich_2',
            'datngoaikhuonvien_tongiao_chuacap_dientich_3',
            'datngoaikhuonvien_nnlnntts_chuacap_dientich_3',
            'datngoaikhuonvien_gdyt_chuacap_dientich_3',
            'datngoaikhuonvien_dsdmdk_chuacap_dientich_3',
            'cosothotu_ditichlichsu',
            'cosothotu_ditichvanhoa',
            'cosothotu_ditichlichsuvanhoa',
            'cosothotu_ditichkientrucnghethuat',
            'cosothotu_ditichkhaoco',
            'cosothotu_captrunguong',
            'cosothotu_captinh'
        ];
        $conditions = [
            $location . ' <>' => '',
            $location . ' is not null',
        ];

        return compact('fields', 'conditions');
    }

    private function __getData($model)
    {
        $f = '__get' . $model. 'Params';
        $option = $this->$f();
        $obj = ClassRegistry::init($model);
        $data = $obj->find('all', $option);

        return Hash::combine($data, '{n}.' . $model . '.id', '{n}.' . $model);
    }
}
