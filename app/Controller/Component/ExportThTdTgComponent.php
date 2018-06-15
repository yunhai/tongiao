<?php
App::uses('ExportExcelComponent', 'Controller/Component');
class ExportThTdTgComponent extends ExportExcelComponent
{
    public function layout($filter = [])
    {
        $row_data_index = 11;
        $row_header_index = 8;
        $column_begin = 7;
        $column_structure = [
            CONG_GIAO => 4,
            PHAT_GIAO => 4,
            TIN_LANH => 4,
            CAO_DAI => 4,
            TINH_DO_CU_SI => 4,
            HOA_HAO => 4,
            HOI_GIAO => 4,
            KHAC => 4,
        ];

        $column_remove = [];
        $cell_total_count = 2;
        if ($filter) {
            foreach ($column_structure as $index => $tmp) {
                if (!in_array($index, $filter)) {
                    $column_remove[$index] = $index;
                }
            }
        }
        return compact('column_begin', 'column_structure', 'column_remove', 'row_header_index', 'row_data_index', 'cell_total_count');
    }

    public function export($filter = [])
    {
        $filter_group = $filter['ton_giao'];
        $filter_location = $filter['prefecture'];

        $groups = [
            CONG_GIAO => 'Giaoxu',
            PHAT_GIAO => 'Tuvienphatgiao',
            TIN_LANH => 'Chihoitinlanh',
            CAO_DAI => 'Hodaocaodai',
            TINH_DO_CU_SI => 'Chihoitinhdocusiphatgiaovietnam',
            HOA_HAO => 'Hoahao',
            HOI_GIAO => 'Cosohoigiaoislam',
            KHAC => 'Tongiaokhac',
        ];

        $province = $this->Province->getProvince($filter_location);

        $export = $this->init($province);
        foreach ($groups as $field_index => $model) {
            if (!empty($filter_group) && !in_array($field_index, $filter_group)) {
                continue;
            }

            $func = '__get' . $model;
            $tmp = $this->$func($model);

            foreach ($province as $provice_code => $name) {
                if (!empty($filter_location) && !in_array($provice_code, $filter_location)) {
                    unset($export[$provice_code]);
                    continue;
                }

                $partial = $tmp[$provice_code];

                foreach ($partial as $field => $value) {
                    $value = intval($value);
                    $export[$provice_code]['total_' . $field] += $value;
                    $export[$provice_code][$model . '_' . $field] = $value;
                }
            }
        }

        return  $this->sum($export);
    }

    private function __getTongiaokhac($model)
    {
        $result = [];
        $province = $this->Province->getProvince();

        foreach ($province as $provice_code => $name) {
            $result[$provice_code] = array(
                'total' => 0,
                'dathuchiennghiletongiao' => 0,
                'chuathuchiennghiletongiao' => 0,
                'dantocthieuso' => 0,
            );
        }

        return $result;
    }

    private function __getCosohoigiaoislam($model)
    {
        $fields = [
            'id',
            'tenthanhduong_diachi_huyen'
        ];
        $conditions = [
            'tenthanhduong_diachi_huyen <>' => '',
            'tenthanhduong_diachi_huyen is not null'
        ];
        $column = [
            'tongsotindo',
            'sotindo_dantoc_thieuso'
        ];
        $province_field = 'tenthanhduong_diachi_huyen';

        $fields = array_merge($fields, $column);

        $data = $this->__getData($model, compact('fields', 'conditions'));

        $result = $this->__groupData($data, $column, $province_field);

        foreach ($result as &$item) {
            $item = [
                'total' => $item['tongsotindo'],
                'dathuchiennghiletongiao' => $item['tongsotindo'],
                'chuathuchiennghiletongiao' => $item['tongsotindo'],
                'dantocthieuso' => $item['sotindo_dantoc_thieuso'],
            ];
        }

        return $result;
    }

