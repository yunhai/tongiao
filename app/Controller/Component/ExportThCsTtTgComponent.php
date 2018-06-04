<?php
App::uses('ExportExcelComponent', 'Controller/Component');

class ExportThCsTtTgComponent extends ExportExcelComponent
{
    public function __construct()
    {
        $this->index = 1;
    }

    public function export()
    {
        $groups = [
            'Giaoxu',
            'Tuvienphatgiao',
            'Chihoitinlanh',
            'Hodaocaodai',
            'Chihoitinhdocusiphatgiaovietnam',
            'Cosohoigiaoislam',
            'Cosotinnguong',
        ];

        $export = [];

        foreach ($groups as $field_index => $model) {
            $export = array_merge($export, $this->__getInfo($model));
        }

        return $export;
    }

    public function layout($filter = [])
    {
        $row_header_index = 4;
        $row_data_index = 8;
        $column_begin = 1;
        $column_structure = [
        ];

        $column_remove = [];
        $cell_total_count = 0;
        if ($filter) {
            foreach ($column_structure as $index => $tmp) {
                if (!in_array($index, $filter)) {
                    $column_remove[$index] = $index;
                }
            }
        }
        $ignore_format = true;
        return compact('column_begin', 'column_structure', 'column_remove', 'row_header_index', 'row_data_index', 'cell_total_count', 'ignore_format');
    }

    private function __getStt($target, $model)
    {
        $index = $this->index;
        $this->index += 1;
        return $index;
    }

