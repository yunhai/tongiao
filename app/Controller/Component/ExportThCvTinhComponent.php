<?php

class ExportThCvTinhComponent extends Component
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
			'Giaoxu',
            'Tuvienphatgiao',
			'Chihoitinlanh',
			'Hodaocaodai',
			'Chucviecphathoahao',
			'Chihoitinhdocusiphatgiaovietnam',
        ];

        $province = $this->Province->getProvince();

        $export = $this->init($province);

        foreach ($export_fields as $field_index => $model) {
			$func = '__get' . $model;
            $tmp = $this->$func($model);

            foreach ($province as $provice_code => $name) {
                $partial = $tmp[$provice_code];


				foreach($partial as $field => $value) {
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

		foreach($result as &$item) {
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

		foreach($result as &$item) {
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
		foreach($result as &$item) {
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
		foreach($result as &$item) {
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

		foreach($result as &$item) {
			$tmp = array(
				'total' => array_sum($item),
				'banhotu' => 0
			);
			$item = array_merge($tmp, $item);
		}

		return $result;
	}

    private function __getGiaoxu($model)
    {
        $fields = [
            'id',
            'diachi_huyen'
        ];
        $conditions = [];
        $column = [

        ];
        $province_field = 'diachi_huyen';

        $fields = array_merge($fields, $column);
        $data = $this->__getData($model, compact('fields', 'conditions'));

		$result = $this->__groupData($data, $column, $province_field);

		foreach($result as &$item) {
			$item = array(
				'total' => 0,
				0,
				0,
				0,
				0);

		}

		return $result;
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