    private function __getHoahao($model)
    {
        $result = [];
        $province = $this->Province->getProvince();

        foreach ($province as $provice_code => $name) {
            $result[$provice_code] = array(
                'total' => 0,
                'dathuchiennghiletongiao' => 0,
                'chuathuchiennghiletongiao' => 0,
                'dantocthieuso' => 0,
            );
        }

        return $result;
    }
    private function __getChihoitinhdocusiphatgiaovietnam($model)
    {
        $fields = [
            'id',
            'tenchihoi_diachi_huyen'
        ];
        $conditions = [
            'tenchihoi_diachi_huyen <>' => '',
            'tenchihoi_diachi_huyen is not null'
        ];
        $column = [
            'soluonghoivien_tindo',
            'sotindo_dantoc_thieuso'
        ];
        $province_field = 'tenchihoi_diachi_huyen';

        $fields = array_merge($fields, $column);

        $data = $this->__getData($model, compact('fields', 'conditions'));

        $result = $this->__groupData($data, $column, $province_field);

        foreach ($result as &$item) {
            $total = $item['soluonghoivien_tindo'] + $item['sotindo_dantoc_thieuso'];
            $item = [
                'total' => $item['soluonghoivien_tindo'],
                'dathuchiennghiletongiao' => $item['soluonghoivien_tindo'],
                'chuathuchiennghiletongiao' => $item['soluonghoivien_tindo'],
                'dantocthieuso' => $item['sotindo_dantoc_thieuso'],
            ];
        }

        return $result;
    }

    private function __getHodaocaodai($model)
    {
        $fields = [
            'id',
            'tenhodao_diachi_huyen'
        ];
        $conditions = [
            'tenhodao_diachi_huyen <>' => '',
            'tenhodao_diachi_huyen is not null'
        ];
        $column = [
            'tongsotindo',
            'tongsotindo_cosocaudao',
            'tongsotindo_chuacosocaudao',
            'sotindo_dantoc_thieuso'
        ];
        $province_field = 'tenhodao_diachi_huyen';

        $fields = array_merge($fields, $column);

        $data = $this->__getData($model, compact('fields', 'conditions'));

        $result = $this->__groupData($data, $column, $province_field);

        foreach ($result as &$item) {
            $item = [
                'total' => $item['tongsotindo'],
                'dathuchiennghiletongiao' => $item['tongsotindo_cosocaudao'],
                'chuathuchiennghiletongiao' => $item['tongsotindo_chuacosocaudao'],
                'dantocthieuso' => $item['sotindo_dantoc_thieuso'],
            ];
        }

        return $result;
    }

    private function __getChihoitinlanh($model)
    {
        $fields = [
            'id',
            'diachi_huyen'
        ];
        $conditions = [
            'diachi_huyen <>' => '',
            'diachi_huyen is not null'
        ];
        $column = [
            'tongsotindo',
            'tongsotindo_baptem',
            'tongsotindo_chuabaptem',
            'sotindo_dantoc_thieuso'
        ];
        $province_field = 'diachi_huyen';

        $fields = array_merge($fields, $column);

        $data = $this->__getData($model, compact('fields', 'conditions'));

        $result = $this->__groupData($data, $column, $province_field);

        foreach ($result as &$item) {
            $item = [
                'total' => $item['tongsotindo'],
                'dathuchiennghiletongiao' => $item['tongsotindo_baptem'],
                'chuathuchiennghiletongiao' => $item['tongsotindo_chuabaptem'],
                'dantocthieuso' => $item['sotindo_dantoc_thieuso'],
            ];
        }

        return $result;
    }

    private function __getTuvienphatgiao($model)
    {
        $fields = [
            'id',
            'diachi_huyen'
        ];
        $conditions = [
            'diachi_huyen <>' => '',
            'diachi_huyen is not null'
        ];
        $column = [
            'daquyy',
            'soluongtindo',
            'phattu_dantoc_thieuso'
        ];
        $province_field = 'diachi_huyen';

        $fields = array_merge($fields, $column);

        $data = $this->__getData($model, compact('fields', 'conditions'));

        $result = $this->__groupData($data, $column, $province_field);

        foreach ($result as &$item) {
            $daquyy = intval($item['daquyy']);
            $phattu_dantoc_thieuso = intval($item['phattu_dantoc_thieuso']);
            $soluongtindo = intval($item['soluongtindo']);

            $chuathuchiennghiletongiao = $soluongtindo - $daquyy;
            if ($chuathuchiennghiletongiao < 0) {
                $chuathuchiennghiletongiao = 0;
            }
            $item = [
                'total' => $soluongtindo,
                'dathuchiennghiletongiao' => $daquyy,
                'chuathuchiennghiletongiao' => $chuathuchiennghiletongiao,
                'dantocthieuso' => $phattu_dantoc_thieuso,
            ];
        }

        return $result;
    }

