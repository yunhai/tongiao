<?php

class ExportThCscvComponent extends Component
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
        $export_fields = [
            'Chucsacnhatuhanhconggiaotrieu',
            'Chucsacnhatuhanhphatgiao',
            'Chucsactinlanh',
            'Chucsaccaodai',
            'Chucviechoigiao',
            'Chucviectinhdocusiphathoivietnam'
        ];

        $province = $this->Province->getProvince();

        $export = $this->init($province);

        foreach ($export_fields as $field_index => $model) {
            $func = '__get' . $model;
            $tmp = $this->$func($model);

            foreach ($province as $provice_code => $name) {
                $partial = $tmp[$provice_code];

                foreach ($partial as $field => $value) {
                    if ($field === 'total') {
                        $export[$provice_code]['total'] += $value;
                    }
                    $export[$provice_code][$model . '_' . $field] = $value;
                }
            }
        }

        return $export;
    }

    private function init($province)
    {
        $index = 1;
        $export = [];

        foreach ($province as $code => $name) {
            $export[$code] = [
                'index' => $index++,
                'province' => $name,
                'total' => 0,
            ];
        }

        return $export;
    }

    private function __getChucviectinhdocusiphathoivietnam($model)
    {
        $fields = [
            'id',
            'noiohiennay_huyen'
        ];
        $conditions = [
            'noiohiennay_huyen <>' => '',
            'noiohiennay_huyen is not null',
            'or' => [
                'phamsactrongtongiao_ntn_bonhiem_phogiangsu is not null',
                'phamsactrongtongiao_ntn_bonhiem_phogiangsu <>' => '',
                'phamsactrongtongiao_ntn_bonhiem_thuyettrinhvien is not null',
                'phamsactrongtongiao_ntn_bonhiem_thuyettrinhvien <>' => '',
            ]
        ];
        $column = [
            'phamsactrongtongiao_ntn_bonhiem_phogiangsu',
            'phamsactrongtongiao_ntn_bonhiem_thuyettrinhvien',
        ];
        $province_field = 'noiohiennay_huyen';

        $fields = array_merge($fields, $column);

        $data = $this->__getData($model, compact('fields', 'conditions'));

        $result = $this->__groupData($data, $column, $province_field);
        foreach ($result as &$item) {
            $total = array_sum($item);
            $item = array(
                'total' => $total,
                'phamsactrongtongiao_ntn_bonhiem_phogiangsu' => $item['phamsactrongtongiao_ntn_bonhiem_phogiangsu'],
                'phamsactrongtongiao_ntn_bonhiem_thuyettrinhvien' => $item['phamsactrongtongiao_ntn_bonhiem_thuyettrinhvien'],
                'ysi' => 0,
                'ysinh' => 0,
            );
        }

        return $result;
    }

    private function __getChucviechoigiao($model)
    {
        $fields = [
            'id',
            'noiohiennay_huyen'
        ];
        $conditions = [
            'noiohiennay_huyen <>' => '',
            'noiohiennay_huyen is not null',
            'or' => [
                'phamsactrongtongiao_ntn_bonhiem_hakim is not null',
                'phamsactrongtongiao_ntn_bonhiem_hakim <>' => '',
                'phamsactrongtongiao_ntn_bonhiem_naep is not null',
                'phamsactrongtongiao_ntn_bonhiem_naep <>' => '',
                'phamsactrongtongiao_ntn_bonhiem_khotip is not null',
                'phamsactrongtongiao_ntn_bonhiem_khotip <>' => '',
                'phamsactrongtongiao_ntn_bonhiem_imam is not null',
                'phamsactrongtongiao_ntn_bonhiem_imam <>' => '',
                'phamsactrongtongiao_ntn_bonhiem_tuon is not null',
                'phamsactrongtongiao_ntn_bonhiem_tuon <>' => '',
            ]
        ];
        $column = [
            'phamsactrongtongiao_ntn_bonhiem_hakim',
            'phamsactrongtongiao_ntn_bonhiem_naep',
            'phamsactrongtongiao_ntn_bonhiem_khotip',
            'phamsactrongtongiao_ntn_bonhiem_imam',
            'phamsactrongtongiao_ntn_bonhiem_tuon',
        ];
        $province_field = 'noiohiennay_huyen';

        $fields = array_merge($fields, $column);

        $data = $this->__getData($model, compact('fields', 'conditions'));

        $result = $this->__groupData($data, $column, $province_field);
        foreach ($result as &$item) {
            $total = array_sum($item);
            $item = array(
                'total' => $total,
                'phamsactrongtongiao_ntn_bonhiem_hakim' => $item['phamsactrongtongiao_ntn_bonhiem_hakim'],
                'phamsactrongtongiao_ntn_bonhiem_naep' => $item['phamsactrongtongiao_ntn_bonhiem_naep'],
                'ahly' => 0,
                'phamsactrongtongiao_ntn_bonhiem_khotip' => $item['phamsactrongtongiao_ntn_bonhiem_khotip'],
                'phamsactrongtongiao_ntn_bonhiem_imam' => $item['phamsactrongtongiao_ntn_bonhiem_imam'],
                'phamsactrongtongiao_ntn_bonhiem_tuon' => $item['phamsactrongtongiao_ntn_bonhiem_tuon'],
            );
        }

        return $result;
    }

    private function __getChucsaccaodai($model)
    {
        $fields = [
            'id',
            'noiohiennay_huyen'
        ];
        $conditions = [
            'noiohiennay_huyen <>' => '',
            'noiohiennay_huyen is not null',
            'or' => [
                'phamsac_ntn_cauthang_phosu is not null',
                'phamsac_ntn_cauthang_phosu <>' => '',
                'phamsac_ntn_cauthang_giaosu is not null',
                'phamsac_ntn_cauthang_giaosu <>' => '',
                'phamsac_ntn_cauthang_giaohuu is not null',
                'phamsac_ntn_cauthang_giaohuu <>' => '',
                'phamsac_ntn_cauphong_lesanh is not null',
                'phamsac_ntn_cauphong_lesanh' => '',
            ]
        ];
        $column = [
            'phamsac_ntn_cauthang_phosu',
            'phamsac_ntn_cauthang_giaosu',
            'phamsac_ntn_cauthang_giaohuu',
            'phamsac_ntn_cauphong_lesanh'
        ];
        $province_field = 'noiohiennay_huyen';

        $fields = array_merge($fields, $column);

        $data = $this->__getData($model, compact('fields', 'conditions'));

        $result = $this->__groupData($data, $column, $province_field);
        foreach ($result as &$item) {
            $total = array_sum($item);
            $item = array(
                'total' => $total,
                'phamsac_ntn_cauthang_phosu' => $item['phamsac_ntn_cauthang_phosu'],
                'phamsac_ntn_cauthang_giaosu' => $item['phamsac_ntn_cauthang_giaosu'],
                'phamsac_ntn_cauthang_giaohuu' => $item['phamsac_ntn_cauthang_giaohuu'],
                'phamsac_ntn_cauphong_lesanh' => $item['phamsac_ntn_cauphong_lesanh'],
            );
        }

        return $result;
    }

    private function __getChucsactinlanh($model)
    {
        $fields = [
            'id',
            'noiohiennay_huyen'
        ];
        $conditions = [
            'noiohiennay_huyen <>' => '',
            'noiohiennay_huyen is not null',
            'or' => [
                'phamsactrongtongiao_ntn_duocphong_mucsu is not null',
                'phamsactrongtongiao_ntn_duocphong_mucsu <>' => '',
                'phamsactrongtongiao_ntn_duocphong_mucsunc is not null',
                'phamsactrongtongiao_ntn_duocphong_mucsunc <>' => '',
                'phamsactrongtongiao_ntn_duocphong_truyendao is not null',
                'phamsactrongtongiao_ntn_duocphong_truyendao <>' => '',
            ]
        ];
        $column = [
            'phamsactrongtongiao_ntn_duocphong_mucsu',
            'phamsactrongtongiao_ntn_duocphong_mucsunc',
            'phamsactrongtongiao_ntn_duocphong_truyendao',
        ];
        $province_field = 'noiohiennay_huyen';

        $fields = array_merge($fields, $column);

        $data = $this->__getData($model, compact('fields', 'conditions'));

        $result = $this->__groupData($data, $column, $province_field);
        foreach ($result as &$item) {
            $total = array_sum($item);
            $item = array(
                'total' => $total,
                'phamsactrongtongiao_ntn_duocphong_mucsu' => $item['phamsactrongtongiao_ntn_duocphong_mucsu'],
                'phamsactrongtongiao_ntn_duocphong_mucsunc' => $item['phamsactrongtongiao_ntn_duocphong_mucsunc'],
                'phamsactrongtongiao_ntn_duocphong_truyendao' => $item['phamsactrongtongiao_ntn_duocphong_truyendao'],
            );
        }

        return $result;
    }

    private function __getChucsacnhatuhanhphatgiao($model)
    {
        $fields = [
            'id',
            'noiohiennay_huyen'
        ];
        $conditions = [
            'noiohiennay_huyen <>' => '',
            'noiohiennay_huyen is not null',
            'or' => [
                'ntn_tanphong_hoathuong_hoac_nitruong is not null',
                'ntn_tanphong_hoathuong_hoac_nitruong <>' => '',
                'ntn_tanphong_thuongtao_hoac_nisu is not null',
                'ntn_tanphong_thuongtao_hoac_nisu <>' => '',
            ]
        ];
        $column = [
            'ntn_tanphong_hoathuong_hoac_nitruong',
            'ntn_tanphong_thuongtao_hoac_nisu',
            'phapdanh'
        ];
        $province_field = 'noiohiennay_huyen';

        $fields = array_merge($fields, $column);

        $data = $this->__getData($model, compact('fields', 'conditions'));

        $result = $this->__groupChucsacnhatuhanhphatgiaoData($data, $column, $province_field);

        foreach ($result as &$item) {
            $total = array_sum($item);
            $item = array_merge(['total' => $total], $item);
        }
        print('<pre>');
        print_r($result);
        print('</pre>');
        exit;
        return $result;
    }

    private function __groupChucsacnhatuhanhphatgiaoData($data, $column, $province_field)
    {
        $result = [];
        $province = $this->Province->getProvince();

        foreach ($province as $provice_code => $name) {
            $result[$provice_code] = array(
                'hoathuong' => 0,
                'thuongtoa' => 0,
                'nitruong' => 0,
                'nisu' => 0
            );
        }

        foreach ($data as $id => $item) {
            $provice_code = $this->Province->retrieveProvinceCode($item[$province_field]);
            if (!$provice_code) {
                continue;
            }
            $field = $this->__getChucsacnhatuhanhphatgiaoField($item);
            if ($field) {
                $result[$provice_code][$field] = $result[$provice_code][$field] + 1;
            }
        }

        return $result;
    }

    private function __getChucsacnhatuhanhphatgiaoField($target)
    {
        $detect = $this->Utility->slug($target['phapdanh']);

        $gender = 1; // male
        if (strpos($detect, 'tn') !== false || strpos($detect, 'thich-nu') !== false) {
            $gender = 0; // female
        }

        if ($target['ntn_tanphong_hoathuong_hoac_nitruong']) {
            return $gender ? 'hoathuong' : 'nitruong';
        }

        if ($target['ntn_tanphong_thuongtao_hoac_nisu']) {
            return $gender ? 'thuongtoa' : 'nisu';
        }

        return '';
    }

    private function __getChucsacnhatuhanhconggiaotrieu($model)
    {
        $fields = [
            'id',
            'noiohiennay_huyen'
        ];
        $conditions = [
            'noiohiennay_huyen <>' => '',
            'noiohiennay_huyen is not null',
            'or' => [
                'phamsactrongtongiao_namphong_giammuc is not null',
                'phamsactrongtongiao_namphong_giammuc <>' => '',
                'phamsactrongtongiao_namphong_linhmuc is not null',
                'phamsactrongtongiao_namphong_linhmuc <>' => '',
            ]
        ];
        $column = [
            'phamsactrongtongiao_namphong_giammuc',
            'phamsactrongtongiao_namphong_linhmuc'
        ];
        $province_field = 'noiohiennay_huyen';

        $fields = array_merge($fields, $column);

        $data = $this->__getData($model, compact('fields', 'conditions'));

        $result = $this->__groupData($data, $column, $province_field);

        foreach ($result as &$item) {
            $total = array_sum($item);
            $item = array(
                'total' => $total,
                'phamsactrongtongiao_namphong_giammuc' => $item['phamsactrongtongiao_namphong_giammuc'],
                'betrentongquyen' => 0,
                'giamtinh' => 0,
                'phamsactrongtongiao_namphong_linhmuc' => $item['phamsactrongtongiao_namphong_linhmuc']
            );
        }

        return $result;
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
            $result[$provice_code] = array();
            foreach ($column as $col) {
                $result[$provice_code][$col] = 0;
            }
        }

        foreach ($data as $id => $item) {
            $provice_code = $this->Province->retrieveProvinceCode($item[$province_field]);
            if (!$provice_code) {
                continue;
            }

            foreach ($result[$provice_code] as $key => &$count) {
                if ($item[$key]) {
                    $count++;
                }
            }
        }

        return $result;
    }
}