    private function __getInfo($model)
    {
        $fields = [
            'stt',
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
        $result = '';
        switch ($model) {
            case 'Giaoxu':
                $result = $data['tengiaoxu'];
                break;
            case 'Tuvienphatgiao':
                $result = $data['tentuvien'];
                break;
            case 'Chihoitinlanh':
                $result = $data['tenchihoi'];
                break;
            case 'Hodaocaodai':
                $result = $data['tenhodao'];
                break;
            case 'Chihoitinhdocusiphatgiaovietnam':
                $result = $data['tenchihoi'];
                break;
            case 'Cosohoigiaoislam':
                $result = $data['tenthanhduong'];
                break;
            case 'Cosotinnguong':
                $result = $data['tencoso'];
                break;
        }

        return $result;
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

        $name = [
              $prefix . 'so' => 'số',
            $prefix . 'duong' => 'đường',
            $prefix . 'ap' => 'ấp',
            $prefix . 'xa' => 'xã',
            $prefix . 'huyen' => 'huyện',
            $prefix . 'tinh' => 'tỉnh',
        ];

        $string = '';
        if ($fields) {
            foreach ($fields as $f) {
                if ($target[$f]) {
                    $string .= $name[$f] . ' ' . $target[$f] . ', ';
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
        $result = '';
        switch ($model) {
            case 'Giaoxu':
                $result = $data['giaodan_sonhankhau'];
                break;
            case 'Tuvienphatgiao':
                $result = $data['daquyy'];
                break;
            case 'Chihoitinlanh':
                $result = $data['tongsotindo_baptem'];
                break;
            case 'Hodaocaodai':
                $result = $data['tongsotindo_cosocaudao'];
                break;
            case 'Chihoitinhdocusiphatgiaovietnam':
                $result = $data['soluonghoivien_tindo'];
                break;
            case 'Cosohoigiaoislam':
                $result = $data['tongsotindo'];
                break;
            case 'Cosotinnguong':
                $result = 0;
                break;
        }
        return $result;
    }

    private function __getTindochuathuchiennghiletongiao($data, $model)
    {
        $result = '';
        switch ($model) {
            case 'Giaoxu':
                $result = 0;
                break;
            case 'Tuvienphatgiao':
                $result = $data['soluongtindo'] - $data['daquyy'];
                break;
            case 'Chihoitinlanh':
                $result = $data['tongsotindo_chuabaptem'];
                break;
            case 'Hodaocaodai':
                $result = $data['tongsotindo_chuacosocaudao'];
                break;
            case 'Chihoitinhdocusiphatgiaovietnam':
                $result = 0;
                break;
            case 'Cosohoigiaoislam':
                $result = 0;
                break;
            case 'Cosotinnguong':
                $result = 0;
                break;
        }
        return $result;
    }

    private function __getTindoladantocthieuso($data, $model)
    {
        switch ($model) {
            case 'Giaoxu':
                $result = $data['giaodandantocthieuso_sonhankhau'];
                break;
            case 'Tuvienphatgiao':
                $result = $data['phattu_dantoc_thieuso'];
                break;
            case 'Chihoitinlanh':
                $result = $data['sotindo_dantoc_thieuso'];
                break;
            case 'Hodaocaodai':
                $result = $data['sotindo_dantoc_thieuso'];
                break;
            case 'Chihoitinhdocusiphatgiaovietnam':
                $result = $data['sotindo_dantoc_thieuso'];
                break;
            case 'Cosohoigiaoislam':
                $result = $data['sotindo_dantoc_thieuso'];
                break;
            case 'Cosotinnguong':
                $result = 0;
                break;
        }
        return $result;
    }

    private function __getChucsac($data, $model)
    {
        $result = '';
        switch ($model) {
            case 'Giaoxu':
                break;
            case 'Tuvienphatgiao':
                $result = $data['sochucsac'];
                break;
            case 'Chihoitinlanh':
                $result = $data['sochucsac'];
                break;
            case 'Hodaocaodai':
                $result = $data['sochucsac_phoisu'] +
                          $data['sochucsac_giaosu'] +
                          $data['sochucsac_giaohuu'] +
                          $data['sochucsac_lesanh'];
                break;
            case 'Chihoitinhdocusiphatgiaovietnam':
                $result = 0;
                break;
            case 'Cosohoigiaoislam':
                $result = 0;
                break;
            case 'Cosotinnguong':
                $result = 0;
                break;
        }
        return $result;
    }

    private function __getTusi($data, $model)
    {
        $result = '';
        switch ($model) {
            case 'Giaoxu':
                $result = $data['sotusi'];
                break;
            case 'Tuvienphatgiao':
                $result = $data['sotusi'];
                break;
            case 'Chihoitinlanh':
                $result = 0;
                break;
            case 'Hodaocaodai':
                $result = 0;
                break;
            case 'Chihoitinhdocusiphatgiaovietnam':
                $result = 0;
                break;
            case 'Cosohoigiaoislam':
                $result = 0;
                break;
            case 'Cosotinnguong':
                $result = 0;
                break;
        }
        return $result;
    }

    private function __getChucsacladantocthieuso($data, $model)
    {
        $result = '';
        switch ($model) {
            case 'Giaoxu':
            case 'Tuvienphatgiao':
            case 'Chihoitinlanh':
            case 'Hodaocaodai':
            case 'Chihoitinhdocusiphatgiaovietnam':
            case 'Cosohoigiaoislam':
            case 'Cosotinnguong':
                $result = 0;
                break;
        }
        return $result;
    }

    private function __getChucviec($data, $model)
    {
        $result = '';
        switch ($model) {
            case 'Giaoxu':
                $result = $data['sothanhvientrongthuongvu'];
                break;
            case 'Tuvienphatgiao':
                $result = 0;
                break;
            case 'Chihoitinlanh':
                $result = $data['sothanhvientrongbanchapsu'];
                break;
            case 'Hodaocaodai':
                $result = $data['sothanvien_bancaiquan'];
                break;
            case 'Chihoitinhdocusiphatgiaovietnam':
                $result = 0;
                break;
            case 'Cosohoigiaoislam':
                $result = 0;
                break;
            case 'Cosotinnguong':
                $result = 0;
                break;
        }
        return $result;
    }

    private function __getChucviecladantocthieuso($data, $model)
    {
        $result = '';
        switch ($model) {
            case 'Giaoxu':
            case 'Tuvienphatgiao':
            case 'Chihoitinlanh':
            case 'Hodaocaodai':
            case 'Chihoitinhdocusiphatgiaovietnam':
            case 'Cosohoigiaoislam':
            case 'Cosotinnguong':
                $result = 0;
                break;
        }
        return $result;
    }

    private function __getNamthanhlap($data, $model)
    {
        $result = '';
        switch ($model) {
            case 'Giaoxu':
            case 'Tuvienphatgiao':
                $result = $data['namthanhlap'];
                break;
            case 'Chihoitinlanh':
                $result = $data['namgiaohoithanhlap'];
                break;
            case 'Hodaocaodai':
                $result = $data['namhoithanhthanhlap'];
                break;
            case 'Chihoitinhdocusiphatgiaovietnam':
                $result = $data['namhoithanhthanhlap'];
                break;
            case 'Cosohoigiaoislam':
                $result = $data['namgiaohoithanhlap'];
                break;
            case 'Cosotinnguong':
                $result = $data['namthanhlap'];
                break;
        }
        return $result;
    }

    private function __getNamxaydung($data, $model)
    {
        $result = '';
        switch ($model) {
            case 'Giaoxu':
                $result = $data['namxaydungnhatho'];
                break;
            case 'Tuvienphatgiao':
                $result = $data['namxaydung'];
                break;
            case 'Chihoitinlanh':
                $result = $data['ttttcs_namxaydung'];
                break;
            case 'Hodaocaodai':
                $result = $data['ttttcs_namxaydung'];
                break;
            case 'Chihoitinhdocusiphatgiaovietnam':
                $result = $data['ttttcs_namxaydung'];
                break;
            case 'Cosohoigiaoislam':
                $result = $data['ttttcs_namxaydung'];
                break;
            case 'Cosotinnguong':
                $result = $data['namxaydung'];
                break;
        }
        return $result;
    }

    private function __getSotien($data, $model)
    {
        $result = '';
        switch ($model) {
            case 'Giaoxu':
            case 'Tuvienphatgiao':
            case 'Chihoitinlanh':
            case 'Hodaocaodai':
            case 'Cosohoigiaoislam':
            case 'Cosotinnguong':
                $result = 0;
                break;
        }
        return $result;
    }

    private function __getSolan($data, $model)
    {
        $result = '';
        switch ($model) {
            case 'Giaoxu':
                $result = $data['ttttcs_solan'];
                break;
            case 'Tuvienphatgiao':
                $result = $data['ttttcs_solan'];
                break;
            case 'Chihoitinlanh':
                $result = $data['ttttcs_solan'];
                break;
            case 'Hodaocaodai':
                $result = $data['ttttcs_solan'];
                break;
            case 'Chihoitinhdocusiphatgiaovietnam':
                $result = $data['ttttcs_solan'];
                break;
            case 'Cosohoigiaoislam':
                $result = $data['ttttcs_solan'];
                break;
            case 'Cosotinnguong':
                $result = $data['ttttcs_solan'];
                break;
        }
        return $result;
    }

    private function __getSotienlancuoi($data, $model)
    {
        $result = '';
        switch ($model) {
            case 'Giaoxu':
                $result = $data['ttttcs_tongkinhphi'];
                break;
            case 'Tuvienphatgiao':
                $result = $data['ttttcs_tongkinhphi'];
                break;
            case 'Chihoitinlanh':
                $result = $data['ttttcs_tongkinhphi'];
                break;
            case 'Hodaocaodai':
                $result = $data['ttttcs_tongkinhphi'];
                break;
            case 'Chihoitinhdocusiphatgiaovietnam':
                $result = $data['ttttcs_tongkinhphi'];
                break;
            case 'Cosohoigiaoislam':
                $result = $data['ttttcs_tongkinhphi'];
                break;
            case 'Cosotinnguong':
                $result = $data['ttttcs_tongkinhphi'];
                break;
        }
        return $result;
    }

    private function __getDacapgcnqsddat_tongiao($data, $model)
    {
        switch ($model) {
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
            case 'Chihoitinlanh':
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
            case 'Hodaocaodai':
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
            case 'Chihoitinhdocusiphatgiaovietnam':
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
            case 'Cosohoigiaoislam':
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
            case 'Cosotinnguong':
                $field1 = [
                    'tongiao_dientich',
                ];
                $field2 = [
                    'tongiao_chuacap_dientich',
                ];
                break;
        }

        $result = 0;
        foreach ($field1 as $f) {
            $result += intval($data[$f]);
        }
        foreach ($field2 as $f) {
            $result -= intval($data[$f]);
        }

        return ($result > 0) ? $result : 0;
    }

    private function __getDacapgcnqsddat_khac($data, $model)
    {
        switch ($model) {
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
            case 'Chihoitinlanh':
                $field1 = [
                    'dattrongkhuonvien_nnlnntts_dientich',
                    'dattrongkhuonvien_gdyt_dientich',
                    'dattrongkhuonvien_nghiadia_dientich',
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
                    'dattrongkhuonvien_nghiadia_chuacap_dientich',
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
            case 'Hodaocaodai':
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
            case 'Chihoitinhdocusiphatgiaovietnam':
                $field1 = [
                    'dattrongkhuonvien_nnlnntts_dientich',
                    'dattrongkhuonvien_gdyt_dientich',
                    'dattrongkhuonvien_dsdmdk_dientich',
                    'datngoaikhuonvien_nnlnntts_dientich_1',
                    'datngoaikhuonvien_gdyt_dientich_1',
                    'datngoaikhuonvien_dsdmdk_dientich_1',
                    'datngoaikhuonvien_nnlnntts_dientich_2',
                    'datngoaikhuonvien_nnlnntts_dientich_2',
                    'datngoaikhuonvien_gdyt_dientich_2',
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
                    'datngoaikhuonvien_nnlnntts_dientich_2',
                    'datngoaikhuonvien_nnlnntts_chuacap_dientich_2',
                    'datngoaikhuonvien_gdyt_chuacap_dientich_2',
                    'datngoaikhuonvien_nnlnntts_chuacap_dientich_3',
                    'datngoaikhuonvien_gdyt_chuacap_dientich_3',
                    'datngoaikhuonvien_dsdmdk_chuacap_dientich_3',
                ];
                break;
            case 'Cosohoigiaoislam':
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
                    'datngoaikhuonvien_nnlnntts_chuacap_dientich_3',
                    'datngoaikhuonvien_gdyt_chuacap_dientich_3',
                    'datngoaikhuonvien_dsdmdk_chuacap_dientich_3',
                ];
                break;
            case 'Cosotinnguong':
                $field1 = [
                    'nnlnntts_dientich',
                    'gdyt_dientich',
                    'dsdmdk_dientich',
                ];
                $field2 = [
                    'nnlnntts_chuacap_dientich',
                    'gdyt_chuacap_dientich',
                    'dsdmdk_chuacap_dientich',
                ];
                break;
        }

        $result = 0;
        foreach ($field1 as $f) {
            $result += intval($data[$f]);
        }
        foreach ($field2 as $f) {
            $result -= intval($data[$f]);
        }

        return ($result > 0) ? $result : 0;
    }

    private function __getChuacapgcnqsddat($data, $model)
    {
        switch ($model) {
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
            case 'Chihoitinlanh':
                $field = [
                    'dattrongkhuonvien_tongiao_chuacap_dientich',
                    'dattrongkhuonvien_nnlnntts_chuacap_dientich',
                    'dattrongkhuonvien_gdyt_chuacap_dientich',
                    'dattrongkhuonvien_nghiadia_chuacap_dientich',
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
                ];
                break;
            case 'Hodaocaodai':
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
            case 'Chihoitinhdocusiphatgiaovietnam':
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
            case 'Cosohoigiaoislam':
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
            case 'Cosotinnguong':
                $field = [
                    'tongiao_chuacap_dientich',
                    'nnlnntts_chuacap_dientich',
                    'gdyt_chuacap_dientich',
                    'dsdmdk_chuacap_dientich',
                ];
                break;
        }

        $result = 0;
        foreach ($field as $f) {
            $result += intval($data[$f]);
        }

        return $result;
    }

    private function __getKientruc($data, $model)
    {
        $result = '';
        switch ($model) {
            case 'Giaoxu':
                break;
            case 'Tuvienphatgiao':
                break;
            case 'Chihoitinlanh':
                break;
            case 'Hodaocaodai':
                break;
            case 'Chihoitinhdocusiphatgiaovietnam':
                break;
            case 'Cosohoigiaoislam':
                break;
            case 'Cosotinnguong':
                break;
        }
        return $result;
    }

    private function __getXephangditich($data, $model)
    {
        $mode = [
            'cosothotu_ditichlichsu' => 'Di tích lịch sử',
            'cosothotu_ditichvanhoa' => 'Di tích văn hóa',
            'cosothotu_ditichlichsuvanhoa' => 'Di tích lịch sử văn hóa',
            'cosothotu_ditichkientrucnghethuat' => 'Di tích kiến trúc nghệ thuật',
            'cosothotu_ditichkhaoco' => "Di tích khảo cổ'",
        ];

        foreach ($mode as $f => $name) {
            if (!empty($data[$f])) {
                return $name;
            }
        }

        return '';
    }

    private function __getCapcongnhan($data, $model)
    {
        $mode = [
            'cosothotu_captrunguong' => 'Cấp Trung ương',
            'cosothotu_captinh' => 'Cấp tỉnh',
        ];

        foreach ($mode as $f => $name) {
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

    private function __getChihoitinlanhParams()
    {
        $location = 'tenchihoi';
        $prefix = 'diachi_';
        $fields = [
            'id',
            $location,
            $prefix . 'so',
            $prefix . 'ap',
            $prefix . 'xa',
            $prefix . 'huyen',
            $prefix . 'tinh',
            'tongsotindo_baptem',
            'tongsotindo_chuabaptem',
            'sotindo_dantoc_thieuso',
            'sochucsac',
            'sothanhvientrongbanchapsu',
            'namgiaohoithanhlap',
            'ttttcs_namxaydung',
            'ttttcs_solan',
            'ttttcs_tongkinhphi',

            ////Đã cấp GCNQSD đất
            'dattrongkhuonvien_tongiao_dientich',
            'datngoaikhuonvien_tongiao_dientich_1',
            'datngoaikhuonvien_tongiao_dientich_2',
            'datngoaikhuonvien_tongiao_dientich_3',
            /****/
            'dattrongkhuonvien_tongiao_chuacap_dientich',
            'datngoaikhuonvien_tongiao_chuacap_dientich_1',
            'datngoaikhuonvien_tongiao_chuacap_dientich_2',
            'datngoaikhuonvien_tongiao_chuacap_dientich_3',

            ////Mục đích sử dụng khác:
            'dattrongkhuonvien_nnlnntts_dientich',
            'dattrongkhuonvien_gdyt_dientich',
            'dattrongkhuonvien_nghiadia_dientich',
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
            /****/
            'dattrongkhuonvien_nnlnntts_chuacap_dientich',
            'dattrongkhuonvien_gdyt_chuacap_dientich',
            'dattrongkhuonvien_nghiadia_chuacap_dientich',
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

            //Chưa được cấp GCNQSD đất:
            'dattrongkhuonvien_tongiao_chuacap_dientich',
            'dattrongkhuonvien_nnlnntts_chuacap_dientich',
            'dattrongkhuonvien_gdyt_chuacap_dientich',
            'dattrongkhuonvien_nghiadia_chuacap_dientich',
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

    private function __getHodaocaodaiParams()
    {
        $location = 'tenhodao';
        $prefix = 'tenhodao_diachi_';
        $fields = [
            'id',
            $location,
            $prefix . 'so',
            $prefix . 'duong',
            $prefix . 'ap',
            $prefix . 'xa',
            $prefix . 'huyen',
            $prefix . 'tinh',
            'tongsotindo_cosocaudao',
            'tongsotindo_chuacosocaudao',
            'sotindo_dantoc_thieuso',
            'sochucsac_phoisu',
            'sochucsac_giaosu',
            'sochucsac_giaohuu',
            'sochucsac_lesanh',
            'sothanvien_bancaiquan',
            'namhoithanhthanhlap',
            'ttttcs_namxaydung',
            'ttttcs_solan',
            'ttttcs_tongkinhphi',

            //Đã cấp GCNQSD đất
            'dattrongkhuonvien_tongiao_dientich',
            'datngoaikhuonvien_tongiao_dientich_1',
            'datngoaikhuonvien_tongiao_dientich_2',
            'datngoaikhuonvien_tongiao_dientich_3',
            /***/
            'dattrongkhuonvien_tongiao_chuacap_dientich',
            'datngoaikhuonvien_tongiao_chuacap_dientich_1',
            'datngoaikhuonvien_tongiao_chuacap_dientich_2',
            'datngoaikhuonvien_tongiao_chuacap_dientich_3',

            //Mục đích sử dụng khác:
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
            /***/
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

            //Chưa được cấp GCNQSD đất:
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

    private function __getChihoitinhdocusiphatgiaovietnamParams()
    {
        $location = 'tenchihoi';
        $prefix = 'tenchihoi_diachi_';
        $fields = [
            'id',
            $location,
            $prefix . 'so',
            $prefix . 'duong',
            $prefix . 'ap',
            $prefix . 'xa',
            $prefix . 'huyen',
            $prefix . 'tinh',
            'soluonghoivien_tindo',
            'sotindo_dantoc_thieuso',
            'namhoithanhthanhlap',
            'ttttcs_namxaydung',
            'ttttcs_solan',
            'ttttcs_tongkinhphi',

            // Mục đích sử dụng đất TG:
            'dattrongkhuonvien_tongiao_dientich',
            'datngoaikhuonvien_tongiao_dientich_1',
            'datngoaikhuonvien_tongiao_dientich_2',
            'datngoaikhuonvien_tongiao_dientich_3',
            /***/
            'dattrongkhuonvien_tongiao_chuacap_dientich',
            'datngoaikhuonvien_tongiao_chuacap_dientich_1',
            'datngoaikhuonvien_tongiao_chuacap_dientich_2',
            'datngoaikhuonvien_tongiao_chuacap_dientich_3',

             // Mục đích sử dụng khác:
            'dattrongkhuonvien_nnlnntts_dientich',
            'dattrongkhuonvien_gdyt_dientich',
            'dattrongkhuonvien_dsdmdk_dientich',
            'datngoaikhuonvien_nnlnntts_dientich_1',
            'datngoaikhuonvien_gdyt_dientich_1',
            'datngoaikhuonvien_dsdmdk_dientich_1',
            'datngoaikhuonvien_nnlnntts_dientich_2',
            'datngoaikhuonvien_nnlnntts_dientich_2',
            'datngoaikhuonvien_gdyt_dientich_2',
            'datngoaikhuonvien_nnlnntts_dientich_3',
            'datngoaikhuonvien_gdyt_dientich_3',
            'datngoaikhuonvien_dsdmdk_dientich_3',
            /**/
            'dattrongkhuonvien_nnlnntts_chuacap_dientich',
            'dattrongkhuonvien_gdyt_chuacap_dientich',
            'dattrongkhuonvien_dsdmdk_chuacap_dientich',
            'datngoaikhuonvien_nnlnntts_chuacap_dientich_1',
            'datngoaikhuonvien_gdyt_chuacap_dientich_1',
            'datngoaikhuonvien_dsdmdk_chuacap_dientich_1',
            'datngoaikhuonvien_nnlnntts_dientich_2',
            'datngoaikhuonvien_nnlnntts_chuacap_dientich_2',
            'datngoaikhuonvien_gdyt_chuacap_dientich_2',
            'datngoaikhuonvien_nnlnntts_chuacap_dientich_3',
            'datngoaikhuonvien_gdyt_chuacap_dientich_3',
            'datngoaikhuonvien_dsdmdk_chuacap_dientich_3',

            // Chưa được cấp GCNQSD đất:
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

    private function __getCosohoigiaoislamParams()
    {
        $location = 'tenthanhduong';
        $prefix = 'tenthanhduong_diachi_';
        $fields = [
            'id',
            $location,
            $prefix . 'so',
            $prefix . 'duong',
            $prefix . 'ap',
            $prefix . 'xa',
            $prefix . 'huyen',
            $prefix . 'tinh',
            'tongsotindo',
            'sotindo_dantoc_thieuso',
            'namgiaohoithanhlap',
            'ttttcs_namxaydung',
            'ttttcs_solan',
            'ttttcs_tongkinhphi',

            // Mục đích sử dụng đất TG:
            'dattrongkhuonvien_tongiao_dientich',
            'datngoaikhuonvien_tongiao_dientich_1',
            'datngoaikhuonvien_tongiao_dientich_2',
            'datngoaikhuonvien_tongiao_dientich_3',
            /***/
            'dattrongkhuonvien_tongiao_chuacap_dientich',
            'datngoaikhuonvien_tongiao_chuacap_dientich_1',
            'datngoaikhuonvien_tongiao_chuacap_dientich_2',
            'datngoaikhuonvien_tongiao_chuacap_dientich_3',

            // Mục đích sử dụng khác:
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
            /**/
            'dattrongkhuonvien_nnlnntts_chuacap_dientich',
            'dattrongkhuonvien_gdyt_chuacap_dientich',
            'dattrongkhuonvien_dsdmdk_chuacap_dientich',
            'datngoaikhuonvien_nnlnntts_chuacap_dientich_1',
            'datngoaikhuonvien_gdyt_chuacap_dientich_1',
            'datngoaikhuonvien_dsdmdk_chuacap_dientich_1',
            'datngoaikhuonvien_nnlnntts_chuacap_dientich_2',
            'datngoaikhuonvien_gdyt_chuacap_dientich_2',
            'datngoaikhuonvien_nnlnntts_chuacap_dientich_3',
            'datngoaikhuonvien_gdyt_chuacap_dientich_3',
            'datngoaikhuonvien_dsdmdk_chuacap_dientich_3',

            // Chưa được cấp GCNQSD đất:
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

    private function __getCosotinnguongParams()
    {
        $location = 'tencoso';
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
            'namthanhlap',
            'namxaydung',
            'ttttcs_solan',
            'ttttcs_tongkinhphi',

            // Mục đích sử dụng đất TG:
            'tongiao_dientich',
            /**/
            'tongiao_chuacap_dientich',

            // Mục đích sử dụng khác:
            'nnlnntts_dientich',
            'gdyt_dientich',
            'dsdmdk_dientich',
            /**/
            'nnlnntts_chuacap_dientich',
            'gdyt_chuacap_dientich',
            'dsdmdk_chuacap_dientich',

            // Chưa được cấp GCNQSD đất:
            'tongiao_chuacap_dientich',
            'nnlnntts_chuacap_dientich',
            'gdyt_chuacap_dientich',
            'dsdmdk_chuacap_dientich',

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

/**
 * DANH SÁCH CƠ SỞ THỜ TỰ TÔN GIÁO, TÍN NGƯỠNG TRÊN ĐỊA BÀN TỈNH
 *
 * I. CÔNG GIÁO
 * 1. Bảng giaoxu
 * Tên cơ sở thờ tự: tengiaoxu
 * Địa chỉ: diachi_so, diachi_duong, diachi_ap, diachi_xa, diachi_huyen, diachi_tinh
 * Thuộc tổ chức tôn giáo cơ sở: Để mặc định là 'Công Giáo'
 * Số lượng tín đồ
 *      Đã thực hiện lễ nghi tôn giáo: giaodan_sonhankhau
 *      Chưa thực hiện lễ nghi tôn giáo: giaodan_sonhankhau
 *      Là người dân tộc thiểu số: giaodandantocthieuso_sonhankhau
 * Số lượng chức sắc tu sĩ
 *      Chức sắc: Để mặc định bằng 0
 *      Tu sĩ: sotusi
 *      Chắc sắc là người dân tộc thiểu số: Để mặc định bằng 0
 * Số lượng chức việc
 *      Số lượng chức việc: sothanhvientrongthuongvu
 *      Số lượng chức việc là người dân tộc thiểu số: Để mặc định bằng 0
 * Năm thành lập: namthanhlap
 * Về xây dựng
 *      Năm xây dựng: namxaydungnhatho
 *      Số tiền: Để mặc định bằng 0
 * Về trùng tu tôn tạo
 *      Số lần: ttttcs_solan
 *      Số tiền lần cuối: ttttcs_tongkinhphi
 * Diện tích (m2)
 *      Đã cấp GCNQSD đất
 *          Mục đích sử dụng đất TG:
 *              (dattrongkhuonvien_tongiao_dientich - dattrongkhuonvien_tongiao_chuacap_dientich) +
 *              (datngoaikhuonvien_tongiao_dientich_1 - datngoaikhuonvien_tongiao_chuacap_dientich_1) +
 *              (datngoaikhuonvien_tongiao_dientich_2 - datngoaikhuonvien_tongiao_chuacap_dientich_2) +
 *              (datngoaikhuonvien_tongiao_dientich_3 - datngoaikhuonvien_tongiao_chuacap_dientich_3)
 *          Mục đích sử dụng khác:
 *              (dattrongkhuonvien_nnlnntts_dientich - dattrongkhuonvien_nnlnntts_chuacap_dientich) +
 *              (dattrongkhuonvien_gdyt_dientich - dattrongkhuonvien_gdyt_chuacap_dientich) +
 *              (dattrongkhuonvien_nghiadia_dientich - dattrongkhuonvien_nghiadia_chuacap_dientich) +
 *              (dattrongkhuonvien_dsdmdk_dientich - dattrongkhuonvien_dsdmdk_chuacap_dientich) +
 *              (datngoaikhuonvien_nnlnntts_dientich_1 - datngoaikhuonvien_nnlnntts_chuacap_dientich_1) +
 *              (datngoaikhuonvien_gdyt_dientich_1 - datngoaikhuonvien_gdyt_chuacap_dientich_1) +
 *              (datngoaikhuonvien_nghiadia_dientich_1 - datngoaikhuonvien_nghiadia_chuacap_dientich_1) +
 *              (datngoaikhuonvien_dsdmdk_dientich_1 - datngoaikhuonvien_dsdmdk_chuacap_dientich_1) +
 *              (datngoaikhuonvien_nnlnntts_dientich_2 - datngoaikhuonvien_nnlnntts_chuacap_dientich_2) +
 *              (datngoaikhuonvien_gdyt_dientich_2 - datngoaikhuonvien_gdyt_chuacap_dientich_2) +
 *              (datngoaikhuonvien_nghiadia_dientich_2 - datngoaikhuonvien_nghiadia_chuacap_dientich_2) +
 *              (datngoaikhuonvien_dsdmdk_dientich_2 - datngoaikhuonvien_dsdmdk_chuacap_dientich_2) +
 *              (datngoaikhuonvien_nnlnntts_dientich_3 - datngoaikhuonvien_nnlnntts_chuacap_dientich_3) +
 *              (datngoaikhuonvien_gdyt_dientich_3 - datngoaikhuonvien_gdyt_chuacap_dientich_3) +
 *              (datngoaikhuonvien_nghiadia_dientich_3 - datngoaikhuonvien_nghiadia_chuacap_dientich_3) +
 *              (datngoaikhuonvien_dsdmdk_dientich_3 - datngoaikhuonvien_dsdmdk_chuacap_dientich_3)
 *      Chưa được cấp GCNQSD đất:
 *          dattrongkhuonvien_tongiao_chuacap_dientich + dattrongkhuonvien_nnlnntts_chuacap_dientich +
 *          dattrongkhuonvien_gdyt_chuacap_dientich + dattrongkhuonvien_dsdmdk_chuacap_dientich +
 *          datngoaikhuonvien_tongiao_chuacap_dientich_1 + datngoaikhuonvien_nnlnntts_chuacap_dientich_1 +
 *          datngoaikhuonvien_gdyt_chuacap_dientich_1 + datngoaikhuonvien_nghiadia_chuacap_dientich_1 + datngoaikhuonvien_dsdmdk_chuacap_dientich_1 +
 *          datngoaikhuonvien_tongiao_chuacap_dientich_2 + datngoaikhuonvien_nnlnntts_chuacap_dientich_2 +
 *          datngoaikhuonvien_gdyt_chuacap_dientich_2 + datngoaikhuonvien_nghiadia_chuacap_dientich_2 + datngoaikhuonvien_dsdmdk_chuacap_dientich_2 +
 *          datngoaikhuonvien_tongiao_chuacap_dientich_3 + datngoaikhuonvien_nnlnntts_chuacap_dientich_3 +
 *          datngoaikhuonvien_gdyt_chuacap_dientich_3 + datngoaikhuonvien_nghiadia_chuacap_dientich_3 + datngoaikhuonvien_dsdmdk_chuacap_dientich_3
 *
 * Kiến trúc: Để mặc định là rỗng
 * Di tích
 *      Xếp hạng di tích:
 *          if cosothotu_ditichlichsu == true
 *              Xếp hạng di tích: 'Di tích lịch sử'
 *          if cosothotu_ditichvanhoa == true
 *              Xếp hạng di tích: 'Di tích văn hóa'
 *          if cosothotu_ditichlichsuvanhoa == true
 *              Xếp hạng di tích: 'Di tích lịch sử văn hóa'
 *          if cosothotu_ditichkientrucnghethuat == true
 *              Xếp hạng di tích: 'Di tích kiến trúc nghệ thuật'
 *          if cosothotu_ditichkhaoco == true
 *              Xếp hạng di tích: 'Di tích khảo cổ'
 *      Cấp công nhận
 *          if cosothotu_captrunguong == true
 *              Cấp công nhận: 'Cấp Trung ương'
 *          if cosothotu_captinh == true
 *              Cấp công nhận: 'Cấp tỉnh'
 *
 * II. PHẬT GIÁO
 * 2. Bảng tuvienphatgiao
 * Tên cơ sở thờ tự: tentuvien
 * Địa chỉ: diachi_so, diachi_duong, diachi_ap, diachi_xa, diachi_huyen, diachi_tinh
 * Thuộc tổ chức tôn giáo cơ sở: Để mặc định là 'Phật Giáo'
 * Số lượng tín đồ
 *      Đã thực hiện lễ nghi tôn giáo: daquyy
 *      Chưa thực hiện lễ nghi tôn giáo: soluongtindo - daquyy
 *      Là người dân tộc thiểu số: phattu_dantoc_thieuso
 * Số lượng chức sắc tu sĩ
 *      Chức sắc: sochucsac
 *      Tu sĩ: sotusi
 *      Chắc sắc là người dân tộc thiểu số: Để mặc định bằng 0
 * Số lượng chức việc
 *      Số lượng chức việc: Để mặc định bằng 0
 *      Số lượng chức việc là người dân tộc thiểu số: Để mặc định bằng 0
 * Năm thành lập: namthanhlap
 * Về xây dựng
 *      Năm xây dựng: namxaydung
 *      Số tiền: Để mặc định bằng 0
 * Về trùng tu tôn tạo
 *      Số lần: ttttcs_solan
 *      Số tiền lần cuối: ttttcs_tongkinhphi
 * Diện tích (m2)
 *      Đã cấp GCNQSD đất
 *          Mục đích sử dụng đất TG:
 *              (dattrongkhuonvien_nnlnntts_dientich - dattrongkhuonvien_nnlnntts_chuacap_dientich) +
 *              (dattrongkhuonvien_gdyt_dientich - dattrongkhuonvien_gdyt_chuacap_dientich) +
 *              (dattrongkhuonvien_dsdmdk_dientich - dattrongkhuonvien_dsdmdk_chuacap_dientich) +
 *              (datngoaikhuonvien_nnlnntts_dientich_1 - datngoaikhuonvien_nnlnntts_chuacap_dientich_1) +
 *              (datngoaikhuonvien_gdyt_dientich_1 - datngoaikhuonvien_gdyt_chuacap_dientich_1) +
 *              (datngoaikhuonvien_dsdmdk_dientich_1 - datngoaikhuonvien_dsdmdk_chuacap_dientich_1) +
 *              (datngoaikhuonvien_nnlnntts_dientich_2 - datngoaikhuonvien_nnlnntts_chuacap_dientich_2) +
 *              (datngoaikhuonvien_gdyt_dientich_2 - datngoaikhuonvien_gdyt_chuacap_dientich_2) +
 *              (datngoaikhuonvien_nnlnntts_dientich_3 - datngoaikhuonvien_nnlnntts_chuacap_dientich_3) +
 *              (datngoaikhuonvien_gdyt_dientich_3 - datngoaikhuonvien_gdyt_chuacap_dientich_3) +
 *              (datngoaikhuonvien_dsdmdk_dientich_3 - datngoaikhuonvien_dsdmdk_chuacap_dientich_3)
 *          Mục đích sử dụng khác:
 *              (dattrongkhuonvien_nnlnntts_dientich - dattrongkhuonvien_nnlnntts_chuacap_dientich) +
 *              (dattrongkhuonvien_gdyt_dientich - dattrongkhuonvien_gdyt_chuacap_dientich) +
 *              (dattrongkhuonvien_dsdmdk_dientich - dattrongkhuonvien_dsdmdk_chuacap_dientich) +
 *              (datngoaikhuonvien_nnlnntts_dientich_1 - datngoaikhuonvien_nnlnntts_chuacap_dientich_1) +
 *              (datngoaikhuonvien_gdyt_dientich_1 - datngoaikhuonvien_gdyt_chuacap_dientich_1) +
 *              (datngoaikhuonvien_dsdmdk_dientich_1 - datngoaikhuonvien_dsdmdk_chuacap_dientich_1) +
 *              (datngoaikhuonvien_nnlnntts_dientich_2 - datngoaikhuonvien_nnlnntts_chuacap_dientich_2) +
 *              (datngoaikhuonvien_gdyt_dientich_2 - datngoaikhuonvien_gdyt_chuacap_dientich_2) +
 *              (datngoaikhuonvien_nnlnntts_dientich_3 - datngoaikhuonvien_nnlnntts_chuacap_dientich_3) +
 *              (datngoaikhuonvien_gdyt_dientich_3 - datngoaikhuonvien_gdyt_chuacap_dientich_3) +
 *              (datngoaikhuonvien_dsdmdk_dientich_3 - datngoaikhuonvien_dsdmdk_chuacap_dientich_3)
 *      Chưa được cấp GCNQSD đất:
 *          dattrongkhuonvien_tongiao_chuacap_dientich + dattrongkhuonvien_nnlnntts_chuacap_dientich +
 *          dattrongkhuonvien_gdyt_chuacap_dientich + dattrongkhuonvien_dsdmdk_chuacap_dientich +
 *          datngoaikhuonvien_tongiao_chuacap_dientich_1 + datngoaikhuonvien_nnlnntts_chuacap_dientich_1 +
 *          datngoaikhuonvien_gdyt_chuacap_dientich_1 + datngoaikhuonvien_dsdmdk_chuacap_dientich_1 +
 *          datngoaikhuonvien_tongiao_chuacap_dientich_2 + datngoaikhuonvien_nnlnntts_chuacap_dientich_2 +
 *          datngoaikhuonvien_gdyt_chuacap_dientich_2 + datngoaikhuonvien_dsdmdk_chuacap_dientich_2 +
 *          datngoaikhuonvien_tongiao_chuacap_dientich_3 + datngoaikhuonvien_nnlnntts_chuacap_dientich_3 +
 *          datngoaikhuonvien_gdyt_chuacap_dientich_3 + datngoaikhuonvien_dsdmdk_chuacap_dientich_3
 * Kiến trúc: Để mặc định là rỗng
 * Di tích
 *      Xếp hạng di tích:
 *          if cosothotu_ditichlichsu == true
 *              Xếp hạng di tích: 'Di tích lịch sử'
 *          if cosothotu_ditichvanhoa == true
 *              Xếp hạng di tích: 'Di tích văn hóa'
 *          if cosothotu_ditichlichsuvanhoa == true
 *              Xếp hạng di tích: 'Di tích lịch sử văn hóa'
 *          if cosothotu_ditichkientrucnghethuat == true
 *              Xếp hạng di tích: 'Di tích kiến trúc nghệ thuật'
 *          if cosothotu_ditichkhaoco == true
 *              Xếp hạng di tích: 'Di tích khảo cổ'
 *      Cấp công nhận
 *          if cosothotu_captrunguong == true
 *              Cấp công nhận: 'Cấp Trung ương'
 *          if cosothotu_captinh == true
 *              Cấp công nhận: 'Cấp tỉnh'
 * III. TIN LÀNH
 * 3. Bảng chihoitinlanh
 * Tên cơ sở thờ tự: tenchihoi
 * Địa chỉ: diachi_so, diachi_ap, diachi_xa, diachi_huyen, diachi_tinh
 * Thuộc tổ chức tôn giáo cơ sở: Để mặc định là 'Tin Lành'
 * Số lượng tín đồ
 *      Đã thực hiện lễ nghi tôn giáo: tongsotindo_baptem
 *      Chưa thực hiện lễ nghi tôn giáo: tongsotindo_chuabaptem
 *      Là người dân tộc thiểu số: sotindo_dantoc_thieuso
 * Số lượng chức sắc tu sĩ
 *      Chức sắc: sochucsac
 *      Tu sĩ: Để mặc định bằng 0
 *      Chắc sắc là người dân tộc thiểu số: Để mặc định bằng 0
 * Số lượng chức việc
 *      Số lượng chức việc: sothanhvientrongbanchapsu
 *      Số lượng chức việc là người dân tộc thiểu số: Để mặc định bằng 0
 * Năm thành lập: namgiaohoithanhlap
 * Về xây dựng
 *      Năm xây dựng: ttttcs_namxaydung
 *      Số tiền: Để mặc định bằng 0
 * Về trùng tu tôn tạo
 *      Số lần: ttttcs_solan
 *      Số tiền lần cuối: ttttcs_tongkinhphi
 * Diện tích (m2)
 *      Đã cấp GCNQSD đất
 *          Mục đích sử dụng đất TG:
 *              (dattrongkhuonvien_tongiao_dientich - dattrongkhuonvien_tongiao_chuacap_dientich) +
 *              (datngoaikhuonvien_tongiao_dientich_1 - datngoaikhuonvien_tongiao_chuacap_dientich_1) +
 *              (datngoaikhuonvien_tongiao_dientich_2 - datngoaikhuonvien_tongiao_chuacap_dientich_2) +
 *              (datngoaikhuonvien_tongiao_dientich_3 - datngoaikhuonvien_tongiao_chuacap_dientich_3)
 *          Mục đích sử dụng khác:
 *              (dattrongkhuonvien_nnlnntts_dientich - dattrongkhuonvien_nnlnntts_chuacap_dientich) +
 *              (dattrongkhuonvien_gdyt_dientich - dattrongkhuonvien_gdyt_chuacap_dientich) +
 *              (dattrongkhuonvien_nghiadia_dientich - dattrongkhuonvien_nghiadia_chuacap_dientich) +
 *              (dattrongkhuonvien_dsdmdk_dientich - dattrongkhuonvien_dsdmdk_chuacap_dientich) +
 *              (datngoaikhuonvien_nnlnntts_dientich_1 - datngoaikhuonvien_nnlnntts_chuacap_dientich_1) +
 *              (datngoaikhuonvien_gdyt_dientich_1 - datngoaikhuonvien_gdyt_chuacap_dientich_1) +
 *              (datngoaikhuonvien_nghiadia_dientich_1 - datngoaikhuonvien_nghiadia_chuacap_dientich_1) +
 *              (datngoaikhuonvien_dsdmdk_dientich_1 - datngoaikhuonvien_dsdmdk_chuacap_dientich_1) +
 *              (datngoaikhuonvien_nnlnntts_dientich_2 - datngoaikhuonvien_nnlnntts_chuacap_dientich_2) +
 *              (datngoaikhuonvien_gdyt_dientich_2 - datngoaikhuonvien_gdyt_chuacap_dientich_2) +
 *              (datngoaikhuonvien_nghiadia_dientich_2 - datngoaikhuonvien_nghiadia_chuacap_dientich_2) +
 *              (datngoaikhuonvien_dsdmdk_dientich_2 - datngoaikhuonvien_dsdmdk_chuacap_dientich_2) +
 *              (datngoaikhuonvien_nnlnntts_dientich_3 - datngoaikhuonvien_nnlnntts_chuacap_dientich_3) +
 *              (datngoaikhuonvien_gdyt_dientich_3 - datngoaikhuonvien_gdyt_chuacap_dientich_3) +
 *              (datngoaikhuonvien_nghiadia_dientich_3 - datngoaikhuonvien_nghiadia_chuacap_dientich_3) +
 *              (datngoaikhuonvien_dsdmdk_dientich_3 - datngoaikhuonvien_dsdmdk_chuacap_dientich_3)
 *      Chưa được cấp GCNQSD đất:
 *          dattrongkhuonvien_tongiao_chuacap_dientich + dattrongkhuonvien_nnlnntts_chuacap_dientich +
 *          dattrongkhuonvien_gdyt_chuacap_dientich + dattrongkhuonvien_nghiadia_chuacap_dientich + dattrongkhuonvien_dsdmdk_chuacap_dientich +
 *          datngoaikhuonvien_tongiao_chuacap_dientich_1 + datngoaikhuonvien_nnlnntts_chuacap_dientich_1 +
 *          datngoaikhuonvien_gdyt_chuacap_dientich_1 + datngoaikhuonvien_nghiadia_chuacap_dientich_1 + datngoaikhuonvien_dsdmdk_chuacap_dientich_1 +
 *          datngoaikhuonvien_tongiao_chuacap_dientich_2 + datngoaikhuonvien_nnlnntts_chuacap_dientich_2 +
 *          datngoaikhuonvien_gdyt_chuacap_dientich_2 + datngoaikhuonvien_nghiadia_chuacap_dientich_2 + datngoaikhuonvien_dsdmdk_chuacap_dientich_2 +
 *          datngoaikhuonvien_tongiao_chuacap_dientich_3 + datngoaikhuonvien_nnlnntts_chuacap_dientich_3 +
 *          datngoaikhuonvien_gdyt_chuacap_dientich_3 + datngoaikhuonvien_nghiadia_chuacap_dientich_3 + datngoaikhuonvien_dsdmdk_chuacap_dientich_3
 *
 * Kiến trúc: Để mặc định là rỗng
 * Di tích
 *      Xếp hạng di tích:
 *          if cosothotu_ditichlichsu == true
 *              Xếp hạng di tích: 'Di tích lịch sử'
 *          if cosothotu_ditichvanhoa == true
 *              Xếp hạng di tích: 'Di tích văn hóa'
 *          if cosothotu_ditichlichsuvanhoa == true
 *              Xếp hạng di tích: 'Di tích lịch sử văn hóa'
 *          if cosothotu_ditichkientrucnghethuat == true
 *              Xếp hạng di tích: 'Di tích kiến trúc nghệ thuật'
 *          if cosothotu_ditichkhaoco == true
 *              Xếp hạng di tích: 'Di tích khảo cổ'
 *      Cấp công nhận
 *          if cosothotu_captrunguong == true
 *              Cấp công nhận: 'Cấp Trung ương'
 *          if cosothotu_captinh == true
 *              Cấp công nhận: 'Cấp tỉnh'
 * IV. CAO ĐÀI
 * 4. Bảng hodaocaodai
 * Tên cơ sở thờ tự: tenhodao
 * Địa chỉ: tenhodao_diachi_so, tenhodao_diachi_duong, tenhodao_diachi_ap, tenhodao_diachi_xa, tenhodao_diachi_huyen, tenhodao_diachi_tinh
 * Thuộc tổ chức tôn giáo cơ sở: Để mặc định là 'Cao Đài'
 * Số lượng tín đồ
 *      Đã thực hiện lễ nghi tôn giáo: tongsotindo_cosocaudao
 *      Chưa thực hiện lễ nghi tôn giáo: tongsotindo_chuacosocaudao
 *      Là người dân tộc thiểu số: sotindo_dantoc_thieuso
 * Số lượng chức sắc tu sĩ
 *      Chức sắc: sochucsac_phoisu + sochucsac_giaosu + sochucsac_giaohuu + sochucsac_lesanh
 *      Tu sĩ: Để mặc định bằng 0
 *      Chắc sắc là người dân tộc thiểu số: Để mặc định bằng 0
 * Số lượng chức việc
 *      Số lượng chức việc: sothanvien_bancaiquan
 *      Số lượng chức việc là người dân tộc thiểu số: Để mặc định bằng 0
 * Năm thành lập: namhoithanhthanhlap
 * Về xây dựng
 *      Năm xây dựng: ttttcs_namxaydung
 *      Số tiền: Để mặc định bằng 0
 * Về trùng tu tôn tạo
 *      Số lần: ttttcs_solan
 *      Số tiền lần cuối: ttttcs_tongkinhphi
 * Diện tích (m2)
 *      Đã cấp GCNQSD đất
 *          Mục đích sử dụng đất TG:
 *              (dattrongkhuonvien_tongiao_dientich - dattrongkhuonvien_tongiao_chuacap_dientich) +
 *              (datngoaikhuonvien_tongiao_dientich_1 - datngoaikhuonvien_tongiao_chuacap_dientich_1) +
 *              (datngoaikhuonvien_tongiao_dientich_2 - datngoaikhuonvien_tongiao_chuacap_dientich_2) +
 *              (datngoaikhuonvien_tongiao_dientich_3 - datngoaikhuonvien_tongiao_chuacap_dientich_3)
 *          Mục đích sử dụng khác:
 *              (dattrongkhuonvien_nnlnntts_dientich - dattrongkhuonvien_nnlnntts_chuacap_dientich) +
 *              (dattrongkhuonvien_gdyt_dientich - dattrongkhuonvien_gdyt_chuacap_dientich) +
 *              (dattrongkhuonvien_dsdmdk_dientich - dattrongkhuonvien_dsdmdk_chuacap_dientich) +
 *              (datngoaikhuonvien_nnlnntts_dientich_1 - datngoaikhuonvien_nnlnntts_chuacap_dientich_1) +
 *              (datngoaikhuonvien_gdyt_dientich_1 - datngoaikhuonvien_gdyt_chuacap_dientich_1) +
 *              (datngoaikhuonvien_dsdmdk_dientich_1 - datngoaikhuonvien_dsdmdk_chuacap_dientich_1) +
 *              (datngoaikhuonvien_nnlnntts_dientich_2 - datngoaikhuonvien_nnlnntts_chuacap_dientich_2) +
 *              (datngoaikhuonvien_gdyt_dientich_2 - datngoaikhuonvien_gdyt_chuacap_dientich_2) +
 *              (datngoaikhuonvien_nnlnntts_dientich_3 - datngoaikhuonvien_nnlnntts_chuacap_dientich_3) +
 *              (datngoaikhuonvien_gdyt_dientich_3 - datngoaikhuonvien_gdyt_chuacap_dientich_3) +
 *              (datngoaikhuonvien_dsdmdk_dientich_3 - datngoaikhuonvien_dsdmdk_chuacap_dientich_3)
 *      Chưa được cấp GCNQSD đất:
 *          dattrongkhuonvien_tongiao_chuacap_dientich + dattrongkhuonvien_nnlnntts_chuacap_dientich +
 *          dattrongkhuonvien_gdyt_chuacap_dientich + dattrongkhuonvien_dsdmdk_chuacap_dientich +
 *          datngoaikhuonvien_tongiao_chuacap_dientich_1 + datngoaikhuonvien_nnlnntts_chuacap_dientich_1 +
 *          datngoaikhuonvien_gdyt_chuacap_dientich_1 + datngoaikhuonvien_dsdmdk_chuacap_dientich_1 +
 *          datngoaikhuonvien_tongiao_chuacap_dientich_2 + datngoaikhuonvien_nnlnntts_chuacap_dientich_2 +
 *          datngoaikhuonvien_gdyt_chuacap_dientich_2 + datngoaikhuonvien_dsdmdk_chuacap_dientich_2 +
 *          datngoaikhuonvien_tongiao_chuacap_dientich_3 + datngoaikhuonvien_nnlnntts_chuacap_dientich_3 +
 *          datngoaikhuonvien_gdyt_chuacap_dientich_3 + datngoaikhuonvien_dsdmdk_chuacap_dientich_3
 * Kiến trúc: Để mặc định là rỗng
 * Di tích
 *      Xếp hạng di tích:
 *          if cosothotu_ditichlichsu == true
 *              Xếp hạng di tích: 'Di tích lịch sử'
 *          if cosothotu_ditichvanhoa == true
 *              Xếp hạng di tích: 'Di tích văn hóa'
 *          if cosothotu_ditichlichsuvanhoa == true
 *              Xếp hạng di tích: 'Di tích lịch sử văn hóa'
 *          if cosothotu_ditichkientrucnghethuat == true
 *              Xếp hạng di tích: 'Di tích kiến trúc nghệ thuật'
 *          if cosothotu_ditichkhaoco == true
 *              Xếp hạng di tích: 'Di tích khảo cổ'
 *      Cấp công nhận
 *          if cosothotu_captrunguong == true
 *              Cấp công nhận: 'Cấp Trung ương'
 *          if cosothotu_captinh == true
 *              Cấp công nhận: 'Cấp tỉnh'
 *
 * V. TĐCSPHVN
 * 5. Bảng chihoitinhdocusiphatgiaovietnam
 * Tên cơ sở thờ tự: tenchihoi
 * Địa chỉ: tenchihoi_diachi_so, tenchihoi_diachi_duong, tenchihoi_diachi_ap, tenchihoi_diachi_xa, tenchihoi_diachi_huyen, tenchihoi_diachi_tinh
 * Thuộc tổ chức tôn giáo cơ sở: Để mặc định là 'Tịnh độ cư sĩ phật hội'
 * Số lượng tín đồ
 *      Đã thực hiện lễ nghi tôn giáo: soluonghoivien_tindo
 *      Chưa thực hiện lễ nghi tôn giáo: soluonghoivien_tindo
 *      Là người dân tộc thiểu số: sotindo_dantoc_thieuso
 * Số lượng chức sắc tu sĩ
 *      Chức sắc: Để mặc định bằng 0
 *      Tu sĩ: Để mặc định bằng 0
 *      Chắc sắc là người dân tộc thiểu số: Để mặc định bằng 0
 * Số lượng chức việc
 *      Số lượng chức việc: Để mặc định bằng 0
 *      Số lượng chức việc là người dân tộc thiểu số: Để mặc định bằng 0
 * Năm thành lập: namhoithanhthanhlap
 * Về xây dựng
 *      Năm xây dựng: ttttcs_namxaydung
 *      Số tiền: Để mặc định bằng 0
 * Về trùng tu tôn tạo
 *      Số lần: ttttcs_solan
 *      Số tiền lần cuối: ttttcs_tongkinhphi
 * Diện tích (m2)
 *      Đã cấp GCNQSD đất
 *          Mục đích sử dụng đất TG:
 *              (dattrongkhuonvien_tongiao_dientich - dattrongkhuonvien_tongiao_chuacap_dientich) +
 *              (datngoaikhuonvien_tongiao_dientich_1 - datngoaikhuonvien_tongiao_chuacap_dientich_1) +
 *              (datngoaikhuonvien_tongiao_dientich_2 - datngoaikhuonvien_tongiao_chuacap_dientich_2) +
 *              (datngoaikhuonvien_tongiao_dientich_3 - datngoaikhuonvien_tongiao_chuacap_dientich_3)
 *          Mục đích sử dụng khác:
 *              (dattrongkhuonvien_nnlnntts_dientich - dattrongkhuonvien_nnlnntts_chuacap_dientich) +
 *              (dattrongkhuonvien_gdyt_dientich - dattrongkhuonvien_gdyt_chuacap_dientich) +
 *              (dattrongkhuonvien_dsdmdk_dientich - dattrongkhuonvien_dsdmdk_chuacap_dientich) +
 *              (datngoaikhuonvien_nnlnntts_dientich_1 - datngoaikhuonvien_nnlnntts_chuacap_dientich_1) +
 *              (datngoaikhuonvien_gdyt_dientich_1 - datngoaikhuonvien_gdyt_chuacap_dientich_1) +
 *              (datngoaikhuonvien_dsdmdk_dientich_1 - datngoaikhuonvien_dsdmdk_chuacap_dientich_1) +
 *              (datngoaikhuonvien_nnlnntts_dientich_2 - datngoaikhuonvien_nnlnntts_chuacap_dientich_2) +
 *              (datngoaikhuonvien_gdyt_dientich_2 - datngoaikhuonvien_gdyt_chuacap_dientich_2) +
 *              (datngoaikhuonvien_nnlnntts_dientich_3 - datngoaikhuonvien_nnlnntts_chuacap_dientich_3) +
 *              (datngoaikhuonvien_gdyt_dientich_3 - datngoaikhuonvien_gdyt_chuacap_dientich_3) +
 *              (datngoaikhuonvien_dsdmdk_dientich_3 - datngoaikhuonvien_dsdmdk_chuacap_dientich_3)
 *      Chưa được cấp GCNQSD đất:
 *          dattrongkhuonvien_tongiao_chuacap_dientich + dattrongkhuonvien_nnlnntts_chuacap_dientich +
 *          dattrongkhuonvien_gdyt_chuacap_dientich + dattrongkhuonvien_dsdmdk_chuacap_dientich +
 *          datngoaikhuonvien_tongiao_chuacap_dientich_1 + datngoaikhuonvien_nnlnntts_chuacap_dientich_1 +
 *          datngoaikhuonvien_gdyt_chuacap_dientich_1 + datngoaikhuonvien_dsdmdk_chuacap_dientich_1 +
 *          datngoaikhuonvien_tongiao_chuacap_dientich_2 + datngoaikhuonvien_nnlnntts_chuacap_dientich_2 +
 *          datngoaikhuonvien_gdyt_chuacap_dientich_2 + datngoaikhuonvien_dsdmdk_chuacap_dientich_2 +
 *          datngoaikhuonvien_tongiao_chuacap_dientich_3 + datngoaikhuonvien_nnlnntts_chuacap_dientich_3 +
 *          datngoaikhuonvien_gdyt_chuacap_dientich_3 + datngoaikhuonvien_dsdmdk_chuacap_dientich_3
 * Kiến trúc: Để mặc định là rỗng
 * Di tích
 *      Xếp hạng di tích:
 *          if cosothotu_ditichlichsu == true
 *              Xếp hạng di tích: 'Di tích lịch sử'
 *          if cosothotu_ditichvanhoa == true
 *              Xếp hạng di tích: 'Di tích văn hóa'
 *          if cosothotu_ditichlichsuvanhoa == true
 *              Xếp hạng di tích: 'Di tích lịch sử văn hóa'
 *          if cosothotu_ditichkientrucnghethuat == true
 *              Xếp hạng di tích: 'Di tích kiến trúc nghệ thuật'
 *          if cosothotu_ditichkhaoco == true
 *              Xếp hạng di tích: 'Di tích khảo cổ'
 *      Cấp công nhận
 *          if cosothotu_captrunguong == true
 *              Cấp công nhận: 'Cấp Trung ương'
 *          if cosothotu_captinh == true
 *              Cấp công nhận: 'Cấp tỉnh'
 *
 * VI. HỒI GIÁO
 * 6. Bảng cosohoigiaoislam
 * Tên cơ sở thờ tự: tenthanhduong
 * Địa chỉ: tenthanhduong_diachi_so, tenthanhduong_diachi_duong, tenthanhduong_diachi_ap, tenthanhduong_diachi_xa, tenthanhduong_diachi_huyen, tenthanhduong_diachi_tinh
 * Thuộc tổ chức tôn giáo cơ sở: Để mặc định là 'Hồi Giáo'
 * Số lượng tín đồ
 *      Đã thực hiện lễ nghi tôn giáo: tongsotindo
 *      Chưa thực hiện lễ nghi tôn giáo: tongsotindo
 *      Là người dân tộc thiểu số: sotindo_dantoc_thieuso
 * Số lượng chức sắc tu sĩ
 *      Chức sắc: Để mặc định bằng 0
 *      Tu sĩ: Để mặc định bằng 0
 *      Chắc sắc là người dân tộc thiểu số: Để mặc định bằng 0
 * Số lượng chức việc
 *      Số lượng chức việc: Để mặc định bằng 0
 *      Số lượng chức việc là người dân tộc thiểu số: Để mặc định bằng 0
 * Năm thành lập: namgiaohoithanhlap
 * Về xây dựng
 *      Năm xây dựng: ttttcs_namxaydung
 *      Số tiền: Để mặc định bằng 0
 * Về trùng tu tôn tạo
 *      Số lần: ttttcs_solan
 *      Số tiền lần cuối: ttttcs_tongkinhphi
 * Diện tích (m2)
 *      Đã cấp GCNQSD đất
 *          Mục đích sử dụng đất TG:
 *              (dattrongkhuonvien_tongiao_dientich - dattrongkhuonvien_tongiao_chuacap_dientich) +
 *              (datngoaikhuonvien_tongiao_dientich_1 - datngoaikhuonvien_tongiao_chuacap_dientich_1) +
 *              (datngoaikhuonvien_tongiao_dientich_2 - datngoaikhuonvien_tongiao_chuacap_dientich_2) +
 *              (datngoaikhuonvien_tongiao_dientich_3 - datngoaikhuonvien_tongiao_chuacap_dientich_3)
 *          Mục đích sử dụng khác:
 *              (dattrongkhuonvien_nnlnntts_dientich - dattrongkhuonvien_nnlnntts_chuacap_dientich) +
 *              (dattrongkhuonvien_gdyt_dientich - dattrongkhuonvien_gdyt_chuacap_dientich) +
 *              (dattrongkhuonvien_dsdmdk_dientich - dattrongkhuonvien_dsdmdk_chuacap_dientich) +
 *              (datngoaikhuonvien_nnlnntts_dientich_1 - datngoaikhuonvien_nnlnntts_chuacap_dientich_1) +
 *              (datngoaikhuonvien_gdyt_dientich_1 - datngoaikhuonvien_gdyt_chuacap_dientich_1) +
 *              (datngoaikhuonvien_dsdmdk_dientich_1 - datngoaikhuonvien_dsdmdk_chuacap_dientich_1) +
 *              (datngoaikhuonvien_nnlnntts_dientich_2 - datngoaikhuonvien_nnlnntts_chuacap_dientich_2) +
 *              (datngoaikhuonvien_gdyt_dientich_2 - datngoaikhuonvien_gdyt_chuacap_dientich_2) +
 *              (datngoaikhuonvien_nnlnntts_dientich_3 - datngoaikhuonvien_nnlnntts_chuacap_dientich_3) +
 *              (datngoaikhuonvien_gdyt_dientich_3 - datngoaikhuonvien_gdyt_chuacap_dientich_3) +
 *              (datngoaikhuonvien_dsdmdk_dientich_3 - datngoaikhuonvien_dsdmdk_chuacap_dientich_3)
 *      Chưa được cấp GCNQSD đất:
 *          dattrongkhuonvien_tongiao_chuacap_dientich + dattrongkhuonvien_nnlnntts_chuacap_dientich +
 *          dattrongkhuonvien_gdyt_chuacap_dientich + dattrongkhuonvien_dsdmdk_chuacap_dientich +
 *          datngoaikhuonvien_tongiao_chuacap_dientich_1 + datngoaikhuonvien_nnlnntts_chuacap_dientich_1 +
 *          datngoaikhuonvien_gdyt_chuacap_dientich_1 + datngoaikhuonvien_dsdmdk_chuacap_dientich_1 +
 *          datngoaikhuonvien_tongiao_chuacap_dientich_2 + datngoaikhuonvien_nnlnntts_chuacap_dientich_2 +
 *          datngoaikhuonvien_gdyt_chuacap_dientich_2 + datngoaikhuonvien_dsdmdk_chuacap_dientich_2 +
 *          datngoaikhuonvien_tongiao_chuacap_dientich_3 + datngoaikhuonvien_nnlnntts_chuacap_dientich_3 +
 *          datngoaikhuonvien_gdyt_chuacap_dientich_3 + datngoaikhuonvien_dsdmdk_chuacap_dientich_3
 * Kiến trúc: Để mặc định là rỗng
 * Di tích
 *      Xếp hạng di tích:
 *          if cosothotu_ditichlichsu == true
 *              Xếp hạng di tích: 'Di tích lịch sử'
 *          if cosothotu_ditichvanhoa == true
 *              Xếp hạng di tích: 'Di tích văn hóa'
 *          if cosothotu_ditichlichsuvanhoa == true
 *              Xếp hạng di tích: 'Di tích lịch sử văn hóa'
 *          if cosothotu_ditichkientrucnghethuat == true
 *              Xếp hạng di tích: 'Di tích kiến trúc nghệ thuật'
 *          if cosothotu_ditichkhaoco == true
 *              Xếp hạng di tích: 'Di tích khảo cổ'
 *      Cấp công nhận
 *          if cosothotu_captrunguong == true
 *              Cấp công nhận: 'Cấp Trung ương'
 *          if cosothotu_captinh == true
 *              Cấp công nhận: 'Cấp tỉnh'
 *
 * VII. TÍN NGƯỠNG
 * 6. Bảng cosotinnguong
 * Tên cơ sở thờ tự: tencoso
 * Địa chỉ: diachi_so, diachi_duong, diachi_ap, diachi_xa, diachi_huyen, diachi_tinh
 * Thuộc tổ chức tôn giáo cơ sở: Để mặc định là 'Tín Ngưỡng'
 * Số lượng tín đồ
 *      Đã thực hiện lễ nghi tôn giáo: Để mặc định bằng 0
 *      Chưa thực hiện lễ nghi tôn giáo: Để mặc định bằng 0
 *      Là người dân tộc thiểu số: Để mặc định bằng 0
 * Số lượng chức sắc tu sĩ
 *      Chức sắc: Để mặc định bằng 0
 *      Tu sĩ: Để mặc định bằng 0
 *      Chắc sắc là người dân tộc thiểu số: Để mặc định bằng 0
 * Số lượng chức việc
 *      Số lượng chức việc: Để mặc định bằng 0
 *      Số lượng chức việc là người dân tộc thiểu số: Để mặc định bằng 0
 * Năm thành lập: namthanhlap
 * Về xây dựng
 *      Năm xây dựng: namxaydung
 *      Số tiền: Để mặc định bằng 0
 * Về trùng tu tôn tạo
 *      Số lần: ttttcs_solan
 *      Số tiền lần cuối: ttttcs_tongkinhphi
 * Diện tích (m2)
 *      Đã cấp GCNQSD đất
 *          Mục đích sử dụng đất TG:
 *              tongiao_dientich - tongiao_chuacap_dientich
 *          Mục đích sử dụng khác:
 *              (nnlnntts_dientich - nnlnntts_chuacap_dientich) +
 *              (gdyt_dientich - gdyt_chuacap_dientich) +
 *              (dsdmdk_dientich - dsdmdk_chuacap_dientich)
 *      Chưa được cấp GCNQSD đất:
 *          tongiao_chuacap_dientich + nnlnntts_chuacap_dientich +
 *          gdyt_chuacap_dientich + dsdmdk_chuacap_dientich
 * Kiến trúc: Để mặc định là rỗng
 * Di tích
 *      Xếp hạng di tích:
 *          if cosothotu_ditichlichsu == true
 *              Xếp hạng di tích: 'Di tích lịch sử'
 *          if cosothotu_ditichvanhoa == true
 *              Xếp hạng di tích: 'Di tích văn hóa'
 *          if cosothotu_ditichlichsuvanhoa == true
 *              Xếp hạng di tích: 'Di tích lịch sử văn hóa'
 *          if cosothotu_ditichkientrucnghethuat == true
 *              Xếp hạng di tích: 'Di tích kiến trúc nghệ thuật'
 *          if cosothotu_ditichkhaoco == true
 *              Xếp hạng di tích: 'Di tích khảo cổ'
 *      Cấp công nhận
 *          if cosothotu_captrunguong == true
 *              Cấp công nhận: 'Cấp Trung ương'
 *          if cosothotu_captinh == true
 *              Cấp công nhận: 'Cấp tỉnh'
 *
 */
