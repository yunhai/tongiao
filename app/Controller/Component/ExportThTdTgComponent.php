<?php
class ExportThTdTgComponent extends Component
{
    public function __construct()
    {
        App::uses('ProvinceComponent', 'Controller/Component');
        $this->Province = new ProvinceComponent(new ComponentCollection());
    }

    public function export()
    {
        $export_fields = [
            'Giaoxu',
            'Tuvienphatgiao',
            'Chihoitinlanh',
            'Hodaocaodai',
            'Chihoitinhdocusiphatgiaovietnam',
            'Hoahao',
            'Cosohoigiaoislam',
            'Tongiaokhac',
        ];

        $province = $this->Province->getProvince();

        $export = $this->init($province);

        foreach ($export_fields as $field_index => $model) {
            $func = '__get' . $model;
            $tmp = $this->$func($model);

            foreach ($province as $provice_code => $name) {
                $partial = $tmp[$provice_code];

                foreach ($partial as $field => $value) {
                    $export[$provice_code][$model . '_' . $field] = $value;
                }
            }
        }

        return $export;
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
            $total = $item['tongsotindo'] + $item['sotindo_dantoc_thieuso'];
            $item = [
                'total' => $total,
                'dathuchiennghiletongiao' => $item['tongsotindo'],
                'chuathuchiennghiletongiao' => 0,
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
            $total = $item['tongsotindo_cosocaudao'] + $item['sotindo_dantoc_thieuso'];
            $item = [
                'total' => $total,
                'dathuchiennghiletongiao' => $item['soluonghoivien_tindo'],
                'chuathuchiennghiletongiao' => 0,
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
            'tongsotindo_cosocaudao',
            'tongsotindo_chuacosocaudao',
            'sotindo_dantoc_thieuso'
        ];
        $province_field = 'tenhodao_diachi_huyen';

        $fields = array_merge($fields, $column);

        $data = $this->__getData($model, compact('fields', 'conditions'));

        $result = $this->__groupData($data, $column, $province_field);

        foreach ($result as &$item) {
            $total = $item['tongsotindo_cosocaudao'] + $item['tongsotindo_chuacosocaudao'] + $item['sotindo_dantoc_thieuso'];
            $item = [
                'total' => $total,
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
            'tongsotindo_baptem',
            'tongsotindo_chuabaptem',
            'sotindo_dantoc_thieuso'
        ];
        $province_field = 'diachi_huyen';

        $fields = array_merge($fields, $column);

        $data = $this->__getData($model, compact('fields', 'conditions'));

        $result = $this->__groupData($data, $column, $province_field);

        foreach ($result as &$item) {
            $total = $item['tongsotindo_baptem'] + $item['tongsotindo_chuabaptem'] + $item['sotindo_dantoc_thieuso'];
            $item = [
                'total' => $total,
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
            $chuathuchiennghiletongiao = $item['soluongtindo'] - $item['daquyy'];
            if ($chuathuchiennghiletongiao < 0) {
                $chuathuchiennghiletongiao = 0;
            }
            $total = $item['soluongtindo'] + $item['phattu_dantoc_thieuso'];
            $item = [
                'total' => $total,
                'dathuchiennghiletongiao' => $item['daquyy'],
                'chuathuchiennghiletongiao' => $chuathuchiennghiletongiao,
                'dantocthieuso' => $item['phattu_dantoc_thieuso'],
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
            $total = array_sum($item);
            $item = [
                'total' => $total,
                'dathuchiennghiletongiao' => $item['giaodan_sonhankhau'],
                'chuathuchiennghiletongiao' => 0,
                'dantocthieuso' => $item['giaodandantocthieuso_sonhankhau'],
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
            ];
        }

        return $export;
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
 * ĐÃ THỰC HIỆN LỄ NGHI TÔN GIÁO: giaodan_sonhankhau
 * CHƯA THỰC HIỆN LỄ NGHI TÔN GIÁO: giaodan_sonhankhau
 * LÀ DÂN TỘC THIỂU SỐ: Lấy cột giaodandantocthieuso_sonhankhau
 *
 * II. PHẬT GIÁO
 * 2. Bảng tuvienphatgiao
 * Tương ứng với từng huyện: BIÊN HÒA/LONG KHÁNH/XUÂN LỘC/CẨM MỸ/TÂN PHÚ/ĐỊNH QUÁN/THỐNG NHẤT/TRẢNG BOM/VĨNH CỬU/NHƠN TRẠCH/LONG THÀNH
 * diachi_huyen = Tương ứng với từng huyện ở trên và điều kiện
 * ĐÃ THỰC HIỆN LỄ NGHI TÔN GIÁO: Lấy cột daquyy
 * CHƯA THỰC HIỆN LỄ NGHI TÔN GIÁO: Lấy cột soluongtindo -  cột daquyy
 * LÀ DÂN TỘC THIỂU SỐ: Lấy dữ liệu từ cột phattu_dantoc_thieuso
 *
 * III. TIN LÀNH
 * 3. Bảng chihoitinlanh
 * Tương ứng với từng huyện: BIÊN HÒA/LONG KHÁNH/XUÂN LỘC/CẨM MỸ/TÂN PHÚ/ĐỊNH QUÁN/THỐNG NHẤT/TRẢNG BOM/VĨNH CỬU/NHƠN TRẠCH/LONG THÀNH
 * diachi_huyen = Tương ứng với từng huyện ở trên và điều kiện
 * ĐÃ THỰC HIỆN LỄ NGHI TÔN GIÁO: Lấy cột tongsotindo_baptem
 * CHƯA THỰC HIỆN LỄ NGHI TÔN GIÁO: Lấy cột tongsotindo_chuabaptem
 * LÀ DÂN TỘC THIỂU SỐ: Lấy dữ liệu từ cột sotindo_dantoc_thieuso
 *
 * IV. CAO ĐÀI
 * 4. Bảng hodaocaodai
 * Tương ứng với từng huyện: BIÊN HÒA/LONG KHÁNH/XUÂN LỘC/CẨM MỸ/TÂN PHÚ/ĐỊNH QUÁN/THỐNG NHẤT/TRẢNG BOM/VĨNH CỬU/NHƠN TRẠCH/LONG THÀNH
 * tenhodao_diachi_huyen = Tương ứng với từng huyện ở trên và điều kiện
 * ĐÃ THỰC HIỆN LỄ NGHI TÔN GIÁO: Lấy cột tongsotindo_cosocaudao
 * CHƯA THỰC HIỆN LỄ NGHI TÔN GIÁO: Lấy cột tongsotindo_chuacosocaudao
 * LÀ DÂN TỘC THIỂU SỐ: Lấy dữ liệu từ cột sotindo_dantoc_thieuso
 *
 * V. TỊNH ĐỘ CƯ SĨ PHẬT HỘI VIỆT NAM
 * 5. Bảng chihoitinhdocusiphatgiaovietnam
 * Tương ứng với từng huyện: BIÊN HÒA/LONG KHÁNH/XUÂN LỘC/CẨM MỸ/TÂN PHÚ/ĐỊNH QUÁN/THỐNG NHẤT/TRẢNG BOM/VĨNH CỬU/NHƠN TRẠCH/LONG THÀNH
 * tenchihoi_diachi_huyen = Tương ứng với từng huyện ở trên và điều kiện
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
 * ĐÃ THỰC HIỆN LỄ NGHI TÔN GIÁO:  Lấy cột tongsotindo
 * CHƯA THỰC HIỆN LỄ NGHI TÔN GIÁO:  Lấy cột tongsotindo
 * LÀ DÂN TỘC THIỂU SỐ:  Lấy cột sotindo_dantoc_thieuso
 *
 * VIII. CÁC TÔN GIÁO KHÁC
 * ĐÃ THỰC HIỆN LỄ NGHI TÔN GIÁO: Để mặc định bằng 0
 * CHƯA THỰC HIỆN LỄ NGHI TÔN GIÁO: Để mặc định bằng 0
 * LÀ DÂN TỘC THIỂU SỐ: Để mặc định bằng 0
 */
