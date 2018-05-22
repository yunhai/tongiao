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
print_r("<pre>");
print_r($data);
print_r("</pre>");
exit;

        return $result;
    }

	private function __getInfo($model)
	{
		$fields = [
			'stt',
			'tencosothotu',
			'diachi',
			'thuoctochuctongiaocoso',
			'thuoclinhvuc',
			'cosohopphapchuahopphap',
			'coquancongnhan',
			'giaychungnhan',
			'ghichu'
		];

		$result = [];
		$data = $this->__getData($model);

		foreach ($data as $target) {
			$target = $this->__format($target, $model);

			$tmp = [];
			foreach ($fields as $f) {
				$func = '__format' . ucfirst($f);
				$tmp[$f] = $this->$func($target, $model);
			}

			$result[] = $tmp;
		}

		return $result;
	}

    private function __statis($data, $model) {
        $result = [];
        $row = [
            'tencosothotu' => '',
            'diachi' => '',
            'thuoctochuctongiao' => '',
            'tindodathuchiennghiletongiao' => 0,
            'tindochuathuchiennghiletongiao' => 0,
            'tindoladantocthieuso' => 0,
            'chucsac' => 0,
            'tusi' => 0,
            'chucsacladantocthieuso' => 0,
            'chucviec' => 0,
            'chucviecladantocthieuso' => 0,
            'namthanhlap' => 0,
            'namxaydung' => 0,
            'sotien' => 0,
            'solan' => 0,
			'sotienlancuoi' => 0,
            'dacapgcnqsddat_tongiao' => 0,
            'dacapgcnqsddat_khac' => 0,
            'chuacapgcnqsddat' => 0,
            'kientruc' => '',
            'xephangditich' => '',
            'capcongnhan' => '',
        ];
        foreach ($data as $element) {
            $tmp = [];
            foreach($row as $field => $value) {
                $function = '__get' . ucfirst($field);
                $tmp[$field] = $this->$function($element, $model);
            }
			print_r("<pre>");
			print_r($tmp);
			print_r("</pre>");
			exit;
        }
    }

	private function __getTencosothotu($data, $model)
	{
		switch($model) {
			case 'Giaoxu':
				$field = 'tengiaoxu';
				break;
		}
		return $data[$field];
	}

	private function __getDiachi($data, $model)
	{
		$field = [];
		switch($model) {
			case 'Giaoxu':
				$field = [
					'diachi_so',
					'diachi_duong',
					'diachi_ap',
					'diachi_xa',
					'diachi_huyen',
					'diachi_tinh'
				];
				break;
		}

		$address = '';
		foreach ($field as $f) {
			if ($data[$f]) {
				$address .= $data[$f] . ", ";
			}
		}
		return trim($address, ", ");
	}

	private function __getThuoctochuctongiao($data, $model)
	{
		$string = '';
		switch($model) {
			case 'Giaoxu':
				$string = 'Công Giáo';
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
		}
		return $field ? $data[$field] : 0;
	}

	private function __getTindochuathuchiennghiletongiao($data, $model)
	{
		switch($model) {
			case 'Giaoxu':
				$field = '';
				break;
		}
		return $field ? $data[$field] : 0;
	}

	private function __getTindoladantocthieuso($data, $model)
	{
		switch($model) {
			case 'Giaoxu':
				$field = 'giaodandantocthieuso_sonhankhau';
				break;
		}
		return $field ? $data[$field] : 0;
	}

	private function __getChucsac($data, $model)
	{
		switch($model) {
			case 'Giaoxu':
				$field = '';
				break;
		}
		return $field ? $data[$field] : 0;
	}

	private function __getTusi($data, $model)
	{
		switch($model) {
			case 'Giaoxu':
				$field = 'sotusi';
				break;
		}
		return $field ? $data[$field] : 0;
	}

	private function __getChucsacladantocthieuso($data, $model)
	{
		switch($model) {
			case 'Giaoxu':
				$field = '';
				break;
		}
		return $field ? $data[$field] : 0;
	}

	private function __getChucviec($data, $model)
	{
		switch($model) {
			case 'Giaoxu':
				$field = 'sothanhvientrongthuongvu';
				break;
		}
		return $field ? $data[$field] : 0;
	}

	private function __getChucviecladantocthieuso($data, $model)
	{
		switch($model) {
			case 'Giaoxu':
				$field = '';
				break;
		}
		return $field ? $data[$field] : 0;
	}

	private function __getNamthanhlap($data, $model)
	{
		switch($model) {
			case 'Giaoxu':
				$field = 'namthanhlap';
				break;
		}
		return $field ? $data[$field] : 0;

	}

	private function __getNamxaydung($data, $model)
	{
		switch($model) {
			case 'Giaoxu':
				$field = 'namxaydungnhatho';
				break;
		}
		return $field ? $data[$field] : 0;
	}

	private function __getSotien($data, $model)
	{
		switch($model) {
			case 'Giaoxu':
				$field = '';
				break;
		}
		return $field ? $data[$field] : 0;
	}

	private function __getSolan($data, $model)
	{
		switch($model) {
			case 'Giaoxu':
				$field = 'ttttcs_solan';
				break;
		}
		return $field ? $data[$field] : 0;
	}

	private function __getSotienlancuoi($data, $model)
	{
		switch($model) {
			case 'Giaoxu':
				$field = 'ttttcs_tongkinhphi';
				break;
		}
		return $field ? $data[$field] : 0;
	}

	private function __getDacapgcnqsddat_tongiao($data, $model)
	{
		switch($model) {
			case 'Giaoxu':
				$field = '';
				break;
		}
		return $field ? $data[$field] : 0;
	}

	private function __getDacapgcnqsddat_khac($data, $model)
	{
		switch($model) {
			case 'Giaoxu':
				$field = 'giaodandantocthieuso_sonhankhau';
				break;
		}
		return $field ? $data[$field] : 0;
	}

	private function __getChuacapgcnqsddat($data, $model)
	{
		switch($model) {
			case 'Giaoxu':
				$field = 'giaodandantocthieuso_sonhankhau';
				break;
		}
		return $field ? $data[$field] : 0;
	}

	private function __getKientruc($data, $model)
	{
		switch($model) {
			case 'Giaoxu':
				$field = '';
				break;
		}
		return $field ? $data[$field] : '';
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

    private function __getData($model, $option = [])
    {
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