/**
 * TONG HOP CHUC SAC CO CHUC VU
 * BẢNG TỔNG HỢP CHỨC SẮC CÁC TÔN GIÁO TRÊN ĐỊA BÀN TỈNH (CÓ CHỨC VỤ)
 *
 * I. CÔNG GIÁO
 * 1. Bảng chucsacnhatuhanhconggiaotrieu
 * Tương ứng với từng huyện: BIÊN HÒA/LONG KHÁNH/XUÂN LỘC/CẨM MỸ/TÂN PHÚ/ĐỊNH QUÁN/THỐNG NHẤT/TRẢNG BOM/VĨNH CỬU/NHƠN TRẠCH/LONG THÀNH
 * noiohiennay_huyen = Tương ứng với từng huyện ở trên và điều kiện
 * GIÁM MỤC: phamsactrongtongiao_namphong_giammuc != null
 * BỀ TRÊN TỔNG QUYỀN: Để mặc định bằng 0
 * GIÁM TỈNH: Để mặc định bằng 0
 * LINH MỤC: phamsactrongtongiao_namphong_linhmuc != null
 *
 * II. PHẬT GIÁO
 * 2. Bảng chucsacnhatuhanhphatgiao
 * Tương ứng với từng huyện: BIÊN HÒA/LONG KHÁNH/XUÂN LỘC/CẨM MỸ/TÂN PHÚ/ĐỊNH QUÁN/THỐNG NHẤT/TRẢNG BOM/VĨNH CỬU/NHƠN TRẠCH/LONG THÀNH
 * noiohiennay_huyen = Tương ứng với từng huyện ở trên và điều kiện
 * HÒA THƯỢNG: (phapdanh NOT LIKE 'TN' và NOT LIKE 'Thích nữ') và ntn_tanphong_hoathuong_hoac_nitruong != null
 * THƯỢNG TỌA: (phapdanh NOT LIKE 'TN' và NOT LIKE 'Thích nữ') và ntn_tanphong_thuongtao_hoac_nisu != null
 * NI TRƯỞNG: (phapdanh LIKE 'TN' hoặc LIKE 'Thích nữ') và ntn_tanphong_hoathuong_hoac_nitruong != null
 * NI SƯ: (phapdanh LIKE 'TN' hoặc LIKE 'Thích nữ') và ntn_tanphong_thuongtao_hoac_nisu != null
 *
 * III. TIN LÀNH
 * 3. Bảng chucsactinlanh
 * Tương ứng với từng huyện: BIÊN HÒA/LONG KHÁNH/XUÂN LỘC/CẨM MỸ/TÂN PHÚ/ĐỊNH QUÁN/THỐNG NHẤT/TRẢNG BOM/VĨNH CỬU/NHƠN TRẠCH/LONG THÀNH
 * noiohiennay_huyen = Tương ứng với từng huyện ở trên và điều kiện
 * MỤC SƯ: phamsactrongtongiao_ntn_duocphong_mucsu != null
 * MỤC SƯ NHIỆM CHỨC: phamsactrongtongiao_ntn_duocphong_mucsunc != null
 * TRUYỀN ĐẠO: phamsactrongtongiao_ntn_duocphong_truyendao != null
 *
 * IV. CAO ĐÀI
 * 4. Bảng chucsaccaodai
 * Tương ứng với từng huyện: BIÊN HÒA/LONG KHÁNH/XUÂN LỘC/CẨM MỸ/TÂN PHÚ/ĐỊNH QUÁN/THỐNG NHẤT/TRẢNG BOM/VĨNH CỬU/NHƠN TRẠCH/LONG THÀNH
 * noiohiennay_huyen = Tương ứng với từng huyện ở trên và điều kiện
 * PHỐI SƯ: phamsac_ntn_cauthang_phosu != null
 * GIÁO SƯ: phamsac_ntn_cauthang_giaosu != null
 * GIÁO HỮU: phamsac_ntn_cauthang_giaohuu != null
 * LỄ SANH VÀ TƯƠNG ĐƯƠNG: phamsac_ntn_cauphong_lesanh != null
 *
 * V. HỒI GIÁO
 * 5. Bảng chucviechoigiao
 * Tương ứng với từng huyện: BIÊN HÒA/LONG KHÁNH/XUÂN LỘC/CẨM MỸ/TÂN PHÚ/ĐỊNH QUÁN/THỐNG NHẤT/TRẢNG BOM/VĨNH CỬU/NHƠN TRẠCH/LONG THÀNH
 * noiohiennay_huyen = Tương ứng với từng huyện ở trên và điều kiện
 * HAKIM: phamsactrongtongiao_ntn_bonhiem_hakim != null
 * NAEP: phamsactrongtongiao_ntn_bonhiem_naep != null
 * AHLY: Để mặc định bằng 0
 * KHOTIP: phamsactrongtongiao_ntn_bonhiem_khotip != null
 * IMAM: phamsactrongtongiao_ntn_bonhiem_imam != null
 * TUON: phamsactrongtongiao_ntn_bonhiem_tuon != null
 *
 * VI. TĐCSPHVN
 * 5. Bảng chucviectinhdocusiphathoivietnam
 * Tương ứng với từng huyện: BIÊN HÒA/LONG KHÁNH/XUÂN LỘC/CẨM MỸ/TÂN PHÚ/ĐỊNH QUÁN/THỐNG NHẤT/TRẢNG BOM/VĨNH CỬU/NHƠN TRẠCH/LONG THÀNH
 * noiohiennay_huyen = Tương ứng với từng huyện ở trên và điều kiện
 * GIẢNG SƯ: phamsactrongtongiao_ntn_bonhiem_phogiangsu != null
 * THUYẾT TRÌNH VIÊN: phamsactrongtongiao_ntn_bonhiem_thuyettrinhvien != null
 * Y SĨ: Để mặc định bằng 0
 * Y SINH: Để mặc định bằng 0
 */