    private function __getGiaoxu($model)
    {
        $fields = [
            'id',
            'diachi_huyen'
        ];
        $conditions = [
            'diachi_huyen <>' => '',
            'diachi_huyen is not null'
        ];
        $column = [
            'giaodan_sonhankhau',
            'giaodandantocthieuso_sonhankhau',
        ];
        $province_field = 'diachi_huyen';

        $fields = array_merge($fields, $column);

        $data = $this->__getData($model, compact('fields', 'conditions'));

        $result = $this->__groupData($data, $column, $province_field);

        foreach ($result as &$item) {
            $giaodan_sonhankhau = intval($item['giaodan_sonhankhau']);
            $giaodandantocthieuso_sonhankhau = intval($item['giaodandantocthieuso_sonhankhau']);

            $item = [
                'total' => $giaodan_sonhankhau,
                'dathuchiennghiletongiao' => $giaodan_sonhankhau,
                'chuathuchiennghiletongiao' => $giaodan_sonhankhau,
                'dantocthieuso' => $giaodandantocthieuso_sonhankhau,
            ];
        }

        return $result;
    }

    private function init($province)
    {
        $index = 1;
        $export = [];

        foreach ($province as $code => $name) {
            $export[$code] = [
                'index' => $index++,
                'province' => $name,
                'total_total' => 0,
                'total_dathuchiennghiletongiao' => 0,
                'total_chuathuchiennghiletongiao' => 0,
                'total_dantocthieuso' => 0
            ];
        }

        return $export;
    }

    private function __getData($model, $option = [])
    {
        $obj = ClassRegistry::init($model);
        $data = $obj->find('all', $option);

        $result = Hash::combine($data, '{n}.' . $model . '.id', '{n}.' . $model);
        $this->track($model, $result);

        return $result;
    }

    protected function track($name, $result)
    {
        $name = 'debug/' . strtolower($name);
        foreach ($result as $item) {
            foreach ($item as $value) {
                if (!$value) {
                    $this->log(print_r($item, true), $name);
                    break;
                }
            }
        }
        return true;
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
                    $count += intval($item[$key]);
                }
            }
        }
        return $result;
    }
}

