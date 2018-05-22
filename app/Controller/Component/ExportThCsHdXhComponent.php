<?php

class ExportThCsHdXhComponent extends Component
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

    private function __getInfo($model) {
        $fields = [
            'stt',
            'tencosothotu',
            'diachi',
            'thuoctochuctongiaocoso',
            'thuoclinhvuc',
            'cosohopphapchuahopphap',
            'coquancongnhan',
            'giaychungnhan',
            'ghichu',
        ];

        $result = [];
        $data = $this->__getData($model);

        foreach($data as $target) {
            $target = $this->__format($target, $model);

            $tmp = [];
            foreach($fields as $f) {
                $func = '__format' . ucfirst($f);
                $tmp[$f] = $this->$func($target, $model);
            }

            $result[] = $tmp;
        }

        return $result;
    }

    private function __format($target, $model) {
        switch($model) {
            case 'Giaoxu':
                $field = 'cachoatdongbacai_dogiaoxu';
                break;
            case 'Tuvienphatgiao':
                $field = 'cachoatdongbacai';
                break;
            case 'Chihoitinlanh':
                $field = 'cachoatdongbacai';
                break;
            case 'Hodaocaodai':
                $field = 'cachoatdongbacai';
                break;
            case 'Chihoitinhdocusiphatgiaovietnam':
                $field = 'cachoatdongbacai';
                break;
            case 'Cosohoigiaoislam':
                $field = 'cachoatdongbacai';
                break;
            case 'Cosotinnguong':
                $field = 'cachoatdongbacai';
                break;

        }

        $string = $target[$field];
        if ($string) {
            $extends = $this->__parseString($string);
            if ($extends) {
                $target = array_merge($target, $extends);
            }
        }

        unset($target[$field]);
        return $target;
    }

    private function __parseString($string) {
        $result = [];
        $group = explode(';', $string);
        foreach ($group as $str) {
            $tmp = explode(',', $str);
            foreach ($tmp as $element) {
                if (strpos($element, ':') === false) {
                    continue;
                }

                list($key, $value) = explode(':', $element);

                $key = trim($key, '_');
                $value = trim($value, '_');

                if (empty($result[$key])) {
                    $result[$key] = $value;
                } else {
                    $result[$key] .= ', ' . $value;
                }
            }
        }

        return $result;
    }

    private function __formatStt($target, $model) {
        $index = $this->index;
        $this->index += 1;
        return $index;
    }

    private function __formatTencosothotu($target, $model){
        switch($model) {
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

        return $target[$field] ?: '';
    }

    private function __formatDiachi($target, $model){
        $fields = [];
        switch($model) {
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
            foreach($fields as $f) {
                if ($target[$f]) {
                    $string .= $target[$f] . ', ';
                }
            }
        }
        return trim($string, ', ');
    }

    private function __formatThuoctochuctongiaocoso($target, $model){
        switch($model) {
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

    private function __formatThuoclinhvuc($target, $model){
        switch($model) {
            case 'Giaoxu':
                $field = 'hoatdongbatai_linhvuchoatdong';
                break;
            case 'Tuvienphatgiao':
                $field = 'cachoatdong_linhvuchoatdong';
                break;
            case 'Chihoitinlanh':
                $field = 'cachoatdong_linhvuchoatdong';
                break;
            case 'Hodaocaodai':
                $field = 'cachoatdongbacai_linhvuchoatdong';
                break;
            case 'Chihoitinhdocusiphatgiaovietnam':
                $field = 'cachoatdongbacai_linhvuchoatdong';
                break;
            case 'Cosohoigiaoislam':
                $field = 'cachoatdongbacai_linhvuchoatdong';
                break;
            case 'Cosotinnguong':
                $field = 'cachoatdong_linhvuchoatdong';
                break;
        }
        return empty($target[$field]) ? '' : $target[$field];
    }

    private function __formatCosohopphapchuahopphap($target, $model) {
        switch($model) {
            case 'Giaoxu':
                $field = 'hoatdongbatai_dangkyhoatdong';
                break;
            case 'Tuvienphatgiao':
                $field = 'cachoatdong_dangkyhoatdong';
                break;
            case 'Chihoitinlanh':
                $field = 'cachoatdong_dangkyhoatdong';
                break;
            case 'Hodaocaodai':
                $field = 'cachoatdongbacai_capdangkyhoatdong';
                break;
            case 'Chihoitinhdocusiphatgiaovietnam':
                $field = 'cachoatdongbacai_capdangkyhoatdong';
                break;
            case 'Cosohoigiaoislam':
                $field = 'cachoatdongbacai_capdangkyhoatdong';
                break;
            case 'Cosotinnguong':
                $field = 'cachoatdongbacai_capdangkyhoatdong';
                break;
        }

        if (empty($target[$field])) {
            return 'Chưa hợp pháp';
        }
        return 'Cơ sở họp pháp';
    }

    private function __formatCoquancongnhan($target, $model){
        switch($model) {
            case 'Giaoxu':
                $field = 'hoatdongbatai_coquancap';
                break;
            case 'Tuvienphatgiao':
                $field = 'cachoatdong_sogiaychungnhan_coquancap';
                break;
            case 'Chihoitinlanh':
                $field = 'cachoatdong_sogiaychungnhan_coquancap';
                break;
            case 'Hodaocaodai':
                $field = 'cachoatdongbacai_coquancap';
                break;
            case 'Chihoitinhdocusiphatgiaovietnam':
                $field = 'cachoatdongbacai_coquancap';
                break;
            case 'Cosohoigiaoislam':
                $field = 'cachoatdongbacai_coquancap';
                break;
            case 'Cosotinnguong':
                $field = 'cachoatdong_sogiaychungnhan_coquancap';
                break;
        }

        return empty($target[$field]) ? '' : $target[$field];
    }

    private function __formatGiaychungnhan($target, $model){
        switch($model) {
            case 'Giaoxu':
                $field = 'hoatdongbatai_sogiaychungnhan';
                break;
            case 'Tuvienphatgiao':
                $field = 'cachoatdong_sogiaychungnhan';
                break;
            case 'Chihoitinlanh':
                $field = 'cachoatdong_sogiaychungnhan';
                break;
            case 'Hodaocaodai':
                $field = 'cachoatdongbacai_sogiaychungnhan';
                break;
            case 'Chihoitinhdocusiphatgiaovietnam':
                $field = 'cachoatdongbacai_sogiaychungnhan';
                break;
            case 'Cosohoigiaoislam':
                $field = 'cachoatdongbacai_sogiaychungnhan';
                break;
            case 'Cosotinnguong':
                $field = 'cachoatdong_sogiaychungnhan';
                break;
        }

        return empty($target[$field]) ? '' : $target[$field];
    }

    private function __formatGhichu($target, $model){
        switch($model) {
            case 'Giaoxu':
            case 'Tuvienphatgiao':
            case 'Chihoitinlanh':
            case 'Hodaocaodai':
            case 'Chihoitinhdocusiphatgiaovietnam':
            case 'Cosohoigiaoislam':
            case 'Cosotinnguong':
                $string = '';
                break;
        }
        return $string;
    }

    private function __getParams($model) {
        switch ($model) {
            case 'Giaoxu':
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
                    'cachoatdongbacai_dogiaoxu'
                ];
                $conditions = [
                    $location . ' <>' => '',
                    $location . ' is not null',
                ];
                break;
            case 'Tuvienphatgiao':
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
                    'cachoatdongbacai'
                ];
                $conditions = [
                    $location . ' <>' => '',
                    $location . ' is not null',
                ];
                break;
            case 'Chihoitinlanh':
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
                    'cachoatdongbacai'
                ];
                $conditions = [
                    $location . ' <>' => '',
                    $location . ' is not null',
                ];
                break;
            case 'Hodaocaodai':
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
                    'cachoatdongbacai'
                ];
                $conditions = [
                    $location . ' <>' => '',
                    $location . ' is not null',
                ];
                break;
            case 'Chihoitinhdocusiphatgiaovietnam':
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
                    'cachoatdongbacai'
                ];
                $conditions = [
                    $location . ' <>' => '',
                    $location . ' is not null',
                ];
                break;
            case 'Cosohoigiaoislam':
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
                    'cachoatdongbacai'
                ];
                $conditions = [
                    $location . ' <>' => '',
                    $location . ' is not null',
                ];
                break;
            case 'Cosotinnguong':
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
                    'cachoatdongbacai'
                ];
                $conditions = [
                    $location . ' <>' => '',
                    $location . ' is not null',
                ];
                break;
        }

        return compact('fields', 'conditions');
    }


    private function __getData($model)
    {
        $option = $this->__getParams($model);
        $obj = ClassRegistry::init($model);
        $data = $obj->find('all', $option);

        return Hash::combine($data, '{n}.' . $model . '.id', '{n}.' . $model);
    }
}

    /**
     * DANH SÁCH CƠ SỞ HOẠT ĐỘNG XÃ HỘI CỦA CÁC TÔN GIÁO TRÊN ĐỊA BÀN TỈNH
     *
     * I. CÔNG GIÁO
     * 1. Bảng giaoxu
     * Tên cơ sở thờ tự: tengiaoxu
       Địa chỉ: diachi_so, diachi_duong, diachi_ap, diachi_xa, diachi_huyen, diachi_tinh
       Thuộc tổ chức tôn giáo cơ sở: Để mặc định là 'Công Giáo'
     * Lấy dữ liệu từ cột cachoatdongbacai_dogiaoxu, dữ liệu lưu như dưới có thể n+ (n = 1, 2, 3, ...)
     *      hoatdongbatai_linhvuchoatdong______:Lĩnh vực hoạt động 1______,hoatdongbatai_sogiaychungnhan______:GCN1______,hoatdongbatai_ngaycap______:11/11/2011______,hoatdongbatai_coquancap______:CQCDN______;
            hoatdongbatai_linhvuchoatdong______:Lĩnh vực hoạt động 2______,hoatdongbatai_dangkyhoatdong______:1______,hoatdongbatai_sogiaychungnhan______:GCN2______,hoatdongbatai_ngaycap______:12/12/2012______,hoatdongbatai_coquancap______:CQCDN
            Sau khi parse xong, lấy dữ liệu excel như sau:
                Thuộc lĩnh vực: hoatdongbatai_linhvuchoatdong
                Cơ sở họp pháp/chưa hợp pháp: if hoatdongbatai_dangkyhoatdong = true Cơ sở họp pháp else chưa hợp pháp
                Cơ quan công nhận: hoatdongbatai_coquancap
                Giấy chứng nhận: hoatdongbatai_sogiaychungnhan
                Ghi chú: Bỏ trống
     *
     * II. PHẬT GIÁO
     * 2. Bảng tuvienphatgiao
     * Tên cơ sở thờ tự: tentuvien
       Địa chỉ: diachi_so, diachi_duong, diachi_ap, diachi_xa, diachi_huyen, diachi_tinh
       Thuộc tổ chức tôn giáo cơ sở: Để mặc định là 'Phật Giáo'
       Lấy dữ liệu từ cột cachoatdongbacai, dữ liệu lưu như dưới có thể n+ (n = 1, 2, 3, ...)
            cachoatdong_linhvuchoatdong______:Lĩnh vực hoạt động 1______,cachoatdong_sogiaychungnhan______:GCN1______,cachoatdong_sogiaychungnhan_ngaycap______:22/12/2012______,cachoatdong_sogiaychungnhan_coquancap______:CQC
            Sau khi parse xong, lấy dữ liệu excel như sau:
                Thuộc lĩnh vực: cachoatdong_linhvuchoatdong
                Cơ sở họp pháp/chưa hợp pháp: if cachoatdong_dangkyhoatdong = true Cơ sở họp pháp else chưa hợp pháp
                Cơ quan công nhận: cachoatdong_sogiaychungnhan_coquancap
                Giấy chứng nhận: cachoatdong_sogiaychungnhan
                Ghi chú: Bỏ trống

     * III. TIN LÀNH
     * 3. Bảng chihoitinlanh
     * Tên cơ sở thờ tự: tenchihoi
       Địa chỉ: diachi_so, diachi_ap, diachi_xa, diachi_huyen, diachi_tinh
       Thuộc tổ chức tôn giáo cơ sở: Để mặc định là 'Tin Lành'
       Lấy dữ liệu từ cột cachoatdongbacai, dữ liệu lưu như dưới có thể n+ (n = 1, 2, 3, ...)
            cachoatdong_linhvuchoatdong______:Lĩnh vực hoạt động 1______,cachoatdong_sogiaychungnhan______:GCN1______,cachoatdong_sogiaychungnhan_ngaycap______:11/11/2011______,cachoatdong_sogiaychungnhan_coquancap______:CQC1______;
            cachoatdong_linhvuchoatdong______:Lĩnh vực hoạt động 2______,cachoatdong_sogiaychungnhan______:GCN2______,cachoatdong_sogiaychungnhan_ngaycap______:11/11/2012______,cachoatdong_sogiaychungnhan_coquancap______:CQC2
            Sau khi parse xong, lấy dữ liệu excel như sau:
                Thuộc lĩnh vực: cachoatdong_linhvuchoatdong
                Cơ sở họp pháp/chưa hợp pháp: if cachoatdong_dangkyhoatdong = true Cơ sở họp pháp else chưa hợp pháp
                Cơ quan công nhận: cachoatdong_sogiaychungnhan_coquancap
                Giấy chứng nhận: cachoatdong_sogiaychungnhan
                Ghi chú: Bỏ trống
     *
     * IV. CAO ĐÀI
     * 4. Bảng hodaocaodai
     * Tên cơ sở thờ tự: tenhodao
       Địa chỉ: tenhodao_diachi_so, tenhodao_diachi_duong, tenhodao_diachi_ap, tenhodao_diachi_xa, tenhodao_diachi_huyen, tenhodao_diachi_tinh
       Thuộc tổ chức tôn giáo cơ sở: Để mặc định là 'Cao Đài'
       Lấy dữ liệu từ cột cachoatdongbacai, dữ liệu lưu như dưới có thể n+ (n = 1, 2, 3, ...)
            cachoatdongbacai_linhvuchoatdong______:Lĩnh vực hoạt động 1______,cachoatdongbacai_capdangkyhoatdong______:1______,cachoatdongbacai_sogiaychungnhan______:GCN1______,cachoatdongbacai_ngaycap______:11/11/2011______,cachoatdongbacai_coquancap______:CQC1______;
            cachoatdongbacai_linhvuchoatdong______:Lĩnh vực hoạt động______,cachoatdongbacai_sogiaychungnhan______:GCN2______,cachoatdongbacai_ngaycap______:11/11/2012______,cachoatdongbacai_coquancap______:CQC2
                Sau khi parse xong, lấy dữ liệu excel như sau:
                Thuộc lĩnh vực: cachoatdongbacai_linhvuchoatdong
                Cơ sở họp pháp/chưa hợp pháp: if cachoatdongbacai_capdangkyhoatdong = true Cơ sở họp pháp else chưa hợp pháp
                Cơ quan công nhận: cachoatdongbacai_coquancap
                Giấy chứng nhận: cachoatdongbacai_sogiaychungnhan
                Ghi chú: Bỏ trống
     *
     * V. TĐCSPHVN
     * 5. Bảng chihoitinhdocusiphatgiaovietnam
     * Tên cơ sở thờ tự: tenchihoi
       Địa chỉ: tenchihoi_diachi_so, tenchihoi_diachi_duong, tenchihoi_diachi_ap, tenchihoi_diachi_xa, tenchihoi_diachi_huyen, tenchihoi_diachi_tinh
       Thuộc tổ chức tôn giáo cơ sở: Để mặc định là 'Tịnh độ cư sĩ phật hội'
       Lấy dữ liệu từ cột cachoatdongbacai, dữ liệu lưu như dưới có thể n+ (n = 1, 2, 3, ...)
            cachoatdongbacai_linhvuchoatdong______:Lĩnh vực hoạt động 1______,cachoatdongbacai_sogiaychungnhan______:GCN1______,cachoatdongbacai_ngaycap______:11/11/2011______,cachoatdongbacai_coquancap______:CQC1
                Sau khi parse xong, lấy dữ liệu excel như sau:
                Thuộc lĩnh vực: cachoatdongbacai_linhvuchoatdong
                Cơ sở họp pháp/chưa hợp pháp: if cachoatdongbacai_capdangkyhoatdong = true Cơ sở họp pháp else chưa hợp pháp
                Cơ quan công nhận: cachoatdongbacai_coquancap
                Giấy chứng nhận: cachoatdongbacai_sogiaychungnhan
                Ghi chú: Bỏ trống
     * VI. HỒI GIÁO
     * 6. Bảng cosohoigiaoislam
     * Tên cơ sở thờ tự: tenthanhduong
       Địa chỉ: tenthanhduong_diachi_so, tenthanhduong_diachi_duong, tenthanhduong_diachi_ap, tenthanhduong_diachi_xa, tenthanhduong_diachi_huyen, tenthanhduong_diachi_tinh
       Thuộc tổ chức tôn giáo cơ sở: Để mặc định là 'Hồi Giáo'
       Lấy dữ liệu từ cột cachoatdongbacai, dữ liệu lưu như dưới có thể n+ (n = 1, 2, 3, ...)
            cachoatdongbacai_linhvuchoatdong______:Lĩnh vực hoạt động 1______,cachoatdongbacai_sogiaychungnhan______:GCN1______,cachoatdongbacai_ngaycap______:11/11/2011______,cachoatdongbacai_coquancap______:CQC1
                Sau khi parse xong, lấy dữ liệu excel như sau:
                Thuộc lĩnh vực: cachoatdongbacai_linhvuchoatdong
                Cơ sở họp pháp/chưa hợp pháp: if cachoatdongbacai_capdangkyhoatdong = true Cơ sở họp pháp else chưa hợp pháp
                Cơ quan công nhận: cachoatdongbacai_coquancap
                Giấy chứng nhận: cachoatdongbacai_sogiaychungnhan
                Ghi chú: Bỏ trống
     *
     * VII. TÍN NGƯỠNG
     * 7. Bảng cosotinnguong
     * Tên cơ sở thờ tự: tencoso
       Địa chỉ: diachi_so, diachi_duong, diachi_ap, diachi_xa, diachi_huyen, diachi_tinh
       Thuộc tổ chức tôn giáo cơ sở: Để mặc định là 'Tín Ngưỡng'
       Lấy dữ liệu từ cột cachoatdongbacai, dữ liệu lưu như dưới có thể n+ (n = 1, 2, 3, ...)
            cachoatdong_linhvuchoatdong______:Lĩnh vực hoạt động 1______,cachoatdong_sogiaychungnhan______:GCN 1______,cachoatdong_sogiaychungnhan_ngaycap______:11//11/2011______,cachoatdong_sogiaychungnhan_coquancap______:CQC1
                Sau khi parse xong, lấy dữ liệu excel như sau:
                Thuộc lĩnh vực: cachoatdong_linhvuchoatdong
                Cơ sở họp pháp/chưa hợp pháp: if cachoatdongbacai_capdangkyhoatdong = true Cơ sở họp pháp else chưa hợp pháp
                Cơ quan công nhận: cachoatdong_sogiaychungnhan_coquancap
                Giấy chứng nhận: cachoatdong_sogiaychungnhan
                Ghi chú: Bỏ trống
*/
