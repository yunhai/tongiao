<?php

class ExportThCvTinhComponent extends Component
{
    public function __construct()
    {
        App::uses('ProvinceComponent', 'Controller/Component');
        $this->Province = new ProvinceComponent(new ComponentCollection());
    }

    public function export($filter = [])
    {
        $groups = [
            CONG_GIAO => 'Giaoxu',
            PHAT_GIAO => 'Tuvienphatgiao',
            TIN_LANH => 'Chihoitinlanh',
            CAO_DAI => 'Hodaocaodai',
            HOA_HAO => 'Chucviecphathoahao',
            TINH_DO_CU_SI => 'Chihoitinhdocusiphatgiaovietnam',
        ];

        $filter_group = $filter['ton_giao'];
        $filter_location = $filter['prefecture'];

        $province = $this->Province->getProvince($filter_location);

        $export = $this->init($province);

        foreach ($groups as $field_index => $model) {
            if (!empty($filter_group) && !in_array($field_index, $filter_group)) {
                continue;
            }
            $func = '__get' . $model;
            $tmp = $this->$func($model);

            foreach ($province as $provice_code => $name) {
                $partial = $tmp[$provice_code];

                foreach ($partial as $field => $value) {
                    if ($field === 'total') {
                        $export[$provice_code]['total'] += $value;
                        if ($model === 'Chihoitinlanh') {
                            continue;
                        }
                    }
                    $export[$provice_code][$model . '_' . $field] = $value;
                }
            }
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

    private function __getChihoitinhdocusiphatgiaovietnam($model)
    {
        $fields = [
            'id',
            'tenchihoi_diachi_huyen'
        ];
        $conditions = [
        ];
        $column = [
            'sothanhvien_banhodao',
            'sothanhvien_banchaphanhdaoduc',
        ];
        $province_field = 'tenchihoi_diachi_huyen';

        $fields = array_merge($fields, $column);

        $data = $this->__getData($model, compact('fields', 'conditions'));

        $result = $this->__groupData($data, $column, $province_field);

        foreach ($result as &$item) {
            $tmp = array(
                'total' => array_sum($item),
            );
            $item = array_merge($tmp, $item);
        }

        return $result;
    }

    private function __getChucviecphathoahao($model)
    {
        $fields = [
            'id',
            'noiohiennay_huyen'
        ];
        $conditions = [
        ];
        $column = [
            'thanhvienbandaidientinh',
            'phobantrisu',
        ];
        $province_field = 'noiohiennay_huyen';

        $fields = array_merge($fields, $column);

        $data = $this->__getData($model, compact('fields', 'conditions'));

        $result = $this->__groupData($data, $column, $province_field, true);

        foreach ($result as &$item) {
            $tmp = array(
                'total' => array_sum($item),
            );
            $item = array_merge($tmp, $item);
        }

        return $result;
    }

    private function __getHodaocaodai($model)
    {
        $fields = [
            'id',
            'tenhodao_diachi_huyen'
        ];
        $conditions = [];
        $column = [
            'sothanvien_bancaiquan'
        ];
        $province_field = 'tenhodao_diachi_huyen';

        $fields = array_merge($fields, $column);

        $data = $this->__getData($model, compact('fields', 'conditions'));

        $result = $this->__groupData($data, $column, $province_field);
        foreach ($result as &$item) {
            $tmp = array(
                'total' => array_sum($item),
            );
            $item = array_merge($tmp, $item, array('bantrisu' => 0));
        }

        return $result;
    }

    private function __getChihoitinlanh($model)
    {
        $fields = [
            'id',
            'diachi_huyen'
        ];
        $conditions = [];
        $column = [
            'sothanhvientrongbanchapsu'
        ];
        $province_field = 'diachi_huyen';

        $fields = array_merge($fields, $column);

        $data = $this->__getData($model, compact('fields', 'conditions'));

        $result = $this->__groupData($data, $column, $province_field);
        foreach ($result as &$item) {
            $tmp = array(
                'total' => array_sum($item),
            );
            $item = array_merge($tmp, $item, array('bantrisu' => 0));
        }

        return $result;
    }

    private function __getTuvienphatgiao($model)
    {
        $fields = [
            'id',
            'diachi_huyen'
        ];
        $conditions = [];
        $column = [
            'banhotu_banhoniem_sothanhvien',
            'giadinhphattu_sodoanvien'
        ];
        $province_field = 'diachi_huyen';

        $fields = array_merge($fields, $column);

        $data = $this->__getData($model, compact('fields', 'conditions'));

        $result = $this->__groupData($data, $column, $province_field);

        foreach ($result as &$item) {
            $tmp = array(
                'total' => array_sum($item),
            );
            $bht = array(
                'banhotu' => $item['banhotu_banhoniem_sothanhvien']
            );
            $item = array_merge($tmp, $bht, $item);
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
            'diachi_huyen is not NULL',
        ];
        $column = [
            'sothanhvientrongthuongvu',
            'hoidoanphucvulenghitongiao',
            'sohoidoanduoccapphephoatdong_sohoidoan'
        ];
        $province_field = 'diachi_huyen';

        $fields = array_merge($fields, $column);
        $data = $this->__getData($model, compact('fields', 'conditions'));

        $result = $this->__groupGiaoxuData($data, $column, $province_field);

        foreach ($result as &$item) {
            $total = array_sum($item);
            $item = array_merge(compact('total'), $item);
        }

        return $result;
    }

    private function __groupGiaoxuData($data, $column, $province_field, $countFlag = false)
    {
        $result = [];
        $province = $this->Province->getProvince();

        foreach ($province as $provice_code => $name) {
            $result[$provice_code] = array(
                'banhanhgiao' => 0,
                'thuongvubhg' => 0,
                'lanhdaocachoidoantucapgxtrolen' => 0,
                'khac' => 0,
            );
        }

        foreach ($data as $id => $item) {
            $provice_code = $this->Province->retrieveProvinceCode($item[$province_field]);
            if (!$provice_code) {
                continue;
            }
            $thuongvubhg = intval($item['sothanhvientrongthuongvu']);
            $lanhdaocachoidoantucapgxtrolen = $this->__countGiaoxulanhdaocachoidoantucapgxtrolen($item);
            $result[$provice_code]['thuongvubhg'] += $thuongvubhg;
            $result[$provice_code]['lanhdaocachoidoantucapgxtrolen'] += $lanhdaocachoidoantucapgxtrolen;
        }

        return $result;
    }

    private function __countGiaoxulanhdaocachoidoantucapgxtrolen($data)
    {
        $fields = [
            'hoidoanphucvulenghitongiao',
            'sohoidoanduoccapphephoatdong_sohoidoan'
        ];

        $map = [
            'hoidoanphucvulenghitongiao_songuoitrongbantrisu',
            'sohoidoandaduoccapphephoatdong_songuoitrongbantrisu'
        ];

        $result = [];
        foreach ($fields as $f) {
            if ($data[$f]) {
                $group = explode(';', $data[$f]);
                foreach ($group as $str) {
                    $tmp = explode(',', $str);
                    foreach ($tmp as $element) {
                        if (strpos($element, ':') === false) {
                            continue;
                        }

                        list($key, $value) = explode(':', $element);

                        if (in_array(trim($key, '_'), $map)) {
                            $result[trim($key, '_')] = intval($value);
                        }
                    }
                }
            }
        }

        return array_sum($result);
    }

    private function __getData($model, $option = [])
    {
        $obj = ClassRegistry::init($model);
        $data = $obj->find('all', $option);

        return Hash::combine($data, '{n}.' . $model . '.id', '{n}.' . $model);
    }

    private function __groupData($data, $column, $province_field, $countFlag = false)
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
                    if ($countFlag) {
                        $count++;
                    } else {
                        $count += $item[$key];
                    }
                }
            }
        }

        return $result;
    }
}

 /**
  * TONG HOP CHUC VIEC
  * BẢNG TỔNG HỢP CHỨC VIỆC CÁC TÔN GIÁO, TÍN NGƯỠNG TRÊN ĐỊA BÀN TỈNH
  *
  * I. CÔNG GIÁO
  * 1. Bảng giaoxu
  * Tương ứng với từng huyện: BIÊN HÒA/LONG KHÁNH/XUÂN LỘC/CẨM MỸ/TÂN PHÚ/ĐỊNH QUÁN/THỐNG NHẤT/TRẢNG BOM/VĨNH CỬU/NHƠN TRẠCH/LONG THÀNH
  * diachi_huyen = Tương ứng với từng huyện ở trên và điều kiện
  * BAN HÀNH GIÁO: Để mặc định bằng 0
  * thuong vu bhg: sothanhvientrongthuongvu
  *   Lấy dữ liệu từ cột hoidoanphucvulenghitongiao
  *     hoidoanphucvulenghitongiao_sott______:01______,hoidoanphucvulenghitongiao_tenhoidoan______:Ca đoàn cécilia______,hoidoanphucvulenghitongiao_namthanhlap______:1955______,hoidoanphucvulenghitongiao_ngaybonmang______:22/11______,hoidoanphucvulenghitongiao_sohoivien______:50______,hoidoanphucvulenghitongiao_nguoiphutrach______:Mai Xuân Hoàng______,hoidoanphucvulenghitongiao_songuoitrongbantrisu______:01______;
  *     hoidoanphucvulenghitongiao_sott______:02______,hoidoanphucvulenghitongiao_tenhoidoan______:Ca đoàn mẹ thiên chúa______,hoidoanphucvulenghitongiao_namthanhlap______:2010______,hoidoanphucvulenghitongiao_ngaybonmang______:1/11______,hoidoanphucvulenghitongiao_sohoivien______:35______,hoidoanphucvulenghitongiao_nguoiphutrach______:Nguyễn Thị Thanh Hà______,hoidoanphucvulenghitongiao_songuoitrongbantrisu______:01______;
  *     hoidoanphucvulenghitongiao_sott______:03______,hoidoanphucvulenghitongiao_tenhoidoan______:Ca đoàn kitô vua ______,hoidoanphucvulenghitongiao_namthanhlap______:2010______,hoidoanphucvulenghitongiao_ngaybonmang______:CN 34 TN______,hoidoanphucvulenghitongiao_sohoivien______:25______,hoidoanphucvulenghitongiao_nguoiphutrach______:Đinh Công Huynh______,hoidoanphucvulenghitongiao_songuoitrongbantrisu______:01______;
  *     hoidoanphucvulenghitongiao_sott______:04______,hoidoanphucvulenghitongiao_tenhoidoan______:Ca đoàn chúa hài đồng______,hoidoanphucvulenghitongiao_namthanhlap______:1975______,hoidoanphucvulenghitongiao_ngaybonmang______:25/12______,hoidoanphucvulenghitongiao_sohoivien______:50______,hoidoanphucvulenghitongiao_nguoiphutrach______:Vũ Thị Mai Loan______,hoidoanphucvulenghitongiao_songuoitrongbantrisu______:01______;
  *     hoidoanphucvulenghitongiao_sott______:05______,hoidoanphucvulenghitongiao_tenhoidoan______:Nhạc đoàn Gioan______,hoidoanphucvulenghitongiao_namthanhlap______:1955______,hoidoanphucvulenghitongiao_ngaybonmang______:24/6______,hoidoanphucvulenghitongiao_sohoivien______:30______,hoidoanphucvulenghitongiao_nguoiphutrach______:Nguyễn Văn Đức ______,hoidoanphucvulenghitongiao_songuoitrongbantrisu______:01______;
  *     hoidoanphucvulenghitongiao_sott______:06______,hoidoanphucvulenghitongiao_tenhoidoan______:Nhạc đoàn Phêrô______,hoidoanphucvulenghitongiao_namthanhlap______:1955______,hoidoanphucvulenghitongiao_ngaybonmang______:29/6______,hoidoanphucvulenghitongiao_sohoivien______:30______,hoidoanphucvulenghitongiao_nguoiphutrach______:Phạm Chí Thành______,hoidoanphucvulenghitongiao_songuoitrongbantrisu______:01______;
  *     hoidoanphucvulenghitongiao_sott______:07______,hoidoanphucvulenghitongiao_tenhoidoan______:Ban lễ sinh______,hoidoanphucvulenghitongiao_namthanhlap______:1955______,hoidoanphucvulenghitongiao_ngaybonmang______:6/5______,hoidoanphucvulenghitongiao_sohoivien______:40______,hoidoanphucvulenghitongiao_nguoiphutrach______:Vũ Quang Hiệp______,hoidoanphucvulenghitongiao_songuoitrongbantrisu______:01
  *     Chuỗi này lưu giống như phần diện tích hôm trước làm, nó là hoidoanphucvulenghitongiao_songuoitrongbantrisu nằm trong chuỗi trên
  *     Sau khi parse xong, lấy tổng hoidoanphucvulenghitongiao_songuoitrongbantrisu
  *
  *   Lấy dữ liệu từ cột sohoidoanduoccapphephoatdong_sohoidoan
  *     sohoidoandaduoccapphephoatdong_sott______:01______,sohoidoandaduoccapphephoatdong_tenhoidoan______:Giới cao niên______,sohoidoandaduoccapphephoatdong_namthanhlap______:1955______,sohoidoandaduoccapphephoatdong_ngaybonmang______:26/7______,sohoidoandaduoccapphephoatdong_sohoivien______:105______,sohoidoandaduoccapphephoatdong_nguoiphutrach______:Vũ Đức Long ______,sohoidoandaduoccapphephoatdong_songuoitrongbantrisu______:04______;
  *     sohoidoandaduoccapphephoatdong_sott______:02______,sohoidoandaduoccapphephoatdong_tenhoidoan______:Giới gia trưởng______,sohoidoandaduoccapphephoatdong_namthanhlap______:1955______,sohoidoandaduoccapphephoatdong_ngaybonmang______:1/5______,sohoidoandaduoccapphephoatdong_sohoivien______:85______,sohoidoandaduoccapphephoatdong_nguoiphutrach______:Trần Ngọc Toán______,sohoidoandaduoccapphephoatdong_songuoitrongbantrisu______:04______;
  *     sohoidoandaduoccapphephoatdong_sott______:03______,sohoidoandaduoccapphephoatdong_tenhoidoan______:Giới hiền mẫu______,sohoidoandaduoccapphephoatdong_namthanhlap______:1955______,sohoidoandaduoccapphephoatdong_ngaybonmang______:27/8______,sohoidoandaduoccapphephoatdong_sohoivien______:195______,sohoidoandaduoccapphephoatdong_nguoiphutrach______:Lê Thị Oanh______,sohoidoandaduoccapphephoatdong_songuoitrongbantrisu______:04______;
  *     sohoidoandaduoccapphephoatdong_sott______:04______,sohoidoandaduoccapphephoatdong_tenhoidoan______:Giới trẻ______,sohoidoandaduoccapphephoatdong_namthanhlap______:1955______,sohoidoandaduoccapphephoatdong_ngaybonmang______:31/01______,sohoidoandaduoccapphephoatdong_sohoivien______:80______,sohoidoandaduoccapphephoatdong_nguoiphutrach______:Trịnh Hoàng Phương______,sohoidoandaduoccapphephoatdong_songuoitrongbantrisu______:04______;
  *     sohoidoandaduoccapphephoatdong_sott______:05______,sohoidoandaduoccapphephoatdong_tenhoidoan______:Giới thiếu nhi______,sohoidoandaduoccapphephoatdong_namthanhlap______:1955______,sohoidoandaduoccapphephoatdong_ngaybonmang______:18/6______,sohoidoandaduoccapphephoatdong_sohoivien______:1257______,sohoidoandaduoccapphephoatdong_nguoiphutrach______:Trần Tuấn Thịnh______,sohoidoandaduoccapphephoatdong_songuoitrongbantrisu______:04
  *     Chuỗi này lưu giống như phần diện tích hôm trước làm, nó là sohoidoandaduoccapphephoatdong_songuoitrongbantrisu
  *     Sau khi parse xong, lấy tổng sohoidoandaduoccapphephoatdong_songuoitrongbantrisu
  *
  * LÃNH ĐẠO CÁC HỘI ĐOÀN TỪ CẤP GX TRỞ LÊN = tổng hoidoanphucvulenghitongiao_songuoitrongbantrisu + tổng sohoidoandaduoccapphephoatdong_songuoitrongbantrisu
  * KHÁC: Để mặc định bằng 0
  *
  * II. PHẬT GIÁO
  * 2. Bảng tuvienphatgiao
  * Tương ứng với từng huyện: BIÊN HÒA/LONG KHÁNH/XUÂN LỘC/CẨM MỸ/TÂN PHÚ/ĐỊNH QUÁN/THỐNG NHẤT/TRẢNG BOM/VĨNH CỬU/NHƠN TRẠCH/LONG THÀNH
  * diachi_huyen = Tương ứng với từng huyện ở trên và điều kiện
  * BAN HỘ TỰ: banhotu_banhoniem_sothanhvien
  * BAN HỘ NIỆM: banhotu_banhoniem_sothanhvien
  * GIA ĐÌNH PHẬT TỬ: giadinhphattu_sodoanvien
  *
  * III. TIN LÀNH
  * 3. Bảng chihoitinlanh
  * Tương ứng với từng huyện: BIÊN HÒA/LONG KHÁNH/XUÂN LỘC/CẨM MỸ/TÂN PHÚ/ĐỊNH QUÁN/THỐNG NHẤT/TRẢNG BOM/VĨNH CỬU/NHƠN TRẠCH/LONG THÀNH
  * diachi_huyen = Tương ứng với từng huyện ở trên và điều kiện
  * BAN CHẤP SỰ: sothanhvientrongbanchapsu
  * BAN TRỊ SỰ: Để mặc định bằng 0
  *
  * IV. CAO ĐÀI
  * 4. Bảng hodaocaodai
  * Tương ứng với từng huyện: BIÊN HÒA/LONG KHÁNH/XUÂN LỘC/CẨM MỸ/TÂN PHÚ/ĐỊNH QUÁN/THỐNG NHẤT/TRẢNG BOM/VĨNH CỬU/NHƠN TRẠCH/LONG THÀNH
  * diachi_huyen = Tương ứng với từng huyện ở trên và điều kiện
  * BAN CAI QUẢN: sothanvien_bancaiquan
  * BAN TRỊ SỰ: Để mặc định bằng 0
  *
  * V. PHẬT GIÁO HÒA HẢO
  * 5. Bảng chucviecphathoahao
  * Tương ứng với từng huyện: BIÊN HÒA/LONG KHÁNH/XUÂN LỘC/CẨM MỸ/TÂN PHÚ/ĐỊNH QUÁN/THỐNG NHẤT/TRẢNG BOM/VĨNH CỬU/NHƠN TRẠCH/LONG THÀNH
  * noiohiennay_huyen = Tương ứng với từng huyện ở trên và điều kiện
  * BAN ĐẠI DIỆN: Đếm tất cả với điều kiện cột thanhvienbandaidientinh != null
  * BAN TRỊ SỰ XÃ, PHƯỜNG, THỊ TRÁN: Đếm tất cả với điều kiện cột phobantrisu != null hoặc cột thanhvienbandaidientinh != null
  *
  * VI. TĐCSPHVN
  * 6. Bảng chihoitinhdocusiphatgiaovietnam
  * Tương ứng với từng huyện: BIÊN HÒA/LONG KHÁNH/XUÂN LỘC/CẨM MỸ/TÂN PHÚ/ĐỊNH QUÁN/THỐNG NHẤT/TRẢNG BOM/VĨNH CỬU/NHƠN TRẠCH/LONG THÀNH
  * tenchihoi_diachi_huyen = Tương ứng với từng huyện ở trên và điều kiện
  * BAN HỘ ĐẠO: sothanhvien_banhodao
  * BAN CHẤP HÀNH ĐẠO ĐỨC: sothanhvien_banchaphanhdaoduc
  *
  */