/**
 * BẢNG TỔNG HỢP TÍN ĐỒ CÁC TÔN GIÁO TRÊN ĐỊA BÀN TỈNH
 *
 * I. CÔNG GIÁO
 * 1. Bảng giaoxu
 * Tương ứng với từng huyện: BIÊN HÒA/LONG KHÁNH/XUÂN LỘC/CẨM MỸ/TÂN PHÚ/ĐỊNH QUÁN/THỐNG NHẤT/TRẢNG BOM/VĨNH CỬU/NHƠN TRẠCH/LONG THÀNH
 * diachi_huyen = Tương ứng với từng huyện ở trên và điều kiện
 * TỔNG SỐ(cột G): soluongtindo
 * ĐÃ THỰC HIỆN LỄ NGHI TÔN GIÁO: giaodan_sonhankhau
 * CHƯA THỰC HIỆN LỄ NGHI TÔN GIÁO: giaodan_sonhankhau
 * LÀ DÂN TỘC THIỂU SỐ: Lấy cột giaodandantocthieuso_sonhankhau
 *
 * II. PHẬT GIÁO
 * 2. Bảng tuvienphatgiao
 * Tương ứng với từng huyện: BIÊN HÒA/LONG KHÁNH/XUÂN LỘC/CẨM MỸ/TÂN PHÚ/ĐỊNH QUÁN/THỐNG NHẤT/TRẢNG BOM/VĨNH CỬU/NHƠN TRẠCH/LONG THÀNH
 * diachi_huyen = Tương ứng với từng huyện ở trên và điều kiện
 * TỔNG SỐ(cột K): soluongtindo
 * ĐÃ THỰC HIỆN LỄ NGHI TÔN GIÁO: Lấy cột daquyy
 * CHƯA THỰC HIỆN LỄ NGHI TÔN GIÁO: Lấy cột soluongtindo -  cột daquyy
 * LÀ DÂN TỘC THIỂU SỐ: Lấy dữ liệu từ cột phattu_dantoc_thieuso
 *
 * III. TIN LÀNH
 * 3. Bảng chihoitinlanh
 * Tương ứng với từng huyện: BIÊN HÒA/LONG KHÁNH/XUÂN LỘC/CẨM MỸ/TÂN PHÚ/ĐỊNH QUÁN/THỐNG NHẤT/TRẢNG BOM/VĨNH CỬU/NHƠN TRẠCH/LONG THÀNH
 * diachi_huyen = Tương ứng với từng huyện ở trên và điều kiện
 * TỔNG SỐ(cột O): tongsotindo
 * ĐÃ THỰC HIỆN LỄ NGHI TÔN GIÁO: Lấy cột tongsotindo_baptem
 * CHƯA THỰC HIỆN LỄ NGHI TÔN GIÁO: Lấy cột tongsotindo_chuabaptem
 * LÀ DÂN TỘC THIỂU SỐ: Lấy dữ liệu từ cột sotindo_dantoc_thieuso
 *
 * IV. CAO ĐÀI
 * 4. Bảng hodaocaodai
 * Tương ứng với từng huyện: BIÊN HÒA/LONG KHÁNH/XUÂN LỘC/CẨM MỸ/TÂN PHÚ/ĐỊNH QUÁN/THỐNG NHẤT/TRẢNG BOM/VĨNH CỬU/NHƠN TRẠCH/LONG THÀNH
 * tenhodao_diachi_huyen = Tương ứng với từng huyện ở trên và điều kiện
 * TỔNG SỐ(cột S): tongsotindo
 * ĐÃ THỰC HIỆN LỄ NGHI TÔN GIÁO: Lấy cột tongsotindo_cosocaudao
 * CHƯA THỰC HIỆN LỄ NGHI TÔN GIÁO: Lấy cột tongsotindo_chuacosocaudao
 * LÀ DÂN TỘC THIỂU SỐ: Lấy dữ liệu từ cột sotindo_dantoc_thieuso
 *
 * V. TỊNH ĐỘ CƯ SĨ PHẬT HỘI VIỆT NAM
 * 5. Bảng chihoitinhdocusiphatgiaovietnam
 * Tương ứng với từng huyện: BIÊN HÒA/LONG KHÁNH/XUÂN LỘC/CẨM MỸ/TÂN PHÚ/ĐỊNH QUÁN/THỐNG NHẤT/TRẢNG BOM/VĨNH CỬU/NHƠN TRẠCH/LONG THÀNH
 * tenchihoi_diachi_huyen = Tương ứng với từng huyện ở trên và điều kiện
 * TỔNG SỐ(cột W): soluonghoivien_tindo
 * ĐÃ THỰC HIỆN LỄ NGHI TÔN GIÁO: Lấy cột soluonghoivien_tindo
 * CHƯA THỰC HIỆN LỄ NGHI TÔN GIÁO: Lấy cột soluonghoivien_tindo
 * LÀ DÂN TỘC THIỂU SỐ: Lấy dữ liệu từ cột sotindo_dantoc_thieuso
 *
 * VI. PHẬT GIÁO HÒA HẢO
 * ĐÃ THỰC HIỆN LỄ NGHI TÔN GIÁO: Để mặc định bằng 0
 * CHƯA THỰC HIỆN LỄ NGHI TÔN GIÁO: Để mặc định bằng 0
 * LÀ DÂN TỘC THIỂU SỐ: Để mặc định bằng 0
 *
 * VII. HỒI GIÁO
 * 7. Bảng cosohoigiaoislam
 * Tương ứng với từng huyện: BIÊN HÒA/LONG KHÁNH/XUÂN LỘC/CẨM MỸ/TÂN PHÚ/ĐỊNH QUÁN/THỐNG NHẤT/TRẢNG BOM/VĨNH CỬU/NHƠN TRẠCH/LONG THÀNH
 * tenthanhduong_diachi_huyen = Tương ứng với từng huyện ở trên và điều kiện
 * TỔNG SỐ(cột AE): tongsotindo
 * ĐÃ THỰC HIỆN LỄ NGHI TÔN GIÁO:  Lấy cột tongsotindo
 * CHƯA THỰC HIỆN LỄ NGHI TÔN GIÁO:  Lấy cột tongsotindo
 * LÀ DÂN TỘC THIỂU SỐ:  Lấy cột sotindo_dantoc_thieuso
 *
 * VIII. CÁC TÔN GIÁO KHÁC
 * ĐÃ THỰC HIỆN LỄ NGHI TÔN GIÁO: Để mặc định bằng 0
 * CHƯA THỰC HIỆN LỄ NGHI TÔN GIÁO: Để mặc định bằng 0
 * LÀ DÂN TỘC THIỂU SỐ: Để mặc định bằng 0
 */
